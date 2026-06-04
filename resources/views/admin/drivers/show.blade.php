@extends('admin.layouts.app')

@section('title', 'Detail Driver Travel')
@section('menu-drivers', 'active')

@section('content')
<div class="content">
    <div class="header">
        <h1>Detail Driver Travel</h1>
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button class="btn btn-danger">Logout</button>
        </form>
    </div>

    <div class="card">
        <div class="info-row">
            <div class="info-label">ID</div>
            <div class="info-value">#{{ $driver->id }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Nama</div>
            <div class="info-value">{{ $driver->agency_name }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Email</div>
            <div class="info-value">{{ $driver->email }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Telepon</div>
            <div class="info-value">{{ $driver->phone ?? '-' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">WhatsApp</div>
            <div class="info-value">{{ $driver->whatsapp ?? '-' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Kota / Provinsi</div>
            <div class="info-value">{{ $driver->city ?? '-' }}, {{ $driver->province ?? '-' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Jenis Kendaraan</div>
            <div class="info-value">{{ $driver->vehicle_type ?? '-' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Kapasitas</div>
            <div class="info-value">{{ $driver->vehicle_capacity ? $driver->vehicle_capacity . ' kursi' : '-' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Harga per Hari</div>
            <div class="info-value">Rp {{ number_format($driver->price_per_day, 0, ',', '.') }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Rute Dilayani</div>
            <div class="info-value">
                @if($driver->routes)
                    @foreach($driver->routes as $route)
                        <span class="badge">{{ $route }}</span>
                    @endforeach
                @else
                    -
                @endif
            </div>
        </div>
        <div class="info-row">
            <div class="info-label">Rating</div>
            <div class="info-value">★ {{ $driver->rating }} ({{ $driver->total_reviews }} ulasan)</div>
        </div>
        <div class="info-row">
            <div class="info-label">Tersedia</div>
            <div class="info-value">{{ $driver->is_available ? 'Ya' : 'Tidak' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Status</div>
            <div class="info-value">
                <span class="status status-{{ $driver->status }}">
                    {{ ucfirst($driver->status) }}
                </span>
            </div>
        </div>
        <div class="info-row">
            <div class="info-label">Tanggal Daftar</div>
            <div class="info-value">{{ $driver->created_at->format('d/m/Y H:i') }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Foto KTP</div>
            <div class="info-value">
                @if($driver->ktp_photo)
                    <img src="{{ asset('storage/' . $driver->ktp_photo) }}" class="ktp-photo">
                @else
                    <em>Belum upload KTP</em>
                @endif
            </div>
        </div>
    </div>

    <div style="margin-top: 20px;">
        <a href="{{ url()->previous() }}" class="btn btn-back">← Kembali</a>

        @if($driver->status == 'pending')
            <form method="POST" action="{{ route('admin.drivers.verify', $driver->id) }}" style="display: inline-block;">
                @csrf
                <button type="submit" class="btn btn-primary">Setujui Driver</button>
            </form>
            <button onclick="showRejectModal()" class="btn btn-warning">Tolak Driver</button>
        @endif

        @if($driver->status == 'active')
            <button onclick="suspendDriver()" class="btn btn-warning">Tangguhkan</button>
        @endif

        @if($driver->status == 'suspended')
            <button onclick="activateDriver()" class="btn btn-primary">Aktifkan Kembali</button>
        @endif

        <button onclick="deleteDriver()" class="btn btn-danger">Hapus Driver</button>
    </div>
</div>

<!-- Modal Tolak -->
<div id="rejectModal" class="modal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); justify-content:center; align-items:center;">
    <div style="background:white; padding:30px; border-radius:12px; width:400px;">
        <h3>Tolak Driver</h3>
        <p>Driver: <strong>{{ $driver->agency_name }}</strong></p>
        <form method="POST" action="{{ route('admin.drivers.reject', $driver->id) }}">
            @csrf
            <textarea name="reason" rows="4" placeholder="Alasan penolakan..." style="width:100%; margin:15px 0; padding:8px;" required></textarea>
            <button type="submit" class="btn btn-warning">Ya, Tolak</button>
            <button type="button" onclick="closeModal()" class="btn btn-danger">Batal</button>
        </form>
    </div>
</div>

<style>
    .content { margin-left: 0; padding: 20px 40px; }
    .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
    .card { background: white; border-radius: 12px; padding: 25px; margin-bottom: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
    .info-row { display: flex; margin-bottom: 15px; padding-bottom: 10px; border-bottom: 1px solid #eee; }
    .info-label { width: 180px; font-weight: bold; color: #666; }
    .info-value { flex: 1; color: #333; }
    .ktp-photo { max-width: 300px; margin-top: 10px; border-radius: 8px; border: 1px solid #ddd; }
    .badge { display: inline-block; background: #e5e7eb; color: #374151; padding: 3px 10px; border-radius: 20px; font-size: 12px; margin-right: 5px; margin-bottom: 4px; }
    .status { padding: 6px 14px; border-radius: 20px; font-size: 12px; font-weight: bold; display: inline-block; }
    .status-pending { background: #fef3c7; color: #d97706; }
    .status-active { background: #dcfce7; color: #16a34a; }
    .status-suspended { background: #fee2e2; color: #dc2626; }
    .btn { padding: 10px 20px; border: none; border-radius: 8px; cursor: pointer; text-decoration: none; display: inline-block; margin-right: 10px; }
    .btn-primary { background: #1a3328; color: white; }
    .btn-warning { background: #d97706; color: white; }
    .btn-danger { background: #dc2626; color: white; }
    .btn-back { background: #666; color: white; }
</style>

<script>
    function showRejectModal() {
        document.getElementById('rejectModal').style.display = 'flex';
    }

    function closeModal() {
        document.getElementById('rejectModal').style.display = 'none';
    }

    function suspendDriver() {
        if(confirm('Yakin ingin menangguhkan driver ini?')) {
            let form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("admin.drivers.suspend", $driver->id) }}';
            form.innerHTML = '@csrf';
            document.body.appendChild(form);
            form.submit();
        }
    }

    function activateDriver() {
        if(confirm('Yakin ingin mengaktifkan kembali driver ini?')) {
            let form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("admin.drivers.activate", $driver->id) }}';
            form.innerHTML = '@csrf';
            document.body.appendChild(form);
            form.submit();
        }
    }

    function deleteDriver() {
        if(confirm('Yakin ingin menghapus driver ini secara permanen?')) {
            let form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("admin.drivers.destroy", $driver->id) }}';
            form.innerHTML = '@csrf @method("DELETE")';
            document.body.appendChild(form);
            form.submit();
        }
    }

    window.onclick = function(event) {
        let modal = document.getElementById('rejectModal');
        if (event.target == modal) modal.style.display = 'none';
    }
</script>
@endsection