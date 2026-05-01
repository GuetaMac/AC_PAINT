<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PurchasingController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\DebtsController;
use App\Http\Controllers\CategoryController;

// Redirect root to login
Route::get('/', function () {
    return redirect('/login');
});

// Login routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected routes
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);

    // Products
    Route::post('/admin/products', [AdminController::class, 'storeProduct'])->name('products.store');
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');

    // Purchasing / Point of Sale
    Route::get('/purchasing', [PurchasingController::class, 'index'])->name('purchasing.index');
    Route::get('/purchasing/search', [PurchasingController::class, 'search'])->name('purchasing.search');
Route::post('/purchasing/store', [PurchasingController::class, 'store'])->name('purchasing.store');
    Route::post('/purchasing', [PurchasingController::class, 'store'])->name('purchasing.store');

    // Sales
    Route::get('/sales', [SalesController::class, 'index'])->name('sales.index');

    //debts
  Route::get('/debts',                                [DebtsController::class, 'index'])->name('debts.index');
Route::get('/debts/search',                         [DebtsController::class, 'search'])->name('debts.search');
Route::get('/debts/debtor-names',                   [DebtsController::class, 'debtorNames'])->name('debts.debtorNames');
Route::post('/debts',                               [DebtsController::class, 'store'])->name('debts.store');
Route::get('/debts/{id}',                           [DebtsController::class, 'show'])->name('debts.show');
Route::post('/debts/{id}/pay',                      [DebtsController::class, 'pay'])->name('debts.pay');
Route::post('/debts/{id}/items/{itemId}/pay',       [DebtsController::class, 'payItem'])->name('debts.items.pay');

    // History
    Route::get('/history', [HistoryController::class, 'index'])->name('history.index');

    // Suppliers
    Route::get('/suppliers', [SupplierController::class, 'index'])->name('suppliers.index');
    Route::post('/suppliers', [SupplierController::class, 'store'])->name('suppliers.store');

    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

    // Settings
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update');

    Route::post  ('categories',         [CategoryController::class, 'store'])   ->name('categories.store');
Route::delete('categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
 
});