<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - MobiTravel Driver</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:wght@300;400;500;600&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --forest:   #1a3328;
            --moss:     #2d5a3d;
            --sage:     #4e8060;
            --mist:     #a8c5b0;
            --cream:    #f5f0e8;
            --ivory:    #faf8f3;
            --sand:     #e8dfc8;
            --terra:    #c17f3b;
            --gold:     #e8a83e;
            --ink:      #2e2e2e;
            --muted:    #7a7a6e;

            --font-display: 'Playfair Display', Georgia, serif;
            --font-body:    'DM Sans', sans-serif;
            --font-mono:    'DM Mono', monospace;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: var(--font-body); background: var(--ivory); color: var(--ink); }

        /* SIDEBAR */
        .sidebar {
            width: 260px;
            background: var(--forest);
            color: white;
            position: fixed;
            height: 100%;
            padding: 0;
            display: flex;
            flex-direction: column;
            z-index: 50;
        }
        .sidebar-brand {
            padding: 1.5rem 1.25rem;
            border-bottom: 1px solid rgba(255,255,255,.08);
        }
        .sidebar-brand h2 {
            font-family: var(--font-display);
            font-size: 1.4rem;
            font-weight: 900;
            color: white;
            letter-spacing: -.02em;
        }
        .sidebar-brand h2 span { color: var(--gold); }
        .sidebar-brand p {
            font-size: .7rem;
            font-family: var(--font-mono);
            letter-spacing: .1em;
            text-transform: uppercase;
            color: var(--mist);
            margin-top: .25rem;
        }

        .sidebar-user {
            padding: 1rem 1.25rem;
            border-bottom: 1px solid rgba(255,255,255,.08);
            display: flex;
            align-items: center;
            gap: .75rem;
        }
        .user-avatar {
            width: 38px; height: 38px;
            background: var(--gold);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700;
            color: var(--forest);
            font-size: .9rem;
            flex-shrink: 0;
        }
        .user-info { overflow: hidden; }
        .user-name {
            font-size: .875rem;
            font-weight: 600;
            color: white;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .user-status {
            font-size: .7rem;
            color: var(--mist);
            display: flex;
            align-items: center;
            gap: .3rem;
            margin-top: .1rem;
        }
        .status-dot {
            width: 6px; height: 6px;
            border-radius: 50%;
            background: #4ade80;
        }
        .status-dot.offline { background: #f87171; }

        .sidebar-nav {
            flex: 1;
            padding: 1rem 0;
            overflow-y: auto;
        }
        .nav-label {
            font-family: var(--font-mono);
            font-size: .6rem;
            letter-spacing: .12em;
            text-transform: uppercase;
            color: rgba(168,197,176,.5);
            padding: .75rem 1.25rem .25rem;
        }
        .sidebar-nav a {
            display: flex;
            align-items: center;
            gap: .75rem;
            color: rgba(168,197,176,.8);
            padding: .7rem 1.25rem;
            text-decoration: none;
            font-size: .9rem;
            font-weight: 500;
            transition: all .2s;
            border-left: 3px solid transparent;
        }
        .sidebar-nav a:hover {
            color: white;
            background: rgba(255,255,255,.06);
        }
        .sidebar-nav a.active {
            color: var(--gold);
            background: rgba(232,168,62,.08);
            border-left-color: var(--gold);
        }
        .nav-icon { font-size: 1rem; width: 20px; text-align: center; }

        .sidebar-footer {
            padding: 1rem 1.25rem;
            border-top: 1px solid rgba(255,255,255,.08);
        }
        .sidebar-footer form button {
            display: flex;
            align-items: center;
            gap: .75rem;
            background: none;
            border: none;
            color: rgba(168,197,176,.8);
            cursor: pointer;
            font-size: .9rem;
            font-family: var(--font-body);
            font-weight: 500;
            padding: .5rem 0;
            width: 100%;
            transition: color .2s;
        }
        .sidebar-footer form button:hover { color: #f87171; }

        /* CONTENT */
        .content {
            margin-left: 260px;
            min-height: 100vh;
        }
        .topbar {
            background: white;
            border-bottom: 1px solid var(--sand);
            padding: 1rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 40;
        }
        .topbar-title {
            font-family: var(--font-display);
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--forest);
        }
        .topbar-right {
            display: flex;
            align-items: center;
            gap: 1rem;
            font-size: .875rem;
            color: var(--muted);
        }

        .page-body {
            padding: 2rem;
            max-width: 1200px;
        }

        /* CARDS */
        .card {
            background: white;
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 2px 12px rgba(26,51,40,.07);
            border: 1px solid var(--sand);
            margin-bottom: 1.5rem;
        }
        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.25rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--sand);
        }
        .card-title {
            font-family: var(--font-display);
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--forest);
        }

        /* BUTTONS */
        .btn {
            padding: .5rem 1rem;
            border: none;
            border-radius: .5rem;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            font-size: .875rem;
            font-family: var(--font-body);
            font-weight: 600;
            transition: all .2s;
        }
        .btn-primary { background: var(--forest); color: white; }
        .btn-primary:hover { background: var(--moss); }
        .btn-warning { background: var(--gold); color: var(--forest); }
        .btn-danger { background: #fee2e2; color: #dc2626; }
        .btn-success { background: #dcfce7; color: #16a34a; }
        .btn-sm { padding: .3rem .7rem; font-size: .8rem; }

        /* FORM */
        .form-group { margin-bottom: 1.25rem; }
        label {
            display: block;
            font-family: var(--font-mono);
            font-size: .7rem;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: .4rem;
        }
        input[type="text"], input[type="email"], input[type="password"],
        input[type="number"], textarea, select {
            width: 100%;
            border: 1.5px solid var(--sand);
            border-radius: .65rem;
            padding: .75rem .9rem;
            font-family: var(--font-body);
            font-size: .9375rem;
            color: var(--ink);
            background: var(--ivory);
            outline: none;
            transition: all .2s;
        }
        input:focus, textarea:focus, select:focus {
            border-color: var(--sage);
            box-shadow: 0 0 0 3px rgba(78,128,96,.14);
            background: white;
        }
        .row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }

        /* ALERTS */
        .alert { padding: .875rem 1rem; border-radius: .65rem; margin-bottom: 1.25rem; font-size: .875rem; }
        .alert-success { background: #dcfce7; color: #16a34a; border: 1px solid #bbf7d0; }
        .alert-error   { background: #fee2e2; color: #dc2626; border: 1px solid #fecaca; }

        /* TABLE */
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: .875rem 1rem; text-align: left; border-bottom: 1px solid var(--sand); font-size: .875rem; }
        th { background: var(--ivory); font-family: var(--font-mono); font-size: .7rem; letter-spacing: .08em; text-transform: uppercase; color: var(--muted); }

        /* BADGE */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: .2rem .6rem;
            border-radius: 99px;
            font-size: .75rem;
            font-weight: 600;
        }
        .badge-pending   { background: #fef9c3; color: #854d0e; }
        .badge-confirmed { background: #dbeafe; color: #1e40af; }
        .badge-completed { background: #dcfce7; color: #166534; }
        .badge-cancelled { background: #fee2e2; color: #991b1b; }
        .badge-ongoing   { background: #ede9fe; color: #5b21b6; }

        @media (max-width: 768px) {
            .sidebar { display: none; }
            .content { margin-left: 0; }
            .row { grid-template-columns: 1fr; }
            .page-body { padding: 1rem; }
        }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="sidebar-brand">
        <h2>Mobi<span>Travel</span></h2>
        <p>Driver Panel</p>
    </div>

    <div class="sidebar-user">
        <div class="user-avatar">{{ strtoupper(substr(Auth::guard('agent')->user()->agency_name, 0, 1)) }}</div>
        <div class="user-info">
            <div class="user-name">{{ Auth::guard('agent')->user()->agency_name }}</div>
            <div class="user-status">
                <span class="status-dot {{ Auth::guard('agent')->user()->is_available ? '' : 'offline' }}"></span>
                {{ Auth::guard('agent')->user()->is_available ? 'Tersedia' : 'Tidak Tersedia' }}
            </div>
        </div>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-label">Menu Utama</div>
        <a href="{{ route('driver.dashboard') }}" class="@yield('menu-dashboard')">
            <span class="nav-icon">🏠</span> Dashboard
        </a>
        <a href="{{ route('driver.routes.index') }}" class="@yield('menu-routes')">
            <span class="nav-icon">🗺️</span> Rute & Ketersediaan
        </a>
        <a href="{{ route('driver.bookings.index') }}" class="@yield('menu-bookings')">
            <span class="nav-icon">📋</span> Pemesanan
        </a>

        <div class="nav-label">Akun</div>
        <a href="{{ route('driver.profile.index') }}" class="@yield('menu-profile')">
            <span class="nav-icon">👤</span> Profil
        </a>
    </nav>

    <div class="sidebar-footer">
        <form method="POST" action="{{ route('agen.logout') }}">
            @csrf
            <button type="submit">
                <span class="nav-icon">🚪</span> Logout
            </button>
        </form>
    </div>
</div>

<div class="content">
    <div class="topbar">
        <div class="topbar-title">@yield('title')</div>
        <div class="topbar-right">
            {{ Auth::guard('agent')->user()->city }}, {{ Auth::guard('agent')->user()->province }}
        </div>
    </div>

    <div class="page-body">
        @if(session('success'))
            <div class="alert alert-success">✓ {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">✗ {{ session('error') }}</div>
        @endif

        @yield('content')
    </div>
</div>

</body>
</html>