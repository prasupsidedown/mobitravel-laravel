<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar — MobiTravel</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400;1,700&family=DM+Sans:wght@300;400;500;600&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">

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
            --charcoal: #1c1c1c;
            --ink:      #2e2e2e;
            --muted:    #7a7a6e;
            --error:    #c0392b;

            --font-display: 'Playfair Display', Georgia, serif;
            --font-body:    'DM Sans', sans-serif;
            --font-mono:    'DM Mono', monospace;

            --ease-smooth: cubic-bezier(.25,.46,.45,.94);
            --ease-bounce: cubic-bezier(.34,1.56,.64,1);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: var(--font-body); background: var(--ivory); color: var(--ink); min-height: 100vh; }

        /* NAV */
        .nav {
            position: fixed; top: 0; left: 0; right: 0; z-index: 100;
            display: flex; align-items: center; justify-content: space-between;
            padding: 1.25rem 4rem;
            background: rgba(245,240,232,.92);
            backdrop-filter: blur(12px);
            box-shadow: 0 1px 0 rgba(0,0,0,.08);
        }
        .nav__logo { font-family: var(--font-display); font-size: 1.5rem; font-weight: 900; color: var(--forest); letter-spacing: -.02em; }
        .nav__logo span { color: var(--gold); }
        .nav__links { display: flex; gap: 2.5rem; list-style: none; }
        .nav__links a { font-size: .875rem; font-weight: 500; letter-spacing: .04em; text-transform: uppercase; color: var(--ink); text-decoration: none; transition: color .2s; }
        .nav__links a:hover { color: var(--sage); }

        /* CONTAINER */
        .container { max-width: 820px; margin: 0 auto; padding: 120px 20px 60px; }

        /* ROLE PICKER */
        .role-picker {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-bottom: 2rem;
        }
        .role-option {
            position: relative;
            cursor: pointer;
        }
        .role-option input[type="radio"] {
            position: absolute;
            opacity: 0;
            width: 0; height: 0;
        }
        .role-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: .75rem;
            padding: 1.5rem 1rem;
            border: 2px solid var(--sand);
            border-radius: 1rem;
            background: white;
            transition: all .25s var(--ease-bounce);
            text-align: center;
            user-select: none;
        }
        .role-card:hover {
            border-color: var(--sage);
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(26,51,40,.1);
        }
        .role-option input:checked + .role-card {
            border-color: var(--forest);
            background: var(--forest);
            color: white;
            box-shadow: 0 10px 30px rgba(26,51,40,.25);
        }
        .role-icon {
            font-size: 2.25rem;
            line-height: 1;
        }
        .role-title {
            font-family: var(--font-display);
            font-size: 1.125rem;
            font-weight: 700;
        }
        .role-desc {
            font-size: .8rem;
            color: var(--muted);
            line-height: 1.4;
        }
        .role-option input:checked + .role-card .role-desc {
            color: var(--mist);
        }

        /* CARD */
        .card {
            background: white;
            border-radius: 1.25rem;
            padding: 2.5rem;
            box-shadow: 0 20px 60px rgba(26,51,40,.1);
            border: 1px solid var(--sand);
            transition: all .3s var(--ease-smooth);
        }
        .card-title {
            font-family: var(--font-display);
            font-size: 1.875rem;
            font-weight: 900;
            color: var(--forest);
            margin-bottom: .5rem;
            transition: all .3s;
        }
        .sub { color: var(--muted); margin-bottom: 2rem; }

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
        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="number"],
        textarea, select {
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
            background: #fff;
        }
        input[type="file"] {
            width: 100%;
            border: 1.5px dashed var(--sand);
            border-radius: .65rem;
            padding: .75rem .9rem;
            font-family: var(--font-body);
            font-size: .875rem;
            color: var(--muted);
            background: var(--ivory);
            cursor: pointer;
        }
        .row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
        .row-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem; }

        /* SECTION DIVIDER */
        .section-label {
            font-family: var(--font-mono);
            font-size: .7rem;
            letter-spacing: .12em;
            text-transform: uppercase;
            color: var(--sage);
            padding: .75rem 0 .5rem;
            border-top: 1.5px solid var(--sand);
            margin: 1.5rem 0 1rem;
            display: flex;
            align-items: center;
            gap: .5rem;
        }
        .section-label::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--sand);
        }

        /* DRIVER FIELDS */
        .driver-fields {
            display: none;
            animation: slideDown .3s var(--ease-smooth);
        }
        .driver-fields.visible { display: block; }
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-12px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* AGEN FIELDS */
        .agen-fields {
            display: none;
            animation: slideDown .3s var(--ease-smooth);
        }
        .agen-fields.visible { display: block; }

        /* BUTTON */
        button[type="submit"] {
            background: var(--forest);
            color: var(--cream);
            border: none;
            border-radius: .75rem;
            padding: .9rem;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            width: 100%;
            transition: all .2s var(--ease-bounce);
            margin-top: .5rem;
        }
        button[type="submit"]:hover {
            background: var(--moss);
            transform: translateY(-2px);
            box-shadow: 0 10px 28px rgba(26,51,40,.25);
        }

        /* ALERTS */
        .alert { padding: 12px; border-radius: 10px; margin-bottom: 20px; font-size: 14px; }
        .alert-error { background: #fee2e2; color: #dc2626; border: 1px solid #fecaca; }
        .alert-success { background: #dcfce7; color: #16a34a; border: 1px solid #bbf7d0; }

        /* LINK */
        .link { text-align: center; margin-top: 1.5rem; font-size: .875rem; color: var(--muted); }
        .link a { color: var(--terra); font-weight: 600; text-decoration: none; }

        @media (max-width: 640px) {
            .nav { padding: 1rem; }
            .row, .row-3, .role-picker { grid-template-columns: 1fr; }
            .card { padding: 1.5rem; }
        }
    </style>
</head>
<body>

<nav class="nav">
    <div class="nav__logo">Mobi<span>Travel</span></div>
    <ul class="nav__links">
        <li><a href="/">Beranda</a></li>
        <li><a href="/agen/login">Masuk</a></li>
    </ul>
</nav>

<div class="container">

    {{-- ROLE PICKER --}}
    <div class="role-picker">
        <label class="role-option">
            <input type="radio" name="role_select" value="agen" checked onchange="switchRole('agen')">
            <div class="role-card">
                <div class="role-icon">🏢</div>
                <div class="role-title">Agen Travel</div>
                <div class="role-desc">Kelola destinasi, paket wisata, dan kendaraan untuk pelanggan</div>
            </div>
        </label>
        <label class="role-option">
            <input type="radio" name="role_select" value="driver" onchange="switchRole('driver')">
            <div class="role-card">
                <div class="role-icon">🚗</div>
                <div class="role-title">Driver Travel</div>
                <div class="role-desc">Tawarkan layanan transportasi dan kelola rute perjalanan</div>
            </div>
        </label>
    </div>

    <div class="card">
        <h1 class="card-title" id="formTitle">Daftar Agen Travel</h1>
        <p class="sub" id="formSub">Bergabunglah dan jangkau ribuan pelanggan</p>

        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-error">
                <ul style="margin-left:1rem">
                    @foreach($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('agen.register.post') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="is_driver" id="is_driver_input" value="0">

            {{-- DATA DIRI (sama untuk semua) --}}
            <div class="row">
                <div class="form-group">
                    <label>NIK (16 digit) *</label>
                    <input type="text" name="nik" value="{{ old('nik') }}" maxlength="16" required>
                    @error('nik') <small style="color:var(--error)">{{ $message }}</small> @enderror
                </div>
                <div class="form-group">
                    <label id="nameLabel">Nama Agen *</label>
                    <input type="text" name="agency_name" value="{{ old('agency_name') }}" required>
                    @error('agency_name') <small style="color:var(--error)">{{ $message }}</small> @enderror
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <label>Email *</label>
                    <input type="email" name="email" value="{{ old('email') }}" required>
                    @error('email') <small style="color:var(--error)">{{ $message }}</small> @enderror
                </div>
                <div class="form-group">
                    <label>Password *</label>
                    <input type="password" name="password" required>
                    @error('password') <small style="color:var(--error)">{{ $message }}</small> @enderror
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <label>Konfirmasi Password *</label>
                    <input type="password" name="password_confirmation" required>
                </div>
                <div class="form-group">
                    <label>Telepon *</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" required>
                    @error('phone') <small style="color:var(--error)">{{ $message }}</small> @enderror
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <label>WhatsApp *</label>
                    <input type="text" name="whatsapp" value="{{ old('whatsapp') }}" required>
                    @error('whatsapp') <small style="color:var(--error)">{{ $message }}</small> @enderror
                </div>
                <div class="form-group">
                    <label>Kota *</label>
                    <input type="text" name="city" value="{{ old('city') }}" required>
                    @error('city') <small style="color:var(--error)">{{ $message }}</small> @enderror
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <label>Provinsi *</label>
                    <input type="text" name="province" value="{{ old('province') }}" required>
                    @error('province') <small style="color:var(--error)">{{ $message }}</small> @enderror
                </div>
                <div class="form-group">
                    <label>Alamat *</label>
                    <textarea name="address" rows="2" required>{{ old('address') }}</textarea>
                    @error('address') <small style="color:var(--error)">{{ $message }}</small> @enderror
                </div>
            </div>

            {{-- FIELD KHUSUS AGEN --}}
            <div class="agen-fields visible" id="agenFields">
                <div class="section-label">Info Agen</div>
                <div class="form-group">
                    <label>Deskripsi Agen *</label>
                    <textarea name="description" rows="3">{{ old('description') }}</textarea>
                    @error('description') <small style="color:var(--error)">{{ $message }}</small> @enderror
                </div>
            </div>

            {{-- FIELD KHUSUS DRIVER --}}
            <div class="driver-fields" id="driverFields">
                <div class="section-label">Info Kendaraan</div>
                <div class="row">
                    <div class="form-group">
                        <label>Jenis Kendaraan *</label>
                        <select name="vehicle_type">
                            <option value="">Pilih jenis...</option>
                            <option value="minibus" {{ old('vehicle_type')=='minibus'?'selected':'' }}>Minibus</option>
                            <option value="bus" {{ old('vehicle_type')=='bus'?'selected':'' }}>Bus</option>
                            <option value="sedan" {{ old('vehicle_type')=='sedan'?'selected':'' }}>Sedan</option>
                            <option value="suv" {{ old('vehicle_type')=='suv'?'selected':'' }}>SUV</option>
                            <option value="van" {{ old('vehicle_type')=='van'?'selected':'' }}>Van</option>
                        </select>
                        @error('vehicle_type') <small style="color:var(--error)">{{ $message }}</small> @enderror
                    </div>
                    <div class="form-group">
                        <label>Kapasitas Penumpang *</label>
                        <input type="number" name="vehicle_capacity" value="{{ old('vehicle_capacity') }}" min="1" max="60">
                        @error('vehicle_capacity') <small style="color:var(--error)">{{ $message }}</small> @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label>Harga per Hari (Rp) *</label>
                    <input type="number" name="price_per_day" value="{{ old('price_per_day') }}" min="0" placeholder="Contoh: 500000">
                    @error('price_per_day') <small style="color:var(--error)">{{ $message }}</small> @enderror
                </div>

                <div class="section-label">Rute Layanan</div>
                <div class="form-group">
                    <label>Rute yang Dilayani *</label>
                    <textarea name="routes_text" rows="2" placeholder="Contoh: Surabaya-Malang, Surabaya-Banyuwangi">{{ old('routes_text') }}</textarea>
                    <small style="color:var(--muted)">Pisahkan dengan koma</small>
                    @error('routes_text') <small style="color:var(--error)">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label>Deskripsi Layanan</label>
                    <textarea name="description" rows="2" placeholder="Ceritakan tentang layanan driver kamu...">{{ old('description') }}</textarea>
                </div>
            </div>

            {{-- FOTO KTP (sama untuk semua) --}}
            <div class="section-label">Dokumen</div>
            <div class="form-group">
                <label>Foto KTP *</label>
                <input type="file" name="ktp_photo" accept="image/jpeg,image/png,image/jpg" required>
                <small style="color:var(--muted)">Format: JPG, PNG. Maks 2MB</small>
                @error('ktp_photo') <small style="color:var(--error)">{{ $message }}</small> @enderror
            </div>

            <button type="submit" id="submitBtn">Daftar Sekarang</button>
        </form>

        <div class="link">
            Sudah punya akun? <a href="{{ route('agen.login') }}">Login</a>
        </div>
    </div>
</div>

<script>
function switchRole(role) {
    const agenFields  = document.getElementById('agenFields');
    const driverFields = document.getElementById('driverFields');
    const title       = document.getElementById('formTitle');
    const sub         = document.getElementById('formSub');
    const nameLabel   = document.getElementById('nameLabel');
    const isDriver    = document.getElementById('is_driver_input');
    const submitBtn   = document.getElementById('submitBtn');

    if (role === 'driver') {
        agenFields.classList.remove('visible');
        driverFields.classList.add('visible');
        title.textContent    = 'Daftar Driver Travel';
        sub.textContent      = 'Tawarkan layanan transportasi ke pelanggan MobiTravel';
        nameLabel.textContent = 'Nama Lengkap *';
        isDriver.value       = '1';
        submitBtn.textContent = 'Daftar sebagai Driver';
    } else {
        driverFields.classList.remove('visible');
        agenFields.classList.add('visible');
        title.textContent    = 'Daftar Agen Travel';
        sub.textContent      = 'Bergabunglah dan jangkau ribuan pelanggan';
        nameLabel.textContent = 'Nama Agen *';
        isDriver.value       = '0';
        submitBtn.textContent = 'Daftar Sekarang';
    }
}

// Restore role jika ada validation error
@if(old('is_driver') == '1')
    document.querySelector('input[value="driver"]').checked = true;
    switchRole('driver');
@endif
</script>

</body>
</html>