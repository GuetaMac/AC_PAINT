{{-- resources/views/purchasing/index.blade.php --}}
@extends('layouts.app')

@section('title', 'New Purchase')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<style>
/* ── CSS VARIABLES ──────────────────────────────────────── */
:root {
    --green:       #16a34a;
    --green-light: #dcfce7;
    --green-mid:   #bbf7d0;
    --green-dark:  #14532d;
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
    --accent:      #0ea5e9;
    --radius:      14px;
    --radius-sm:   8px;
    --shadow-sm:   0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
    --shadow-md:   0 4px 16px rgba(0,0,0,0.08), 0 2px 6px rgba(0,0,0,0.04);
    --shadow-lg:   0 12px 40px rgba(0,0,0,0.10), 0 4px 12px rgba(0,0,0,0.05);
    --font:        'DM Sans', sans-serif;
    --font-mono:   'DM Mono', monospace;
}

*, *::before, *::after { box-sizing: border-box; }

body { font-family: var(--font); background: var(--surface); color: var(--text); }

/* ── SWEETALERT2 OVERRIDES ──────────────────────────────── */
.swal2-popup {
    font-family: var(--font) !important;
    border-radius: var(--radius) !important;
    border: 1px solid var(--border) !important;
    box-shadow: var(--shadow-lg) !important;
    padding: 2rem 2.25rem !important;
}
.swal2-title {
    font-size: 18px !important;
    font-weight: 600 !important;
    color: var(--text) !important;
    letter-spacing: -0.2px !important;
}
.swal2-html-container {
    font-size: 14.5px !important;
    color: var(--text-mid) !important;
    line-height: 1.6 !important;
}
.swal2-confirm {
    font-family: var(--font) !important;
    font-size: 14.5px !important;
    font-weight: 600 !important;
    border-radius: 10px !important;
    padding: 10px 24px !important;
    box-shadow: none !important;
    letter-spacing: 0.01em !important;
}
.swal2-cancel {
    font-family: var(--font) !important;
    font-size: 14.5px !important;
    font-weight: 500 !important;
    border-radius: 10px !important;
    padding: 10px 24px !important;
    box-shadow: none !important;
}
.swal2-icon {
    border-width: 2px !important;
    margin-bottom: 1rem !important;
}
/* Toast style */
.swal2-toast-custom {
    font-family: var(--font) !important;
}
.swal2-toast .swal2-title {
    font-size: 14.5px !important;
}

/* ── PAGE HEADER ────────────────────────────────────────── */
.page-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1.5rem;
    gap: 1rem;
}
.page-header-left { display: flex; flex-direction: column; gap: 3px; }
.page-title {
    font-size: 26px;
    font-weight: 600;
    color: var(--text);
    letter-spacing: -0.3px;
}
.page-sub { font-size: 15px; color: var(--text-muted); }
.ref-badge {
    display: flex;
    align-items: center;
    gap: 8px;
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 50px;
    padding: 8px 18px;
    font-size: 13.5px;
    color: var(--text-mid);
    box-shadow: var(--shadow-sm);
}
.ref-badge strong {
    font-family: var(--font-mono);
    font-size: 14px;
    color: var(--text);
    letter-spacing: 0.04em;
}
.ref-dot {
    width: 7px; height: 7px;
    border-radius: 50%;
    background: var(--green);
    box-shadow: 0 0 0 2px var(--green-light);
    animation: pulse 2s infinite;
}
@keyframes pulse {
    0%, 100% { box-shadow: 0 0 0 2px var(--green-light); }
    50%       { box-shadow: 0 0 0 4px var(--green-mid); }
}

/* ── STAT CARDS ─────────────────────────────────────────── */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 10px;
    margin-bottom: 1.5rem;
}
.stat-card {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 18px 20px;
    display: flex;
    align-items: center;
    gap: 14px;
    box-shadow: var(--shadow-sm);
    transition: box-shadow .2s;
}
.stat-card:hover { box-shadow: var(--shadow-md); }
.stat-icon {
    width: 44px; height: 44px;
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.stat-icon svg { width: 20px; height: 20px; }
.stat-icon.blue   { background: #eff6ff; color: #3b82f6; }
.stat-icon.indigo { background: #eef2ff; color: #6366f1; }
.stat-icon.green  { background: var(--green-light); color: var(--green); }
.stat-info { min-width: 0; }
.stat-val {
    font-size: 22px;
    font-weight: 600;
    color: var(--text);
    line-height: 1.1;
    font-variant-numeric: tabular-nums;
}
.stat-val.green { color: var(--green); }
.stat-val.red   { color: var(--red); }
.stat-lbl { font-size: 13px; color: var(--text-muted); margin-top: 3px; }

/* ── TWO COLUMN ─────────────────────────────────────────── */
.two-col {
    display: grid;
    grid-template-columns: 1fr 1.1fr;
    gap: 14px;
    align-items: start;
}
@media (max-width: 780px) { .two-col { grid-template-columns: 1fr; } }

/* ── CARD ────────────────────────────────────────────────── */
.card {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    box-shadow: var(--shadow-sm);
    overflow: hidden;
    margin-bottom: 12px;
}
.card-head {
    display: flex;
    align-items: center;
    gap: 9px;
    padding: 16px 20px;
    border-bottom: 1px solid var(--border);
    background: #fdfdfd;
}
.card-head-icon {
    width: 30px; height: 30px;
    border-radius: 7px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.card-head-icon svg { width: 15px; height: 15px; }
.card-head-icon.blue   { background: #eff6ff; color: #3b82f6; }
.card-head-icon.violet { background: #f5f3ff; color: #7c3aed; }
.card-head-icon.green  { background: var(--green-light); color: var(--green); }
.card-head-title { font-size: 14px; font-weight: 600; color: var(--text); letter-spacing: 0.02em; }
.card-body { padding: 18px 20px; }

/* ── SEARCH ──────────────────────────────────────────────── */
.search-wrap {
    position: relative;
    margin-bottom: 10px;
}
.search-wrap input {
    width: 100%;
    padding: 11px 16px 11px 44px;
    font-size: 15px;
    font-family: var(--font);
    border: 1.5px solid var(--border);
    border-radius: 10px;
    background: var(--surface);
    color: var(--text);
    outline: none;
    transition: border-color .2s, box-shadow .2s;
}
.search-wrap input:focus {
    border-color: var(--accent);
    background: var(--card);
    box-shadow: 0 0 0 3px rgba(14,165,233,0.10);
}
.search-wrap input::placeholder { color: var(--text-muted); }
.search-ico {
    position: absolute;
    left: 14px; top: 50%;
    transform: translateY(-50%);
    width: 17px; height: 17px;
    color: var(--text-muted);
    pointer-events: none;
}

/* ── RESULTS LIST ────────────────────────────────────────── */
.results-list {
    border: 1px solid var(--border);
    border-radius: 10px;
    max-height: 280px;
    overflow-y: auto;
    box-shadow: var(--shadow-md);
    background: var(--card);
}
.results-list::-webkit-scrollbar { width: 4px; }
.results-list::-webkit-scrollbar-track { background: transparent; }
.results-list::-webkit-scrollbar-thumb { background: var(--border-dark); border-radius: 4px; }

.result-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 16px;
    cursor: pointer;
    border-bottom: 1px solid #f1f5f9;
    transition: background .12s;
    gap: 10px;
}
.result-item:last-child { border-bottom: none; }
.result-item:hover { background: #f8fafc; }
.ri-name { font-size: 14.5px; font-weight: 500; color: var(--text); }
.ri-meta { font-size: 13px; color: var(--text-muted); margin-top: 2px; }
.ri-right { display: flex; align-items: center; gap: 8px; flex-shrink: 0; }
.stock-badge {
    font-size: 12px;
    font-weight: 600;
    padding: 3px 9px;
    border-radius: 20px;
    white-space: nowrap;
}
.stock-badge.ok  { background: var(--green-light); color: var(--green); }
.stock-badge.low { background: var(--amber-light); color: var(--amber); }
.stock-badge.out { background: var(--red-light);   color: var(--red); }
.add-btn {
    font-size: 13px;
    font-family: var(--font);
    font-weight: 600;
    padding: 6px 14px;
    border: 1.5px solid var(--border-dark);
    border-radius: 7px;
    background: var(--card);
    color: var(--text);
    cursor: pointer;
    white-space: nowrap;
    transition: all .15s;
}
.add-btn:hover:not(:disabled) { background: var(--text); color: var(--card); border-color: var(--text); }
.add-btn:disabled { opacity: .35; cursor: not-allowed; }
.no-results { padding: 1.2rem; text-align: center; color: var(--text-muted); font-size: 14px; }

/* ── FORM FIELDS ─────────────────────────────────────────── */
.form-field { margin-bottom: 16px; }
.form-field:last-child { margin-bottom: 0; }
.form-field label {
    display: block;
    font-size: 13px;
    font-weight: 600;
    color: var(--text-mid);
    margin-bottom: 7px;
    letter-spacing: 0.03em;
    text-transform: uppercase;
}
.form-field .opt { color: var(--text-muted); font-weight: 400; text-transform: none; font-size: 12px; }
.form-field input {
    width: 100%;
    padding: 10px 14px;
    font-size: 15px;
    font-family: var(--font);
    border: 1.5px solid var(--border);
    border-radius: 10px;
    background: var(--surface);
    color: var(--text);
    outline: none;
    transition: border-color .2s, box-shadow .2s;
}
.form-field input:focus {
    border-color: var(--accent);
    background: var(--card);
    box-shadow: 0 0 0 3px rgba(14,165,233,0.10);
}
.form-field input::placeholder { color: var(--text-muted); }

/* ── PAYMENT TOGGLE ──────────────────────────────────────── */
.pay-toggle {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 8px;
}
.pay-opt {
    padding: 12px;
    border: 1.5px solid var(--border);
    border-radius: 10px;
    background: var(--surface);
    cursor: pointer;
    font-size: 14.5px;
    font-family: var(--font);
    font-weight: 500;
    color: var(--text-mid);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    transition: all .18s;
}
.pay-opt:hover { border-color: var(--border-dark); background: var(--card); color: var(--text); }
.pay-opt.active {
    border-color: var(--green);
    background: var(--green-light);
    color: var(--green-dark);
    box-shadow: 0 0 0 3px rgba(22,163,74,0.10);
}
.pay-opt svg { width: 17px; height: 17px; }

/* ── CART EMPTY ──────────────────────────────────────────── */
.cart-empty {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 2.5rem 1.5rem;
    color: var(--text-muted);
    gap: 12px;
}
.cart-empty-icon {
    width: 56px; height: 56px;
    border-radius: 50%;
    background: var(--surface);
    border: 1.5px dashed var(--border-dark);
    display: flex; align-items: center; justify-content: center;
}
.cart-empty-icon svg { width: 24px; height: 24px; opacity: .4; }
.cart-empty p { font-size: 14px; text-align: center; line-height: 1.6; }
.cart-empty strong { display: block; font-size: 15px; color: var(--text-mid); margin-bottom: 4px; }

/* ── CART TABLE ──────────────────────────────────────────── */
.cart-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 14px;
}
.cart-table th {
    padding: 9px 11px;
    color: var(--text-muted);
    font-weight: 600;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    border-bottom: 1px solid var(--border);
    text-align: left;
}
.cart-table td {
    padding: 11px 11px;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: middle;
}
.cart-table tr:last-child td { border-bottom: none; }
.cart-table tr:hover td { background: #fafbfc; }

.item-name { font-size: 14px; font-weight: 500; color: var(--text); line-height: 1.4; }
.item-price { font-size: 12.5px; color: var(--text-muted); margin-top: 2px; }

/* ── QTY CONTROL ─────────────────────────────────────────── */
.qty-ctrl { display: flex; align-items: center; gap: 6px; }
.qty-btn {
    width: 29px; height: 29px;
    border: 1.5px solid var(--border-dark);
    border-radius: 7px;
    background: var(--card);
    cursor: pointer;
    font-size: 15px;
    display: flex; align-items: center; justify-content: center;
    color: var(--text-mid);
    transition: all .15s;
    line-height: 1;
    font-family: var(--font);
}
.qty-btn:hover { background: var(--text); color: var(--card); border-color: var(--text); }
.qty-val { min-width: 26px; text-align: center; font-weight: 600; font-size: 15px; color: var(--text); }

.remove-btn {
    width: 29px; height: 29px;
    border: 1.5px solid #fca5a5;
    border-radius: 7px;
    background: var(--card);
    cursor: pointer;
    font-size: 16px;
    display: flex; align-items: center; justify-content: center;
    color: var(--red);
    transition: all .15s;
    line-height: 1;
}
.remove-btn:hover { background: var(--red); color: var(--card); border-color: var(--red); }

.amount-cell {
    font-weight: 600;
    font-size: 15px;
    color: var(--text);
    font-variant-numeric: tabular-nums;
    white-space: nowrap;
}

/* ── ORDER SUMMARY ───────────────────────────────────────── */
.order-summary {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 10px;
    padding: 16px 18px;
    margin-top: 14px;
}
.sum-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 5px 0;
    font-size: 14.5px;
    color: var(--text-mid);
}
.sum-row.total {
    font-weight: 700;
    font-size: 19px;
    color: var(--text);
    border-top: 1.5px solid var(--border-dark);
    padding-top: 11px;
    margin-top: 6px;
}
.sum-row.total span:last-child { color: var(--green); }

/* ── CONFIRM BUTTON ──────────────────────────────────────── */
.confirm-btn {
    width: 100%;
    margin-top: 14px;
    padding: 14px;
    background: var(--green);
    color: #fff;
    border: none;
    border-radius: 11px;
    font-size: 16px;
    font-family: var(--font);
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: all .2s;
    letter-spacing: 0.01em;
    box-shadow: 0 2px 8px rgba(22,163,74,0.25);
}
.confirm-btn svg { width: 19px; height: 19px; }
.confirm-btn:hover:not(:disabled) {
    background: #15803d;
    box-shadow: 0 4px 16px rgba(22,163,74,0.35);
    transform: translateY(-1px);
}
.confirm-btn:active:not(:disabled) { transform: translateY(0); }
.confirm-btn:disabled {
    background: #e2e8f0;
    color: #94a3b8;
    cursor: not-allowed;
    box-shadow: none;
}

/* ── DIVIDER ─────────────────────────────────────────────── */
.divider { height: 1px; background: var(--border); margin: 14px 0; }

/* ── RESPONSIVE ──────────────────────────────────────────── */
@media (max-width: 600px) {
    .stats-grid { grid-template-columns: 1fr; }
    .stat-card { padding: 14px 16px; }
}
</style>
@endpush

@section('content')

{{-- PAGE HEADER --}}
<div class="page-header">
    <div class="page-header-left">
        <div class="page-title">New Purchase</div>
        <div class="page-sub">Search products and process a sale transaction</div>
    </div>
    <div class="ref-badge">
        <span class="ref-dot"></span>
        Ref# &nbsp;<strong id="ref-display">{{ $reference }}</strong>
    </div>
</div>

{{-- STAT CARDS --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon blue">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/>
            </svg>
        </div>
        <div class="stat-info">
            <div class="stat-val" id="stat-items">0</div>
            <div class="stat-lbl">Items in cart</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon indigo">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
            </svg>
        </div>
        <div class="stat-info">
            <div class="stat-val" id="stat-total">₱0.00</div>
            <div class="stat-lbl">Order total</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="20 6 9 17 4 12"/>
            </svg>
        </div>
        <div class="stat-info">
            <div class="stat-val green" id="stat-change">₱0.00</div>
            <div class="stat-lbl">Change</div>
        </div>
    </div>
</div>

{{-- TWO COLUMN LAYOUT --}}
<div class="two-col">

    {{-- LEFT COLUMN --}}
    <div>

        {{-- Product Search --}}
        <div class="card">
            <div class="card-head">
                <div class="card-head-icon blue">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                    </svg>
                </div>
                <div class="card-head-title">Search Products</div>
            </div>
            <div class="card-body">
                <div class="search-wrap">
                    <svg class="search-ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                    </svg>
                    <input type="text" id="prod-search" placeholder="Type product name or code…"
                           autocomplete="off" oninput="searchProducts(this.value)">
                </div>
                <div id="search-results" class="results-list" style="display:none"></div>
            </div>
        </div>

        {{-- Customer & Payment --}}
        <div class="card">
            <div class="card-head">
                <div class="card-head-icon violet">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                    </svg>
                </div>
                <div class="card-head-title">Customer & Payment</div>
            </div>
            <div class="card-body">
                <div class="form-field">
                    <label>Customer Name <span class="opt">(optional)</span></label>
                    <input type="text" id="cust-name" placeholder="Walk-in customer">
                </div>

                <div class="form-field">
                    <label>Payment Method</label>
                    <div class="pay-toggle">
                        <button class="pay-opt active" onclick="setPayment('Cash', this)">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/>
                            </svg>
                            Cash
                        </button>
                        <button class="pay-opt" onclick="setPayment('GCash', this)">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="5" y="2" width="14" height="20" rx="2"/><line x1="12" y1="18" x2="12.01" y2="18"/>
                            </svg>
                            GCash
                        </button>
                    </div>
                </div>

                <div class="form-field" id="cash-row">
                    <label>Amount Tendered</label>
                    <input type="number" id="cash-input" placeholder="0.00" min="0"
                           step="0.01" oninput="calcChange()">
                </div>
            </div>
        </div>

    </div>

    {{-- RIGHT COLUMN: Cart --}}
    <div>
        <div class="card">
            <div class="card-head">
                <div class="card-head-icon green">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                    </svg>
                </div>
                <div class="card-head-title">Order Cart</div>
            </div>
            <div class="card-body">

                {{-- Empty State --}}
                <div id="cart-empty" class="cart-empty">
                    <div class="cart-empty-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                        </svg>
                    </div>
                    <div>
                        <strong>Your cart is empty</strong>
                        Search for products on the left and click Add to get started.
                    </div>
                </div>

                {{-- Cart Items --}}
                <div id="cart-wrap" style="display:none">
                    <table class="cart-table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Qty</th>
                                <th>Amount</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="cart-body"></tbody>
                    </table>

                    <div class="order-summary">
                        <div class="sum-row">
                            <span>Subtotal</span>
                            <span id="sum-sub">₱0.00</span>
                        </div>
                        <div class="sum-row">
                            <span>Discount</span>
                            <span>—</span>
                        </div>
                        <div class="sum-row total">
                            <span>Total</span>
                            <span id="sum-total">₱0.00</span>
                        </div>
                    </div>
                </div>

                <button class="confirm-btn" id="confirm-btn" disabled onclick="confirmSale()">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    Confirm Sale
                </button>

            </div>
        </div>
    </div>
</div>

@endsection


@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
const SEARCH_URL = "{{ route('purchasing.search') }}";
const STORE_URL  = "{{ route('purchasing.store') }}";
const CSRF       = "{{ csrf_token() }}";

let cart          = [];
let paymentMethod = 'Cash';
let searchTimer;

/* ── SweetAlert2 Toast (top-right, non-blocking) ── */
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer);
        toast.addEventListener('mouseleave', Swal.resumeTimer);
    }
});

/* ── Product search (debounced AJAX) ── */
function searchProducts(q) {
    clearTimeout(searchTimer);
    const box = document.getElementById('search-results');
    if (!q.trim()) { box.style.display = 'none'; return; }

    searchTimer = setTimeout(async () => {
        const res  = await fetch(`${SEARCH_URL}?q=${encodeURIComponent(q)}`);
        const data = await res.json();
        renderResults(data, box);
    }, 250);
}

function renderResults(products, box) {
    if (!products.length) {
        box.innerHTML = '<div class="no-results">No products found</div>';
        box.style.display = 'block';
        return;
    }

    box.innerHTML = products.map(p => {
        const inCart = cart.find(c => c.id === p.id);
        let stockClass = 'ok', stockLabel = `${p.stock} in stock`;
        if (p.stock <= 0)        { stockClass = 'out'; stockLabel = 'Out of stock'; }
        else if (p.stock <= 5)   { stockClass = 'low'; stockLabel = `Low: ${p.stock}`; }

        return `<div class="result-item" onclick="addToCart(${p.id},'${escHtml(p.name)}',${p.price},${p.stock})">
            <div style="min-width:0;flex:1">
                <div class="ri-name">${escHtml(p.name)}</div>
                <div class="ri-meta">₱${numFmt(p.price)} &nbsp;·&nbsp; ${escHtml(p.unit ?? 'pc')}</div>
            </div>
            <div class="ri-right">
                <span class="stock-badge ${stockClass}">${stockLabel}</span>
                <button class="add-btn" ${p.stock <= 0 ? 'disabled' : ''}
                    onclick="event.stopPropagation();addToCart(${p.id},'${escHtml(p.name)}',${p.price},${p.stock})">
                    ${inCart ? '+ More' : 'Add'}
                </button>
            </div>
        </div>`;
    }).join('');

    box.style.display = 'block';
}

/* ── Cart operations ── */
function addToCart(id, name, price, maxQty) {
    if (maxQty <= 0) return;

    const existing = cart.find(c => c.id === id);

    if (existing) {
        if (existing.qty >= maxQty) {
            Toast.fire({
                icon: 'warning',
                title: `Max stock reached for <strong>${name}</strong>`
            });
            return;
        }
        existing.qty++;
        Toast.fire({
            icon: 'success',
            title: `Added another <strong>${name}</strong>`
        });
    } else {
        cart.push({ id, name, price, qty: 1, maxQty });
        Toast.fire({
            icon: 'success',
            title: `<strong>${name}</strong> added to cart`
        });
    }

    renderCart();
    const q = document.getElementById('prod-search').value;
    if (q) searchProducts(q);
}

function removeFromCart(id) {
    const item = cart.find(c => c.id === id);
    if (!item) return;

    Swal.fire({
        title: 'Remove item?',
        html: `Remove <strong>${escHtml(item.name)}</strong> from the cart?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes, remove it',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#e2e8f0',
        customClass: {
            cancelButton: 'swal-cancel-dark'
        },
        reverseButtons: true,
        focusCancel: true,
    }).then((result) => {
        if (result.isConfirmed) {
            cart = cart.filter(c => c.id !== id);
            renderCart();
            Toast.fire({
                icon: 'info',
                title: `<strong>${escHtml(item.name)}</strong> removed`
            });
        }
    });
}

function changeQty(id, delta) {
    const item = cart.find(c => c.id === id);
    if (!item) return;
    const newQty = item.qty + delta;

    if (newQty < 1) {
        removeFromCart(id);
        return;
    }
    if (newQty > item.maxQty) {
        Toast.fire({
            icon: 'warning',
            title: `Only <strong>${item.maxQty}</strong> in stock`
        });
        return;
    }

    item.qty = newQty;
    renderCart();
}

function renderCart() {
    const body  = document.getElementById('cart-body');
    const empty = document.getElementById('cart-empty');
    const wrap  = document.getElementById('cart-wrap');
    const btn   = document.getElementById('confirm-btn');

    if (!cart.length) {
        empty.style.display = 'flex';
        wrap.style.display  = 'none';
        btn.disabled = true;
        updateStats(0, 0);
        return;
    }

    empty.style.display = 'none';
    wrap.style.display  = 'block';
    btn.disabled = false;

    body.innerHTML = cart.map(item => `
        <tr>
            <td>
                <div class="item-name">${escHtml(item.name)}</div>
                <div class="item-price">₱${numFmt(item.price)} / pc</div>
            </td>
            <td>
                <div class="qty-ctrl">
                    <button class="qty-btn" onclick="changeQty(${item.id},-1)">−</button>
                    <span class="qty-val">${item.qty}</span>
                    <button class="qty-btn" onclick="changeQty(${item.id},1)">+</button>
                </div>
            </td>
            <td class="amount-cell">₱${numFmt(item.price * item.qty)}</td>
            <td><button class="remove-btn" onclick="removeFromCart(${item.id})" title="Remove">×</button></td>
        </tr>
    `).join('');

    const total = cart.reduce((s, c) => s + c.price * c.qty, 0);
    document.getElementById('sum-sub').textContent   = '₱' + numFmt(total);
    document.getElementById('sum-total').textContent = '₱' + numFmt(total);
    updateStats(cart.reduce((s, c) => s + c.qty, 0), total);
    calcChange();
}

/* ── Stats ── */
function updateStats(items, total) {
    document.getElementById('stat-items').textContent = items;
    document.getElementById('stat-total').textContent = '₱' + numFmt(total);
}

function calcChange() {
    const total    = cart.reduce((s, c) => s + c.price * c.qty, 0);
    const tendered = parseFloat(document.getElementById('cash-input').value) || 0;
    const el       = document.getElementById('stat-change');

    if (paymentMethod === 'GCash') {
        el.textContent = '—';
        el.className   = 'stat-val';
        return;
    }

    const change = tendered - total;
    el.textContent = change >= 0
        ? '₱' + numFmt(change)
        : '−₱' + numFmt(Math.abs(change));
    el.className = 'stat-val ' + (change >= 0 ? 'green' : 'red');
}

/* ── Payment method ── */
function setPayment(method, btn) {
    paymentMethod = method;
    document.querySelectorAll('.pay-opt').forEach(el => el.classList.remove('active'));
    btn.classList.add('active');
    document.getElementById('cash-row').style.display = method === 'Cash' ? 'block' : 'none';
    calcChange();
}

/* ── Confirm & submit ── */
async function confirmSale() {
    if (!cart.length) return;

    const total    = cart.reduce((s, c) => s + c.price * c.qty, 0);
    const tendered = parseFloat(document.getElementById('cash-input').value) || 0;
    const customer = document.getElementById('cust-name').value || 'Walk-in';

    // Cash validation before confirmation dialog
    if (paymentMethod === 'Cash' && tendered < total) {
        Swal.fire({
            icon: 'warning',
            title: 'Insufficient Amount',
            html: `The amount tendered (<strong>₱${numFmt(tendered)}</strong>) is less than the total (<strong>₱${numFmt(total)}</strong>).
                   <br><br>Please enter the correct amount.`,
            confirmButtonText: 'Got it',
            confirmButtonColor: '#d97706',
        });
        return;
    }

    // Build items summary for confirmation
    const itemLines = cart.map(c =>
        `<tr>
            <td style="padding:4px 8px;text-align:left">${escHtml(c.name)}</td>
            <td style="padding:4px 8px;text-align:center">${c.qty}</td>
            <td style="padding:4px 8px;text-align:right;font-weight:600">₱${numFmt(c.price * c.qty)}</td>
        </tr>`
    ).join('');

    const changeAmt = paymentMethod === 'Cash' ? tendered - total : null;

    const { isConfirmed } = await Swal.fire({
        title: 'Confirm Sale',
        html: `
            <div style="text-align:left;font-size:14px;color:#475569">
                <div style="display:flex;justify-content:space-between;margin-bottom:12px;gap:12px">
                    <div><span style="font-weight:600;color:#94a3b8;font-size:11px;text-transform:uppercase;letter-spacing:.04em">Customer</span><br><span style="color:#0f172a;font-weight:500">${escHtml(customer)}</span></div>
                    <div><span style="font-weight:600;color:#94a3b8;font-size:11px;text-transform:uppercase;letter-spacing:.04em">Payment</span><br><span style="color:#0f172a;font-weight:500">${paymentMethod}</span></div>
                </div>
                <table style="width:100%;border-collapse:collapse;margin-bottom:12px">
                    <thead>
                        <tr style="border-bottom:1px solid #e2e8f0">
                            <th style="padding:5px 8px;text-align:left;font-size:11px;color:#94a3b8;font-weight:600;text-transform:uppercase;letter-spacing:.04em">Item</th>
                            <th style="padding:5px 8px;text-align:center;font-size:11px;color:#94a3b8;font-weight:600;text-transform:uppercase;letter-spacing:.04em">Qty</th>
                            <th style="padding:5px 8px;text-align:right;font-size:11px;color:#94a3b8;font-weight:600;text-transform:uppercase;letter-spacing:.04em">Amount</th>
                        </tr>
                    </thead>
                    <tbody>${itemLines}</tbody>
                </table>
                <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:8px;padding:10px 12px">
                    <div style="display:flex;justify-content:space-between;margin-bottom:4px">
                        <span>Total</span>
                        <strong style="color:#16a34a;font-size:16px">₱${numFmt(total)}</strong>
                    </div>
                    ${paymentMethod === 'Cash' ? `
                    <div style="display:flex;justify-content:space-between;margin-bottom:4px;font-size:13px">
                        <span>Tendered</span><span>₱${numFmt(tendered)}</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;font-size:13px">
                        <span>Change</span><strong style="color:#16a34a">₱${numFmt(changeAmt)}</strong>
                    </div>` : ''}
                </div>
            </div>`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: '✓ &nbsp;Process Sale',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#16a34a',
        cancelButtonColor: '#e2e8f0',
        reverseButtons: true,
        focusConfirm: true,
        width: '480px',
    });

    if (!isConfirmed) return;

    // Show loading state
    const btn = document.getElementById('confirm-btn');
    btn.disabled  = true;
    btn.innerHTML = `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:19px;height:19px;animation:spin 1s linear infinite"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg> Processing…`;

    Swal.fire({
        title: 'Processing sale…',
        html: 'Please wait while we record the transaction.',
        allowOutsideClick: false,
        allowEscapeKey: false,
        didOpen: () => { Swal.showLoading(); }
    });

    const payload = {
        customer_name   : document.getElementById('cust-name').value || null,
        payment_method  : paymentMethod,
        amount_tendered : paymentMethod === 'Cash' ? tendered : null,
        items: cart.map(c => ({ product_id: c.id, quantity: c.qty })),
    };

    try {
        const res  = await fetch(STORE_URL, {
            method : 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
            body   : JSON.stringify(payload),
        });
        const data = await res.json();

        if (data.success) {
            const changeDisplay = data.change !== null
                ? `<div style="display:flex;justify-content:space-between;margin-top:6px;font-size:14px">
                       <span style="color:#475569">Change</span>
                       <strong style="color:#16a34a">₱${numFmt(data.change)}</strong>
                   </div>` : '';

            await Swal.fire({
                icon: 'success',
                title: 'Sale Recorded!',
                html: `
                    <div style="text-align:left;font-size:14px">
                        <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:8px;padding:12px 14px;margin-bottom:12px">
                            <div style="font-family:'DM Mono',monospace;font-size:15px;font-weight:600;color:#14532d;margin-bottom:8px">${escHtml(data.reference_no)}</div>
                            <div style="display:flex;justify-content:space-between;margin-bottom:4px">
                                <span style="color:#475569">Total</span>
                                <strong style="color:#0f172a">₱${numFmt(data.total)}</strong>
                            </div>
                            ${changeDisplay}
                        </div>
                        <p style="color:#64748b;font-size:13px;text-align:center;margin:0">Transaction successfully saved.</p>
                    </div>`,
                confirmButtonText: 'New Sale',
                confirmButtonColor: '#16a34a',
                width: '400px',
            });

            resetForm(data.reference_no);

        } else {
            Swal.fire({
                icon: 'error',
                title: 'Sale Failed',
                html: data.message || 'Something went wrong. Please try again.',
                confirmButtonText: 'Try Again',
                confirmButtonColor: '#dc2626',
            });
        }
    } catch (e) {
        Swal.fire({
            icon: 'error',
            title: 'Network Error',
            html: 'Could not connect to the server. Please check your connection and try again.',
            confirmButtonText: 'OK',
            confirmButtonColor: '#dc2626',
        });
    }

    btn.disabled  = false;
    btn.innerHTML = `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width:19px;height:19px"><polyline points="20 6 9 17 4 12"/></svg> Confirm Sale`;
}

/* ── Reset ── */
function resetForm(nextRef) {
    cart = [];
    renderCart();
    document.getElementById('prod-search').value = '';
    document.getElementById('search-results').style.display = 'none';
    document.getElementById('cash-input').value  = '';
    document.getElementById('cust-name').value   = '';
    if (nextRef) {
        const num = parseInt(nextRef.replace('TXN-', '')) + 1;
        document.getElementById('ref-display').textContent = 'TXN-' + String(num).padStart(4, '0');
    }
}

/* ── Helpers ── */
function numFmt(n) {
    return parseFloat(n).toLocaleString('en-PH', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}
function escHtml(str) {
    return String(str)
        .replace(/&/g,'&amp;').replace(/</g,'&lt;')
        .replace(/>/g,'&gt;').replace(/"/g,'&quot;').replace(/'/g,'&#39;');
}
</script>

<style>
@keyframes spin { to { transform: rotate(360deg); } }
/* Fix SweetAlert cancel button text color */
.swal2-cancel { color: #374151 !important; }
</style>
@endpush