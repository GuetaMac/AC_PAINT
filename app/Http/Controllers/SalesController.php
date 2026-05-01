<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->input('month'); // e.g. "2025-04"

        // --- Base query for the sales table ---
        $salesQuery = Sale::with(['items.product', 'user'])
            ->where('status', '!=', 'voided');

        if ($month) {
            $salesQuery->whereYear('created_at', substr($month, 0, 4))
                       ->whereMonth('created_at', substr($month, 5, 2));
        }

        $sales = $salesQuery->latest()->paginate(15)->withQueryString();

        // --- Stats base (no eager loads needed) ---
        $statsBase = Sale::where('status', '!=', 'voided');

        if ($month) {
            $statsBase->whereYear('created_at', substr($month, 0, 4))
                      ->whereMonth('created_at', substr($month, 5, 2));
        }

        $today = $statsBase->clone()
            ->whereDate('created_at', today())
            ->selectRaw('COUNT(*) as count, COALESCE(SUM(total_amount), 0) as total')
            ->first();

        $thisWeek = $statsBase->clone()
            ->whereBetween('created_at', [
                now()->startOfWeek()->toDateTimeString(),
                now()->endOfWeek()->toDateTimeString(),
            ])
            ->selectRaw('COUNT(*) as count, COALESCE(SUM(total_amount), 0) as total')
            ->first();

        $thisMonth = $statsBase->clone()
            ->whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->selectRaw('COUNT(*) as count, COALESCE(SUM(total_amount), 0) as total')
            ->first();

        // --- Product breakdown (only when filtered by month) ---
        $productStats = null;

        if ($month) {
            $productStats = SaleItem::whereHas('sale', function ($q) use ($month) {
                    $q->whereYear('created_at', substr($month, 0, 4))
                      ->whereMonth('created_at', substr($month, 5, 2))
                      ->where('status', '!=', 'voided');
                })
                ->with('product')
                ->selectRaw('product_id, SUM(quantity) as total_qty, SUM(subtotal) as total_revenue')
                ->groupBy('product_id')
                ->orderByDesc('total_qty')
                ->get();
        }

        return view('sales.index', compact(
            'sales', 'today', 'thisWeek', 'thisMonth', 'productStats', 'month'
        ));
    }
}