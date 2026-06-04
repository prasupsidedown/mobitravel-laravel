@extends('driver.layouts.app')

@section('title', 'Dashboard')
@section('menu-dashboard', 'active')

@section('content')

<style>
    .welcome-card {
        background: linear-gradient(135deg, var(--forest) 0%, var(--moss) 100%);
        color: white;
        border-radius: 1rem;
        padding: 1.75rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .welcome-card h2 {
        font-family: var(--font-display);
        font-size: 1.5rem;
        font-weight: 900;
        margin-bottom: .25rem;
    }
    .welcome-card p { color: var(--mist); font-size: .9rem; }
    .welcome-badge {
        background: rgba(232,168,62,.15);
        border: 1px solid rgba(232,168,62,.3);
        color: var(--gold);
        padding: .4rem .9rem;
        border-radius: 99px;
        font-size: .8rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: .4rem;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    .stat-card {
        background: white;
        border-radius: 1rem;
        padding: 1.25rem;
        border: 1px solid var(--sand);
        box-shadow: 0 2px 8px rgba(26,51,40,.06);
    }
    .stat-value {
        font-family: var(--font-display);
        font-size: 1.875rem;
        font-weight: 900;
        color: var(--forest);
        line-height: 1;
        margin-bottom: .25rem;
    }
    .stat-label {
        font-size: .8rem;
        color: var(--muted);
        font-family: var(--font-mono);
        text-transform: uppercase;
        letter-spacing: .06em;
    }
    .stat-icon { font-size: 1.5rem; margin-bottom: .5rem; }

    .availability-toggle {
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    .toggle-switch {
        position: relative;
        width: 52px;
        height: 28px;
    }
    .toggle-switch input { opacity: 0; width: 0; height: 0; }
    .toggle-slider {
        position: absolute;
        cursor: pointer;
        inset: 0;
        background: #e5e7eb;
        border-radius: 999px;
        transition: .3s;
    }
    .toggle-slider:before {
        content: '';
        position: absolute;
        height: 20px; width: 20px;
        left: 4px; bottom: 4px;
        background: white;
        border-radius: 50%;
        transition: .3s;
        box-shadow: 0 1px 4px rgba(0,0,0,.2);
    }
    input:checked + .toggle-slider { background: #4ade80; }
    input:checked + .toggle-slider:before { transform: translateX(24px); }

    .empty-state {
        text-align: center;
        padding: 2rem;
        color: var(--muted);
    }
    .empty-state p { font-size: .9rem; }
</style>

{{-- Welcome --}}
<div class="welcome-card">
    <div>
        <h2>Halo, {{ $driver->agency_name }}!</h2>
        <p>{{ $driver->city }}, {{ $driver->province }} · {{ $driver->phone }}</p>
    </div>
    <div class="welcome-badge">
        🚗 Driver Travel
    </div>
</div>

{{-- Availability Toggle --}}
<div class="card" style="margin-bottom:1.5rem">
    <div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:1rem">
        <div>
            <div style="font-weight:600; color:var(--forest); margin-bottom:.25rem">Status Ketersediaan</div>
            <div style="font-size:.875rem; color:var(--muted)">Aktifkan agar pelanggan bisa memesan layanan kamu</div>
        </div>
        <form method="POST" action="{{ route('driver.availability.update') }}">
            @csrf @method('PUT')
            <div class="availability-toggle">
                <span style="font-size:.875rem; color:var(--muted)">
                    {{ $driver->is_available ? 'Tersedia' : 'Tidak Tersedia' }}
                </span>
                <label class="toggle-switch">
                    <input type="checkbox" name="is_available" value="1"
                        {{ $driver->is_available ? 'checked' : '' }}
                        onchange="this.form.submit()">
                    <span class="toggle-slider"></span>
                </label>
            </div>
        </form>
    </div>
</div>

{{-- Stats --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon">📋</div>
        <div class="stat-value">{{ $stats['total_bookings'] }}</div>
        <div class="stat-label">Total Pemesanan</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">⏳</div>
        <div class="stat-value">{{ $stats['pending_bookings'] }}</div>
        <div class="stat-label">Menunggu Konfirmasi</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">✅</div>
        <div class="stat-value">{{ $stats['done_bookings'] }}</div>
        <div class="stat-label">Selesai</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">💰</div>
        <div class="stat-value" style="font-size:1.4rem">Rp {{ number_format($stats['total_income'], 0, ',', '.') }}</div>
        <div class="stat-label">Total Pendapatan</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">⭐</div>
        <div class="stat-value">{{ number_format($stats['rating'], 1) }}</div>
        <div class="stat-label">Rating</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">🚗</div>
        <div class="stat-value" style="font-size:1.1rem; text-transform:capitalize">{{ $driver->vehicle_type ?? '-' }}</div>
        <div class="stat-label">Jenis Kendaraan</div>
    </div>
</div>

{{-- Rute --}}
<div class="card" style="margin-bottom:1.5rem">
    <div class="card-header">
        <div class="card-title">Rute yang Dilayani</div>
        <a href="{{ route('driver.routes.index') }}" class="btn btn-primary btn-sm">Edit Rute</a>
    </div>
    @if($driver->routes && count($driver->routes) > 0)
        <div style="display:flex; flex-wrap:wrap; gap:.5rem">
            @foreach($driver->routes as $route)
                <span style="background:var(--cream); border:1px solid var(--sand); padding:.3rem .8rem; border-radius:99px; font-size:.85rem; color:var(--forest); font-weight:500">
                    🗺️ {{ $route }}
                </span>
            @endforeach
        </div>
    @else
        <div class="empty-state"><p>Belum ada rute. <a href="{{ route('driver.routes.index') }}" style="color:var(--terra)">Tambah rute sekarang</a></p></div>
    @endif
</div>

{{-- Recent Bookings --}}
<div class="card">
    <div class="card-header">
        <div class="card-title">Pemesanan Terbaru</div>
        <a href="{{ route('driver.bookings.index') }}" class="btn btn-primary btn-sm">Lihat Semua</a>
    </div>
    @if($recentBookings->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Pelanggan</th>
                    <th>Tanggal</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentBookings as $booking)
                <tr>
                    <td style="font-family:var(--font-mono); font-size:.75rem; color:var(--muted)">#{{ $booking->id }}</td>
                    <td style="font-weight:500">{{ $booking->user->name ?? '-' }}</td>
                    <td style="color:var(--muted)">{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}</td>
                    <td style="font-weight:600">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                    <td><span class="badge badge-{{ $booking->status }}">{{ ucfirst($booking->status) }}</span></td>
                    <td><a href="{{ route('driver.bookings.show', $booking->id) }}" class="btn btn-sm" style="background:var(--cream)">Detail</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="empty-state"><p>Belum ada pemesanan masuk.</p></div>
    @endif
</div>

@endsection