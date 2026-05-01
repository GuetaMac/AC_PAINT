@extends('layouts.app')

@section('title', 'Edit Product')

@push('styles')
<style>
    /* ── PAGE HEADER ── */
    .page-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        margin-bottom: 1.6rem;
        gap: 1rem;
    }
    .page-header-left .page-title {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 2.4rem; /* was 2rem */
        letter-spacing: 0.05em;
        color: var(--black);
        line-height: 1;
    }
    .page-header-left .page-subtitle {
        font-size: 1rem; /* was 0.8rem */
        color: var(--gray-mid);
        margin-top: 3px;
    }

    /* ── BREADCRUMB ── */
    .breadcrumb {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 0.95rem; /* was 0.78rem */
        color: var(--gray-mid);
        margin-bottom: 1.4rem;
    }
    .breadcrumb a {
        color: var(--gray-mid);
        text-decoration: none;
        transition: color 0.15s;
    }
    .breadcrumb a:hover { color: var(--red); }
    .breadcrumb svg { width: 13px; height: 13px; stroke: #CCC; flex-shrink: 0; } /* was 10px */
    .breadcrumb span { color: var(--black); font-weight: 500; }

    /* ── EDIT CARD ── */
    .edit-card {
        background: var(--white);
        border: 1.5px solid var(--red);
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(208,18,18,0.08);
        overflow: hidden;
        max-width: 860px;
    }
    .edit-card-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1.1rem 1.5rem; /* was 0.9rem 1.3rem */
        border-bottom: 1px solid var(--border);
        background: #FAFAFA;
    }
    .edit-card-head strong {
        font-size: 1.05rem; /* was 0.88rem */
        color: var(--black);
    }
    .product-id-chip {
        font-family: 'Courier New', monospace;
        font-size: 14px; /* was 11px */
        background: #F0F0F0;
        border: 1px solid #E0E0E0;
        padding: 3px 10px; /* was 2px 8px */
        border-radius: 5px;
        color: #666;
    }

    /* ── SECTION LABEL ── */
    .section-label {
        font-size: 0.85rem; /* was 0.68rem */
        text-transform: uppercase;
        letter-spacing: 0.12em;
        font-weight: 700;
        color: #AAA;
        padding: 1rem 1.5rem 0.4rem; /* was 1rem 1.3rem 0.4rem */
    }

    /* ── FORM GRID ── */
    .form-grid {
        padding: 0 1.5rem 0.5rem; /* was 0 1.3rem 0.5rem */
    }

    /* ── STOCK STATUS PREVIEW ── */
    .stock-preview {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 16px; /* was 10px 14px */
        border-radius: 8px;
        font-size: 1rem; /* was 0.8rem */
        font-weight: 600;
        margin-top: 0.5rem;
        transition: all 0.2s;
    }
    .stock-preview.in-stock  { background: #DCFCE7; color: #15803D; border: 1px solid #BBF7D0; }
    .stock-preview.low-stock { background: #FEF3C7; color: #92400E; border: 1px solid #FDE68A; }
    .stock-preview.out-stock { background: #FEE2E2; color: #B91C1C; border: 1px solid #FECACA; }
    .stock-preview::before {
        content: '';
        width: 8px; height: 8px; /* was 7px */
        border-radius: 50%;
        flex-shrink: 0;
    }
    .stock-preview.in-stock::before  { background: #22c55e; }
    .stock-preview.low-stock::before { background: #f59e0b; }
    .stock-preview.out-stock::before { background: var(--red); }

    /* ── FORM ACTIONS ── */
    .edit-actions {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 1rem 1.5rem 1.3rem; /* was 0.9rem 1.3rem 1.2rem */
        border-top: 1px solid var(--border);
        background: #FAFAFA;
        margin-top: 0.6rem;
    }
    .spacer { flex: 1; }

    /* ── DELETE ZONE ── */
    .danger-zone {
        max-width: 860px;
        margin-top: 1.4rem;
        border: 1px solid #FECACA;
        border-radius: 12px;
        overflow: hidden;
    }
    .danger-zone-head {
        padding: 0.85rem 1.5rem; /* was 0.7rem 1.3rem */
        background: #FFF5F5;
        border-bottom: 1px solid #FECACA;
        font-size: 0.9rem; /* was 0.75rem */
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: #B91C1C;
    }
    .danger-zone-body {
        padding: 1.1rem 1.5rem; /* was 1rem 1.3rem */
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        background: var(--white);
    }
    .danger-zone-body p {
        font-size: 1rem; /* was 0.82rem */
        color: var(--gray-mid);
        max-width: 480px;
    }

    /* ── VALIDATION ERRORS ── */
    .alert-errors {
        background: #FEF2F2;
        border: 1px solid #FECACA;
        border-radius: 10px;
        padding: 14px 18px; /* was 12px 16px */
        margin-bottom: 1.2rem;
        font-size: 1rem; /* was 0.82rem */
        color: #B91C1C;
        max-width: 860px;
    }
    .alert-errors ul { margin: 0; padding-left: 1.2rem; }
    .alert-errors li + li { margin-top: 4px; }

    /* ── RESPONSIVE ── */
    @media (max-width: 768px) {
        .danger-zone-body { flex-direction: column; align-items: flex-start; }
    }
</style>
@endpush

@section('content')

{{-- BREADCRUMB --}}
<div class="breadcrumb">
    <a href="{{ route('products.index') }}">Products</a>
    <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <polyline points="9 18 15 12 9 6"/>
    </svg>
    <span>Edit Product</span>
</div>

{{-- PAGE HEADER --}}
<div class="page-header">
    <div class="page-header-left">
        <div class="page-title">Edit Product</div>
        <div class="page-subtitle">{{ $product->name }}</div>
    </div>
    <a href="{{ route('products.index') }}" class="btn-sm">← Back to Products</a>
</div>

{{-- VALIDATION ERRORS --}}
@if($errors->any())
<div class="alert-errors">
    <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

{{-- EDIT CARD --}}
<div class="edit-card">
    <div class="edit-card-head">
        <strong>Product Details</strong>
        @if($product->product_code)
            <span class="product-id-chip">{{ $product->product_code }}</span>
        @endif
    </div>

    <form action="{{ route('products.update', $product) }}" method="POST" id="editForm">
        @csrf
        @method('PUT')

        <div class="section-label">Identification</div>
        <div class="form-grid">
            <div class="form-group">
                <label>Product Code</label>
                <input type="text" name="product_code" value="{{ old('product_code', $product->product_code) }}" placeholder="e.g. BOY-PER-4L-WHT">
            </div>
            <div class="form-group">
                <label>Product Name <span style="color:var(--red)">*</span></label>
                <input type="text" name="name" value="{{ old('name', $product->name) }}" placeholder="e.g. Boysen Permacoat Latex White" required>
            </div>
        </div>

        <div class="section-label">Classification</div>
        <div class="form-grid">
            <div class="form-group">
                <label>Brand <span style="color:var(--red)">*</span></label>
                <input type="text" name="brand" value="{{ old('brand', $product->brand) }}" placeholder="e.g. Boysen" required>
            </div>
            <div class="form-group">
                <label>Category</label>
                <select name="category">
                    @foreach(['Latex Paint','Enamel Paint','Roof Paint','Epoxy','Primer','Thinner'] as $cat)
                        <option value="{{ $cat }}" @selected(old('category', $product->category) === $cat)>{{ $cat }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Size</label>
                <select name="size">
                    @foreach(['1L','4L','5L','16L'] as $sz)
                        <option value="{{ $sz }}" @selected(old('size', $product->size) === $sz)>{{ $sz }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Supplier</label>
                <input type="text" name="supplier" value="{{ old('supplier', $product->supplier) }}" placeholder="Supplier name">
            </div>
        </div>

        <div class="section-label">Pricing & Inventory</div>
        <div class="form-grid">
            <div class="form-group">
                <label>Price (₱) <span style="color:var(--red)">*</span></label>
                <input type="number" name="price" value="{{ old('price', $product->price) }}" placeholder="0.00" step="0.01" required>
            </div>
            <div class="form-group">
                <label>Stock Quantity <span style="color:var(--red)">*</span></label>
                <input type="number" name="stock" id="stockInput" value="{{ old('stock', $product->stock) }}" placeholder="0" required oninput="updateStockPreview()">
            </div>
            <div class="form-group">
                <label>Min Stock Level</label>
                <input type="number" name="min_stock" id="minStockInput" value="{{ old('min_stock', $product->min_stock) }}" placeholder="5" oninput="updateStockPreview()">
            </div>
        </div>

        {{-- Live stock status preview --}}
        <div style="padding: 0 1.5rem 1rem;">
            <div class="stock-preview" id="stockPreview">In Stock</div>
        </div>

        <div class="edit-actions">
            <button type="submit" class="btn-sm solid">Save Changes</button>
            <a href="{{ route('products.index') }}" class="btn-sm">Cancel</a>
            <div class="spacer"></div>
            <span style="font-size:0.9rem;color:#CCC;"> <!-- was 0.72rem -->
                Last updated: {{ $product->updated_at->diffForHumans() }}
            </span>
        </div>
    </form>
</div>

{{-- DANGER ZONE --}}
<div class="danger-zone">
    <div class="danger-zone-head">⚠ Danger Zone</div>
    <div class="danger-zone-body">
        <p>Permanently delete <strong>{{ $product->name }}</strong> from the inventory. This action cannot be undone.</p>
        <form method="POST" action="{{ route('products.destroy', $product) }}"
              onsubmit="return confirm('Delete {{ addslashes($product->name) }}? This cannot be undone.')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-sm" style="color:var(--red);border-color:#FECACA;">
                Delete Product
            </button>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function updateStockPreview() {
        const stock    = parseInt(document.getElementById('stockInput').value) || 0;
        const minStock = parseInt(document.getElementById('minStockInput').value) || 0;
        const preview  = document.getElementById('stockPreview');

        preview.classList.remove('in-stock', 'low-stock', 'out-stock');

        if (stock <= 0) {
            preview.classList.add('out-stock');
            preview.textContent = 'Out of Stock';
        } else if (minStock > 0 && stock <= minStock) {
            preview.classList.add('low-stock');
            preview.textContent = `Low Stock — ${stock} unit${stock !== 1 ? 's' : ''} remaining`;
        } else {
            preview.classList.add('in-stock');
            preview.textContent = `In Stock — ${stock} unit${stock !== 1 ? 's' : ''} available`;
        }
    }

    // Run on page load to set initial state
    updateStockPreview();
</script>
@endpush