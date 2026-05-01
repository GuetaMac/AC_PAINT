@extends('layouts.app')

@section('title', 'Sales')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">

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
    --surface:     #f8fafc;
    --card:        #ffffff;
    --border:      #e2e8f0;
    --border-dark: #cbd5e1;
    --text:        #0f172a;
    --text-mid:    #475569;
    --text-muted:  #94a3b8;
    --radius:      14px;
    --radius-sm:   8px;
    --shadow-sm:   0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
    --shadow-md:   0 4px 16px rgba(0,0,0,0.08), 0 2px 6px rgba(0,0,0,0.04);
    --font:        'DM Sans', sans-serif;
    --font-mono:   'DM Mono', monospace;
}

*, *::before, *::after { box-sizing: border-box; }
body { font-family: var(--font); background: var(--surface); color: var(--text); }

/* ── PAGE HEADER ── */
.page-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1.5rem;
    gap: 1rem;
}
.page-title { font-size: 22px; font-weight: 600; letter-spacing: -0.3px; }
.page-sub   { font-size: 13px; color: var(--text-muted); margin-top: 3px; }

/* ── STAT CARDS ── */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 12px;
    margin-bottom: 1.5rem;
}
.stat-card {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 18px 20px;
    box-shadow: var(--shadow-sm);
    display: flex;
    flex-direction: column;
    gap: 10px;
    transition: box-shadow .2s, transform .2s;
    position: relative;
    overflow: hidden;
}
.stat-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    border-radius: var(--radius) var(--radius) 0 0;
}
.stat-card.green::before { background: var(--green); }
.stat-card.blue::before  { background: var(--blue); }
.stat-card.amber::before { background: var(--amber); }
.stat-card:hover { box-shadow: var(--shadow-md); transform: translateY(-1px); }

.stat-top { display: flex; align-items: center; justify-content: space-between; }
.stat-label { font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.06em; color: var(--text-muted); }
.stat-icon {
    width: 34px; height: 34px;
    border-radius: 9px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.stat-icon svg { width: 16px; height: 16px; }
.stat-icon.green  { background: var(--green-light); color: var(--green); }
.stat-icon.blue   { background: var(--blue-light);  color: var(--blue); }
.stat-icon.amber  { background: var(--amber-light); color: var(--amber); }

.stat-amount {
    font-size: 26px;
    font-weight: 700;
    color: var(--text);
    letter-spacing: -0.5px;
    line-height: 1;
    font-variant-numeric: tabular-nums;
}
.stat-count {
    font-size: 12px;
    color: var(--text-muted);
    display: flex;
    align-items: center;
    gap: 5px;
}
.stat-count-dot {
    width: 6px; height: 6px;
    border-radius: 50%;
    flex-shrink: 0;
}
.stat-count-dot.green { background: var(--green); }
.stat-count-dot.blue  { background: var(--blue); }
.stat-count-dot.amber { background: var(--amber); }

/* ── TOOLBAR ── */
.toolbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1rem;
    gap: 10px;
    flex-wrap: wrap;
}
.toolbar-search {
    display: flex;
    align-items: center;
    background: var(--card);
    border: 1.5px solid var(--border);
    border-radius: var(--radius-sm);
    padding: 0 12px;
    gap: 8px;
    height: 38px;
    flex: 1;
    min-width: 180px;
    max-width: 300px;
    transition: border-color .2s, box-shadow .2s;
}
.toolbar-search:focus-within {
    border-color: var(--blue);
    box-shadow: 0 0 0 3px rgba(59,130,246,0.10);
}
.toolbar-search svg  { width: 14px; height: 14px; color: var(--text-muted); flex-shrink: 0; }
.toolbar-search input {
    border: none; background: none; outline: none;
    font-family: var(--font);
    font-size: 13.5px; color: var(--text); width: 100%;
}
.toolbar-search input::placeholder { color: var(--text-muted); }
.toolbar-right { display: flex; align-items: center; gap: 8px; }
.filter-select {
    font-family: var(--font);
    font-size: 13px;
    font-weight: 500;
    padding: 0 12px;
    height: 38px;
    border: 1.5px solid var(--border);
    border-radius: var(--radius-sm);
    background: var(--card);
    color: var(--text-mid);
    cursor: pointer;
    outline: none;
    transition: border-color .2s;
}
.filter-select:focus { border-color: var(--blue); }
.export-btn {
    display: flex; align-items: center; gap: 6px;
    height: 38px; padding: 0 14px;
    background: var(--card);
    border: 1.5px solid var(--border);
    border-radius: var(--radius-sm);
    font-family: var(--font);
    font-size: 13px; font-weight: 500;
    color: var(--text-mid);
    cursor: pointer;
    transition: all .15s;
    white-space: nowrap;
}
.export-btn svg { width: 14px; height: 14px; }
.export-btn:hover { background: var(--surface); border-color: var(--border-dark); color: var(--text); }

/* ── TABLE CARD ── */
.table-card {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    overflow: hidden;
    box-shadow: var(--shadow-sm);
}
.sales-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 13px;
}
.sales-table thead th {
    padding: 11px 16px;
    text-align: left;
    font-size: 10.5px;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: var(--text-muted);
    font-weight: 600;
    background: #fdfdfd;
    border-bottom: 1px solid var(--border);
    white-space: nowrap;
}
.sales-table tbody tr {
    border-bottom: 1px solid #f1f5f9;
    transition: background .1s;
}
.sales-table tbody tr:last-child { border-bottom: none; }
.sales-table tbody tr:hover { background: #fafbfc; }
.sales-table tbody td { padding: 12px 16px; vertical-align: middle; }

/* ── REF CHIP ── */
.ref-chip {
    font-family: var(--font-mono);
    font-size: 11.5px;
    background: #f1f5f9;
    border: 1px solid var(--border);
    padding: 3px 9px;
    border-radius: 6px;
    color: var(--text-mid);
    white-space: nowrap;
    display: inline-block;
}

/* ── DATE CELL ── */
.date-main  { font-size: 13px; font-weight: 500; color: var(--text); white-space: nowrap; }
.date-sub   { font-size: 11px; color: var(--text-muted); margin-top: 2px; }

/* ── CUSTOMER CELL ── */
.customer-name { font-size: 13px; font-weight: 500; color: var(--text); }
.customer-walkin {
    font-size: 12px;
    color: var(--text-muted);
    font-style: italic;
}

/* ── ITEMS CELL ── */
.item-row { font-size: 12px; color: var(--text-mid); line-height: 1.8; }
.item-qty  { color: var(--text-muted); }
.items-more { font-size: 11px; color: var(--text-muted); margin-top: 2px; }

/* ── AMOUNT CELL ── */
.amount-cell {
    font-weight: 700;
    font-size: 14px;
    color: var(--text);
    font-variant-numeric: tabular-nums;
    white-space: nowrap;
}

/* ── PAYMENT BADGE ── */
.pay-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 12px;
    font-weight: 500;
    padding: 4px 10px;
    border-radius: 20px;
    white-space: nowrap;
}
.pay-badge.cash   { background: var(--green-light); color: var(--green-dark); }
.pay-badge.gcash  { background: var(--blue-light); color: #1d4ed8; }
.pay-badge.other  { background: #f3f4f6; color: var(--text-mid); }
.pay-badge svg    { width: 11px; height: 11px; }

/* ── CASHIER CELL ── */
.cashier-cell {
    display: flex;
    align-items: center;
    gap: 7px;
}
.cashier-avatar {
    width: 26px; height: 26px;
    border-radius: 50%;
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    display: flex; align-items: center; justify-content: center;
    font-size: 10px;
    font-weight: 700;
    color: #fff;
    flex-shrink: 0;
}
.cashier-name { font-size: 13px; color: var(--text-mid); }

/* ── STATUS BADGE ── */
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 11.5px;
    font-weight: 600;
    padding: 4px 10px;
    border-radius: 20px;
}
.status-badge::before {
    content: '';
    width: 6px; height: 6px;
    border-radius: 50%;
    flex-shrink: 0;
}
.status-badge.completed  { background: var(--green-light); color: var(--green-dark); }
.status-badge.completed::before { background: var(--green); }
.status-badge.pending    { background: var(--amber-light); color: #78350f; }
.status-badge.pending::before { background: var(--amber); }
.status-badge.voided     { background: #fee2e2; color: #7f1d1d; }
.status-badge.voided::before  { background: var(--red); }

/* ── EMPTY STATE ── */
.empty-state {
    padding: 4rem 2rem;
    text-align: center;
    color: var(--text-muted);
}
.empty-state-icon {
    width: 56px; height: 56px;
    border-radius: 50%;
    background: var(--surface);
    border: 1.5px dashed var(--border-dark);
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 1rem;
}
.empty-state-icon svg { width: 24px; height: 24px; opacity: .4; }
.empty-state p { font-size: 13.5px; }

/* ── TABLE FOOTER ── */
.table-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 16px;
    border-top: 1px solid var(--border);
    background: #fdfdfd;
    font-size: 12px;
    color: var(--text-muted);
    gap: 1rem;
}
.table-footer .pagination { display: flex; gap: 4px; }

.table-footer nav span[aria-current="page"] span,
.table-footer nav a {
    display: inline-flex; align-items: center; justify-content: center;
    min-width: 32px; height: 32px;
    padding: 0 10px;
    border: 1px solid var(--border);
    border-radius: 7px;
    font-size: 13px;
    font-family: var(--font);
    color: var(--text-mid);
    text-decoration: none;
    transition: all .15s;
    background: var(--card);
}
.table-footer nav span[aria-current="page"] span {
    background: var(--text);
    color: var(--card);
    border-color: var(--text);
    font-weight: 600;
}
.table-footer nav a:hover { background: var(--surface); color: var(--text); border-color: var(--border-dark); }
.table-footer nav svg { width: 14px; height: 14px; }

/* ── RESPONSIVE ── */
@media (max-width: 768px) {
    .stats-grid { grid-template-columns: 1fr; }
    .toolbar-search { max-width: 100%; }
    .sales-table thead th:nth-child(4),
    .sales-table tbody td:nth-child(4),
    .sales-table thead th:nth-child(7),
    .sales-table tbody td:nth-child(7) { display: none; }
}
/* ── INSIGHTS ── */
.insights-section {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 18px 20px;
    box-shadow: var(--shadow-sm);
    margin-bottom: 1.25rem;
}
.insights-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 16px;
    flex-wrap: wrap;
    gap: 8px;
}
.insights-title {
    font-size: 14px;
    font-weight: 600;
    color: var(--text);
    display: flex;
    align-items: center;
    gap: 7px;
}
.insights-total {
    font-size: 13px;
    color: var(--text-muted);
}
.insights-total strong {
    color: var(--text);
    font-size: 15px;
}
.insights-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
}
.insights-card {
    border: 1px solid var(--border);
    border-radius: var(--radius-sm);
    overflow: hidden;
}
.insights-card-title {
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    padding: 9px 14px;
    display: flex;
    align-items: center;
    gap: 6px;
}
.insights-card-title.best  { background: var(--green-light); color: var(--green-dark); border-bottom: 1px solid var(--green-mid); }
.insights-card-title.worst { background: #fef2f2; color: #991b1b; border-bottom: 1px solid #fecaca; }
.insights-row {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 9px 14px;
    border-bottom: 1px solid #f8fafc;
    transition: background .1s;
}
.insights-row:last-child { border-bottom: none; }
.insights-row:hover { background: #fafbfc; }
.insights-rank {
    width: 22px; height: 22px;
    border-radius: 50%;
    background: var(--surface);
    border: 1px solid var(--border);
    display: flex; align-items: center; justify-content: center;
    font-size: 11px; font-weight: 700;
    color: var(--text-muted);
    flex-shrink: 0;
}
.insights-rank.gold   { background: #fef9c3; border-color: #fde047; color: #713f12; }
.insights-rank.silver { background: #f1f5f9; border-color: #cbd5e1; color: #334155; }
.insights-rank.bronze { background: #fff7ed; border-color: #fdba74; color: #7c2d12; }
.insights-rank.low    { background: #fef2f2; border-color: #fca5a5; color: #991b1b; }
.insights-product { flex: 1; min-width: 0; }
.insights-product-name { font-size: 13px; font-weight: 500; color: var(--text); display: block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.insights-product-qty  { font-size: 11px; color: var(--text-muted); }
.insights-revenue      { font-size: 13px; font-weight: 600; color: var(--text); white-space: nowrap; }
.insights-revenue.muted { color: var(--text-muted); font-weight: 500; }

@media (max-width: 768px) {
    .insights-grid { grid-template-columns: 1fr; }
}
</style>
@endpush

@section('content')

{{-- PAGE HEADER --}}
<div class="page-header">
    <div>
        <div class="page-title">Sales</div>
        <div class="page-sub">All transactions and revenue overview</div>
    </div>
</div>

{{-- STAT CARDS --}}
<div class="stats-grid">
    {{-- Today --}}
    <div class="stat-card green">
        <div class="stat-top">
            <div class="stat-label">Today</div>
            <div class="stat-icon green">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                </svg>
            </div>
        </div>
        <div class="stat-amount">₱{{ number_format($today->total, 2) }}</div>
        <div class="stat-count">
            <span class="stat-count-dot green"></span>
            {{ $today->count }} transaction{{ $today->count !== 1 ? 's' : '' }}
        </div>
    </div>

    {{-- This Week --}}
    <div class="stat-card blue">
        <div class="stat-top">
            <div class="stat-label">This Week</div>
            <div class="stat-icon blue">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                </svg>
            </div>
        </div>
        <div class="stat-amount">₱{{ number_format($thisWeek->total, 2) }}</div>
        <div class="stat-count">
            <span class="stat-count-dot blue"></span>
            {{ $thisWeek->count }} transaction{{ $thisWeek->count !== 1 ? 's' : '' }}
        </div>
    </div>

    {{-- This Month --}}
    <div class="stat-card amber">
        <div class="stat-top">
            <div class="stat-label">This Month</div>
            <div class="stat-icon amber">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                </svg>
            </div>
        </div>
        <div class="stat-amount">₱{{ number_format($thisMonth->total, 2) }}</div>
        <div class="stat-count">
            <span class="stat-count-dot amber"></span>
            {{ $thisMonth->count }} transaction{{ $thisMonth->count !== 1 ? 's' : '' }}
        </div>
    </div>
</div>

{{-- TOOLBAR --}}
<div class="toolbar">
    <div class="toolbar-search">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
        </svg>
        <input type="text" placeholder="Search ref#, customer…" oninput="filterRows(this.value)">
    </div>
    <div class="toolbar-right">
        <select class="filter-select" onchange="filterPayment(this.value)">
            <option value="">All Payments</option>
            <option>Cash</option>
            <option>GCash</option>
        </select>

        {{-- MONTH FILTER --}}
        <form method="GET" action="{{ route('sales.index') }}" id="monthForm" style="display:flex;gap:8px;align-items:center;">
            <input
                type="month"
                name="month"
                value="{{ $month ?? '' }}"
                class="filter-select"
                style="padding: 0 10px; cursor:pointer;"
                onchange="document.getElementById('monthForm').submit()"
            >
            @if($month)
                <a href="{{ route('sales.index') }}" class="export-btn" style="text-decoration:none;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    Clear
                </a>
            @endif
        </form>
    </div>
</div>
{{-- PRODUCT INSIGHTS (visible only when month is filtered) --}}
@if($month && $productStats && $productStats->count() > 0)
<div class="insights-section">
    <div class="insights-header">
        <div class="insights-title">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:16px;height:16px;">
                <line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/>
            </svg>
            Product Performance —
            <span style="color:var(--text-muted);font-weight:500;">
                {{ \Carbon\Carbon::parse($month)->format('F Y') }}
            </span>
        </div>
        <div class="insights-total">
            Total Revenue:
            <strong>₱{{ number_format($productStats->sum('total_revenue'), 2) }}</strong>
        </div>
    </div>

    <div class="insights-grid">
        {{-- TOP SELLERS --}}
        <div class="insights-card">
            <div class="insights-card-title best">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:13px;height:13px;"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
                Top Selling
            </div>
            @foreach($productStats->take(5) as $i => $p)
            <div class="insights-row">
                <div class="insights-rank {{ $i === 0 ? 'gold' : ($i === 1 ? 'silver' : ($i === 2 ? 'bronze' : '')) }}">
                    {{ $i + 1 }}
                </div>
                <div class="insights-product">
                    <span class="insights-product-name">{{ $p->product->name ?? 'Unknown' }}</span>
                    <span class="insights-product-qty">{{ $p->total_qty }} units sold</span>
                </div>
                <div class="insights-revenue">₱{{ number_format($p->total_revenue, 2) }}</div>
            </div>
            @endforeach
        </div>

        {{-- LEAST SELLERS --}}
        <div class="insights-card">
            <div class="insights-card-title worst">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:13px;height:13px;"><polyline points="23 18 13.5 8.5 8.5 13.5 1 6"/><polyline points="17 18 23 18 23 12"/></svg>
                Least Selling
            </div>
            @foreach($productStats->sortBy('total_qty')->take(5) as $i => $p)
            <div class="insights-row">
                <div class="insights-rank low">{{ $i + 1 }}</div>
                <div class="insights-product">
                    <span class="insights-product-name">{{ $p->product->name ?? 'Unknown' }}</span>
                    <span class="insights-product-qty">{{ $p->total_qty }} units sold</span>
                </div>
                <div class="insights-revenue muted">₱{{ number_format($p->total_revenue, 2) }}</div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif
{{-- TABLE --}}
<div class="table-card">
    <table class="sales-table" id="salesTable">
        <thead>
            <tr>
                <th>Ref #</th>
                <th>Date & Time</th>
                <th>Customer</th>
                <th>Items Sold</th>
                <th>Total</th>
                <th>Payment</th>
                <th>Cashier</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody id="salesBody">
            @forelse($sales as $sale)
            @php
                $statusClass = match(strtolower($sale->status ?? 'completed')) {
                    'completed' => 'completed',
                    'pending'   => 'pending',
                    'voided'    => 'voided',
                    default     => 'completed',
                };
                $payClass = match(strtolower($sale->payment_method ?? '')) {
                    'cash'  => 'cash',
                    'gcash' => 'gcash',
                    default => 'other',
                };
                $initials = $sale->user
                    ? collect(explode(' ', $sale->user->name))->map(fn($w) => strtoupper($w[0]))->take(2)->join('')
                    : '?';
            @endphp
            <tr data-search="{{ strtolower($sale->reference_no . ' ' . ($sale->customer_name ?? 'walk-in')) }}"
                data-payment="{{ strtolower($sale->payment_method ?? '') }}">
                <td><span class="ref-chip">{{ $sale->reference_no }}</span></td>
                <td>
                    <div class="date-main">{{ $sale->created_at->format('M d, Y') }}</div>
                    <div class="date-sub">{{ $sale->created_at->format('h:i A') }}</div>
                </td>
                <td>
                    @if($sale->customer_name)
                        <div class="customer-name">{{ $sale->customer_name }}</div>
                    @else
                        <div class="customer-walkin">Walk-in</div>
                    @endif
                </td>
                <td>
                    @foreach($sale->items->take(2) as $item)
                        <div class="item-row">
                            {{ $item->product->name ?? 'N/A' }}
                            <span class="item-qty">× {{ $item->quantity }}</span>
                        </div>
                    @endforeach
                    @if($sale->items->count() > 2)
                        <div class="items-more">+{{ $sale->items->count() - 2 }} more item{{ $sale->items->count() - 2 > 1 ? 's' : '' }}</div>
                    @endif
                </td>
                <td class="amount-cell">₱{{ number_format($sale->total_amount, 2) }}</td>
                <td>
                    <span class="pay-badge {{ $payClass }}">
                        @if($payClass === 'cash')
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/>
                            </svg>
                        @elseif($payClass === 'gcash')
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="5" y="2" width="14" height="20" rx="2"/><line x1="12" y1="18" x2="12.01" y2="18"/>
                            </svg>
                        @endif
                        {{ $sale->payment_method }}
                    </span>
                </td>
                <td>
                    <div class="cashier-cell">
                        <div class="cashier-avatar">{{ $initials }}</div>
                        <span class="cashier-name">{{ $sale->user->name ?? '—' }}</span>
                    </div>
                </td>
                <td>
                    <span class="status-badge {{ $statusClass }}">{{ ucfirst($sale->status ?? 'Completed') }}</span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8">
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
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

    @if($sales->count() > 0)
    <div class="table-footer">
        <span>Showing <strong>{{ $sales->count() }}</strong> of <strong>{{ $sales->total() }}</strong> transactions</span>
        <div>{{ $sales->links() }}</div>
    </div>
    @endif
</div>

@endsection

@push('scripts')
<script>
function filterRows(q) {
    const search = q.toLowerCase();
    const payVal = document.querySelector('.filter-select')?.value.toLowerCase() ?? '';
    applyFilters(search, payVal);
}

function filterPayment(val) {
    const search = document.querySelector('.toolbar-search input')?.value.toLowerCase() ?? '';
    applyFilters(search, val.toLowerCase());
}

function applyFilters(search, payment) {
    document.querySelectorAll('#salesBody tr[data-search]').forEach(row => {
        const matchSearch  = !search  || row.dataset.search.includes(search);
        const matchPayment = !payment || row.dataset.payment === payment;
        row.style.display  = matchSearch && matchPayment ? '' : 'none';
    });
}
</script>
@endpush