{{-- resources/views/products/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Products')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<style>
:root {
    --green:       #16a34a;
    --green-light: #dcfce7;
    --green-mid:   #bbf7d0;
    --green-dark:  #14532d;
    --blue:        #3b82f6;
    --blue-light:  #eff6ff;
    --amber:       #d97706;
    --amber-light: #fef3c7;
    --red:         #dc2626;
    --red-light:   #fee2e2;
    --surface:     #f8fafc;
    --card:        #ffffff;
    --border:      #e2e8f0;
    --border-dark: #cbd5e1;
    --text:        #0f172a;
    --text-mid:    #475569;
    --text-muted:  #94a3b8;
    --radius:      14px;
    --radius-sm:   9px;
    --shadow-sm:   0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
    --shadow-md:   0 4px 16px rgba(0,0,0,0.08), 0 2px 6px rgba(0,0,0,0.04);
    --font:        'DM Sans', sans-serif;
    --font-mono:   'DM Mono', monospace;
}
*, *::before, *::after { box-sizing: border-box; }
body { font-family: var(--font); }

/* ── PAGE HEADER ── */
.page-header {
    display: flex; align-items: flex-start;
    justify-content: space-between;
    margin-bottom: 1.4rem; gap: 1rem;
}
.page-title  { font-size: 30px; font-weight: 700; color: var(--text); letter-spacing: -.3px; }
.page-sub    { font-size: 17px; color: var(--text-muted); margin-top: 3px; }
.header-actions { display: flex; gap: 8px; align-items: center; flex-shrink: 0; }

/* ── BUTTONS ── */
.btn {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 0 20px; height: 46px;
    border-radius: var(--radius-sm);
    font-family: var(--font); font-size: 16px; font-weight: 600;
    cursor: pointer; border: 1.5px solid var(--border);
    transition: all .18s; white-space: nowrap; text-decoration: none;
}
.btn svg { width: 17px; height: 17px; flex-shrink: 0; }
.btn-primary { background: var(--text); color: #fff; border-color: var(--text); }
.btn-primary:hover { background: #1e293b; }
.btn-ghost   { background: var(--card); color: var(--text-mid); }
.btn-ghost:hover { background: var(--surface); color: var(--text); border-color: var(--border-dark); }
.btn-danger  { background: var(--card); color: var(--red); border-color: #fca5a5; }
.btn-danger:hover { background: var(--red-light); }

/* ── SUMMARY PILLS ── */
.summary-pills { display: flex; gap: 8px; margin-bottom: 1.3rem; flex-wrap: wrap; }
.pill {
    display: flex; align-items: center; gap: 7px;
    background: var(--card); border: 1px solid var(--border);
    border-radius: 50px; padding: 8px 16px 8px 12px;
    font-size: 15px; font-weight: 500; color: var(--text-mid);
    box-shadow: var(--shadow-sm);
}
.pill-dot { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; }
.pill-dot.green { background: var(--green); }
.pill-dot.amber { background: var(--amber); }
.pill-dot.red   { background: var(--red); }
.pill-dot.blue  { background: var(--blue); }

/* ── SLIDE PANEL (shared) ── */
.slide-panel { display: none; margin-bottom: 1.3rem; animation: slideDown .2s ease; }
.slide-panel.open { display: block; }
@keyframes slideDown {
    from { opacity:0; transform:translateY(-8px); }
    to   { opacity:1; transform:translateY(0); }
}
.panel-card {
    background: var(--card); border-radius: var(--radius);
    border: 1.5px solid var(--border);
    box-shadow: var(--shadow-md); overflow: hidden;
}
.panel-card.accent-blue  { border-color: var(--blue); box-shadow: 0 4px 20px rgba(59,130,246,.10); }
.panel-card.accent-red   { border-color: var(--red);  box-shadow: 0 4px 20px rgba(220,38,38,.08); }
.panel-head {
    display: flex; align-items: center; justify-content: space-between;
    padding: 17px 22px; border-bottom: 1px solid var(--border);
    background: #fdfdfd;
}
.panel-head-left { display: flex; align-items: center; gap: 9px; }
.panel-head-icon {
    width: 34px; height: 34px; border-radius: 7px;
    display: flex; align-items: center; justify-content: center;
}
.panel-head-icon svg { width: 17px; height: 17px; }
.panel-head-icon.blue { background: var(--blue-light); color: var(--blue); }
.panel-head-icon.red  { background: var(--red-light);  color: var(--red); }
.panel-head strong { font-size: 17px; color: var(--text); }
.panel-close {
    background: none; border: none; cursor: pointer;
    color: var(--text-muted); font-size: 22px; line-height: 1;
    padding: 2px 6px; border-radius: 6px; transition: background .15s;
}
.panel-close:hover { background: var(--surface); color: var(--text); }

/* ── FORM GRID ── */
.form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 14px; padding: 22px;
}
.form-group label {
    display: block; font-size: 14px; font-weight: 600;
    color: var(--text-mid); margin-bottom: 7px;
    text-transform: uppercase; letter-spacing: .04em;
}
.form-group input,
.form-group select {
    width: 100%; padding: 11px 14px;
    font-family: var(--font); font-size: 16px;
    border: 1.5px solid var(--border); border-radius: var(--radius-sm);
    background: var(--surface); color: var(--text); outline: none;
    transition: border-color .2s, box-shadow .2s;
}
.form-group input:focus,
.form-group select:focus {
    border-color: var(--blue); background: var(--card);
    box-shadow: 0 0 0 3px rgba(59,130,246,.10);
}
.form-group input::placeholder { color: var(--text-muted); }
.panel-actions { display: flex; gap: 8px; padding: 0 22px 22px; }

/* ── CATEGORY MANAGER ── */
.cat-panel-body { padding: 22px; }
.cat-add-row {
    display: flex; gap: 8px; margin-bottom: 16px;
}
.cat-add-row input {
    flex: 1; padding: 11px 14px;
    font-family: var(--font); font-size: 16px;
    border: 1.5px solid var(--border); border-radius: var(--radius-sm);
    background: var(--surface); color: var(--text); outline: none;
    transition: border-color .2s, box-shadow .2s;
}
.cat-add-row input:focus {
    border-color: var(--blue); background: var(--card);
    box-shadow: 0 0 0 3px rgba(59,130,246,.10);
}
.cat-add-row input::placeholder { color: var(--text-muted); }

.cat-list { display: flex; flex-direction: column; gap: 6px; max-height: 320px; overflow-y: auto; }
.cat-list::-webkit-scrollbar { width: 4px; }
.cat-list::-webkit-scrollbar-thumb { background: var(--border-dark); border-radius: 4px; }

.cat-item {
    display: flex; align-items: center; justify-content: space-between;
    padding: 13px 16px;
    background: var(--surface); border: 1px solid var(--border);
    border-radius: var(--radius-sm);
    font-size: 16px; color: var(--text);
    transition: border-color .15s;
}
.cat-item:hover { border-color: var(--border-dark); }
.cat-item-left { display: flex; align-items: center; gap: 9px; }
.cat-dot {
    width: 9px; height: 9px; border-radius: 50%;
    background: var(--blue); flex-shrink: 0; opacity: .6;
}
.cat-name { font-weight: 500; }
.cat-count { font-size: 14px; color: var(--text-muted); margin-left: 4px; }
.cat-delete {
    background: none; border: 1px solid transparent;
    border-radius: 6px; padding: 5px 11px;
    font-size: 15px; font-weight: 600;
    color: var(--text-muted); cursor: pointer;
    transition: all .15s; display: flex; align-items: center; gap: 4px;
}
.cat-delete svg { width: 15px; height: 15px; }
.cat-delete:hover { color: var(--red); border-color: #fca5a5; background: var(--red-light); }
.cat-delete:disabled { opacity: .35; cursor: not-allowed; }
.cat-empty { text-align: center; padding: 1.5rem; color: var(--text-muted); font-size: 16px; }

/* ── TOOLBAR ── */
.toolbar { display: flex; align-items: center; gap: 8px; margin-bottom: 1rem; flex-wrap: wrap; }
.toolbar-search {
    display: flex; align-items: center;
    background: var(--card); border: 1.5px solid var(--border);
    border-radius: var(--radius-sm); padding: 0 14px;
    gap: 8px; height: 46px; flex: 1;
    min-width: 180px; max-width: 300px;
    transition: border-color .2s, box-shadow .2s;
}
.toolbar-search:focus-within {
    border-color: var(--blue);
    box-shadow: 0 0 0 3px rgba(59,130,246,.10);
}
.toolbar-search svg { width: 17px; height: 17px; color: var(--text-muted); flex-shrink: 0; }
.toolbar-search input {
    border: none; background: none; outline: none;
    font-family: var(--font); font-size: 16px; color: var(--text); width: 100%;
}
.toolbar-search input::placeholder { color: var(--text-muted); }
.filter-select {
    font-family: var(--font); font-size: 16px; font-weight: 500;
    padding: 0 14px; height: 46px;
    border: 1.5px solid var(--border); border-radius: var(--radius-sm);
    background: var(--card); color: var(--text-mid);
    cursor: pointer; outline: none; transition: border-color .2s;
}
.filter-select:focus { border-color: var(--blue); }

/* ── TABLE ── */
.table-card {
    background: var(--card); border: 1px solid var(--border);
    border-radius: var(--radius); overflow: hidden; box-shadow: var(--shadow-sm);
}
.products-table { width: 100%; border-collapse: collapse; font-size: 16px; }
.products-table thead th {
    padding: 13px 17px; text-align: left;
    font-size: 14px; text-transform: uppercase;
    letter-spacing: .08em; color: var(--text-muted);
    font-weight: 600; background: #fdfdfd;
    border-bottom: 1px solid var(--border); white-space: nowrap;
}
.products-table thead th.sortable { cursor: pointer; user-select: none; }
.products-table thead th.sortable:hover { color: var(--text); }
.products-table tbody tr { border-bottom: 1px solid #f1f5f9; transition: background .1s; }
.products-table tbody tr:last-child { border-bottom: none; }
.products-table tbody tr:hover { background: #fafbfc; }
.products-table tbody td { padding: 14px 17px; color: var(--text-mid); vertical-align: middle; }

.code-chip {
    font-family: var(--font-mono); font-size: 14px;
    background: #f1f5f9; border: 1px solid var(--border);
    padding: 3px 10px; border-radius: 5px; color: var(--text-mid); white-space: nowrap;
}
.code-chip.empty { color: #ccc; background: none; border-color: transparent; font-style: italic; }

.prod-name { font-weight: 600; color: var(--text); font-size: 16px; }
.prod-supplier { font-size: 14px; color: var(--text-muted); margin-top: 1px; }

.price-cell { font-weight: 700; color: var(--text); font-variant-numeric: tabular-nums; }

.stock-cell { display: flex; align-items: center; gap: 8px; }
.stock-num  { font-weight: 700; min-width: 26px; font-size: 16px; }
.stock-bar-wrap { width: 54px; height: 5px; background: #e2e8f0; border-radius: 10px; overflow: hidden; flex-shrink: 0; }
.stock-bar { height: 100%; border-radius: 10px; transition: width .3s; }
.stock-bar.green { background: var(--green); }
.stock-bar.amber { background: var(--amber); }
.stock-bar.red   { background: var(--red); }

.status-badge {
    display: inline-flex; align-items: center; gap: 5px;
    font-size: 14px; font-weight: 600;
    padding: 5px 13px; border-radius: 20px; white-space: nowrap;
}
.status-badge::before {
    content: ''; width: 7px; height: 7px;
    border-radius: 50%; flex-shrink: 0;
}
.status-badge.in-stock  { background: var(--green-light); color: var(--green-dark); }
.status-badge.in-stock::before  { background: var(--green); }
.status-badge.low-stock { background: var(--amber-light); color: #78350f; }
.status-badge.low-stock::before { background: var(--amber); }
.status-badge.out-stock { background: var(--red-light);   color: #7f1d1d; }
.status-badge.out-stock::before { background: var(--red); }

.row-actions { display: flex; gap: 4px; opacity: 0; transition: opacity .15s; }
.products-table tbody tr:hover .row-actions { opacity: 1; }
.action-btn {
    background: none; border: 1px solid var(--border);
    border-radius: 6px; padding: 6px 14px;
    font-size: 14px; font-weight: 600;
    cursor: pointer; transition: all .15s;
    font-family: var(--font); text-decoration: none;
    display: inline-flex; align-items: center;
}
.action-btn.edit   { color: var(--blue); border-color: #bfdbfe; }
.action-btn.edit:hover   { background: var(--blue-light); }
.action-btn.delete { color: var(--red);  border-color: #fca5a5; }
.action-btn.delete:hover { background: var(--red-light); }

.table-footer {
    display: flex; align-items: center; justify-content: space-between;
    padding: 13px 17px; border-top: 1px solid var(--border);
    background: #fdfdfd; font-size: 15px; color: var(--text-muted);
}

.empty-state { text-align: center; padding: 3.5rem 2rem; color: var(--text-muted); }
.empty-state svg { width: 42px; height: 42px; opacity: .25; margin-bottom: 10px; }
.empty-state p { font-size: 16px; }

/* ── SWEETALERT2 CUSTOM THEME ── */
.swal2-popup {
    font-family: var(--font) !important;
    border-radius: 16px !important;
}
.swal2-title {
    font-size: 20px !important;
    font-weight: 700 !important;
    color: var(--text) !important;
}
.swal2-html-container {
    font-size: 15px !important;
    color: var(--text-mid) !important;
}
.swal2-confirm {
    font-family: var(--font) !important;
    font-weight: 600 !important;
    border-radius: 9px !important;
    font-size: 15px !important;
    padding: 10px 24px !important;
}
.swal2-cancel {
    font-family: var(--font) !important;
    font-weight: 600 !important;
    border-radius: 9px !important;
    font-size: 15px !important;
    padding: 10px 24px !important;
}
.swal2-timer-progress-bar { background: var(--green) !important; }

@media (max-width: 768px) {
    .summary-pills { display: none; }
    .toolbar-search { max-width: 100%; }
}
</style>
@endpush

@section('content')

{{-- PAGE HEADER --}}
<div class="page-header">
    <div>
        <div class="page-title">Products</div>
        <div class="page-sub">{{ $products->count() }} total products in inventory</div>
    </div>
    <div class="header-actions">
        <button class="btn btn-ghost" onclick="togglePanel('cat-panel', 'toggle-cat-btn')" id="toggle-cat-btn">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M4 6h16M4 12h8M4 18h4"/>
            </svg>
            Manage Categories
        </button>
        <button class="btn btn-primary" onclick="togglePanel('add-panel', 'toggle-add-btn')" id="toggle-add-btn">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
            </svg>
            Add Product
        </button>
    </div>
</div>

{{-- SUMMARY PILLS --}}
@php
    $inStockCount = $products->where('stock', '>', 0)->filter(fn($p) => $p->stock > $p->min_stock)->count();
    $lowCount     = $products->filter(fn($p) => $p->stock > 0 && $p->stock <= $p->min_stock)->count();
    $outCount     = $products->where('stock', '<=', 0)->count();
@endphp
<div class="summary-pills">
    <div class="pill"><span class="pill-dot blue"></span>   {{ $products->count() }} Total</div>
    <div class="pill"><span class="pill-dot green"></span>  {{ $inStockCount }} In Stock</div>
    <div class="pill"><span class="pill-dot amber"></span>  {{ $lowCount }} Low Stock</div>
    <div class="pill"><span class="pill-dot red"></span>    {{ $outCount }} Out of Stock</div>
</div>

{{-- ═══════════════════════════════════════════════════════════════
     CATEGORY MANAGER PANEL
═══════════════════════════════════════════════════════════════ --}}
<div class="slide-panel" id="cat-panel">
    <div class="panel-card accent-blue">
        <div class="panel-head">
            <div class="panel-head-left">
                <div class="panel-head-icon blue">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 6h16M4 12h8M4 18h4"/>
                    </svg>
                </div>
                <strong>Manage Categories</strong>
            </div>
            <button class="panel-close" onclick="togglePanel('cat-panel', 'toggle-cat-btn')">✕</button>
        </div>

        <div class="cat-panel-body">

            {{-- Add new category --}}
            <div class="cat-add-row">
                <input type="text" id="newCatInput" placeholder="Type new category name…"
                       onkeydown="if(event.key==='Enter'){addCategory()}"
                       maxlength="60">
                <button class="btn btn-primary" onclick="addCategory()">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                    </svg>
                    Add
                </button>
            </div>

            {{-- Category list --}}
            <div class="cat-list" id="cat-list">
                @forelse($categories as $cat)
                <div class="cat-item" id="cat-row-{{ $cat->id }}">
                    <div class="cat-item-left">
                        <span class="cat-dot"></span>
                        <span class="cat-name">{{ $cat->name }}</span>
                        <span class="cat-count">({{ $cat->products_count ?? 0 }} products)</span>
                    </div>
                    <button class="cat-delete"
                            onclick="deleteCategory({{ $cat->id }}, '{{ addslashes($cat->name) }}', {{ $cat->products_count ?? 0 }}, this)"
                            {{ ($cat->products_count ?? 0) > 0 ? 'disabled title=\'Has products — reassign first\'' : '' }}>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                            <path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
                        </svg>
                        Delete
                    </button>
                </div>
                @empty
                <div class="cat-empty" id="cat-empty-msg">No categories yet. Add one above.</div>
                @endforelse
            </div>

        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════════════
     ADD PRODUCT PANEL
═══════════════════════════════════════════════════════════════ --}}
<div class="slide-panel" id="add-panel">
    <div class="panel-card accent-red">
        <div class="panel-head">
            <div class="panel-head-left">
                <div class="panel-head-icon red">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
                    </svg>
                </div>
                <strong>Add New Product</strong>
            </div>
            <button class="panel-close" onclick="togglePanel('add-panel', 'toggle-add-btn')">✕</button>
        </div>
        <form action="{{ route('products.store') }}" method="POST">
            @csrf
            <div class="form-grid">
                <div class="form-group">
                    <label>Product Code</label>
                    <input type="text" name="product_code" placeholder="e.g. BOY-PER-4L-WHT">
                </div>
                <div class="form-group">
                    <label>Product Name *</label>
                    <input type="text" name="name" placeholder="e.g. Boysen Permacoat Latex" required>
                </div>
                <div class="form-group">
                    <label>Brand *</label>
                    <input type="text" name="brand" placeholder="e.g. Boysen" required>
                </div>
                <div class="form-group">
                    <label>Category</label>
                    <select name="category" id="add-category-select">
                        <option value="">— Select category —</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->name }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Size</label>
                    <select name="size">
                        <option>1L</option>
                        <option>4L</option>
                        <option>5L</option>
                        <option>16L</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Price (₱) *</label>
                    <input type="number" name="price" placeholder="0.00" step="0.01" required>
                </div>
                <div class="form-group">
                    <label>Stock Quantity *</label>
                    <input type="number" name="stock" placeholder="0" required>
                </div>
                <div class="form-group">
                    <label>Min Stock Level</label>
                    <input type="number" name="min_stock" placeholder="5">
                </div>
                <div class="form-group">
                    <label>Supplier</label>
                    <input type="text" name="supplier" placeholder="Supplier name">
                </div>
            </div>
            <div class="panel-actions">
                <button type="submit" class="btn btn-primary">Save Product</button>
                <button type="button" class="btn btn-ghost" onclick="togglePanel('add-panel', 'toggle-add-btn')">Cancel</button>
            </div>
        </form>
    </div>
</div>

{{-- TOOLBAR --}}
<div class="toolbar">
    <div class="toolbar-search">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
        </svg>
        <input type="text" id="searchInput" placeholder="Search products…" oninput="filterTable()">
    </div>
    <select class="filter-select" id="categoryFilter" onchange="filterTable()">
        <option value="">All Categories</option>
        @foreach($categories as $cat)
            <option value="{{ $cat->name }}">{{ $cat->name }}</option>
        @endforeach
    </select>
    <select class="filter-select" id="statusFilter" onchange="filterTable()">
        <option value="">All Status</option>
        <option value="in-stock">In Stock</option>
        <option value="low-stock">Low Stock</option>
        <option value="out-stock">Out of Stock</option>
    </select>
</div>

{{-- PRODUCTS TABLE --}}
<div class="table-card">
    <table class="products-table" id="productsTable">
        <thead>
            <tr>
                <th>Code</th>
                <th class="sortable" onclick="sortTable(1)">Product ↕</th>
                <th>Brand</th>
                <th>Category</th>
                <th>Size</th>
                <th class="sortable" onclick="sortTable(5)">Price ↕</th>
                <th class="sortable" onclick="sortTable(6)">Stock ↕</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody id="tableBody">
            @forelse($products as $product)
            @php
                $stockPct    = $product->min_stock > 0
                    ? min(100, ($product->stock / max($product->min_stock * 2, 1)) * 100)
                    : min(100, $product->stock * 10);
                $stockColor  = $product->stock <= 0 ? 'red' : ($product->stock <= $product->min_stock ? 'amber' : 'green');
                $statusClass = $product->stock <= 0 ? 'out-stock' : ($product->stock <= $product->min_stock ? 'low-stock' : 'in-stock');
                $statusLabel = $product->stock <= 0 ? 'Out of Stock' : ($product->stock <= $product->min_stock ? 'Low Stock' : 'In Stock');
            @endphp
            <tr data-status="{{ $statusClass }}" data-category="{{ $product->category }}">
                <td>
                    @if($product->product_code)
                        <span class="code-chip">{{ $product->product_code }}</span>
                    @else
                        <span class="code-chip empty">—</span>
                    @endif
                </td>
                <td>
                    <div class="prod-name">{{ $product->name }}</div>
                    @if($product->supplier)
                        <div class="prod-supplier">{{ $product->supplier }}</div>
                    @endif
                </td>
                <td>{{ $product->brand }}</td>
                <td>{{ $product->category }}</td>
                <td>{{ $product->size }}</td>
                <td class="price-cell">₱{{ number_format($product->price, 2) }}</td>
                <td>
                    <div class="stock-cell">
                        <span class="stock-num">{{ $product->stock }}</span>
                        <div class="stock-bar-wrap">
                            <div class="stock-bar {{ $stockColor }}" style="width:{{ $stockPct }}%"></div>
                        </div>
                    </div>
                </td>
                <td><span class="status-badge {{ $statusClass }}">{{ $statusLabel }}</span></td>
                <td>
                    <div class="row-actions">
                        <a href="{{ route('products.edit', $product) }}" class="action-btn edit">Edit</a>
                        {{-- Hidden delete form --}}
                        <form method="POST" action="{{ route('products.destroy', $product) }}"
                              id="delete-form-{{ $product->id }}" style="display:none;">
                            @csrf @method('DELETE')
                        </form>
                        <button type="button" class="action-btn delete"
                                onclick="confirmDeleteProduct({{ $product->id }}, '{{ addslashes($product->name) }}')">
                            Delete
                        </button>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9">
                    <div class="empty-state">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
                        </svg>
                        <p>No products found. Add your first product above.</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($products->count() > 0)
    <div class="table-footer">
        <span id="rowCount">Showing {{ $products->count() }} products</span>
    </div>
    @endif
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
const CAT_STORE_URL  = "{{ route('categories.store') }}";
const CAT_DELETE_URL = "{{ url('categories') }}";
const CSRF           = "{{ csrf_token() }}";

/* ══════════════════════════════════════════
   SWEETALERT2 SHARED CONFIG
══════════════════════════════════════════ */
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3500,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.onmouseenter = Swal.stopTimer;
        toast.onmouseleave = Swal.resumeTimer;
    }
});

function toastSuccess(msg) {
    Toast.fire({ icon: 'success', title: msg });
}

function toastError(msg) {
    Toast.fire({ icon: 'error', title: msg });
}

/* ── Fire session success toast on page load ── */
@if(session('success'))
    document.addEventListener('DOMContentLoaded', () => {
        toastSuccess("{{ session('success') }}");
    });
@endif

/* ── Panel toggle ── */
function togglePanel(panelId, btnId) {
    const panel = document.getElementById(panelId);
    const btn   = document.getElementById(btnId);
    const isOpen = panel.classList.toggle('open');

    if (btnId === 'toggle-add-btn') {
        btn.innerHTML = isOpen
            ? `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:17px;height:17px"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg> Close`
            : `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:17px;height:17px"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg> Add Product`;
    }
}

/* ══════════════════════════════════════════
   PRODUCT DELETE — SweetAlert confirm
══════════════════════════════════════════ */
function confirmDeleteProduct(id, name) {
    Swal.fire({
        title: 'Delete Product?',
        html: `<span style="color:#475569">Are you sure you want to delete <strong>${escHtml(name)}</strong>? This cannot be undone.</span>`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#64748b',
        reverseButtons: true,
        focusCancel: true,
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById(`delete-form-${id}`).submit();
        }
    });
}

/* ══════════════════════════════════════════
   CATEGORY — Add via AJAX
══════════════════════════════════════════ */
async function addCategory() {
    const input = document.getElementById('newCatInput');
    const name  = input.value.trim();
    if (!name) { input.focus(); return; }

    try {
        const res  = await fetch(CAT_STORE_URL, {
            method : 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
            body   : JSON.stringify({ name }),
        });
        const data = await res.json();

        if (data.success) {
            appendCategoryRow(data.category);
            appendCategoryOption(data.category.name);
            input.value = '';
            input.focus();
            toastSuccess(`Category "${escHtml(name)}" added!`);
        } else {
            toastError(data.message || 'Could not add category.');
        }
    } catch(e) {
        toastError('Network error. Please try again.');
    }
}

function appendCategoryRow(cat) {
    const emptyMsg = document.getElementById('cat-empty-msg');
    if (emptyMsg) emptyMsg.remove();

    const list = document.getElementById('cat-list');
    const div  = document.createElement('div');
    div.className = 'cat-item';
    div.id        = `cat-row-${cat.id}`;
    div.innerHTML = `
        <div class="cat-item-left">
            <span class="cat-dot"></span>
            <span class="cat-name">${escHtml(cat.name)}</span>
            <span class="cat-count">(0 products)</span>
        </div>
        <button class="cat-delete" onclick="deleteCategory(${cat.id}, '${escHtml(cat.name)}', 0, this)">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:15px;height:15px">
                <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                <path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
            </svg>
            Delete
        </button>`;
    list.appendChild(div);
}

function appendCategoryOption(name) {
    const escaped = escHtml(name);
    const filterSel = document.getElementById('categoryFilter');
    const opt1 = new Option(escaped, name);
    filterSel.appendChild(opt1);
    const formSel = document.getElementById('add-category-select');
    const opt2 = new Option(escaped, name);
    formSel.appendChild(opt2);
}

/* ══════════════════════════════════════════
   CATEGORY — Delete via AJAX with SweetAlert confirm
══════════════════════════════════════════ */
async function deleteCategory(id, name, count, btn) {
    if (count > 0) {
        Swal.fire({
            title: 'Cannot Delete',
            html: `<span style="color:#475569"><strong>${escHtml(name)}</strong> has ${count} product(s) assigned. Reassign them first before deleting this category.</span>`,
            icon: 'info',
            confirmButtonText: 'Got it',
            confirmButtonColor: '#3b82f6',
        });
        return;
    }

    const result = await Swal.fire({
        title: 'Delete Category?',
        html: `<span style="color:#475569">Are you sure you want to delete <strong>${escHtml(name)}</strong>? This cannot be undone.</span>`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#64748b',
        reverseButtons: true,
        focusCancel: true,
    });

    if (!result.isConfirmed) return;

    btn.disabled = true;

    try {
        const res  = await fetch(`${CAT_DELETE_URL}/${id}`, {
            method : 'DELETE',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
        });
        const data = await res.json();

        if (data.success) {
            document.getElementById(`cat-row-${id}`)?.remove();
            removeCategoryOption(name);
            if (!document.querySelector('#cat-list .cat-item')) {
                const list = document.getElementById('cat-list');
                list.innerHTML = '<div class="cat-empty" id="cat-empty-msg">No categories yet. Add one above.</div>';
            }
            toastSuccess(`Category "${escHtml(name)}" deleted.`);
        } else {
            toastError(data.message || 'Could not delete category.');
            btn.disabled = false;
        }
    } catch(e) {
        toastError('Network error. Please try again.');
        btn.disabled = false;
    }
}

function removeCategoryOption(name) {
    [document.getElementById('categoryFilter'), document.getElementById('add-category-select')]
        .forEach(sel => {
            if (!sel) return;
            Array.from(sel.options).forEach(opt => {
                if (opt.value === name) opt.remove();
            });
        });
}

/* ── Table filter ── */
function filterTable() {
    const search   = document.getElementById('searchInput').value.toLowerCase();
    const category = document.getElementById('categoryFilter').value.toLowerCase();
    const status   = document.getElementById('statusFilter').value.toLowerCase();
    const rows     = document.querySelectorAll('#tableBody tr[data-status]');
    let visible    = 0;

    rows.forEach(row => {
        const matchSearch   = !search   || row.textContent.toLowerCase().includes(search);
        const matchCategory = !category || row.dataset.category.toLowerCase() === category;
        const matchStatus   = !status   || row.dataset.status === status;
        const show = matchSearch && matchCategory && matchStatus;
        row.style.display = show ? '' : 'none';
        if (show) visible++;
    });

    const counter = document.getElementById('rowCount');
    if (counter) counter.textContent = `Showing ${visible} products`;
}

/* ── Sort ── */
let sortDir = {};
function sortTable(colIndex) {
    const tbody = document.getElementById('tableBody');
    const rows  = Array.from(tbody.querySelectorAll('tr[data-status]'));
    sortDir[colIndex] = !sortDir[colIndex];
    rows.sort((a, b) => {
        const aT = a.cells[colIndex]?.textContent.trim() || '';
        const bT = b.cells[colIndex]?.textContent.trim() || '';
        const aN = parseFloat(aT.replace(/[₱,]/g, ''));
        const bN = parseFloat(bT.replace(/[₱,]/g, ''));
        const cmp = isNaN(aN) ? aT.localeCompare(bT) : aN - bN;
        return sortDir[colIndex] ? cmp : -cmp;
    });
    rows.forEach(r => tbody.appendChild(r));
}

/* ── Helpers ── */
function escHtml(str) {
    return String(str)
        .replace(/&/g,'&amp;').replace(/</g,'&lt;')
        .replace(/>/g,'&gt;').replace(/"/g,'&quot;').replace(/'/g,'&#39;');
}
</script>
@endpush