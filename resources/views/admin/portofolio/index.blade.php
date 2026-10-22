@extends('layouts.admin')

@section('title', 'Galeri Portofolio - Admin Griya Rias Elly Jr.')

@push('styles')
<!-- CSS Fancybox untuk Zoom In/Out -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />
<style>
    .header-action { display: flex; justify-content: space-between; align-items: center; margin-bottom: 28px; }
    .page-title { font-family: 'Playfair Display', serif; color: var(--text-dark); font-size: 1.5rem; }

    .btn-gold { background-color: var(--gold-primary); color: #fff; border: none; padding: 10px 18px; border-radius: 8px; font-size: 0.9rem; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 12px rgba(197, 143, 67, 0.2); transition: all 0.2s; }
    .btn-gold:hover { background-color: var(--gold-hover); }

    .portfolio-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 24px; }
    .portfolio-card { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 12px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.02); }
    
    .portfolio-img-wrapper { position: relative; overflow: hidden; display: block; cursor: pointer; }
    .portfolio-img { width: 100%; height: 320px; object-fit: cover; background-color: #FAFAFA; transition: transform 0.3s ease; }
    .portfolio-img-overlay { position: absolute; inset: 0; background: rgba(36, 26, 22, 0.4); display: flex; align-items: center; justify-content: center; color: #FFFFFF; font-size: 1.5rem; opacity: 0; transition: opacity 0.3s ease; }
    .portfolio-img-wrapper:hover .portfolio-img { transform: scale(1.05); }
    .portfolio-img-wrapper:hover .portfolio-img-overlay { opacity: 1; }

    .portfolio-body { padding: 16px; }
    .portfolio-title { font-family: 'Playfair Display', serif; font-size: 1.1rem; font-weight: 700; margin-bottom: 4px; color: var(--text-dark); }
    .portfolio-cat { font-size: 0.8rem; color: var(--gold-primary); font-weight: 600; text-transform: uppercase; margin-bottom: 12px; }
    .portfolio-actions { display: flex; gap: 8px; margin-top: 12px; }

    .btn-sm { padding: 6px 12px; border: none; border-radius: 6px; font-size: 0.8rem; font-weight: 600; cursor: pointer; color: #fff; display: inline-flex; align-items: center; gap: 6px; transition: opacity 0.2s; }
    .btn-edit { background-color: #3B82F6; }
    .btn-delete { background-color: #EF4444; }
    .btn-sm:hover { opacity: 0.88; }

    /* Modal Form Styles */
    .modal-overlay { position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(36, 26, 22, 0.6); display: none; justify-content: center; align-items: center; z-index: 9999; backdrop-filter: blur(4px); padding: 20px; }
    .modal-overlay.show { display: flex; }
    .modal-card { background-color: var(--bg-card); border: 1px solid var(--border-color); border-radius: 12px; width: 100%; max-width: 520px; padding: 28px; box-shadow: 0 20px 40px rgba(0,0,0,0.15); }
    .modal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid var(--border-color); padding-bottom: 12px; }
    .modal-title { font-family: 'Playfair Display', serif; font-size: 1.2rem; color: var(--text-dark); font-weight: 700; }
    
    .form-group { margin-bottom: 16px; }
    .modal-card label { display: block; font-size: 0.8rem; font-weight: 700; margin-bottom: 6px; color: var(--text-dark); }
    .modal-card input, .modal-card select, .modal-card textarea { width: 100%; padding: 10px 12px; border: 1px solid var(--border-color); border-radius: 8px; background-color: #FAFAFA; font-family: inherit; font-size: 0.9rem; color: var(--text-dark); outline: none; }
    .modal-card input:focus, .modal-card select:focus, .modal-card textarea:focus { border-color: var(--gold-primary); background-color: #FFF; }
    
    .modal-actions { display: flex; gap: 12px; margin-top: 24px; }
    .btn-cancel { flex: 1; background: transparent; border: 1px solid #D6CEC3; padding: 10px; border-radius: 8px; cursor: pointer; font-weight: 600; color: var(--text-muted); }
    .btn-cancel:hover { background-color: #EFE8DE; color: var(--text-dark); }
    .btn-save { flex: 1; background: var(--gold-primary); color: #fff; border: none; padding: 10px; border-radius: 8px; cursor: pointer; font-weight: 600; }
    .btn-save:hover { background-color: var(--gold-hover); }

    /* Memastikan Popup SweetAlert2 Selalu Muncul di Depan Modal */
    .swal2-container {
        z-index: 10000 !important;
    }
</style>
@endpush

@section('content')
<div class="header-action">
    <h1 class="page-title">Galeri Portofolio Hasil Rias</h1>
    <button class="btn-gold" onclick="openModal()"><i class="fa-solid fa-plus"></i> Upload Foto Baru</button>
</div>

<div class="portfolio-grid">
    @forelse($portofolios as $item)
        <div class="portfolio-card">
            <a href="{{ asset('storage/' . $item->gambar) }}" 
               data-fancybox="gallery" 
               data-caption="<strong>{{ $item->judul }}</strong><br>{{$item->deskripsi }}" 
               class="portfolio-img-wrapper">
                <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->judul }}" class="portfolio-img">
                <div class="portfolio-img-overlay">
                    <i class="fa-solid fa-magnifying-glass-plus"></i>
                </div>
            </a>

            <div class="portfolio-body">
                <div class="portfolio-cat">{{ $item->kategori }}</div>
                <h3 class="portfolio-title">{{ $item->judul }}</h3>
                <p style="font-size: 0.85rem; color: var(--text-muted);">{{ Str::limit($item->deskripsi, 60) }}</p>
                
                <div class="portfolio-actions">
                    <button class="btn-sm btn-edit" onclick="openModalEdit({{ json_encode($item) }})">
                        <i class="fa-solid fa-pen-to-square"></i> Edit
                    </button>
                    
                    <form action="{{ route('admin.portofolio.destroy', $item->id) }}" method="POST" style="display:inline;" onsubmit="confirmDelete(event, this)">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-sm btn-delete">
                            <i class="fa-solid fa-trash"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div style="grid-column: 1 / -1; text-align: center; color: var(--text-muted); padding: 40px; background: #fff; border-radius: 12px; border: 1px solid var(--border-color);">
            Belum ada foto portofolio yang diunggah.
        </div>
    @endforelse
</div>

<!-- Modal Form -->
<div class="modal-overlay" id="portofolioModal">
    <div class="modal-card">
        <div class="modal-header">
            <h2 class="modal-title" id="modalTitle">Tambah Foto Portofolio</h2>
            <button onclick="closeModal()" style="background:none; border:none; cursor:pointer; font-size:1.2rem; color:var(--text-muted);"><i class="fa-solid fa-xmark"></i></button>
        </div>
        
        <form id="portofolioForm" action="{{ route('admin.portofolio.store') }}" method="POST" enctype="multipart/form-data" onsubmit="confirmSave(event, this)">
            @csrf
            <input type="hidden" name="_method" id="methodField" value="POST">
            
            <div class="form-group">
                <label>Judul Portofolio</label>
                <input type="text" name="judul" id="judul" placeholder="Contoh: Rias Pengantin Sunda Siger Gold" required>
            </div>
            
            <div class="form-group">
                <label>Kategori Rias / Acara</label>
                <select name="kategori" id="kategori" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($kategoriList as $kategori)
                        <option value="{{ $kategori }}">{{ $kategori }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>File Foto Gambar</label>
                <img id="imgPreview" alt="Preview Gambar Saat Ini" style="display:none; max-width:120px; max-height:90px; object-fit:cover; border-radius:6px; margin-bottom:8px;">
                <input type="file" name="gambar" id="gambar" accept="image/*">
                <small style="color: var(--text-muted); font-size: 0.75rem;">Format: JPG, PNG, WEBP (Maks: 2MB)</small>
            </div>

            <div class="form-group">
                <label>Deskripsi Singkat</label>
                <textarea name="deskripsi" id="deskripsi" rows="3" placeholder="Keterangan riasan atau lokasi acara..."></textarea>
            </div>

            <div class="modal-actions">
                <button type="button" class="btn-cancel" onclick="closeModal()">Batal</button>
                <button type="submit" class="btn-save">Simpan Portofolio</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
<script>
    Fancybox.bind('[data-fancybox="gallery"]', {
        compact: false,
        idle: false,
        animated: true,
        showClass: "f-fadeIn",
        hideClass: "f-fadeOut",
        Images: { zoom: true },
        Toolbar: {
            display: {
                left: ["infobar"],
                middle: ["zoomIn", "zoomOut", "toggle1to1", "rotateCCW", "rotateCW"],
                right: ["slideshow", "fullscreen", "close"],
            },
        },
    });

    const modal = document.getElementById('portofolioModal');
    const form = document.getElementById('portofolioForm');
    const modalTitle = document.getElementById('modalTitle');
    const methodField = document.getElementById('methodField');
    const imgPreview = document.getElementById('imgPreview');

    function openModal() {
        modalTitle.innerText = "Tambah Foto Portofolio";
        form.action = "{{ route('admin.portofolio.store') }}";
        methodField.value = "POST";
        document.getElementById('gambar').required = true;
        imgPreview.style.display = "none";
        form.reset();
        modal.classList.add('show');
    }

    function openModalEdit(item) {
        modalTitle.innerText = "Edit Foto Portofolio";
        form.action = `/admin/portofolio/${item.id}`;
        methodField.value = "PUT";
        
        document.getElementById('judul').value = item.judul || '';
        document.getElementById('kategori').value = item.kategori || '';
        document.getElementById('deskripsi').value = item.deskripsi || '';
        document.getElementById('gambar').required = false;

        if (item.gambar) {
            imgPreview.src = `/storage/${item.gambar}`;
            imgPreview.style.display = "block";
        } else {
            imgPreview.style.display = "none";
        }
        
        modal.classList.add('show');
    }

    function closeModal() { modal.classList.remove('show'); }

    function confirmSave(event, form) {
        event.preventDefault();
        const isEdit = methodField.value === "PUT";

        // Sembunyikan modal form terlebih dahulu
        closeModal();

        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: isEdit ? 'Simpan Perubahan?' : 'Upload Foto Baru?',
                text: isEdit ? "Data portofolio akan diperbarui di sistem." : "Foto portofolio baru akan ditampilkan di galeri.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#C58F43',
                cancelButtonColor: '#8C8279',
                confirmButtonText: isEdit ? 'Ya, Perbarui!' : 'Ya, Upload!',
                cancelButtonText: 'Batal',
                background: '#FFFFFF',
                color: '#241A16'
            }).then((result) => {
                if (result.isConfirmed) { 
                    form.submit(); 
                } else {
                    // Tampilkan kembali modal jika batal
                    modal.classList.add('show');
                }
            });
        } else {
            form.submit();
        }
    }

    function confirmDelete(event, form) {
        event.preventDefault();
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Hapus Foto Portofolio?',
                text: "Foto yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#EF4444',
                cancelButtonColor: '#8C8279',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                background: '#FFFFFF',
                color: '#241A16'
            }).then((result) => {
                if (result.isConfirmed) { form.submit(); }
            });
        } else {
            if (confirm('Apakah Anda yakin ingin menghapus foto ini?')) {
                form.submit();
            }
        }
    }
</script>
@endpush