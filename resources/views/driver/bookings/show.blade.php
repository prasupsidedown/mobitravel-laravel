@extends('driver.layouts.app')

@section('title', 'Detail Pemesanan')
@section('menu-bookings', 'active')

@section('content')

<div style="margin-bottom:1rem">
    <a href="{{ route('driver.bookings.index') }}" class="btn" style="background:var(--cream)">← Kembali</a>
</div>

<div class="card">
    <div class="card-header">
        <div class="card-title">Pemesanan #{{ $booking->id }}</div>
        <span class="badge badge-{{ $booking->status }}">{{ ucfirst($booking->status) }}</span>
    </div>

    <div class="row" style="margin-bottom:1.5rem">
        <div>
            <div style="font-family:var(--font-mono); font-size:.7rem; letter-spacing:.08em; text-transform:uppercase; color:var(--muted); margin-bottom:.75rem">Info Pelanggan</div>
            <table style="width:100%">
                <tr><td style="color:var(--muted); padding:.4rem 0; border:none; font-size:.875rem; width:40%">Nama</td><td style="font-weight:500; border:none; font-size:.875rem">{{ $booking->user->name ?? '-' }}</td></tr>
                <tr><td style="color:var(--muted); padding:.4rem 0; border:none; font-size:.875rem">Telepon</td><td style="border:none; font-size:.875rem">{{ $booking->user->phone ?? '-' }}</td></tr>
                <tr><td style="color:var(--muted); padding:.4rem 0; border:none; font-size:.875rem">Email</td><td style="border:none; font-size:.875rem">{{ $booking->user->email ?? '-' }}</td></tr>
            </table>
        </div>
        <div>
            <div style="font-family:var(--font-mono); font-size:.7rem; letter-spacing:.08em; text-transform:uppercase; color:var(--muted); margin-bottom:.75rem">Info Pemesanan</div>
            <table style="width:100%">
                <tr><td style="color:var(--muted); padding:.4rem 0; border:none; font-size:.875rem; width:40%">Tanggal</td><td style="font-weight:500; border:none; font-size:.875rem">{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}</td></tr>
                <tr><td style="color:var(--muted); padding:.4rem 0; border:none; font-size:.875rem">Rute</td><td style="border:none; font-size:.875rem">{{ $booking->route ?? '-' }}</td></tr>
                <tr><td style="color:var(--muted); padding:.4rem 0; border:none; font-size:.875rem">Total</td><td style="font-weight:700; color:var(--forest); border:none; font-size:.875rem">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td></tr>
            </table>
        </div>
    </div>

    @if($booking->notes)
        <div style="background:var(--ivory); border:1px solid var(--sand); border-radius:.65rem; padding:1rem; margin-bottom:1.5rem">
            <div style="font-size:.8rem; color:var(--muted); margin-bottom:.4rem">Catatan</div>
            <p style="font-size:.9rem">{{ $booking->notes }}</p>
        </div>
    @endif

    {{-- Aksi --}}
    <div style="display:flex; gap:.75rem; flex-wrap:wrap">
        @if($booking->status === 'pending')
            <form method="POST" action="{{ route('driver.bookings.confirm', $booking->id) }}">
                @csrf @method('PUT')
                <button type="submit" class="btn btn-success">✓ Konfirmasi Pesanan</button>
            </form>
            <form method="POST" action="{{ route('driver.bookings.cancel', $booking->id) }}">
                @csrf @method('PUT')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Batalkan pesanan ini?')">✗ Batalkan</button>
            </form>
        @elseif(in_array($booking->status, ['confirmed', 'ongoing']))
            <form method="POST" action="{{ route('driver.bookings.complete', $booking->id) }}">
                @csrf @method('PUT')
                <button type="submit" class="btn btn-primary">✓ Tandai Selesai</button>
            </form>
            <form method="POST" action="{{ route('driver.bookings.cancel', $booking->id) }}">
                @csrf @method('PUT')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Batalkan pesanan ini?')">✗ Batalkan</button>
            </form>
        @endif
    </div>
</div>

@endsection