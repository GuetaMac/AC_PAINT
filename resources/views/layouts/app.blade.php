<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>AC Paint Center</title>
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Barlow:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
  :root {
    --red: #D01212; --red-dark: #A50F0F; --red-light: #FDEAEA;
    --black: #111111; --gray-dark: #333333; --gray-mid: #666666;
    --gray-light: #F4F4F4; --gray-lighter: #FAFAFA;
    --white: #FFFFFF; --border: #E2E2E2; --sidebar-w: 250px;
  }
  body { font-family: 'Barlow', sans-serif; background: var(--gray-lighter); color: var(--black); min-height: 100vh; display: flex; }

  /* SIDEBAR */
  .sidebar { width: var(--sidebar-w); background: var(--black); min-height: 100vh; display: flex; flex-direction: column; flex-shrink: 0; position: sticky; top: 0; height: 100vh; overflow-y: auto; }
  .sidebar-logo { padding: 1.6rem 1.4rem 1.1rem; border-bottom: 1px solid rgba(255,255,255,0.07); }
  .sidebar-logo .brand { font-family: 'Bebas Neue', sans-serif; font-size: 1.7rem; letter-spacing: 0.08em; color: var(--white); line-height: 1; }
  .sidebar-logo .brand span { color: var(--red); }
  .sidebar-logo .sub { font-size: 0.82rem; color: rgba(255,255,255,0.35); letter-spacing: 0.18em; text-transform: uppercase; margin-top: 3px; }
  .nav-section { padding: 1rem 0 0.5rem; }
  .nav-label { font-size: 0.78rem; letter-spacing: 0.18em; text-transform: uppercase; color: rgba(255,255,255,0.25); padding: 0 1.4rem; margin-bottom: 0.3rem; }
  .nav-item { display: flex; align-items: center; gap: 12px; padding: 0.78rem 1.4rem; font-size: 1rem; font-weight: 500; color: rgba(255,255,255,0.55); cursor: pointer; border-left: 3px solid transparent; transition: all 0.15s; text-decoration: none; user-select: none; }
  .nav-item:hover { color: var(--white); background: rgba(255,255,255,0.05); }
  .nav-item.active { color: var(--white); border-left-color: var(--red); background: rgba(208,18,18,0.1); }
  .nav-item svg { width: 19px; height: 19px; flex-shrink: 0; opacity: 0.7; }
  .nav-item.active svg { opacity: 1; }
  .nav-badge { margin-left: auto; background: var(--red); color: #fff; font-size: 0.78rem; font-weight: 700; padding: 2px 8px; border-radius: 10px; }
  .sidebar-footer { margin-top: auto; padding: 1.1rem 1.4rem; border-top: 1px solid rgba(255,255,255,0.07); }
  .user-row { display: flex; align-items: center; gap: 10px; }
  .avatar { width: 36px; height: 36px; border-radius: 50%; background: var(--red); display: flex; align-items: center; justify-content: center; font-size: 0.88rem; font-weight: 700; color: #fff; flex-shrink: 0; }
  .user-info .name { font-size: 0.95rem; font-weight: 600; color: var(--white); }
  .user-info .role { font-size: 0.82rem; color: rgba(255,255,255,0.35); }
  .logout-btn { margin-left: auto; background: none; border: none; cursor: pointer; opacity: 0.4; transition: opacity 0.2s; padding: 0; }
  .logout-btn:hover { opacity: 0.8; }
  .logout-btn svg { width: 18px; height: 18px; stroke: #fff; }

  /* MAIN */
  .main { flex: 1; display: flex; flex-direction: column; min-width: 0; }
  .topbar { background: var(--white); border-bottom: 1px solid var(--border); padding: 0 1.8rem; height: 60px; display: flex; align-items: center; gap: 1rem; position: sticky; top: 0; z-index: 10; }
  .topbar-title { font-family: 'Bebas Neue', sans-serif; font-size: 1.4rem; letter-spacing: 0.06em; color: var(--black); }
  .topbar-right { margin-left: auto; display: flex; align-items: center; gap: 12px; }
  .topbar-date { font-size: 0.92rem; color: var(--gray-mid); }
  .search-box { display: flex; align-items: center; background: var(--gray-light); border: 1px solid var(--border); border-radius: 6px; padding: 0 12px; gap: 7px; height: 38px; }
  .search-box svg { width: 16px; height: 16px; stroke: #999; flex-shrink: 0; }
  .search-box input { border: none; background: none; outline: none; font-family: 'Barlow', sans-serif; font-size: 0.95rem; width: 170px; color: var(--black); }
  .content { padding: 1.8rem; flex: 1; }

  /* CARDS & TABLES */
  .card { background: var(--white); border: 1px solid var(--border); border-radius: 10px; overflow: hidden; margin-bottom: 1.5rem; }

  table { width: 100%; border-collapse: collapse; font-size: 1rem; }
  thead th { background: var(--gray-light); padding: 0.78rem 1rem; text-align: left; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.08em; color: var(--gray-mid); font-weight: 600; border-bottom: 1px solid var(--border); }
  tbody tr { border-bottom: 1px solid var(--border); transition: background 0.1s; }
  tbody tr:last-child { border-bottom: none; }
  tbody tr:hover { background: var(--gray-lighter); }
  tbody td { padding: 0.85rem 1rem; color: var(--gray-dark); vertical-align: middle; }

  /* BADGES */
  .badge { display: inline-block; font-size: 0.82rem; font-weight: 600; padding: 3px 11px; border-radius: 20px; }
  .badge.green { background: #dcfce7; color: #15803d; }
  .badge.amber { background: #fef9c3; color: #a16207; }
  .badge.red { background: var(--red-light); color: var(--red-dark); }
  .badge.blue { background: #dbeafe; color: #1d4ed8; }

  /* BUTTONS */
  .btn-sm { font-family: 'Barlow', sans-serif; font-size: 0.92rem; font-weight: 600; padding: 8px 18px; border-radius: 6px; border: 1.5px solid var(--red); background: var(--white); color: var(--red); cursor: pointer; transition: all 0.15s; }
  .btn-sm:hover { background: var(--red); color: #fff; }
  .btn-sm.solid { background: var(--red); color: #fff; }
  .btn-sm.solid:hover { background: var(--red-dark); }

  /* FORMS */
  .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; padding: 1.3rem; }
  .form-group { display: flex; flex-direction: column; gap: 5px; }
  .form-group.full { grid-column: 1 / -1; }
  .form-group label { font-size: 0.85rem; font-weight: 600; letter-spacing: 0.06em; text-transform: uppercase; color: var(--gray-dark); }
  .form-group input,
  .form-group select,
  .form-group textarea { font-family: 'Barlow', sans-serif; font-size: 1rem; padding: 0.7rem 0.9rem; border: 1.5px solid var(--border); border-radius: 7px; background: var(--gray-light); color: var(--black); outline: none; transition: border-color 0.2s, background 0.2s; }
  .form-group input:focus,
  .form-group select:focus,
  .form-group textarea:focus { border-color: var(--red); background: var(--white); box-shadow: 0 0 0 3px rgba(208,18,18,0.09); }

  /* STAT CARDS */
  .stats-grid { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 14px; margin-bottom: 1.8rem; }
  .stat-card { background: var(--white); border: 1px solid var(--border); border-radius: 10px; padding: 1.2rem 1.3rem; border-top: 3px solid var(--border); }
  .stat-card.red { border-top-color: var(--red); }
  .stat-card.green { border-top-color: #22c55e; }
  .stat-card.amber { border-top-color: #f59e0b; }
  .stat-card.blue { border-top-color: #3b82f6; }
  .stat-label { font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.1em; color: var(--gray-mid); font-weight: 600; margin-bottom: 6px; }
  .stat-value { font-family: 'Bebas Neue', sans-serif; font-size: 2.3rem; letter-spacing: 0.03em; color: var(--black); line-height: 1; }
  .stat-sub { font-size: 0.88rem; color: var(--gray-mid); margin-top: 4px; }
  .stat-sub.up { color: #16a34a; }
  .stat-sub.down { color: var(--red); }

  /* SECTION HEADERS */
  .section-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.9rem; }
  .section-title { font-family: 'Bebas Neue', sans-serif; font-size: 1.3rem; letter-spacing: 0.05em; color: var(--black); }

  /* TWO COL */
  .two-col { display: grid; grid-template-columns: 1fr 1fr; gap: 1.4rem; }

  /* ALERT */
  .alert-bar { background: #fff7ed; border: 1px solid #fed7aa; border-radius: 8px; padding: 0.9rem 1.1rem; display: flex; align-items: center; gap: 10px; margin-bottom: 1.4rem; font-size: 1rem; color: #92400e; }
  .alert-bar svg { width: 20px; height: 20px; stroke: #f59e0b; flex-shrink: 0; }

  @media (max-width: 900px) {
    .stats-grid { grid-template-columns: 1fr 1fr; }
    .two-col { grid-template-columns: 1fr; }
  }
  @media (max-width: 640px) {
    .stats-grid { grid-template-columns: 1fr; }
  }
</style>

@stack('styles')
</head>
<body>

<!-- SIDEBAR -->
<aside class="sidebar">
  <div class="sidebar-logo">
    <div class="brand"><span>AC</span> Paint Center</div>
    <div class="sub">Inventory System</div>
  </div>

  <nav class="nav-section">
    <div class="nav-label">Main</div>

    <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
      Dashboard
    </a>

    <a href="{{ route('purchasing.index') }}" class="nav-item {{ request()->routeIs('purchasing.*') ? 'active' : '' }}">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="9" cy="21" r="1"/>
        <circle cx="20" cy="21" r="1"/>
        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
      </svg>
      Purchasing
    </a>

    <a href="{{ route('products.index') }}" class="nav-item {{ request()->routeIs('products.*') ? 'active' : '' }}">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
      Products
      @php $lowStock = \App\Models\Product::where('stock', '<=', 5)->count(); @endphp
      @if($lowStock > 0)
        <span class="nav-badge">{{ $lowStock }}</span>
      @endif
    </a>

    <a href="{{ route('sales.index') }}" class="nav-item {{ request()->routeIs('sales.*') ? 'active' : '' }}">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
      Sales
    </a>

    <a href="{{ route('debts.index') }}" class="nav-item {{ request()->routeIs('debts.*') ? 'active' : '' }}">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
      Debts
    </a>
  </nav>

  <nav class="nav-section">
    <div class="nav-label">Reports</div>

    <a href="{{ route('reports.index') }}" class="nav-item {{ request()->routeIs('reports.*') ? 'active' : '' }}">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
      Reports
    </a>

    <a href="{{ route('settings.index') }}" class="nav-item {{ request()->routeIs('settings.*') ? 'active' : '' }}">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
      Settings
    </a>
  </nav>

  <div class="sidebar-footer">
    <div class="user-row">
      <div class="avatar">AC</div>
      <div class="user-info">
        <div class="name">acpaint</div>
        <div class="role">Administrator</div>
      </div>

      <form method="POST" action="{{ route('logout') }}" style="margin:0">
        @csrf
        <button type="submit" class="logout-btn" title="Logout">
          <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
        </button>
      </form>

    </div>
  </div>
</aside>

<!-- MAIN -->
<div class="main">
  <div class="topbar">
    <span class="topbar-title">@yield('title', 'Dashboard')</span>
    <div class="topbar-right">
      <div class="search-box">
        <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        <input type="text" placeholder="Search...">
      </div>
      <span class="topbar-date" id="topbar-date"></span>
    </div>
  </div>

  <div class="content">
    @yield('content')
  </div>
</div>

<script>
  const d = new Date();
  document.getElementById('topbar-date').textContent = d.toLocaleDateString('en-PH', { weekday: 'short', year: 'numeric', month: 'short', day: 'numeric' });
</script>
@stack('scripts')
</body>
</html>