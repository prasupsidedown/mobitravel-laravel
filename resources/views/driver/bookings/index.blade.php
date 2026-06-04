@extends('driver.layouts.app')

@section('title', 'Pemesanan')
@section('menu-bookings', 'active')

@section('content')

<div class="card">
    <div class="card-header">
        <div class="card-title">Daftar Pemesanan</div>
        <span style="font-size:.875rem; color:var(--muted)">{{ $bookings->total() }} total</span>
    </div>

    @if($bookings->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Pelanggan</th>
                    <th>Rute</th>
                    <th>Tanggal</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bookings as $booking)
                <tr>
                    <td style="font-family:var(--font-mono); font-size:.75rem; color:var(--muted)">#{{ $booking->id }}</td>
                    <td>
                        <div style="font-weight:500">{{ $booking->user->name ?? '-' }}</div>
                        <div style="font-size:.8rem; color:var(--muted)">{{ $booking->user->phone ?? '' }}</div>
                    </td>
                    <td style="font-size:.875rem">{{ $booking->route ?? '-' }}</td>
                    <td style="color:var(--muted); font-size:.875rem">{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}</td>
                    <td style="font-weight:600">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                    <td><span class="badge badge-{{ $booking->status }}">{{ ucfirst($booking->status) }}</span></td>
                    <td>
                        <a href="{{ route('driver.bookings.show', $booking->id) }}" class="btn btn-sm" style="background:var(--cream)">Detail</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div style="margin-top:1rem">
            {{ $bookings->links() }}
        </div>
    @else
        <div style="text-align:center; padding:3rem; color:var(--muted)">
            <div style="font-size:2.5rem; margin-bottom:.75rem">📋</div>
            <p>Belum ada pemesanan masuk.</p>
        </div>
    @endif
</div>

@endsection