<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Store a new category (AJAX).
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:60|unique:categories,name',
        ]);

        $category = Category::create([
            'name' => trim($request->name),
        ]);

        return response()->json([
            'success'  => true,
            'category' => $category,
        ]);
    }

    /**
     * Delete a category (AJAX).
     * Prevent deletion if any products are still using it.
     */
    public function destroy(Category $category)
    {
        // Safety check — don't delete if products exist under this category
        $count = \App\Models\Product::where('category', $category->name)->count();

        if ($count > 0) {
            return response()->json([
                'success' => false,
                'message' => "Cannot delete — {$count} product(s) still use this category.",
            ], 422);
        }

        $category->delete();

        return response()->json(['success' => true]);
    }
}