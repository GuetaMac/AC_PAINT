@extends('layouts.app')

@section('title', 'Dashboard')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">

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
    --violet:      #7c3aed;
    --violet-light:#f5f3ff;
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
body { font-family: var(--font); background: var(--surface); color: var(--text); }

/* ── WELCOME BAR ── */
.welcome-bar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1.5rem;
    gap: 1rem;
    flex-wrap: wrap;
}
.welcome-left {}
.welcome-title {
    font-size: 30px; /* was 26px */
    font-weight: 700;
    color: var(--text);
    letter-spacing: -0.3px;
}
.welcome-sub {
    font-size: 17px; /* was 15px */
    color: var(--text-muted);
    margin-top: 3px;
}
.date-chip {
    display: flex;
    align-items: center;
    gap: 7px;
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 50px;
    padding: 10px 18px; /* was 8px 16px */
    font-size: 16px; /* was 14px */
    color: var(--text-mid);
    font-weight: 500;
    box-shadow: var(--shadow-sm);
    white-space: nowrap;
}
.date-chip svg { width: 17px; height: 17px; color: var(--text-muted); } /* was 15px */

/* ── STAT CARDS ── */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 12px;
    margin-bottom: 1.4rem;
}
.stat-card {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 20px 22px; /* was 18px 20px */
    box-shadow: var(--shadow-sm);
    display: flex;
    flex-direction: column;
    gap: 12px;
    position: relative;
    overflow: hidden;
    transition: box-shadow .2s, transform .2s;
}
.stat-card:hover { box-shadow: var(--shadow-md); transform: translateY(-2px); }
.stat-card::after {
    content: '';
    position: absolute;
    bottom: -18px; right: -18px;
    width: 70px; height: 70px;
    border-radius: 50%;
    opacity: .06;
}
.stat-card.red::after    { background: var(--red); }
.stat-card.green::after  { background: var(--green); }
.stat-card.amber::after  { background: var(--amber); }
.stat-card.blue::after   { background: var(--blue); }

.stat-top { display: flex; align-items: flex-start; justify-content: space-between; }
.stat-label { font-size: 15px; font-weight: 600; text-transform: uppercase; letter-spacing: .07em; color: var(--text-muted); } /* was 13px */
.stat-icon {
    width: 46px; height: 46px; /* was 40px */
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.stat-icon svg { width: 22px; height: 22px; } /* was 18px */
.stat-icon.red    { background: var(--red-light);    color: var(--red); }
.stat-icon.green  { background: var(--green-light);  color: var(--green); }
.stat-icon.amber  { background: var(--amber-light);  color: var(--amber); }
.stat-icon.blue   { background: var(--blue-light);   color: var(--blue); }

.stat-value {
    font-size: 36px; /* was 30px */
    font-weight: 700;
    color: var(--text);
    letter-spacing: -0.8px;
    line-height: 1;
    font-variant-numeric: tabular-nums;
}
.stat-sub {
    font-size: 15px; /* was 13px */
    color: var(--text-muted);
    display: flex;
    align-items: center;
    gap: 5px;
}
.stat-sub.warn { color: var(--amber); font-weight: 600; }
.stat-sub svg  { width: 15px; height: 15px; } /* was 13px */

/* ── ALERT BAR ── */
.alert-bar {
    display: flex;
    align-items: center;
    gap: 10px;
    background: var(--amber-light);
    border: 1px solid #fde68a;
    border-left: 4px solid var(--amber);
    border-radius: var(--radius-sm);
    padding: 16px 20px; /* was 14px 18px */
    font-size: 17px; /* was 15px */
    color: #78350f;
    margin-bottom: 1.4rem;
    animation: slideIn .3s ease;
}
.alert-bar svg { width: 22px; height: 22px; flex-shrink: 0; color: var(--amber); } /* was 19px */
.alert-bar strong { font-weight: 700; }
@keyframes slideIn { from { opacity:0; transform:translateY(-6px); } to { opacity:1; transform:translateY(0); } }

/* ── TWO COL ── */
.two-col {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 14px;
    align-items: start;
}
@media (max-width: 820px) { .two-col { grid-template-columns: 1fr; } }

/* ── SECTION HEADER ── */
.section-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 10px;
}
.section-title {
    font-size: 20px; /* was 18px */
    font-weight: 700;
    color: var(--red);
    letter-spacing: 0.3px;
}
.view-all-link {
    font-size: 16px; /* was 14px */
    font-weight: 500;
    color: var(--blue);
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 3px;
    transition: gap .15s;
}
.view-all-link:hover { gap: 6px; }
.view-all-link svg { width: 16px; height: 16px; } /* was 14px */

/* ── TABLE CARD ── */
.table-card {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    overflow: hidden;
    box-shadow: var(--shadow-sm);
}
.dash-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 16px; /* was 14px */
}
.dash-table thead th {
    padding: 13px 16px; /* was 11px 15px */
    text-align: left;
    font-size: 14px; /* was 12px */
    text-transform: uppercase;
    letter-spacing: .08em;
    color: var(--text-muted);
    font-weight: 600;
    background: #fdfdfd;
    border-bottom: 1px solid var(--border);
    white-space: nowrap;
}
.dash-table tbody tr {
    border-bottom: 1px solid #f1f5f9;
    transition: background .1s;
}
.dash-table tbody tr:last-child { border-bottom: none; }
.dash-table tbody tr:hover { background: #fafbfc; }
.dash-table tbody td { padding: 14px 16px; vertical-align: middle; color: var(--text-mid); } /* was 12px 15px */

/* ── PRODUCT NAME IN TABLE ── */
.prod-name { font-weight: 500; color: var(--text); font-size: 16px; } /* was 14px */
.prod-ref  { font-size: 14px; color: var(--text-muted); margin-top: 1px; font-family: var(--font-mono); } /* was 12px */

/* ── AMOUNT ── */
.amount { font-weight: 700; color: var(--text); font-variant-numeric: tabular-nums; }

/* ── BADGES ── */
.badge {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-size: 14px; /* was 12.5px */
    font-weight: 600;
    padding: 5px 12px; /* was 4px 10px */
    border-radius: 20px;
    white-space: nowrap;
}
.badge::before {
    content: '';
    width: 6px; height: 6px; /* was 5px */
    border-radius: 50%;
    flex-shrink: 0;
}
.badge.green  { background: var(--green-light);  color: var(--green-dark); }
.badge.green::before  { background: var(--green); }
.badge.amber  { background: var(--amber-light);  color: #78350f; }
.badge.amber::before  { background: var(--amber); }
.badge.red    { background: var(--red-light);    color: #7f1d1d; }
.badge.red::before    { background: var(--red); }

/* ── STOCK BAR ── */
.stock-cell { display: flex; align-items: center; gap: 8px; }
.stock-num  { font-weight: 700; font-size: 16px; min-width: 26px; text-align: right; } /* was 14px / 22px */
.stock-num.danger { color: var(--red); }
.stock-num.warn   { color: var(--amber); }
.stock-bar-wrap { width: 52px; height: 5px; background: #e2e8f0; border-radius: 10px; overflow: hidden; flex-shrink: 0; } /* was 48px / 4px */
.stock-bar { height: 100%; border-radius: 10px; }
.stock-bar.red   { background: var(--red); }
.stock-bar.amber { background: var(--amber); }

/* ── EMPTY STATE ── */
.empty-state {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 2.5rem 1.5rem;
    color: var(--text-muted);
    gap: 10px;
}
.empty-icon {
    width: 54px; height: 54px; /* was 48px */
    border-radius: 50%;
    background: var(--surface);
    border: 1.5px dashed var(--border-dark);
    display: flex; align-items: center; justify-content: center;
}
.empty-icon svg { width: 26px; height: 26px; opacity: .35; } /* was 22px */
.empty-state p { font-size: 16px; } /* was 14px */
/* ── RESPONSIVE ── */
@media (max-width: 900px) {
    .stats-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 520px) {
    .stats-grid { grid-template-columns: 1fr; }
}
</style>
@endpush

@section('content')

{{-- WELCOME BAR --}}
<div class="welcome-bar">
    <div class="welcome-left">
        <div class="welcome-title">Dashboard</div>
        <div class="welcome-sub">Here's what's happening in your store today.</div>
    </div>
    <div class="date-chip">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/>
            <line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
        </svg>
        {{ now()->format('l, F j, Y') }}
    </div>
</div>

{{-- STAT CARDS --}}
<div class="stats-grid">

    {{-- Total Products --}}
    <div class="stat-card red">
        <div class="stat-top">
            <div class="stat-label">Total Products</div>
            <div class="stat-icon red">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
                </svg>
            </div>
        </div>
        <div class="stat-value">{{ $totalProducts }}</div>
        <div class="stat-sub">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
            </svg>
            All products in inventory
        </div>
    </div>

    {{-- Sales Today --}}
    <div class="stat-card green">
        <div class="stat-top">
            <div class="stat-label">Sales Today</div>
            <div class="stat-icon green">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                </svg>
            </div>
        </div>
        <div class="stat-value">₱{{ number_format($salesToday->total, 2) }}</div>
        <div class="stat-sub">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="20 6 9 17 4 12"/>
            </svg>
            {{ $salesToday->count }} transaction{{ $salesToday->count !== 1 ? 's' : '' }} today
        </div>
    </div>

    {{-- Low Stock --}}
    <div class="stat-card amber">
        <div class="stat-top">
            <div class="stat-label">Low Stock</div>     
            <div class="stat-icon amber">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                    <line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
                </svg>
            </div>
        </div>
        <div class="stat-value">{{ $lowStockCount }}</div>
        <div class="stat-sub {{ $lowStockCount > 0 ? 'warn' : '' }}">
            @if($lowStockCount > 0)
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
                Needs reorder soon
            @else
                ✓ All stock levels good
            @endif
        </div>
    </div>

    {{-- Total Suppliers --}}
    <div class="stat-card blue">
        <div class="stat-top">
            <div class="stat-label">Suppliers</div>
            <div class="stat-icon blue">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/>
                    <line x1="12" y1="12" x2="12" y2="16"/><line x1="10" y1="14" x2="14" y2="14"/>
                </svg>
            </div>
        </div>
        <div class="stat-value">{{ $totalSuppliers }}</div>
        <div class="stat-sub">Active accounts</div>
    </div>

</div>

{{-- LOW STOCK ALERT --}}
@if($lowStockCount > 0)
<div class="alert-bar">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
        <line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
    </svg>
    <span>
        <strong>Low stock alert:</strong>
        {{ $lowStockItems->pluck('name')->join(', ') }} — consider reordering.
    </span>
</div>
@endif

{{-- TWO COLUMN --}}
<div class="two-col">

    {{-- RECENT SALES --}}
    <div>
        <div class="section-header">
            <span class="section-title">Recent Sales</span>
            <a href="{{ route('sales.index') }}" class="view-all-link">
                View all
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="9 18 15 12 9 6"/>
                </svg>
            </a>
        </div>
        <div class="table-card">
            <table class="dash-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Amount</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentSales as $sale)
                        @foreach($sale->items as $item)
                        <tr>
                            <td>
                                <div class="prod-name">{{ $item->product->name ?? 'N/A' }}</div>
                                <div class="prod-ref">{{ $sale->reference_no }}</div>
                            </td>
                            <td style="font-weight:600;color:var(--text)">{{ $item->quantity }}</td>
                            <td class="amount">₱{{ number_format($sale->total_amount, 2) }}</td>
                            <td>
                                <span class="badge {{ $sale->status === 'Paid' || strtolower($sale->status) === 'completed' ? 'green' : 'amber' }}">
                                    {{ $sale->status }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    @empty
                        <tr>
                            <td colspan="4">
                                <div class="empty-state">
                                    <div class="empty-icon">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                            <line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                                        </svg>
                                    </div>
                                    <p>No sales recorded yet.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- LOW STOCK TABLE --}}
    <div>
        <div class="section-header">
            <span class="section-title">Low Stock Items</span>
            <a href="{{ route('products.index') }}" class="view-all-link">
                View all
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="9 18 15 12 9 6"/>
                </svg>
            </a>
        </div>
        <div class="table-card">
            <table class="dash-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Stock</th>
                        <th>Min Level</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($lowStockItems as $product)
                    @php
                        $pct = $product->min_stock > 0
                            ? min(100, ($product->stock / ($product->min_stock * 2)) * 100)
                            : 0;
                        $barColor  = $product->stock <= 0 ? 'red' : 'amber';
                        $numColor  = $product->stock <= 0 ? 'danger' : 'warn';
                    @endphp
                    <tr>
                        <td>
                            <div class="prod-name">{{ $product->name }}</div>
                            @if($product->brand)
                                <div class="prod-ref">{{ $product->brand }}</div>
                            @endif
                        </td>
                        <td>
                            <div class="stock-cell">
                                <span class="stock-num {{ $numColor }}">{{ $product->stock }}</span>
                                <div class="stock-bar-wrap">
                                    <div class="stock-bar {{ $barColor }}" style="width:{{ $pct }}%"></div>
                                </div>
                            </div>
                        </td>
                        <td style="color:var(--text-muted);font-size:14px;">{{ $product->min_stock }}</td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="3">
                                <div class="empty-state">
                                    <div class="empty-icon">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                            <polyline points="20 6 9 17 4 12"/>
                                        </svg>
                                    </div>
                                    <p>All stock levels are good!</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection