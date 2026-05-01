<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PurchasingController extends Controller
{
    /**
     * Show the purchasing page.
     */
    public function index()
{
    $lastSale = Sale::latest()->first();
    $nextNum  = $lastSale
        ? intval(str_replace('TXN-', '', $lastSale->reference_no)) + 1
        : 1;

$reference = 'TXN-' . str_pad((string)$nextNum, 4, '0', STR_PAD_LEFT);

    return view('purchasing.index', compact('reference'));
}
    /**
     * Live product search — called via AJAX as user types.
     * Returns JSON list of matching products with stock info.
     */
public function search(Request $request)
{
    $q = $request->input('q', '');

    $products = Product::where('stock', '>', 0)
        ->where(function($query) use ($q) {
            $query->where('name', 'like', "%{$q}%")
                  ->orWhere('brand', 'like', "%{$q}%")
                  ->orWhere('category', 'like', "%{$q}%");
        })
        ->select('id', 'name', 'brand', 'price', 'stock', 'size') // <-- wala nang unit
        ->limit(10)
        ->get()
        ->map(function ($p) {
            $p->unit = $p->size; // i-map lang sa JS side
            return $p;
        });

    return response()->json($products);
}
    /**
     * Process and save the sale.
     * Deducts stock from each product inside a DB transaction.
     */
   public function store(Request $request)
{
    $validated = $request->validate([
        'items'                 => 'required|array|min:1',
        'items.*.product_id'    => 'required|exists:products,id',
        'items.*.quantity'      => 'required|integer|min:1',
        'payment_method'        => 'required|in:Cash,GCash',
        'customer_name'         => 'nullable|string|max:255',
        'amount_tendered'       => 'nullable|numeric|min:0',
    ]);

    DB::beginTransaction();

    try {
        $total = 0;
        $lineItems = [];

        foreach ($validated['items'] as $item) {
            $product = Product::lockForUpdate()->findOrFail($item['product_id']);

            // Check stock
            if ($product->stock < $item['quantity']) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => "Not enough stock for {$product->name}. Available: {$product->stock}",
                ], 422);
            }

            $subtotal = $product->price * $item['quantity'];
            $total   += $subtotal;

            $lineItems[] = [
                'product'    => $product,
                'quantity'   => $item['quantity'],
                'unit_price' => $product->price,
                'subtotal'   => $subtotal,
            ];
        }

        // Compute change
        $change = null;
        if ($validated['payment_method'] === 'Cash') {
            $tendered = $validated['amount_tendered'] ?? 0;
            if ($tendered < $total) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Amount tendered is less than total.',
                ], 422);
            }
            $change = $tendered - $total;
        }

        // Generate reference number
        $lastSale = Sale::latest()->first();
        $nextNum  = $lastSale
            ? intval(str_replace('TXN-', '', $lastSale->reference_no)) + 1
            : 1;
        $refNo = 'TXN-' . str_pad((string)$nextNum, 4, '0', STR_PAD_LEFT);

        // Save sale
       $sale = Sale::create([
    'reference_no'    => $refNo,
    'customer_name'   => $validated['customer_name'] ?? null,
    'payment_method'  => $validated['payment_method'],
    'total_amount'    => $total,          // dati: total
    'amount_tendered' => $validated['amount_tendered'] ?? null,
    'change_amount'   => $change,         // dati: change
    'status'          => 'Paid',
    'user_id'         => auth()->user()->id,    // null kung walang auth
]);

        // Save items + deduct stock
        foreach ($lineItems as $line) {
            SaleItem::create([
                'sale_id'    => $sale->id,
                'product_id' => $line['product']->id,
                'quantity'   => $line['quantity'],
                'unit_price' => $line['unit_price'],
                'subtotal'   => $line['subtotal'],
            ]);

            // Deduct stock
            $line['product']->decrement('stock', $line['quantity']);
        }

        DB::commit();

    return response()->json([
    'success'      => true,
    'reference_no' => $refNo,
    'total'        => $total,
    'change'       => $change,
]);

   } catch (\Exception $e) {
    DB::rollBack();
    return response()->json([
        'success' => false,
        'message' => $e->getMessage(),
        'line'    => $e->getLine(),
    ], 500);
}
}
}