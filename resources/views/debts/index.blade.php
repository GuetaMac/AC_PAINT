@extends('layouts.app')

@section('title', 'Debts')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700;800&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<style>
:root {
    --green:       #16a34a;
    --green-light: #dcfce7;
    --green-mid:   #bbf7d0;
    --green-dark:  #14532d;
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
    --accent:      #0ea5e9;
    --radius:      14px;
    --radius-sm:   8px;
    --shadow-sm:   0 1px 3px rgba(0,0,0,0.06),0 1px 2px rgba(0,0,0,0.04);
    --shadow-md:   0 4px 16px rgba(0,0,0,0.08),0 2px 6px rgba(0,0,0,0.04);
    --shadow-lg:   0 12px 40px rgba(0,0,0,0.13),0 4px 12px rgba(0,0,0,0.07);
    --font:        'DM Sans', sans-serif;
    --font-mono:   'DM Mono', monospace;
}
*,*::before,*::after{box-sizing:border-box;}
body{font-family:var(--font);background:var(--surface);color:var(--text);}

/* ── SWEETALERT2 OVERRIDES ── */
.swal2-popup{font-family:var(--font)!important;border-radius:var(--radius)!important;border:1px solid var(--border)!important;box-shadow:var(--shadow-lg)!important;padding:2rem 2.25rem!important;}
.swal2-title{font-size:18px!important;font-weight:700!important;color:var(--text)!important;letter-spacing:-0.2px!important;}
.swal2-html-container{font-size:14.5px!important;color:var(--text-mid)!important;line-height:1.6!important;}
.swal2-confirm{font-family:var(--font)!important;font-size:14.5px!important;font-weight:700!important;border-radius:10px!important;padding:10px 24px!important;box-shadow:none!important;letter-spacing:0.01em!important;}
.swal2-cancel{font-family:var(--font)!important;font-size:14.5px!important;font-weight:600!important;border-radius:10px!important;padding:10px 24px!important;box-shadow:none!important;color:#374151!important;}
.swal2-icon{border-width:2px!important;margin-bottom:1rem!important;}

.page-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;gap:1rem;flex-wrap:wrap;}
.page-title{font-size:28px;font-weight:700;color:var(--text);letter-spacing:-0.4px;}
.page-sub{font-size:16px;color:var(--text-muted);}

/* ── STAT CARDS ── */
.stats-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:10px;margin-bottom:1.5rem;}
.stat-card{background:var(--card);border:1px solid var(--border);border-radius:var(--radius);padding:20px 22px;display:flex;align-items:center;gap:16px;box-shadow:var(--shadow-sm);}
.stat-icon{width:48px;height:48px;border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
.stat-icon svg{width:22px;height:22px;}
.stat-icon.red{background:var(--red-light);color:var(--red);}
.stat-icon.amber{background:var(--amber-light);color:var(--amber);}
.stat-icon.green{background:var(--green-light);color:var(--green);}
.stat-val{font-size:26px;font-weight:700;color:var(--text);line-height:1.1;font-variant-numeric:tabular-nums;}
.stat-lbl{font-size:14px;color:var(--text-muted);margin-top:4px;}

/* ── TWO COL ── */
.two-col{display:grid;grid-template-columns:1fr 1.1fr;gap:14px;align-items:start;}
@media(max-width:780px){.two-col{grid-template-columns:1fr;}}

/* ── CARDS ── */
.card{background:var(--card);border:1px solid var(--border);border-radius:var(--radius);box-shadow:var(--shadow-sm);overflow:hidden;margin-bottom:12px;}
.card-head{display:flex;align-items:center;gap:10px;padding:17px 22px;border-bottom:1px solid var(--border);background:#fdfdfd;}
.card-head-icon{width:32px;height:32px;border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
.card-head-icon svg{width:16px;height:16px;}
.card-head-icon.blue{background:#eff6ff;color:#3b82f6;}
.card-head-icon.violet{background:var(--violet-light);color:var(--violet);}
.card-head-icon.green{background:var(--green-light);color:var(--green);}
.card-head-title{font-size:15px;font-weight:700;color:var(--text);}
.card-body{padding:20px 22px;}

/* ── SEARCH ── */
.search-wrap{position:relative;margin-bottom:10px;}
.search-wrap input{width:100%;padding:13px 18px 13px 48px;font-size:16px;font-family:var(--font);border:1.5px solid var(--border);border-radius:10px;background:var(--surface);color:var(--text);outline:none;transition:border-color .2s,box-shadow .2s;}
.search-wrap input:focus{border-color:var(--accent);background:var(--card);box-shadow:0 0 0 3px rgba(14,165,233,0.10);}
.search-wrap input::placeholder{color:var(--text-muted);}
.search-ico{position:absolute;left:15px;top:50%;transform:translateY(-50%);width:19px;height:19px;color:var(--text-muted);pointer-events:none;}

.results-list{border:1px solid var(--border);border-radius:10px;max-height:280px;overflow-y:auto;box-shadow:var(--shadow-md);background:var(--card);}
.results-list::-webkit-scrollbar{width:4px;}
.results-list::-webkit-scrollbar-thumb{background:var(--border-dark);border-radius:4px;}
.result-item{display:flex;align-items:center;justify-content:space-between;padding:14px 18px;cursor:pointer;border-bottom:1px solid #f1f5f9;transition:background .12s;gap:12px;}
.result-item:last-child{border-bottom:none;}
.result-item:hover{background:#f8fafc;}
.ri-name{font-size:15px;font-weight:600;color:var(--text);}
.ri-meta{font-size:14px;color:var(--text-muted);margin-top:3px;}
.ri-right{display:flex;align-items:center;gap:8px;flex-shrink:0;}
.stock-badge{font-size:13px;font-weight:600;padding:4px 11px;border-radius:20px;white-space:nowrap;}
.stock-badge.ok{background:var(--green-light);color:var(--green);}
.stock-badge.low{background:var(--amber-light);color:var(--amber);}
.stock-badge.out{background:var(--red-light);color:var(--red);}
.add-btn{font-size:14px;font-family:var(--font);font-weight:600;padding:8px 16px;border:1.5px solid var(--border-dark);border-radius:8px;background:var(--card);color:var(--text);cursor:pointer;white-space:nowrap;transition:all .15s;}
.add-btn:hover:not(:disabled){background:var(--text);color:var(--card);border-color:var(--text);}
.add-btn:disabled{opacity:.35;cursor:not-allowed;}
.no-results{padding:1.4rem;text-align:center;color:var(--text-muted);font-size:15px;}

/* ── FORM FIELDS ── */
.form-field{margin-bottom:18px;}
.form-field:last-child{margin-bottom:0;}
.form-field label{display:block;font-size:14px;font-weight:700;color:var(--text-mid);margin-bottom:8px;letter-spacing:0.03em;text-transform:uppercase;}
.form-field .opt{color:var(--text-muted);font-weight:400;text-transform:none;font-size:13px;}
.form-field input,.form-field textarea{width:100%;padding:12px 16px;font-size:16px;font-family:var(--font);border:1.5px solid var(--border);border-radius:10px;background:var(--surface);color:var(--text);outline:none;transition:border-color .2s,box-shadow .2s;}
.form-field input:focus,.form-field textarea:focus{border-color:var(--accent);background:var(--card);box-shadow:0 0 0 3px rgba(14,165,233,0.10);}
.form-field input::placeholder,.form-field textarea::placeholder{color:var(--text-muted);}

/* ── DEBTOR NAME AUTOCOMPLETE ── */
.debtor-wrap{position:relative;}
.debtor-suggestions{position:absolute;top:calc(100% + 4px);left:0;right:0;background:var(--card);border:1.5px solid var(--border);border-radius:10px;box-shadow:var(--shadow-md);z-index:100;max-height:200px;overflow-y:auto;}
.debtor-sug-item{padding:12px 16px;cursor:pointer;font-size:15px;font-weight:500;color:var(--text);border-bottom:1px solid #f1f5f9;transition:background .12s;display:flex;align-items:center;gap:10px;}
.debtor-sug-item:last-child{border-bottom:none;}
.debtor-sug-item:hover{background:#f8fafc;}
.debtor-sug-badge{font-size:12px;font-weight:600;padding:3px 9px;border-radius:20px;white-space:nowrap;}
.debtor-sug-badge.unpaid{background:var(--red-light);color:var(--red);}
.debtor-sug-badge.partial{background:var(--amber-light);color:var(--amber);}
.merge-hint{font-size:13px;color:var(--amber);font-weight:600;background:var(--amber-light);border:1px solid #fde68a;border-radius:8px;padding:10px 14px;margin-top:8px;display:none;align-items:center;gap:8px;}
.merge-hint svg{width:16px;height:16px;flex-shrink:0;}

/* ── CART ── */
.cart-empty{display:flex;flex-direction:column;align-items:center;justify-content:center;padding:2.5rem 1.5rem;color:var(--text-muted);gap:12px;}
.cart-empty-icon{width:60px;height:60px;border-radius:50%;background:var(--surface);border:1.5px dashed var(--border-dark);display:flex;align-items:center;justify-content:center;}
.cart-empty-icon svg{width:26px;height:26px;opacity:.4;}
.cart-empty p{font-size:15px;text-align:center;line-height:1.6;}
.cart-empty strong{display:block;font-size:16px;color:var(--text-mid);margin-bottom:4px;}

.cart-table{width:100%;border-collapse:collapse;font-size:15px;}
.cart-table th{padding:10px 12px;color:var(--text-muted);font-weight:700;font-size:13px;text-transform:uppercase;letter-spacing:0.06em;border-bottom:1px solid var(--border);text-align:left;}
.cart-table td{padding:13px 12px;border-bottom:1px solid #f1f5f9;vertical-align:middle;}
.cart-table tr:last-child td{border-bottom:none;}
.cart-table tr:hover td{background:#fafbfc;}
.item-name{font-size:15px;font-weight:600;color:var(--text);line-height:1.4;}
.item-price{font-size:13px;color:var(--text-muted);margin-top:2px;}
.qty-ctrl{display:flex;align-items:center;gap:7px;}
.qty-btn{width:32px;height:32px;border:1.5px solid var(--border-dark);border-radius:8px;background:var(--card);cursor:pointer;font-size:17px;display:flex;align-items:center;justify-content:center;color:var(--text-mid);transition:all .15s;line-height:1;}
.qty-btn:hover{background:var(--text);color:var(--card);border-color:var(--text);}
.qty-val{min-width:28px;text-align:center;font-weight:700;font-size:16px;color:var(--text);}
.remove-btn{width:32px;height:32px;border:1.5px solid #fca5a5;border-radius:8px;background:var(--card);cursor:pointer;font-size:17px;display:flex;align-items:center;justify-content:center;color:var(--red);transition:all .15s;line-height:1;}
.remove-btn:hover{background:var(--red);color:var(--card);border-color:var(--red);}
.amount-cell{font-weight:700;font-size:16px;color:var(--text);font-variant-numeric:tabular-nums;white-space:nowrap;}

.order-summary{background:var(--surface);border:1px solid var(--border);border-radius:10px;padding:18px 20px;margin-top:14px;}
.sum-row.total{display:flex;justify-content:space-between;align-items:center;font-weight:700;font-size:20px;color:var(--text);}
.sum-row.total span:last-child{color:var(--red);}

.save-btn{width:100%;margin-top:14px;padding:16px;background:var(--red);color:#fff;border:none;border-radius:12px;font-size:17px;font-family:var(--font);font-weight:700;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:9px;transition:all .2s;letter-spacing:0.01em;box-shadow:0 2px 8px rgba(220,38,38,0.25);}
.save-btn svg{width:20px;height:20px;}
.save-btn:hover:not(:disabled){background:#b91c1c;box-shadow:0 4px 16px rgba(220,38,38,0.35);transform:translateY(-1px);}
.save-btn:disabled{background:#e2e8f0;color:#94a3b8;cursor:not-allowed;box-shadow:none;}

/* ── SECTION SEP ── */
.section-sep{display:flex;align-items:center;gap:14px;margin:1.8rem 0 1.4rem;}
.section-sep-line{flex:1;height:1px;background:var(--border);}
.section-sep-label{font-size:14px;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:var(--text-muted);}

/* ── FILTER ROW ── */
.filter-row{display:flex;align-items:center;gap:8px;margin-bottom:1.2rem;flex-wrap:wrap;}
.filter-btn{font-size:14px;font-family:var(--font);font-weight:600;padding:8px 18px;border-radius:20px;border:1.5px solid var(--border);background:var(--card);color:var(--text-mid);cursor:pointer;transition:all .15s;}
.filter-btn:hover{border-color:var(--border-dark);color:var(--text);}
.filter-btn.active-all{background:var(--text);border-color:var(--text);color:#fff;}
.filter-btn.active-unpaid{background:var(--red-light);border-color:var(--red);color:var(--red);}
.filter-btn.active-partial{background:var(--amber-light);border-color:var(--amber);color:var(--amber);}
.filter-btn.active-paid{background:var(--green-light);border-color:var(--green);color:var(--green);}

/* ── DEBTOR CARDS ── */
.debtors-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:16px;}
@media(max-width:900px){.debtors-grid{grid-template-columns:repeat(2,1fr);}}
@media(max-width:560px){.debtors-grid{grid-template-columns:1fr;}}

.debtor-card{background:var(--card);border:1px solid var(--border);border-left:5px solid var(--border-dark);border-radius:var(--radius);padding:22px 22px 18px;box-shadow:var(--shadow-sm);cursor:pointer;transition:box-shadow .2s,transform .2s;}
.debtor-card:hover{box-shadow:var(--shadow-md);transform:translateY(-2px);}
.debtor-card.unpaid{border-left-color:var(--red);}
.debtor-card.partial{border-left-color:var(--amber);}
.debtor-card.paid{border-left-color:var(--green);}

.dc-top{display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:14px;gap:8px;}
.dc-name{font-size:20px;font-weight:800;color:var(--text);line-height:1.2;}
.dc-date{font-size:13px;color:var(--text-muted);margin-top:4px;}
.dc-badge{display:inline-flex;align-items:center;gap:5px;font-size:13px;font-weight:700;padding:5px 13px;border-radius:20px;white-space:nowrap;flex-shrink:0;}
.dc-badge::before{content:'';width:7px;height:7px;border-radius:50%;flex-shrink:0;}
.dc-badge.unpaid{background:var(--red-light);color:#7f1d1d;}
.dc-badge.unpaid::before{background:var(--red);}
.dc-badge.partial{background:var(--amber-light);color:#78350f;}
.dc-badge.partial::before{background:var(--amber);}
.dc-badge.paid{background:var(--green-light);color:var(--green-dark);}
.dc-badge.paid::before{background:var(--green);}

.dc-progress-wrap{height:7px;background:#f1f5f9;border-radius:10px;overflow:hidden;margin-bottom:16px;}
.dc-progress-bar{height:100%;border-radius:10px;}
.dc-progress-bar.unpaid{background:var(--red);}
.dc-progress-bar.partial{background:var(--amber);}
.dc-progress-bar.paid{background:var(--green);}

.dc-amounts{display:flex;flex-direction:column;gap:10px;}
.dc-remaining-block{background:var(--red-light);border:1.5px solid #fca5a5;border-radius:10px;padding:12px 16px;display:flex;align-items:center;justify-content:space-between;}
.dc-remaining-block.paid{background:var(--green-light);border-color:var(--green-mid);}
.dc-remaining-label{font-size:13px;font-weight:700;text-transform:uppercase;letter-spacing:0.05em;color:var(--red);}
.dc-remaining-block.paid .dc-remaining-label{color:var(--green-dark);}
.dc-remaining-amount{font-size:28px;font-weight:800;color:var(--red);font-variant-numeric:tabular-nums;letter-spacing:-0.5px;}
.dc-remaining-block.paid .dc-remaining-amount{color:var(--green);font-size:22px;}

.dc-total-row{display:flex;justify-content:space-between;align-items:center;}
.dc-total-lbl{font-size:14px;color:var(--text-muted);}
.dc-total-val{font-size:16px;font-weight:600;color:var(--text-mid);font-variant-numeric:tabular-nums;}

.dc-items-count{font-size:13px;color:var(--text-muted);margin-top:12px;padding-top:12px;border-top:1px solid #f1f5f9;display:flex;gap:8px;}

/* ── EMPTY ── */
.empty-debtors{display:flex;flex-direction:column;align-items:center;padding:3rem 1.5rem;color:var(--text-muted);gap:12px;text-align:center;}
.empty-debtors-icon{width:68px;height:68px;border-radius:50%;background:var(--surface);border:1.5px dashed var(--border-dark);display:flex;align-items:center;justify-content:center;}
.empty-debtors-icon svg{width:30px;height:30px;opacity:.3;}
.empty-debtors strong{font-size:17px;color:var(--text-mid);}

/* ── MODAL ── */
.modal-overlay{position:fixed;inset:0;background:rgba(15,23,42,0.45);backdrop-filter:blur(3px);z-index:1000;display:flex;align-items:center;justify-content:center;padding:1rem;opacity:0;pointer-events:none;transition:opacity .2s;}
.modal-overlay.open{opacity:1;pointer-events:all;}
.modal-box{background:var(--card);border-radius:18px;box-shadow:var(--shadow-lg);width:100%;max-width:600px;max-height:90vh;overflow-y:auto;transform:translateY(16px) scale(.98);transition:transform .25s;display:flex;flex-direction:column;}
.modal-overlay.open .modal-box{transform:translateY(0) scale(1);}
.modal-box::-webkit-scrollbar{width:4px;}
.modal-box::-webkit-scrollbar-thumb{background:var(--border-dark);border-radius:4px;}

.modal-header{display:flex;align-items:flex-start;justify-content:space-between;padding:24px 26px 20px;border-bottom:1px solid var(--border);gap:12px;flex-shrink:0;}
.modal-title{font-size:22px;font-weight:800;color:var(--text);}
.modal-meta{font-size:14px;color:var(--text-muted);margin-top:4px;}
.modal-close{width:34px;height:34px;border-radius:9px;border:1.5px solid var(--border);background:var(--surface);cursor:pointer;display:flex;align-items:center;justify-content:center;color:var(--text-muted);transition:all .15s;flex-shrink:0;font-size:19px;line-height:1;}
.modal-close:hover{background:var(--red);border-color:var(--red);color:#fff;}
.modal-body{padding:22px 26px;flex:1;}
.modal-section-title{font-size:13px;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--text-muted);margin-bottom:12px;}

.modal-items-table{width:100%;border-collapse:collapse;font-size:15px;margin-bottom:20px;}
.modal-items-table th{padding:9px 12px;color:var(--text-muted);font-weight:700;font-size:12px;text-transform:uppercase;letter-spacing:0.06em;border-bottom:1px solid var(--border);text-align:left;}
.modal-items-table td{padding:13px 12px;border-bottom:1px solid #f1f5f9;vertical-align:middle;}
.modal-items-table tr:last-child td{border-bottom:none;}
.modal-item-name{font-weight:600;color:var(--text);font-size:15px;}
.modal-item-sub{font-size:13px;color:var(--text-muted);margin-top:2px;}
.mark-item-btn{font-size:13px;font-family:var(--font);font-weight:700;padding:6px 14px;border:1.5px solid var(--green);border-radius:8px;background:var(--card);color:var(--green);cursor:pointer;white-space:nowrap;transition:all .15s;}
.mark-item-btn:hover{background:var(--green);color:#fff;}
.item-paid-badge{display:inline-flex;align-items:center;gap:5px;font-size:13px;font-weight:700;color:var(--green);background:var(--green-light);padding:6px 14px;border-radius:8px;}
.item-paid-badge svg{width:13px;height:13px;}

.modal-payment-box{background:var(--surface);border:1px solid var(--border);border-radius:12px;padding:20px;}
.pay-progress-wrap{height:9px;background:#e2e8f0;border-radius:10px;overflow:hidden;margin-bottom:14px;}
.pay-progress-bar{height:100%;border-radius:10px;background:var(--green);transition:width .4s ease;}
.pay-amounts{display:flex;justify-content:space-between;margin-bottom:18px;flex-wrap:wrap;gap:8px;}
.pay-amount-item{font-size:14px;color:var(--text-muted);}
.pay-amount-item strong{display:block;font-size:22px;font-weight:800;font-variant-numeric:tabular-nums;}
.pay-amount-item strong.red{color:var(--red);}
.pay-amount-item strong.green{color:var(--green);}
.pay-input-row{display:grid;grid-template-columns:1fr auto;gap:8px;align-items:end;}
.pay-input-row input{padding:12px 16px;font-size:16px;font-family:var(--font);border:1.5px solid var(--border);border-radius:10px;background:var(--card);color:var(--text);outline:none;transition:border-color .2s,box-shadow .2s;width:100%;}
.pay-input-row input:focus{border-color:var(--green);box-shadow:0 0 0 3px rgba(22,163,74,0.10);}
.pay-input-row input::placeholder{color:var(--text-muted);}
.pay-btn{padding:12px 22px;background:var(--green);color:#fff;border:none;border-radius:10px;font-size:15px;font-family:var(--font);font-weight:700;cursor:pointer;white-space:nowrap;transition:all .15s;}
.pay-btn:hover{background:#15803d;}
.fullpay-btn{width:100%;margin-top:10px;padding:13px;background:var(--card);border:1.5px solid var(--green);color:var(--green);border-radius:10px;font-size:15px;font-family:var(--font);font-weight:700;cursor:pointer;transition:all .15s;}
.fullpay-btn:hover{background:var(--green);color:#fff;}
.paid-notice{display:flex;align-items:center;gap:12px;background:var(--green-light);border:1px solid var(--green-mid);border-radius:10px;padding:16px 18px;color:var(--green-dark);font-weight:700;font-size:16px;}
.paid-notice svg{width:22px;height:22px;flex-shrink:0;}

@keyframes spin{to{transform:rotate(360deg);}}
</style>
@endpush

@section('content')

<div class="page-header">
    <div>
        <div class="page-title">Debts</div>
        <div class="page-sub">Track customer credit and record payments</div>
    </div>
</div>

{{-- STAT CARDS --}}
@php
    $totalUnpaid  = $debts->where('status','unpaid')->count();
    $totalPartial = $debts->where('status','partial')->count();
    $totalOwe     = $debts->whereIn('status',['unpaid','partial'])->sum(fn($d) => $d->total_amount - $d->amount_paid);
@endphp
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon red">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        </div>
        <div><div class="stat-val">{{ $totalUnpaid }}</div><div class="stat-lbl">Unpaid debts</div></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon amber">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
        </div>
        <div><div class="stat-val">{{ $totalPartial }}</div><div class="stat-lbl">Partial payments</div></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon red">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
        </div>
        <div><div class="stat-val">₱{{ number_format($totalOwe, 2) }}</div><div class="stat-lbl">Total outstanding</div></div>
    </div>
</div>

{{-- NEW DEBT FORM --}}
<div class="two-col">
    <div>
        <div class="card">
            <div class="card-head">
                <div class="card-head-icon blue">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                </div>
                <div class="card-head-title">Search Products</div>
            </div>
            <div class="card-body">
                <div class="search-wrap">
                    <svg class="search-ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    <input type="text" id="prod-search" placeholder="Type product name or brand…" autocomplete="off" oninput="searchProducts(this.value)">
                </div>
                <div id="search-results" class="results-list" style="display:none"></div>
            </div>
        </div>

        <div class="card">
            <div class="card-head">
                <div class="card-head-icon violet">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                </div>
                <div class="card-head-title">Debtor Info</div>
            </div>
            <div class="card-body">
                <div class="form-field">
                    <label>Customer Name</label>
                    <div class="debtor-wrap">
                        <input type="text" id="debtor-name" placeholder="e.g. Juan dela Cruz"
                               autocomplete="off"
                               oninput="onDebtorInput(this.value)"
                               onfocus="onDebtorInput(this.value)">
                        <div id="debtor-suggestions" class="debtor-suggestions" style="display:none"></div>
                    </div>
                    <div class="merge-hint" id="merge-hint">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                        May existing debt — new items will be added to their current balance.
                    </div>
                </div>
                <div class="form-field">
                    <label>Notes <span class="opt">(optional)</span></label>
                    <textarea id="debt-notes" placeholder="Any notes…" rows="2" style="resize:vertical;"></textarea>
                </div>
            </div>
        </div>
    </div>

    <div>
        <div class="card">
            <div class="card-head">
                <div class="card-head-icon green">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                </div>
                <div class="card-head-title">Items on Credit</div>
            </div>
            <div class="card-body">
                <div id="cart-empty" class="cart-empty">
                    <div class="cart-empty-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
                    </div>
                    <div>
                        <strong>No items yet</strong>
                        <p>Search products and click Add to get started.</p>
                    </div>
                </div>
                <div id="cart-wrap" style="display:none">
                    <table class="cart-table">
                        <thead><tr><th>Product</th><th>Qty</th><th>Amount</th><th></th></tr></thead>
                        <tbody id="cart-body"></tbody>
                    </table>
                    <div class="order-summary">
                        <div class="sum-row total">
                            <span>Total Debt</span>
                            <span id="sum-total">₱0.00</span>
                        </div>
                    </div>
                </div>
                <button class="save-btn" id="save-btn" disabled onclick="saveDebt()">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                    Save Debt
                </button>
            </div>
        </div>
    </div>
</div>

{{-- DEBTORS LIST --}}
<div class="section-sep">
    <div class="section-sep-line"></div>
    <div class="section-sep-label">Debtor Records</div>
    <div class="section-sep-line"></div>
</div>

<div class="filter-row">
    <button class="filter-btn active-all" onclick="filterDebts('all', this)">All ({{ $debts->count() }})</button>
    <button class="filter-btn" onclick="filterDebts('unpaid', this)">Unpaid ({{ $debts->where('status','unpaid')->count() }})</button>
    <button class="filter-btn" onclick="filterDebts('partial', this)">Partial ({{ $debts->where('status','partial')->count() }})</button>
    <button class="filter-btn" onclick="filterDebts('paid', this)">Paid ({{ $debts->where('status','paid')->count() }})</button>
</div>

@if($debts->isEmpty())
    <div class="empty-debtors">
        <div class="empty-debtors-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
        </div>
        <strong>No debts recorded yet</strong>
        <p>Add a debt above to get started.</p>
    </div>
@else
    <div class="debtors-grid" id="debtors-grid">
        @foreach($debts as $debt)
        @php
            $pct       = $debt->total_amount > 0 ? min(100, ($debt->amount_paid / $debt->total_amount) * 100) : 0;
            $remaining = $debt->total_amount - $debt->amount_paid;
        @endphp
        <div class="debtor-card {{ $debt->status }}"
             data-status="{{ $debt->status }}"
             onclick="openDebt({{ $debt->id }})">
            <div class="dc-top">
                <div>
                    <div class="dc-name">{{ $debt->debtor_name }}</div>
                    <div class="dc-date">{{ $debt->created_at->format('M j, Y') }}</div>
                </div>
                <span class="dc-badge {{ $debt->status }}">{{ ucfirst($debt->status) }}</span>
            </div>
            <div class="dc-progress-wrap">
                <div class="dc-progress-bar {{ $debt->status }}" style="width:{{ $pct }}%"></div>
            </div>
            <div class="dc-amounts">
                <div class="dc-remaining-block {{ $debt->status === 'paid' ? 'paid' : '' }}">
                    <div>
                        <div class="dc-remaining-label">
                            {{ $debt->status === 'paid' ? 'Fully Paid' : 'Remaining' }}
                        </div>
                        <div class="dc-remaining-amount">
                            {{ $debt->status === 'paid' ? '✓ ₱'.number_format($debt->total_amount,2) : '₱'.number_format($remaining,2) }}
                        </div>
                    </div>
                </div>
                <div class="dc-total-row">
                    <span class="dc-total-lbl">Total debt</span>
                    <span class="dc-total-val">₱{{ number_format($debt->total_amount, 2) }}</span>
                </div>
            </div>
            <div class="dc-items-count">
                <span>{{ $debt->items->count() }} item{{ $debt->items->count() !== 1 ? 's' : '' }}</span>
                @if($debt->amount_paid > 0 && $debt->status !== 'paid')
                    <span>·</span>
                    <span>₱{{ number_format($debt->amount_paid, 2) }} paid</span>
                @endif
            </div>
        </div>
        @endforeach
    </div>
@endif

{{-- MODAL --}}
<div class="modal-overlay" id="modal-overlay" onclick="closeModalOutside(event)">
    <div class="modal-box" id="modal-box">
        <div class="modal-header">
            <div>
                <div class="modal-title" id="modal-name">—</div>
                <div class="modal-meta" id="modal-meta">—</div>
            </div>
            <button class="modal-close" onclick="closeModal()">×</button>
        </div>
        <div class="modal-body" id="modal-body">
            <div style="padding:2rem;text-align:center;color:var(--text-muted);">Loading…</div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
const SEARCH_URL        = "{{ route('debts.search') }}";
const STORE_URL         = "{{ route('debts.store') }}";
const DEBTOR_NAMES_URL  = "{{ route('debts.debtorNames') }}";
const CSRF              = "{{ csrf_token() }}";

let cart          = [];
let searchTimer;
let debtorTimer;
let currentDebtId = null;
let debtModified  = false;

/* ── SweetAlert2 Toast ── */
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3500,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer);
        toast.addEventListener('mouseleave', Swal.resumeTimer);
    }
});

/* ── PRODUCT SEARCH ── */
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
        box.style.display = 'block'; return;
    }
    box.innerHTML = products.map(p => {
        let sc = 'ok', sl = `${p.stock} in stock`;
        if (p.stock <= 0)      { sc = 'out'; sl = 'Out of stock'; }
        else if (p.stock <= 5) { sc = 'low'; sl = `Low: ${p.stock}`; }
        const inCart = cart.find(c => c.id === p.id);
        return `<div class="result-item" onclick="addToCart(${p.id},'${escHtml(p.name)}',${p.price},${p.stock})">
            <div style="min-width:0;flex:1">
                <div class="ri-name">${escHtml(p.name)}</div>
                <div class="ri-meta">₱${numFmt(p.price)}</div>
            </div>
            <div class="ri-right">
                <span class="stock-badge ${sc}">${sl}</span>
                <button class="add-btn" ${p.stock<=0?'disabled':''}
                    onclick="event.stopPropagation();addToCart(${p.id},'${escHtml(p.name)}',${p.price},${p.stock})">
                    ${inCart?'+ More':'Add'}
                </button>
            </div>
        </div>`;
    }).join('');
    box.style.display = 'block';
}

/* ── DEBTOR NAME AUTOCOMPLETE ── */
async function onDebtorInput(val) {
    clearTimeout(debtorTimer);
    const sugBox    = document.getElementById('debtor-suggestions');
    const mergeHint = document.getElementById('merge-hint');
    if (!val.trim()) {
        sugBox.style.display = 'none';
        mergeHint.style.display = 'none';
        return;
    }
    debtorTimer = setTimeout(async () => {
        const res   = await fetch(`${DEBTOR_NAMES_URL}?q=${encodeURIComponent(val)}`);
        const names = await res.json();
        const exact = names.find(n => n.name.toLowerCase() === val.toLowerCase());
        mergeHint.style.display = exact ? 'flex' : 'none';
        if (!names.length) { sugBox.style.display = 'none'; return; }
        sugBox.innerHTML = names.map(n =>
            `<div class="debtor-sug-item" onclick="selectDebtor('${escHtml(n.name)}')">
                <span style="flex:1">${escHtml(n.name)}</span>
                <span class="debtor-sug-badge ${n.status}">${ucfirst(n.status)}</span>
                <span style="font-size:13px;color:var(--text-muted);font-variant-numeric:tabular-nums;">₱${numFmt(n.remaining)} left</span>
            </div>`
        ).join('');
        sugBox.style.display = 'block';
    }, 200);
}
function selectDebtor(name) {
    document.getElementById('debtor-name').value = name;
    document.getElementById('debtor-suggestions').style.display = 'none';
    document.getElementById('merge-hint').style.display = 'flex';
}

/* ── CART ── */
function addToCart(id, name, price, maxQty) {
    if (maxQty <= 0) return;
    const ex = cart.find(c => c.id === id);
    if (ex) {
        if (ex.qty >= maxQty) {
            Toast.fire({ icon: 'warning', title: `Max stock reached for <strong>${name}</strong>` });
            return;
        }
        ex.qty++;
        Toast.fire({ icon: 'success', title: `Added another <strong>${name}</strong>` });
    } else {
        cart.push({ id, name, price, qty: 1, maxQty });
        Toast.fire({ icon: 'success', title: `<strong>${name}</strong> added to list` });
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
        html: `Remove <strong>${escHtml(item.name)}</strong> from the list?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes, remove',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#dc2626',
        reverseButtons: true,
        focusCancel: true,
    }).then(result => {
        if (result.isConfirmed) {
            cart = cart.filter(c => c.id !== id);
            renderCart();
            Toast.fire({ icon: 'info', title: `<strong>${escHtml(item.name)}</strong> removed` });
        }
    });
}
function changeQty(id, delta) {
    const item = cart.find(c => c.id === id);
    if (!item) return;
    const newQty = item.qty + delta;
    if (newQty < 1) { removeFromCart(id); return; }
    if (newQty > item.maxQty) {
        Toast.fire({ icon: 'warning', title: `Only <strong>${item.maxQty}</strong> in stock` });
        return;
    }
    item.qty = newQty;
    renderCart();
}
function renderCart() {
    const body  = document.getElementById('cart-body');
    const empty = document.getElementById('cart-empty');
    const wrap  = document.getElementById('cart-wrap');
    const btn   = document.getElementById('save-btn');
    if (!cart.length) {
        empty.style.display='flex'; wrap.style.display='none'; btn.disabled=true; return;
    }
    empty.style.display='none'; wrap.style.display='block'; btn.disabled=false;
    body.innerHTML = cart.map(item => `
        <tr>
            <td><div class="item-name">${escHtml(item.name)}</div>
                <div class="item-price">₱${numFmt(item.price)} / pc</div></td>
            <td><div class="qty-ctrl">
                <button class="qty-btn" onclick="changeQty(${item.id},-1)">−</button>
                <span class="qty-val">${item.qty}</span>
                <button class="qty-btn" onclick="changeQty(${item.id},1)">+</button>
            </div></td>
            <td class="amount-cell">₱${numFmt(item.price*item.qty)}</td>
            <td><button class="remove-btn" onclick="removeFromCart(${item.id})">×</button></td>
        </tr>`).join('');
    const total = cart.reduce((s,c) => s + c.price * c.qty, 0);
    document.getElementById('sum-total').textContent = '₱' + numFmt(total);
}

/* ── SAVE DEBT ── */
async function saveDebt() {
    const name = document.getElementById('debtor-name').value.trim();
    if (!name) {
        Swal.fire({
            icon: 'warning',
            title: 'Name required',
            html: 'Please enter the <strong>debtor\'s name</strong> before saving.',
            confirmButtonText: 'Got it',
            confirmButtonColor: '#d97706',
        });
        return;
    }
    if (!cart.length) return;

    const total     = cart.reduce((s,c) => s + c.price * c.qty, 0);
    const isMerge   = document.getElementById('merge-hint').style.display === 'flex';
    const itemLines = cart.map(c =>
        `<tr>
            <td style="padding:4px 8px;text-align:left">${escHtml(c.name)}</td>
            <td style="padding:4px 8px;text-align:center">${c.qty}</td>
            <td style="padding:4px 8px;text-align:right;font-weight:700">₱${numFmt(c.price * c.qty)}</td>
        </tr>`
    ).join('');

    const { isConfirmed } = await Swal.fire({
        title: isMerge ? 'Add to existing debt?' : 'Save new debt?',
        html: `
            <div style="text-align:left;font-size:14px">
                ${isMerge ? `<div style="background:#fef3c7;border:1px solid #fde68a;border-radius:8px;padding:10px 14px;margin-bottom:14px;font-size:13px;color:#78350f;font-weight:600">
                    ⚠️ Items will be added to <strong>${escHtml(name)}</strong>'s existing balance.
                </div>` : ''}
                <div style="margin-bottom:8px;font-weight:600;color:#475569">Debtor: <span style="color:#0f172a">${escHtml(name)}</span></div>
                <table style="width:100%;border-collapse:collapse;margin-bottom:12px">
                    <thead><tr style="border-bottom:1px solid #e2e8f0">
                        <th style="padding:5px 8px;text-align:left;font-size:11px;color:#94a3b8;font-weight:700;text-transform:uppercase;letter-spacing:.04em">Item</th>
                        <th style="padding:5px 8px;text-align:center;font-size:11px;color:#94a3b8;font-weight:700;text-transform:uppercase;letter-spacing:.04em">Qty</th>
                        <th style="padding:5px 8px;text-align:right;font-size:11px;color:#94a3b8;font-weight:700;text-transform:uppercase;letter-spacing:.04em">Amount</th>
                    </tr></thead>
                    <tbody>${itemLines}</tbody>
                </table>
                <div style="background:#fee2e2;border:1px solid #fca5a5;border-radius:8px;padding:10px 14px;display:flex;justify-content:space-between;align-items:center">
                    <span style="font-weight:700;color:#7f1d1d">Total Debt</span>
                    <strong style="font-size:18px;color:#dc2626">₱${numFmt(total)}</strong>
                </div>
            </div>`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: isMerge ? '+ Add to Balance' : '💾 Save Debt',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#dc2626',
        reverseButtons: true,
        width: '480px',
    });

    if (!isConfirmed) return;

    const btn = document.getElementById('save-btn');
    btn.disabled = true;
    btn.innerHTML = `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:20px;height:20px;animation:spin 1s linear infinite"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg> Saving…`;

    // Show loading
    Swal.fire({
        title: 'Saving debt…',
        html: 'Please wait.',
        allowOutsideClick: false,
        allowEscapeKey: false,
        didOpen: () => { Swal.showLoading(); }
    });

    const payload = {
        debtor_name : name,
        notes       : document.getElementById('debt-notes').value || null,
        items       : cart.map(c => ({ product_id: c.id, quantity: c.qty })),
    };
    try {
        const res  = await fetch(STORE_URL, {
            method:'POST',
            headers:{'Content-Type':'application/json','X-CSRF-TOKEN':CSRF,'Accept':'application/json'},
            body:JSON.stringify(payload),
        });
        const data = await res.json();
        if (data.success) {
            await Swal.fire({
                icon: 'success',
                title: data.merged ? 'Added to Existing Debt!' : 'Debt Saved!',
                html: data.merged
                    ? `Items worth <strong>₱${numFmt(total)}</strong> added to <strong>${escHtml(name)}</strong>'s balance.`
                    : `New debt of <strong>₱${numFmt(total)}</strong> recorded for <strong>${escHtml(name)}</strong>.`,
                confirmButtonText: 'OK',
                confirmButtonColor: '#dc2626',
                timer: 3000,
                timerProgressBar: true,
            });
            cart=[];renderCart();
            document.getElementById('prod-search').value='';
            document.getElementById('search-results').style.display='none';
            document.getElementById('debtor-name').value='';
            document.getElementById('debt-notes').value='';
            document.getElementById('merge-hint').style.display='none';
            location.reload();
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Failed to Save',
                html: data.message || 'Something went wrong. Please try again.',
                confirmButtonText: 'Try Again',
                confirmButtonColor: '#dc2626',
            });
        }
    } catch(e) {
        Swal.fire({
            icon: 'error',
            title: 'Network Error',
            html: 'Could not connect to the server. Please check your connection.',
            confirmButtonText: 'OK',
            confirmButtonColor: '#dc2626',
        });
    }
    btn.disabled=false;
    btn.innerHTML=`<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width:20px;height:20px"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg> Save Debt`;
}

/* ── MODAL ── */
async function openDebt(id) {
    currentDebtId = id;
    document.getElementById('modal-overlay').classList.add('open');
    document.getElementById('modal-body').innerHTML = '<div style="padding:2rem;text-align:center;color:var(--text-muted);">Loading…</div>';
    const res  = await fetch(`/debts/${id}`, { headers:{'Accept':'application/json','X-CSRF-TOKEN':CSRF} });
    const debt = await res.json();
    renderModal(debt);
}
function renderModal(debt) {
    document.getElementById('modal-name').textContent = debt.debtor_name;
    const badge = `<span class="dc-badge ${debt.status}" style="font-size:13px;">${ucfirst(debt.status)}</span>`;
    document.getElementById('modal-meta').innerHTML =
        `Added ${new Date(debt.created_at).toLocaleDateString('en-PH',{year:'numeric',month:'long',day:'numeric'})} &nbsp; ${badge}`;

    const remaining = debt.total_amount - debt.amount_paid;
    const pct = debt.total_amount > 0 ? Math.min(100,(debt.amount_paid/debt.total_amount)*100) : 0;

    const itemsHtml = `
        <div class="modal-section-title">Items</div>
        <table class="modal-items-table">
            <thead><tr><th>Product</th><th>Qty</th><th>Amount</th><th></th></tr></thead>
            <tbody>
                ${debt.items.map(item=>`
                    <tr>
                        <td>
                            <div class="modal-item-name">${escHtml(item.product_name)}</div>
                            <div class="modal-item-sub">₱${numFmt(item.unit_price)} × ${item.quantity}</div>
                        </td>
                        <td style="font-weight:700;color:var(--text);font-size:15px">${item.quantity}</td>
                        <td style="font-weight:800;color:var(--text);white-space:nowrap;font-size:16px">₱${numFmt(item.subtotal)}</td>
                        <td>
                            ${item.is_paid
                                ? `<span class="item-paid-badge"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>Paid</span>`
                                : `<button class="mark-item-btn" onclick="markItemPaid(${debt.id},${item.id})">Mark Paid</button>`}
                        </td>
                    </tr>`).join('')}
            </tbody>
        </table>`;

    const paymentHtml = debt.status === 'paid'
        ? `<div class="paid-notice">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                This debt has been fully paid. No balance remaining.
           </div>`
        : `<div class="modal-section-title" style="margin-top:18px;">Record Payment</div>
           <div class="modal-payment-box">
               <div class="pay-progress-wrap">
                   <div class="pay-progress-bar" style="width:${pct}%"></div>
               </div>
               <div class="pay-amounts">
                   <div class="pay-amount-item">
                       <span>Paid</span>
                       <strong class="green">₱${numFmt(debt.amount_paid)}</strong>
                   </div>
                   <div class="pay-amount-item" style="text-align:center;">
                       <span>Total</span>
                       <strong>₱${numFmt(debt.total_amount)}</strong>
                   </div>
                   <div class="pay-amount-item" style="text-align:right;">
                       <span>Remaining</span>
                       <strong class="red">₱${numFmt(remaining)}</strong>
                   </div>
               </div>
               <div class="pay-input-row">
                   <input type="number" id="pay-amount-input" placeholder="Enter amount"
                          min="0.01" step="0.01" value="${remaining.toFixed(2)}">
                   <button class="pay-btn" onclick="recordPayment(${debt.id}, ${remaining})">Record</button>
               </div>
               <button class="fullpay-btn" onclick="recordFullPayment(${debt.id},${remaining})">
                   ✓ Mark Fully Paid &nbsp;(₱${numFmt(remaining)} remaining)
               </button>
           </div>`;

    document.getElementById('modal-body').innerHTML = itemsHtml + paymentHtml;
}
function closeModal() {
    document.getElementById('modal-overlay').classList.remove('open');
    if (debtModified) location.reload();
}
function closeModalOutside(e) {
    if (e.target === document.getElementById('modal-overlay')) closeModal();
}

/* ── PAYMENT ── */
async function recordPayment(id, remaining) {
    const amount = parseFloat(document.getElementById('pay-amount-input').value);
    if (!amount || amount <= 0) {
        Toast.fire({ icon: 'warning', title: 'Please enter a valid amount' });
        return;
    }
    if (amount > remaining) {
        const { isConfirmed } = await Swal.fire({
            icon: 'warning',
            title: 'Amount exceeds balance',
            html: `You entered <strong>₱${numFmt(amount)}</strong> but only <strong>₱${numFmt(remaining)}</strong> is remaining.<br><br>Do you want to record <strong>₱${numFmt(remaining)}</strong> instead to fully clear this debt?`,
            showCancelButton: true,
            confirmButtonText: 'Yes, clear it',
            cancelButtonText: 'Let me fix it',
            confirmButtonColor: '#16a34a',
            reverseButtons: true,
        });
        if (!isConfirmed) return;
        return recordFullPayment(id, remaining);
    }

    const { isConfirmed } = await Swal.fire({
        title: 'Record payment?',
        html: `Record a payment of <strong style="color:#16a34a">₱${numFmt(amount)}</strong>?<br><small style="color:#94a3b8">Remaining after: ₱${numFmt(remaining - amount)}</small>`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: '✓ Record Payment',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#16a34a',
        reverseButtons: true,
    });
    if (!isConfirmed) return;

    const res  = await fetch(`/debts/${id}/pay`,{
        method:'POST',
        headers:{'Content-Type':'application/json','X-CSRF-TOKEN':CSRF,'Accept':'application/json'},
        body:JSON.stringify({amount}),
    });
    const data = await res.json();
    if (data.success) {
        debtModified = true;
        Toast.fire({ icon: 'success', title: `Payment of <strong>₱${numFmt(amount)}</strong> recorded!` });
        openDebt(id);
    } else {
        Toast.fire({ icon: 'error', title: data.message || 'Error recording payment' });
    }
}

async function recordFullPayment(id, remaining) {
    const { isConfirmed } = await Swal.fire({
        title: 'Mark as Fully Paid?',
        html: `This will clear the remaining balance of <strong style="color:#dc2626">₱${numFmt(remaining)}</strong> and mark this debt as <strong style="color:#16a34a">Paid</strong>.`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: '✓ Yes, Mark Paid',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#16a34a',
        reverseButtons: true,
    });
    if (!isConfirmed) return;

    const res  = await fetch(`/debts/${id}/pay`,{
        method:'POST',
        headers:{'Content-Type':'application/json','X-CSRF-TOKEN':CSRF,'Accept':'application/json'},
        body:JSON.stringify({amount:remaining}),
    });
    const data = await res.json();
    if (data.success) {
        debtModified = true;
        await Swal.fire({
            icon: 'success',
            title: 'Debt Cleared! 🎉',
            html: 'This debt has been <strong>fully paid</strong>. All balance cleared.',
            confirmButtonText: 'Great!',
            confirmButtonColor: '#16a34a',
            timer: 3000,
            timerProgressBar: true,
        });
        openDebt(id);
    } else {
        Toast.fire({ icon: 'error', title: data.message || 'Error recording payment' });
    }
}

async function markItemPaid(debtId, itemId) {
    const { isConfirmed } = await Swal.fire({
        title: 'Mark item as paid?',
        html: 'This will record this specific item as paid and update the balance.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: '✓ Mark Paid',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#16a34a',
        reverseButtons: true,
    });
    if (!isConfirmed) return;

    const res  = await fetch(`/debts/${debtId}/items/${itemId}/pay`,{
        method:'POST',
        headers:{'Content-Type':'application/json','X-CSRF-TOKEN':CSRF,'Accept':'application/json'},
        body:JSON.stringify({}),
    });
    const data = await res.json();
    if (data.success) {
        debtModified = true;
        Toast.fire({ icon: 'success', title: 'Item marked as paid!' });
        openDebt(debtId);
    } else {
        Toast.fire({ icon: 'error', title: data.message || 'Error' });
    }
}

/* ── FILTER ── */
function filterDebts(status, btn) {
    document.querySelectorAll('.filter-btn').forEach(b => b.className='filter-btn');
    btn.classList.add('active-'+status);
    document.querySelectorAll('.debtor-card').forEach(card => {
        card.style.display = (status==='all' || card.dataset.status===status) ? '' : 'none';
    });
}

/* ── HELPERS ── */
function numFmt(n){ return parseFloat(n).toLocaleString('en-PH',{minimumFractionDigits:2,maximumFractionDigits:2}); }
function ucfirst(s){ return s.charAt(0).toUpperCase()+s.slice(1); }
function escHtml(str){
    return String(str).replace(/&/g,'&amp;').replace(/</g,'&lt;')
        .replace(/>/g,'&gt;').replace(/"/g,'&quot;').replace(/'/g,'&#39;');
}
document.addEventListener('click', e=>{
    if (!e.target.closest('.search-wrap') && !e.target.closest('.results-list'))
        document.getElementById('search-results').style.display='none';
    if (!e.target.closest('.debtor-wrap'))
        document.getElementById('debtor-suggestions').style.display='none';
});
</script>
@endpush