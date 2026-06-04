@extends('admin.layouts.app')

@section('title', 'Manajemen Driver Travel')
@section('menu-drivers', 'active')

@section('content')
<div class="content">
    <div class="header">
        <h1>Manajemen Driver Travel</h1>
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button class="btn btn-danger">Logout</button>
        </form>
    </div>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    <div class="tabs">
        <a href="{{ route('admin.drivers.index', ['status' => 'pending']) }}"
           class="tab {{ $status == 'pending' ? 'active' : '' }}">Menunggu Verifikasi</a>
        <a href="{{ route('admin.drivers.index', ['status' => 'active']) }}"
           class="tab {{ $status == 'active' ? 'active' : '' }}">Aktif</a>
        <a href="{{ route('admin.drivers.index', ['status' => 'suspended']) }}"
           class="tab {{ $status == 'suspended' ? 'active' : '' }}">Ditangguhkan</a>
        <a href="{{ route('admin.drivers.index') }}"
           class="tab {{ $status == '' ? 'active' : '' }}">Semua</a>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Driver</th>
                <th>Email</th>
                <th>Kendaraan</th>
                <th>Kapasitas</th>
                <th>Harga/Hari</th>
                <th>Status</th>
                <th>Tanggal Daftar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($drivers as $driver)
            <tr>
                <td>{{ $driver->id }}</td>
                <td>{{ $driver->agency_name }}</td>
                <td>{{ $driver->email }}</td>
                <td>{{ $driver->vehicle_type ?? '-' }}</td>
                <td>{{ $driver->vehicle_capacity ?? '-' }} kursi</td>
                <td>Rp {{ number_format($driver->price_per_day, 0, ',', '.') }}</td>
                <td>
                    <span class="status status-{{ $driver->status }}">
                        {{ ucfirst($driver->status) }}
                    </span>
                </td>
                <td>{{ $driver->created_at->format('d/m/Y') }}</td>
                <td>
                    <a href="{{ route('admin.drivers.show', $driver->id) }}" class="btn btn-primary btn-sm">Detail</a>

                    @if($driver->status == 'pending')
                        <button onclick="showVerifyModal({{ $driver->id }}, '{{ $driver->agency_name }}')"
                                class="btn btn-primary btn-sm">Setujui</button>
                        <button onclick="showRejectModal({{ $driver->id }}, '{{ $driver->agency_name }}')"
                                class="btn btn-warning btn-sm">Tolak</button>
                    @endif

                    @if($driver->status == 'active')
                        <button onclick="suspendDriver({{ $driver->id }})"
                                class="btn btn-warning btn-sm">Tangguhkan</button>
                    @endif

                    @if($driver->status == 'suspended')
                        <button onclick="activateDriver({{ $driver->id }})"
                                class="btn btn-primary btn-sm">Aktifkan</button>
                    @endif

                    <button onclick="deleteDriver({{ $driver->id }}, '{{ $driver->agency_name }}')"
                            class="btn btn-danger btn-sm">Hapus</button>
                </td>
            </tr>
            @empty
                <tr>
                    <td colspan="9" style="text-align: center;">Tidak ada data driver</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 20px;">
        {{ $drivers->links() }}
    </div>
</div>

<!-- Modal Setujui -->
<div id="verifyModal" class="modal">
    <div class="modal-content">
        <h3>Setujui Driver</h3>
        <p>Yakin ingin menyetujui driver <strong id="verifyName"></strong>?</p>
        <form id="verifyForm" method="POST">
            @csrf
            <button type="submit" class="btn btn-primary">Ya, Setujui</button>
            <button type="button" onclick="closeModal('verifyModal')" class="btn btn-danger">Batal</button>
        </form>
    </div>
</div>

<!-- Modal Tolak -->
<div id="rejectModal" class="modal">
    <div class="modal-content">
        <h3>Tolak Driver</h3>
        <p>Driver: <strong id="rejectName"></strong></p>
        <form id="rejectForm" method="POST">
            @csrf
            <textarea name="reason" rows="4" placeholder="Alasan penolakan..." style="width:100%; margin: 15px 0; padding: 8px;" required></textarea>
            <button type="submit" class="btn btn-warning">Ya, Tolak</button>
            <button type="button" onclick="closeModal('rejectModal')" class="btn btn-danger">Batal</button>
        </form>
    </div>
</div>

<style>
    .content { margin-left: 0; padding: 20px 40px; }
    .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
    .tabs { display: flex; gap: 10px; margin-bottom: 20px; }
    .tab { padding: 10px 20px; background: white; border-radius: 8px; text-decoration: none; color: #333; }
    .tab.active { background: #1a3328; color: white; }
    table { width: 100%; background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
    th, td { padding: 15px; text-align: left; border-bottom: 1px solid #eee; }
    th { background: #f0f0f0; }
    .status { padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: bold; }
    .status-pending { background: #fef3c7; color: #d97706; }
    .status-active { background: #dcfce7; color: #16a34a; }
    .status-suspended { background: #fee2e2; color: #dc2626; }
    .btn { padding: 6px 12px; border: none; border-radius: 6px; cursor: pointer; font-size: 12px; text-decoration: none; display: inline-block; }
    .btn-primary { background: #1a3328; color: white; }
    .btn-danger { background: #dc2626; color: white; }
    .btn-warning { background: #d97706; color: white; }
    .btn-sm { padding: 4px 10px; font-size: 11px; }
    .alert-success { background: #dcfce7; color: #16a34a; padding: 12px; border-radius: 8px; margin-bottom: 20px; }
    .modal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); justify-content: center; align-items: center; }
    .modal-content { background: white; padding: 30px; border-radius: 12px; width: 400px; }
</style>

<script>
    function showVerifyModal(id, name) {
        document.getElementById('verifyName').innerText = name;
        document.getElementById('verifyForm').action = '/admin/drivers/' + id + '/verify';
        document.getElementById('verifyModal').style.display = 'flex';
    }

    function showRejectModal(id, name) {
        document.getElementById('rejectName').innerText = name;
        document.getElementById('rejectForm').action = '/admin/drivers/' + id + '/reject';
        document.getElementById('rejectModal').style.display = 'flex';
    }

    function suspendDriver(id) {
        if(confirm('Yakin ingin menangguhkan driver ini?')) {
            let form = document.createElement('form');
            form.method = 'POST';
            form.action = '/admin/drivers/' + id + '/suspend';
            form.innerHTML = '@csrf';
            document.body.appendChild(form);
            form.submit();
        }
    }

    function activateDriver(id) {
        if(confirm('Yakin ingin mengaktifkan kembali driver ini?')) {
            let form = document.createElement('form');
            form.method = 'POST';
            form.action = '/admin/drivers/' + id + '/activate';
            form.innerHTML = '@csrf';
            document.body.appendChild(form);
            form.submit();
        }
    }

    function deleteDriver(id, name) {
        if(confirm('Yakin ingin menghapus driver "' + name + '" secara permanen?')) {
            let form = document.createElement('form');
            form.method = 'POST';
            form.action = '/admin/drivers/' + id;
            form.innerHTML = '@csrf @method("DELETE")';
            document.body.appendChild(form);
            form.submit();
        }
    }

    function closeModal(modalId) {
        document.getElementById(modalId).style.display = 'none';
    }

    window.onclick = function(event) {
        if (event.target.classList.contains('modal')) {
            event.target.style.display = 'none';
        }
    }
</script>
@endsection