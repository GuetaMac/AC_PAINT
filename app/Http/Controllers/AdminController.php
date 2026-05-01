<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalProducts = Product::count();
        $lowStockItems = Product::whereColumn('stock', '<=', 'min_stock')->get();
        $lowStockCount = $lowStockItems->count();
        $totalSuppliers = 0;

        $salesToday = DB::table('sales')
            ->whereDate('created_at', today())
            ->selectRaw('COALESCE(SUM(total_amount), 0) as total, COUNT(*) as count')
            ->first();

        $recentSales = Sale::with(['items.product'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin_dashboard', compact(
            'totalProducts',
            'lowStockCount',
            'lowStockItems',
            'totalSuppliers',
            'salesToday',
            'recentSales'
        ));
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'brand'    => 'required',
            'category' => 'required',
            'size'     => 'required',
            'price'    => 'required|numeric',
            'stock'    => 'required|integer',
        ]);

        Product::create([
            'product_code' => $request->product_code,
            'name'         => $request->name,
            'brand'        => $request->brand,
            'category'     => $request->category,
            'size'         => $request->size,
            'price'        => $request->price,
            'stock'        => $request->stock,
            'min_stock'    => $request->min_stock ?? 5,
            'supplier'     => $request->supplier,
        ]);

        return redirect()->route('products.index')->with('success', 'Product added!');
    }
}