@extends('layouts.app')

@section('title', 'Settings')

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
.welcome-title {
    font-size: 30px;
    font-weight: 700;
    color: var(--text);
    letter-spacing: -0.3px;
}
.welcome-sub {
    font-size: 17px;
    color: var(--text-muted);
    margin-top: 3px;
}

/* ── SETTINGS LAYOUT ── */
.settings-layout {
    display: grid;
    grid-template-columns: 220px 1fr;
    gap: 20px;
    align-items: start;
}
@media (max-width: 720px) {
    .settings-layout { grid-template-columns: 1fr; }
}

/* ── SIDEBAR NAV ── */
.settings-nav {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    box-shadow: var(--shadow-sm);
    overflow: hidden;
}
.settings-nav-title {
    padding: 14px 18px 10px;
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .1em;
    color: var(--text-muted);
    border-bottom: 1px solid var(--border);
}
.settings-nav a {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 13px 18px;
    font-size: 15px;
    font-weight: 500;
    color: var(--text-mid);
    text-decoration: none;
    border-left: 3px solid transparent;
    transition: background .15s, color .15s, border-color .15s;
}
.settings-nav a:hover {
    background: var(--surface);
    color: var(--text);
}
.settings-nav a.active {
    background: var(--red-light);
    color: var(--red);
    border-left-color: var(--red);
    font-weight: 600;
}
.settings-nav a svg {
    width: 17px;
    height: 17px;
    flex-shrink: 0;
    opacity: .7;
}
.settings-nav a.active svg { opacity: 1; }

/* ── SETTINGS CARD ── */
.settings-card {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    box-shadow: var(--shadow-sm);
    overflow: hidden;
}
.settings-card-header {
    padding: 22px 28px 18px;
    border-bottom: 1px solid var(--border);
    display: flex;
    align-items: center;
    gap: 14px;
}
.settings-card-icon {
    width: 44px;
    height: 44px;
    border-radius: 10px;
    background: var(--red-light);
    color: var(--red);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.settings-card-icon svg { width: 20px; height: 20px; }
.settings-card-title {
    font-size: 19px;
    font-weight: 700;
    color: var(--text);
}
.settings-card-desc {
    font-size: 14px;
    color: var(--text-muted);
    margin-top: 2px;
}
.settings-card-body {
    padding: 28px;
}

/* ── FORM ELEMENTS ── */
.form-group {
    margin-bottom: 22px;
}
.form-group:last-of-type {
    margin-bottom: 0;
}
.form-label {
    display: block;
    font-size: 14px;
    font-weight: 600;
    color: var(--text-mid);
    margin-bottom: 7px;
    letter-spacing: .01em;
}
.form-label span.req {
    color: var(--red);
    margin-left: 3px;
}
.input-wrap {
    position: relative;
}
.form-input {
    width: 100%;
    padding: 11px 44px 11px 14px;
    font-size: 15px;
    font-family: var(--font);
    color: var(--text);
    background: var(--surface);
    border: 1.5px solid var(--border);
    border-radius: var(--radius-sm);
    outline: none;
    transition: border-color .15s, box-shadow .15s, background .15s;
    -webkit-appearance: none;
}
.form-input:focus {
    border-color: var(--red);
    background: #fff;
    box-shadow: 0 0 0 3px rgba(220,38,38,.08);
}
.form-input.is-invalid {
    border-color: var(--red);
    background: #fff9f9;
}
.toggle-pw {
    position: absolute;
    right: 13px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    cursor: pointer;
    color: var(--text-muted);
    padding: 2px;
    display: flex;
    align-items: center;
    transition: color .15s;
}
.toggle-pw:hover { color: var(--text-mid); }
.toggle-pw svg { width: 18px; height: 18px; }
.field-error {
    font-size: 13px;
    color: var(--red);
    margin-top: 5px;
    display: flex;
    align-items: center;
    gap: 4px;
}
.field-error svg { width: 13px; height: 13px; flex-shrink: 0; }

/* ── PASSWORD STRENGTH ── */
.pw-strength {
    margin-top: 8px;
}
.pw-strength-bars {
    display: flex;
    gap: 4px;
    margin-bottom: 5px;
}
.pw-bar {
    height: 4px;
    flex: 1;
    border-radius: 10px;
    background: var(--border);
    transition: background .3s;
}
.pw-bar.active-weak   { background: var(--red); }
.pw-bar.active-fair   { background: var(--amber); }
.pw-bar.active-good   { background: #84cc16; }
.pw-bar.active-strong { background: var(--green); }
.pw-strength-label {
    font-size: 12px;
    font-weight: 600;
    color: var(--text-muted);
    transition: color .3s;
}

/* ── DIVIDER ── */
.form-divider {
    border: none;
    border-top: 1px solid var(--border);
    margin: 26px 0;
}

/* ── SUBMIT ROW ── */
.submit-row {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 10px;
    margin-top: 28px;
    padding-top: 22px;
    border-top: 1px solid var(--border);
}
.btn {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    font-family: var(--font);
    font-size: 15px;
    font-weight: 600;
    padding: 11px 22px;
    border-radius: var(--radius-sm);
    border: none;
    cursor: pointer;
    text-decoration: none;
    transition: background .15s, transform .1s, box-shadow .15s;
}
.btn:active { transform: scale(.98); }
.btn-ghost {
    background: transparent;
    color: var(--text-mid);
    border: 1.5px solid var(--border);
}
.btn-ghost:hover { background: var(--surface); border-color: var(--border-dark); }
.btn-primary {
    background: var(--red);
    color: #fff;
    box-shadow: 0 2px 8px rgba(220,38,38,.25);
}
.btn-primary:hover { background: #b91c1c; box-shadow: 0 4px 14px rgba(220,38,38,.35); }
.btn svg { width: 16px; height: 16px; }

/* ── ALERT ── */
.alert {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    border-radius: var(--radius-sm);
    padding: 14px 18px;
    font-size: 15px;
    margin-bottom: 24px;
    animation: slideIn .3s ease;
}
.alert svg { width: 20px; height: 20px; flex-shrink: 0; margin-top: 1px; }
.alert-success {
    background: var(--green-light);
    border: 1px solid var(--green-mid);
    color: var(--green-dark);
}
.alert-error {
    background: var(--red-light);
    border: 1px solid #fca5a5;
    color: #7f1d1d;
}
@keyframes slideIn { from { opacity:0; transform:translateY(-6px); } to { opacity:1; transform:translateY(0); } }

/* ── ACCOUNT INFO STRIP ── */
.account-info {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 18px 28px;
    background: var(--surface);
    border-bottom: 1px solid var(--border);
}
.account-avatar {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: var(--red-light);
    color: var(--red);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    font-weight: 700;
    flex-shrink: 0;
    border: 2px solid #fca5a5;
}
.account-name {
    font-size: 16px;
    font-weight: 700;
    color: var(--text);
}
.account-username {
    font-size: 13px;
    color: var(--text-muted);
    font-family: var(--font-mono);
    margin-top: 1px;
}
</style>
@endpush

@section('content')

{{-- WELCOME BAR --}}
<div class="welcome-bar">
    <div>
        <div class="welcome-title">Settings</div>
        <div class="welcome-sub">Manage your account and preferences.</div>
    </div>
</div>

<div class="settings-layout">

    {{-- SIDEBAR --}}
    <nav class="settings-nav">
        <div class="settings-nav-title">Account</div>
        <a href="#" class="active">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>
            </svg>
            Change Password
        </a>
    </nav>

    {{-- MAIN PANEL --}}
    <div>

        {{-- SUCCESS / ERROR ALERTS --}}
        @if(session('success'))
        <div class="alert alert-success">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-error">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            <span>{{ session('error') }}</span>
        </div>
        @endif

        {{-- CHANGE PASSWORD CARD --}}
        <div class="settings-card">
            <div class="settings-card-header">
                <div class="settings-card-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                    </svg>
                </div>
                <div>
                    <div class="settings-card-title">Change Password</div>
                    <div class="settings-card-desc">Update your login password. You'll stay logged in after saving.</div>
                </div>
            </div>

            {{-- ACCOUNT INFO STRIP --}}
            <div class="account-info">
                <div class="account-avatar">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div>
                    <div class="account-name">{{ Auth::user()->name }}</div>
                    <div class="account-username">@{{ Auth::user()->username }}</div>
                </div>
            </div>

            <div class="settings-card-body">
                <form method="POST" action="{{ route('settings.update') }}" id="pw-form">
                    @csrf

                    {{-- CURRENT PASSWORD --}}
                    <div class="form-group">
                        <label class="form-label" for="current_password">
                            Current Password <span class="req">*</span>
                        </label>
                        <div class="input-wrap">
                            <input
                                type="password"
                                id="current_password"
                                name="current_password"
                                class="form-input {{ $errors->has('current_password') ? 'is-invalid' : '' }}"
                                autocomplete="current-password"
                                placeholder="Enter your current password"
                            >
                            <button type="button" class="toggle-pw" data-target="current_password" tabindex="-1">
                                <svg class="eye-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                                </svg>
                            </button>
                        </div>
                        @error('current_password')
                            <div class="field-error">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <hr class="form-divider">

                    {{-- NEW PASSWORD --}}
                    <div class="form-group">
                        <label class="form-label" for="new_password">
                            New Password <span class="req">*</span>
                        </label>
                        <div class="input-wrap">
                            <input
                                type="password"
                                id="new_password"
                                name="new_password"
                                class="form-input {{ $errors->has('new_password') ? 'is-invalid' : '' }}"
                                autocomplete="new-password"
                                placeholder="At least 8 characters"
                                oninput="checkStrength(this.value)"
                            >
                            <button type="button" class="toggle-pw" data-target="new_password" tabindex="-1">
                                <svg class="eye-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                                </svg>
                            </button>
                        </div>
                        {{-- STRENGTH METER --}}
                        <div class="pw-strength" id="pw-strength" style="display:none;">
                            <div class="pw-strength-bars">
                                <div class="pw-bar" id="bar1"></div>
                                <div class="pw-bar" id="bar2"></div>
                                <div class="pw-bar" id="bar3"></div>
                                <div class="pw-bar" id="bar4"></div>
                            </div>
                            <div class="pw-strength-label" id="pw-strength-label">Too short</div>
                        </div>
                        @error('new_password')
                            <div class="field-error">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- CONFIRM PASSWORD --}}
                    <div class="form-group">
                        <label class="form-label" for="new_password_confirmation">
                            Confirm New Password <span class="req">*</span>
                        </label>
                        <div class="input-wrap">
                            <input
                                type="password"
                                id="new_password_confirmation"
                                name="new_password_confirmation"
                                class="form-input"
                                autocomplete="new-password"
                                placeholder="Repeat your new password"
                            >
                            <button type="button" class="toggle-pw" data-target="new_password_confirmation" tabindex="-1">
                                <svg class="eye-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                                </svg>
                            </button>
                        </div>
                        @error('new_password_confirmation')
                            <div class="field-error">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="submit-row">
                        <a href="{{ route('dashboard') }}" class="btn btn-ghost">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/>
                            </svg>
                            Save Password
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<script>
// ── TOGGLE PASSWORD VISIBILITY ──
document.querySelectorAll('.toggle-pw').forEach(btn => {
    btn.addEventListener('click', () => {
        const input = document.getElementById(btn.dataset.target);
        const isText = input.type === 'text';
        input.type = isText ? 'password' : 'text';
        btn.querySelector('svg').innerHTML = isText
            ? '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>'
            : '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>';
    });
});

// ── PASSWORD STRENGTH METER ──
function checkStrength(value) {
    const meter = document.getElementById('pw-strength');
    const label = document.getElementById('pw-strength-label');
    const bars  = [document.getElementById('bar1'), document.getElementById('bar2'),
                   document.getElementById('bar3'), document.getElementById('bar4')];

    if (!value) { meter.style.display = 'none'; return; }
    meter.style.display = 'block';

    let score = 0;
    if (value.length >= 8)  score++;
    if (value.length >= 12) score++;
    if (/[A-Z]/.test(value) && /[a-z]/.test(value)) score++;
    if (/\d/.test(value) && /[^A-Za-z0-9]/.test(value)) score++;

    const levels = [
        { cls: 'active-weak',   text: 'Weak',   color: '#dc2626' },
        { cls: 'active-fair',   text: 'Fair',   color: '#d97706' },
        { cls: 'active-good',   text: 'Good',   color: '#84cc16' },
        { cls: 'active-strong', text: 'Strong', color: '#16a34a' },
    ];

    bars.forEach((b, i) => {
        b.className = 'pw-bar';
        if (i < score) b.classList.add(levels[score - 1].cls);
    });

    const lvl = levels[score - 1] || levels[0];
    label.textContent = lvl.text;
    label.style.color = lvl.color;
}
</script>

@endsection