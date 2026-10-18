@extends('layouts.admin')

@section('title', 'Kelola Kategori Paket - Admin Griya Rias Elly Jr.')

@push('styles')
<style>
    .wrap { max-width: 100%; margin: 0 auto; }
    
    .top, .toolbar, .actions { display: flex; align-items: center; gap: 12px; }
    .top, .toolbar { justify-content: space-between; }
    .top { margin-bottom: 24px; }
    
    .eyebrow { 
        color: var(--gold-primary); 
        text-transform: uppercase; 
        letter-spacing: .12em; 
        font-size: 11px; 
        font-weight: 700; 
    }

    h1 { 
        margin: 5px 0; 
        color: var(--text-dark); 
        font-family: 'Playfair Display', serif; 
        font-size: 28px; 
    }

    p { color: var(--text-muted); margin: 5px 0; font-size: 0.9rem; }

    /* Custom Button Styles */
    .btn { 
        border: 0; 
        border-radius: 8px; 
        padding: 10px 16px; 
        background: var(--gold-primary); 
        color: #fff; 
        cursor: pointer; 
        text-decoration: none; 
        font-weight: 600; 
        font-size: 14px; 
        display: inline-flex; 
        align-items: center; 
        justify-content: center; 
        gap: 7px; 
        white-space: nowrap; 
        transition: all 0.2s;
        box-shadow: 0 4px 12px rgba(197, 143, 67, 0.15);
    }
    .btn:hover { background: var(--gold-hover); }

    .btn-light { background: #fff; color: var(--text-dark); border: 1px solid var(--border-color); box-shadow: none; }
    .btn-light:hover { background: #f5eee7; }

    /* Panel Table Styling */
    .panel { 
        background: var(--bg-card); 
        border: 1px solid var(--border-color); 
        border-radius: 12px; 
        box-shadow: 0 4px 12px rgba(0,0,0,0.02); 
        overflow: hidden; 
    }

    .toolbar { padding: 18px 20px; border-bottom: 1px solid var(--border-color); }
    .toolbar h2 { margin: 0; font-size: 17px; color: var(--text-dark); font-family: 'Playfair Display', serif; }

    .table-wrap { overflow: auto; }
    table { width: 100%; border-collapse: collapse; min-width: 650px; }
    
    th { 
        text-align: left; 
        color: var(--gold-primary); 
        background: #FAFAFA; 
        padding: 13px 16px; 
        font-size: 11px; 
        letter-spacing: .08em; 
        text-transform: uppercase; 
        border-bottom: 2px solid var(--border-color); 
    }

    td { padding: 15px 16px; border-top: 1px solid var(--border-color); vertical-align: middle; font-size: 0.9rem; }
    tbody tr:hover { background: #FDFBF9; }

    .subtle { color: var(--text-muted); font-size: 13px; }

    .count { 
        display: inline-flex; 
        padding: 5px 12px; 
        border-radius: 20px; 
        background: #F6F0E9; 
        color: #775B3D; 
        font-size: 12px; 
        font-weight: 700; 
        border: 1px solid var(--border-color);
    }

    .row-actions { display: flex; gap: 8px; }
    .icon-btn { 
        border: none; 
        border-radius: 6px; 
        padding: 6px 12px; 
        cursor: pointer; 
        font-weight: 600; 
        font-size: 0.8rem; 
        color: #fff; 
        display: inline-flex; 
        align-items: center; 
        gap: 6px; 
        transition: opacity 0.2s;
    }
    .icon-btn:hover { opacity: 0.88; }
    .icon-btn.btn-edit { background: #3B82F6; }
    .icon-btn.btn-danger { background: #EF4444; }
    .icon-btn:disabled { opacity: .45; cursor: not-allowed; }

    .empty { text-align: center; color: var(--text-muted); padding: 36px; }

    /* Modal Custom Styles */
    .modal-backdrop { 
        position: fixed; inset: 0; 
        background: rgba(36, 26, 22, 0.6); 
        display: none; align-items: center; justify-content: center; 
        padding: 18px; z-index: 9999; backdrop-filter: blur(4px);
    }
    .modal-backdrop.show { display: flex; }

    .modal { 
        width: min(480px, 100%); 
        background: #fff; border-radius: 12px; 
        box-shadow: 0 20px 40px rgba(0,0,0,0.15); border: 1px solid var(--border-color);
    }

    .modal-head, .modal-foot { 
        padding: 18px 22px; display: flex; align-items: center; justify-content: space-between; 
        border-bottom: 1px solid var(--border-color); 
    }
    .modal-foot { border: 0; border-top: 1px solid var(--border-color); justify-content: flex-end; gap: 10px; }
    
    .modal-head h2 { margin: 0; color: var(--text-dark); font-family: 'Playfair Display', serif; font-size: 19px; }
    .close { border: 0; background: transparent; font-size: 24px; color: var(--text-muted); cursor: pointer; }

    .modal-body { padding: 22px; }
    .field label { display: block; margin-bottom: 7px; font-size: 13px; font-weight: 700; color: var(--text-dark); }
    .field input { 
        width: 100%; font-family: inherit; color: var(--text-dark); 
        padding: 11px 12px; border: 1px solid var(--border-color); 
        border-radius: 8px; outline: none; background: #FAFAFA;
    }
    .field input:focus { border-color: var(--gold-primary); background: #fff; }
    .hint { font-size: 12px; color: var(--text-muted); margin-top: 8px; }

    @media(max-width:680px){
        .top { align-items: flex-start; flex-direction: column; }
    }
</style>
@endpush

@section('content')
<div class="wrap">
    <header class="top">
        <div>
            <span class="eyebrow">Administrasi</span>
            <h1>Kategori Paket</h1>
            <p>Kelola kategori yang digunakan pada data paket.</p>
        </div>
        <div class="actions">
            <a class="btn btn-light" href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
            <button class="btn" type="button" onclick="openModal('create-modal')"><i class="fa-solid fa-plus"></i> Tambah Kategori</button>
        </div>
    </header>

    <section class="panel">
        <div class="toolbar">
            <h2>Daftar Kategori <span class="subtle">({{ $kategoriPakets->count() }})</span></h2>
        </div>
        
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Nama Kategori</th>
                        <th>Paket Terhubung</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kategoriPakets as $kategori)
                    <tr>
                        <td>
                            <strong>{{ $kategori->nama_kategori }}</strong>
                            <div class="subtle">Kategori #{{ $kategori->id }}</div>
                        </td>
                        <td>
                            <span class="count"><i class="fa-solid fa-box-open me-1" style="font-size:10px;"></i> {{ $kategori->pakets_count }} paket</span>
                        </td>
                        <td>
                            <div class="row-actions">
                                <button class="icon-btn btn-edit" type="button" onclick="editKategori(this)" 
                                        data-action="{{ route('admin.kategori-paket.update',$kategori) }}" 
                                        data-name="{{ $kategori->nama_kategori }}">
                                    <i class="fa-solid fa-pen-to-square"></i> Edit
                                </button>

                                <form method="POST" action="{{ route('admin.kategori-paket.destroy',$kategori) }}" style="display:inline;" onsubmit="confirmDelete(event, this)">
                                    @csrf 
                                    @method('DELETE')
                                    <button class="icon-btn btn-danger" type="submit" 
                                            @disabled($kategori->pakets_count > 0) 
                                            title="{{ $kategori->pakets_count > 0 ? 'Kategori masih dipakai paket' : 'Hapus kategori' }}">
                                        <i class="fa-solid fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td class="empty" colspan="3">Belum ada kategori. Klik “Tambah Kategori” untuk mulai mengisi.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>

<!-- Modal Tambah Kategori -->
<div class="modal-backdrop" id="create-modal" onclick="backdropClose(event,this)">
    <section class="modal" role="dialog" aria-modal="true">
        <form id="create-form" method="POST" action="{{ route('admin.kategori-paket.store') }}" onsubmit="confirmCreate(event, this)">
            @csrf
            <div class="modal-head">
                <h2>Tambah Kategori Baru</h2>
                <button class="close" type="button" onclick="closeModal('create-modal')">&times;</button>
            </div>
            <div class="modal-body">
                <div class="field">
                    <label>Nama Kategori</label>
                    <input name="nama_kategori" value="{{ old('nama_kategori') }}" placeholder="Contoh: Paket Pernikahan" required maxlength="100">
                    <div class="hint">Nama kategori harus unik.</div>
                </div>
            </div>
            <div class="modal-foot">
                <button class="btn btn-light" type="button" onclick="closeModal('create-modal')">Batal</button>
                <button class="btn" type="submit">Simpan Kategori</button>
            </div>
        </form>
    </section>
</div>

<!-- Modal Edit Kategori -->
<div class="modal-backdrop" id="edit-modal" onclick="backdropClose(event,this)">
    <section class="modal" role="dialog" aria-modal="true">
        <form id="edit-form" method="POST" onsubmit="confirmUpdate(event, this)">
            @csrf 
            @method('PUT')
            <div class="modal-head">
                <h2>Ubah Kategori</h2>
                <button class="close" type="button" onclick="closeModal('edit-modal')">&times;</button>
            </div>
            <div class="modal-body">
                <div class="field">
                    <label>Nama Kategori</label>
                    <input id="edit-name" name="nama_kategori" required maxlength="100">
                    <div class="hint">Perubahan nama berlaku pada semua paket yang terhubung.</div>
                </div>
            </div>
            <div class="modal-foot">
                <button class="btn btn-light" type="button" onclick="closeModal('edit-modal')">Batal</button>
                <button class="btn" type="submit">Simpan Perubahan</button>
            </div>
        </form>
    </section>
</div>
@endsection

@push('scripts')
<script>
    function openModal(id){ document.getElementById(id).classList.add('show'); }
    function closeModal(id){ document.getElementById(id).classList.remove('show'); }
    function backdropClose(e,el){ if(e.target===el) el.classList.remove('show'); }

    function editKategori(b){
        document.getElementById('edit-form').action = b.dataset.action;
        document.getElementById('edit-name').value = b.dataset.name;
        openModal('edit-modal');
    }

    document.addEventListener('keydown', e => {
        if(e.key === 'Escape') document.querySelectorAll('.modal-backdrop.show').forEach(m => m.classList.remove('show'));
    });

    // ================= SWEETALERT2 CONFIRMATIONS =================

    function confirmCreate(event, form) {
        event.preventDefault();
        Swal.fire({
            title: 'Simpan Kategori Baru?',
            text: "Pastikan nama kategori yang dimasukkan sudah sesuai.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#C58F43',
            cancelButtonColor: '#8C8279',
            confirmButtonText: 'Ya, Simpan!',
            cancelButtonText: 'Batal',
            background: '#FFFFFF',
            color: '#241A16'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    }

    function confirmUpdate(event, form) {
        event.preventDefault();
        Swal.fire({
            title: 'Simpan Perubahan?',
            text: "Nama kategori akan diperbarui di seluruh paket yang terhubung.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#C58F43',
            cancelButtonColor: '#8C8279',
            confirmButtonText: 'Ya, Perbarui!',
            cancelButtonText: 'Batal',
            background: '#FFFFFF',
            color: '#241A16'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    }

    function confirmDelete(event, form) {
        event.preventDefault();
        Swal.fire({
            title: 'Hapus Kategori Ini?',
            text: "Kategori ini akan dihapus permanen dari sistem.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#EF4444',
            cancelButtonColor: '#8C8279',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            background: '#FFFFFF',
            color: '#241A16'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    }
</script>
@endpush