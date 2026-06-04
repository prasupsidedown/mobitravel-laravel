@extends('driver.layouts.app')

@section('title', 'Rute & Ketersediaan')
@section('menu-routes', 'active')

@section('content')

<div class="card">
    <div class="card-header">
        <div class="card-title">Info Kendaraan & Rute</div>
    </div>

    <form method="POST" action="{{ route('driver.routes.update') }}">
        @csrf @method('PUT')

        <div class="row">
            <div class="form-group">
                <label>Jenis Kendaraan *</label>
                <select name="vehicle_type" required>
                    <option value="">Pilih jenis...</option>
                    @foreach(['minibus'=>'Minibus','bus'=>'Bus','sedan'=>'Sedan','suv'=>'SUV','van'=>'Van'] as $val => $label)
                        <option value="{{ $val }}" {{ $driver->vehicle_type == $val ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @error('vehicle_type') <small style="color:#c0392b">{{ $message }}</small> @enderror
            </div>
            <div class="form-group">
                <label>Kapasitas Penumpang *</label>
                <input type="number" name="vehicle_capacity" value="{{ old('vehicle_capacity', $driver->vehicle_capacity) }}" min="1" max="60" required>
                @error('vehicle_capacity') <small style="color:#c0392b">{{ $message }}</small> @enderror
            </div>
        </div>

        <div class="form-group">
            <label>Harga per Hari (Rp) *</label>
            <input type="number" name="price_per_day" value="{{ old('price_per_day', $driver->price_per_day) }}" min="0" required>
            @error('price_per_day') <small style="color:#c0392b">{{ $message }}</small> @enderror
        </div>

        <div class="form-group">
            <label>Rute yang Dilayani *</label>
            <textarea name="routes_text" rows="3" required placeholder="Contoh: Surabaya-Malang, Surabaya-Banyuwangi">{{ old('routes_text', $driver->routes ? implode(', ', $driver->routes) : '') }}</textarea>
            <small style="color:var(--muted)">Pisahkan dengan koma</small>
            @error('routes_text') <small style="color:#c0392b">{{ $message }}</small> @enderror
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </form>
</div>

{{-- Availability --}}
<div class="card">
    <div class="card-header">
        <div class="card-title">Status Ketersediaan</div>
    </div>
    <p style="font-size:.9rem; color:var(--muted); margin-bottom:1rem">
        Aktifkan status ketersediaan agar pelanggan dapat memesan layanan kamu.
        Nonaktifkan jika sedang tidak bisa menerima pesanan.
    </p>
    <form method="POST" action="{{ route('driver.availability.update') }}">
        @csrf @method('PUT')
        <div style="display:flex; align-items:center; gap:1rem; flex-wrap:wrap">
            <div style="display:flex; align-items:center; gap:.75rem">
                <span style="font-weight:500; color:var(--forest)">
                    Status saat ini:
                    <strong style="color: {{ $driver->is_available ? '#16a34a' : '#dc2626' }}">
                        {{ $driver->is_available ? 'Tersedia ✓' : 'Tidak Tersedia ✗' }}
                    </strong>
                </span>
            </div>
            @if($driver->is_available)
                <input type="hidden" name="is_available" value="0">
                <button type="submit" class="btn btn-danger">Nonaktifkan Ketersediaan</button>
            @else
                <input type="hidden" name="is_available" value="1">
                <button type="submit" class="btn btn-success">Aktifkan Ketersediaan</button>
            @endif
        </div>
    </form>
</div>

@endsection