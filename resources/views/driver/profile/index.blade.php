@extends('driver.layouts.app')

@section('title', 'Profil')
@section('menu-profile', 'active')

@section('content')

<div class="card">
    <div class="card-header">
        <div class="card-title">Informasi Profil</div>
    </div>

    <form method="POST" action="{{ route('driver.profile.update') }}">
        @csrf @method('PUT')

        <div class="row">
            <div class="form-group">
                <label>Nama Lengkap *</label>
                <input type="text" name="agency_name" value="{{ old('agency_name', $driver->agency_name) }}" required>
                @error('agency_name') <small style="color:#c0392b">{{ $message }}</small> @enderror
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" value="{{ $driver->email }}" disabled style="opacity:.6; cursor:not-allowed">
            </div>
        </div>

        <div class="row">
            <div class="form-group">
                <label>Telepon *</label>
                <input type="text" name="phone" value="{{ old('phone', $driver->phone) }}" required>
                @error('phone') <small style="color:#c0392b">{{ $message }}</small> @enderror
            </div>
            <div class="form-group">
                <label>WhatsApp *</label>
                <input type="text" name="whatsapp" value="{{ old('whatsapp', $driver->whatsapp) }}" required>
                @error('whatsapp') <small style="color:#c0392b">{{ $message }}</small> @enderror
            </div>
        </div>

        <div class="row">
            <div class="form-group">
                <label>Kota *</label>
                <input type="text" name="city" value="{{ old('city', $driver->city) }}" required>
                @error('city') <small style="color:#c0392b">{{ $message }}</small> @enderror
            </div>
            <div class="form-group">
                <label>Provinsi *</label>
                <input type="text" name="province" value="{{ old('province', $driver->province) }}" required>
                @error('province') <small style="color:#c0392b">{{ $message }}</small> @enderror
            </div>
        </div>

        <div class="form-group">
            <label>Alamat *</label>
            <textarea name="address" rows="2" required>{{ old('address', $driver->address) }}</textarea>
            @error('address') <small style="color:#c0392b">{{ $message }}</small> @enderror
        </div>

        <div class="form-group">
            <label>Deskripsi Layanan</label>
            <textarea name="description" rows="3" placeholder="Ceritakan tentang layanan kamu...">{{ old('description', $driver->description) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </form>
</div>

{{-- Ganti Password --}}
<div class="card">
    <div class="card-header">
        <div class="card-title">Ganti Password</div>
    </div>

    <form method="POST" action="{{ route('driver.profile.password') }}">
        @csrf @method('PUT')

        <div class="row">
            <div class="form-group">
                <label>Password Lama *</label>
                <input type="password" name="current_password" required>
                @error('current_password') <small style="color:#c0392b">{{ $message }}</small> @enderror
            </div>
        </div>

        <div class="row">
            <div class="form-group">
                <label>Password Baru *</label>
                <input type="password" name="password" required>
                @error('password') <small style="color:#c0392b">{{ $message }}</small> @enderror
            </div>
            <div class="form-group">
                <label>Konfirmasi Password Baru *</label>
                <input type="password" name="password_confirmation" required>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Ganti Password</button>
    </form>
</div>

@endsection