<?php

namespace App\Http\Controllers;

use App\Models\Debt;
use App\Models\DebtItem;
use App\Models\Product;
use Illuminate\Http\Request;

class DebtsController extends Controller
{
    public function index()
    {
        $debts = Debt::with('items')->latest()->get();
        return view('debts.index', compact('debts'));
    }

    /**
     * Same exact search logic as PurchasingController
     */
    public function search(Request $request)
    {
        $q = $request->input('q', '');

        $products = Product::where('stock', '>', 0)
            ->where(function ($query) use ($q) {
                $query->where('name', 'like', "%{$q}%")
                      ->orWhere('brand', 'like', "%{$q}%")
                      ->orWhere('category', 'like', "%{$q}%");
            })
            ->select('id', 'name', 'brand', 'price', 'stock', 'size')
            ->limit(10)
            ->get()
            ->map(function ($p) {
                $p->unit = $p->size;
                return $p;
            });

        return response()->json($products);
    }

    /**
     * Store or MERGE into existing unpaid/partial debt by debtor name.
     * If debtor already has an active debt, new items are appended to it.
     */
    public function store(Request $request)
    {
        $request->validate([
            'debtor_name'        => 'required|string|max:255',
            'items'              => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity'   => 'required|integer|min:1',
        ]);

        $debtorName = trim($request->debtor_name);
        $newAmount  = 0;
        $itemsData  = [];

        foreach ($request->items as $item) {
            $product  = Product::findOrFail($item['product_id']);
            $subtotal = $product->price * $item['quantity'];
            $newAmount += $subtotal;

            $itemsData[] = [
                'product_id'   => $product->id,
                'product_name' => $product->name,
                'unit_price'   => $product->price,
                'quantity'     => $item['quantity'],
                'subtotal'     => $subtotal,
                'is_paid'      => false,
            ];
        }

        // Check if this debtor already has an active (unpaid/partial) debt
        $existingDebt = Debt::where('debtor_name', $debtorName)
            ->whereIn('status', ['unpaid', 'partial'])
            ->latest()
            ->first();

        if ($existingDebt) {
            // Merge: add items + increase total
            foreach ($itemsData as $item) {
                $existingDebt->items()->create($item);
            }
            $existingDebt->total_amount += $newAmount;
            // Keep status as-is (unpaid or partial)
            $existingDebt->save();

            return response()->json([
                'success' => true,
                'merged'  => true,
                'debt'    => $existingDebt,
            ]);
        }

        // New debtor — create fresh record
        $debt = Debt::create([
            'debtor_name'  => $debtorName,
            'notes'        => $request->notes,
            'total_amount' => $newAmount,
            'amount_paid'  => 0,
            'status'       => 'unpaid',
        ]);

        foreach ($itemsData as $item) {
            $debt->items()->create($item);
        }

        return response()->json([
            'success' => true,
            'merged'  => false,
            'debt'    => $debt,
        ]);
    }

    public function show($id)
    {
        $debt = Debt::with('items')->findOrFail($id);
        return response()->json($debt);
    }

    /**
     * Also return list of existing debtor names for autocomplete
     */
    public function debtorNames(Request $request)
    {
        $q = $request->input('q', '');

        $debts = Debt::whereIn('status', ['unpaid', 'partial'])
            ->where('debtor_name', 'like', "%{$q}%")
            ->orderBy('debtor_name')
            ->get(['debtor_name', 'status', 'total_amount', 'amount_paid']);

        // Deduplicate by name, keep highest remaining
        $unique = $debts->groupBy('debtor_name')->map(function ($group) {
            return $group->sortByDesc(fn($d) => $d->total_amount - $d->amount_paid)->first();
        })->values()->map(fn($d) => [
            'name'      => $d->debtor_name,
            'status'    => $d->status,
            'remaining' => $d->total_amount - $d->amount_paid,
        ]);

        return response()->json($unique);
    }

    public function pay(Request $request, $id)
    {
        $request->validate(['amount' => 'required|numeric|min:0.01']);

        $debt      = Debt::findOrFail($id);
        $remaining = $debt->total_amount - $debt->amount_paid;
        $payment   = min($request->amount, $remaining);

        $debt->amount_paid += $payment;
        $debt->status = $debt->amount_paid >= $debt->total_amount ? 'paid' : 'partial';

        if ($debt->status === 'paid') {
            $debt->items()->update(['is_paid' => true]);
        }

        $debt->save();

        return response()->json(['success' => true, 'debt' => $debt]);
    }

    public function payItem(Request $request, $debtId, $itemId)
    {
        $debt = Debt::with('items')->findOrFail($debtId);
        $item = DebtItem::where('debt_id', $debtId)->findOrFail($itemId);

        if ($item->is_paid) {
            return response()->json(['success' => false, 'message' => 'Item already paid.']);
        }

        $item->is_paid = true;
        $item->save();

        $paidTotal         = $debt->items()->where('is_paid', true)->sum('subtotal');
        $debt->amount_paid = $paidTotal;
        $debt->status      = $paidTotal >= $debt->total_amount ? 'paid'
                           : ($paidTotal > 0 ? 'partial' : 'unpaid');
        $debt->save();

        return response()->json(['success' => true, 'debt' => $debt]);
    }
}