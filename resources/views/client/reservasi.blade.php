@extends('layouts.app')

@section('title', 'Ajukan Reservasi')

@section('content')
<section class="reservation-hero">
    <div class="container">
        <span class="reservation-eyebrow">Rencanakan hari istimewa Anda</span>
        <h1>Ajukan Reservasi</h1>
        <p>Lengkapi detail acara dan pilih layanan yang Anda inginkan. Tim kami akan menghubungi Anda untuk konfirmasi jadwal.</p>
    </div>
</section>

<section class="reservation-section">
    <div class="container">
        @if ($errors->any())
            <div class="reservation-alert" role="alert">
                <strong>Periksa kembali data reservasi Anda.</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('reservasi.store') }}" method="POST" id="reservation-form">
            @csrf
            <div class="reservation-layout">
                <div class="reservation-main">
                    <section class="reservation-panel">
                        <div class="reservation-panel-heading">
                            <span class="reservation-step">01</span>
                            <div>
                                <h2>Informasi Pemesan</h2>
                                <p>Data ini diambil dari akun Anda.</p>
                            </div>
                        </div>
                        <div class="reservation-fields reservation-fields-two">
                            <div class="reservation-field">
                                <label for="customer-name">Nama pemesan</label>
                                <input id="customer-name" type="text" value="{{ $user->name }}" readonly>
                            </div>
                            <div class="reservation-field">
                                <label for="customer-phone">Nomor WhatsApp</label>
                                <input id="customer-phone" type="text" value="{{ $user->phone ?: 'Nomor belum diisi di profil' }}" readonly>
                            </div>
                        </div>
                    </section>

                    <section class="reservation-panel">
                        <div class="reservation-panel-heading">
                            <span class="reservation-step">02</span>
                            <div>
                                <h2>Detail Acara</h2>
                                <p>Tentukan tanggal, waktu, dan lokasi acara.</p>
                            </div>
                        </div>
                        <div class="reservation-fields reservation-fields-two">
                            <div class="reservation-field">
                                <label for="tgl_acara">Tanggal acara <span>*</span></label>
                                <input id="tgl_acara" name="tgl_acara" type="date" min="{{ now()->toDateString() }}" value="{{ old('tgl_acara') }}" required>
                                @error('tgl_acara') <small class="reservation-error">{{ $message }}</small> @enderror
                            </div>
                            <div class="reservation-field">
                                <label for="jumlah_pesanan">Jumlah pilihan <span>*</span></label>
                                <input id="jumlah_pesanan" name="jumlah_pesanan" type="number" min="1" max="20" value="{{ old('jumlah_pesanan', 1) }}" required>
                                @error('jumlah_pesanan') <small class="reservation-error">{{ $message }}</small> @enderror
                            </div>
                            <div class="reservation-field">
                                <label for="waktu_mulai">Waktu mulai <span>*</span></label>
                                <input id="waktu_mulai" name="waktu_mulai" type="time" value="{{ old('waktu_mulai') }}" required>
                                @error('waktu_mulai') <small class="reservation-error">{{ $message }}</small> @enderror
                            </div>
                            <div class="reservation-field">
                                <label for="waktu_selesai">Waktu selesai <span>*</span></label>
                                <input id="waktu_selesai" name="waktu_selesai" type="time" value="{{ old('waktu_selesai') }}" required>
                                @error('waktu_selesai') <small class="reservation-error">{{ $message }}</small> @enderror
                            </div>
                            <div class="reservation-field reservation-field-full">
                                <label for="lokasi_acara">Lokasi acara <span>*</span></label>
                                <textarea id="lokasi_acara" name="lokasi_acara" rows="3" maxlength="2000" placeholder="Nama gedung, alamat lengkap, dan patokan lokasi" required>{{ old('lokasi_acara') }}</textarea>
                                @error('lokasi_acara') <small class="reservation-error">{{ $message }}</small> @enderror
                            </div>
                            <div class="reservation-field reservation-field-full">
                                <label for="catatan">Catatan tambahan <span class="reservation-optional">(opsional)</span></label>
                                <textarea id="catatan" name="catatan" rows="3" maxlength="2000" placeholder="Ceritakan kebutuhan khusus atau detail acara Anda">{{ old('catatan') }}</textarea>
                                @error('catatan') <small class="reservation-error">{{ $message }}</small> @enderror
                            </div>
                        </div>
                    </section>

                    <section class="reservation-panel">
                        <div class="reservation-panel-heading">
                            <span class="reservation-step">03</span>
                            <div>
                                <h2>Pilih Layanan atau Paket</h2>
                                <p>Tentukan jenis pilihan, lalu pilih item yang ingin dipesan.</p>
                            </div>
                        </div>
                        @php($jenisDipilih = old('jenis_pesanan', $selectedPackageId ? 'paket' : ''))
                        <input type="hidden" name="jenis_pesanan" id="jenis_pesanan" value="{{ $jenisDipilih }}">
                        <div class="reservation-choice-types" role="group" aria-label="Pilih jenis pesanan">
                            <button type="button" class="reservation-type-card {{ $jenisDipilih === 'paket' ? 'selected' : '' }}" data-type-choice="paket" aria-pressed="{{ $jenisDipilih === 'paket' ? 'true' : 'false' }}" @disabled($pakets->isEmpty())>
                                <span class="reservation-type-icon"><i class="fa-solid fa-box-open"></i></span><span><strong>Pilih Paket</strong><small>Paket acara dan kategori paket</small></span><span class="reservation-type-arrow">&#8250;</span>
                            </button>
                            <button type="button" class="reservation-type-card {{ $jenisDipilih === 'layanan' ? 'selected' : '' }}" data-type-choice="layanan" aria-pressed="{{ $jenisDipilih === 'layanan' ? 'true' : 'false' }}" @disabled($layanans->isEmpty())>
                                <span class="reservation-type-icon"><i class="fa-solid fa-scissors"></i></span><span><strong>Pilih Layanan</strong><small>Pilih layanan yang tersedia</small></span><span class="reservation-type-arrow">&#8250;</span>
                            </button>
                        </div>
                        @error('jenis_pesanan') <small class="reservation-error">{{ $message }}</small> @enderror
                        @error('id_item') <small class="reservation-error">{{ $message }}</small> @enderror

                        <div class="reservation-choice-list" id="paket-options" data-options="paket" @if($jenisDipilih !== 'paket') hidden @endif>
                            <h3>Pilih paket yang Anda inginkan</h3>
                            @forelse ($pakets as $paket)
                                <label class="reservation-package-option">
                                    <input type="radio" name="id_item" value="paket:{{ $paket->id }}" data-name="{{ $paket->nama_paket }}" data-price="{{ $paket->harga }}" @checked(old('id_item', $selectedItemValue) === 'paket:' . $paket->id && $jenisDipilih === 'paket')>
                                    <span class="reservation-package-check" aria-hidden="true"></span>
                                    <span class="reservation-package-info"><strong>{{ $paket->nama_paket }}</strong><small>{{ $paket->kategoriPaket?->nama_kategori }}</small>@if($paket->deskripsi)<span>{{ $paket->deskripsi }}</span>@endif</span>
                                    <span class="reservation-package-price">Rp {{ number_format($paket->harga, 0, ',', '.') }}</span>
                                </label>
                            @empty
                                <div class="reservation-no-packages"><strong>Belum ada paket aktif.</strong><p>Silakan pilih layanan atau hubungi tim kami.</p></div>
                            @endforelse
                        </div>

                        <div class="reservation-choice-list" id="layanan-options" data-options="layanan" @if($jenisDipilih !== 'layanan') hidden @endif>
                            <h3>Pilih layanan yang Anda inginkan</h3>
                            @forelse ($layanans as $layanan)
                                <label class="reservation-package-option">
                                    <input type="radio" name="id_item" value="layanan:{{ $layanan->id_layanan }}" data-name="{{ $layanan->nama_layanan }}" data-price="{{ $layanan->harga }}" @checked(old('id_item') === 'layanan:' . $layanan->id_layanan && $jenisDipilih === 'layanan')>
                                    <span class="reservation-package-check" aria-hidden="true"></span>
                                    <span class="reservation-package-info"><strong>{{ $layanan->nama_layanan }}</strong>@if($layanan->variasi)<small>{{ $layanan->variasi }}</small>@endif @if($layanan->deskripsi)<span>{{ $layanan->deskripsi }}</span>@endif</span>
                                    <span class="reservation-package-price">Rp {{ number_format($layanan->harga, 0, ',', '.') }}</span>
                                </label>
                            @empty
                                <div class="reservation-no-packages"><strong>Belum ada layanan aktif.</strong><p>Silakan pilih paket atau hubungi tim kami.</p></div>
                            @endforelse
                        </div>
                        @if ($pakets->isEmpty() && $layanans->isEmpty())
                            <div class="reservation-no-packages">
                                <strong>Katalog belum memiliki layanan atau paket aktif.</strong>
                                <p>Silakan hubungi kami melalui WhatsApp untuk informasi lebih lanjut.</p>
                            </div>
                        @endif
                    </section>
                </div>

                <aside class="reservation-summary">
                    <div class="reservation-summary-heading">
                        <span class="reservation-eyebrow">Ringkasan pilihan</span>
                        <h2>Rincian Reservasi</h2>
                    </div>
                    <div class="reservation-summary-package">
                        <span id="summary-item-label">Pilihan</span>
                        <strong id="summary-package-name">Belum ada pilihan</strong>
                    </div>
                    <div class="reservation-summary-row">
                        <span>Harga per pilihan</span>
                        <strong id="summary-unit-price">Rp 0</strong>
                    </div>
                    <div class="reservation-summary-row">
                        <span>Jumlah pilihan</span>
                        <strong id="summary-quantity">{{ old('jumlah_pesanan', 1) }}</strong>
                    </div>
                    <div class="reservation-summary-total">
                        <span>Estimasi biaya sewa</span>
                        <strong id="summary-total">Rp 0</strong>
                    </div>
                    <p class="reservation-summary-note">Harga akhir dan ketersediaan jadwal akan dikonfirmasi oleh tim kami. Pembayaran dilakukan setelah reservasi disetujui.</p>
                    <button class="reservation-submit" type="submit" @disabled($pakets->isEmpty() && $layanans->isEmpty())>
                        Ajukan Reservasi <span aria-hidden="true">→</span>
                    </button>
                    <a class="reservation-back-link" href="{{ route('client.dashboard') }}">Kembali ke katalog</a>
                </aside>
            </div>
        </form>
    </div>
</section>

<style>
    .reservation-summary .reservation-submit { width:min(100%, 280px); margin:0 auto; }
    .reservation-choice-types{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:14px;margin:4px 0 22px}
    .reservation-type-card{display:flex;align-items:center;gap:13px;width:100%;min-height:82px;padding:15px 17px;border:1px solid #e8ded1;border-radius:14px;background:#fff;text-align:left;cursor:pointer;transition:border-color .2s,background .2s,box-shadow .2s,transform .2s}
    .reservation-type-card:hover:not(:disabled){transform:translateY(-2px);border-color:#c58f43;box-shadow:0 8px 22px #6b431512}
    .reservation-type-card.selected{border-color:#c58f43;background:#fdf8ef;box-shadow:0 0 0 2px #c58f4320}
    .reservation-type-card:disabled{opacity:.5;cursor:not-allowed}
    .reservation-type-icon{display:grid;place-items:center;width:44px;height:44px;flex:0 0 44px;border-radius:12px;background:#f7eddd;color:#a87632;font-size:18px}
    .reservation-type-card>span:nth-child(2){display:grid;gap:4px;flex:1}
    .reservation-type-card strong{color:#34241b;font-size:14px}
    .reservation-type-card small{color:#8c8279;font-size:11px}
    .reservation-type-arrow{color:#a87632;font-size:24px;line-height:1}
    .reservation-choice-list{display:grid;gap:12px;margin-top:8px;animation:reservation-list-in .24s ease both}
    .reservation-choice-list[hidden]{display:none!important}
    .reservation-choice-list h3{margin:0 0 2px;color:#5d4633;font-size:13px;font-weight:700}
    @keyframes reservation-list-in{from{opacity:0;transform:translateY(7px)}to{opacity:1;transform:none}}
    @media(max-width:600px){.reservation-choice-types{grid-template-columns:1fr}.reservation-type-card{min-height:72px}}
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const typeInput = document.getElementById('jenis_pesanan');
        const typeButtons = document.querySelectorAll('[data-type-choice]');
        const optionGroups = document.querySelectorAll('[data-options]');
        const quantityInput = document.getElementById('jumlah_pesanan');
        const packageName = document.getElementById('summary-package-name');
        const unitPrice = document.getElementById('summary-unit-price');
        const quantity = document.getElementById('summary-quantity');
        const total = document.getElementById('summary-total');
        const itemLabel = document.getElementById('summary-item-label');
        const formatPrice = value => new Intl.NumberFormat('id-ID').format(value);

        function showOptions(type) {
            typeInput.value = type;
            typeButtons.forEach(button => {
                const active = button.dataset.typeChoice === type;
                button.classList.toggle('selected', active);
                button.setAttribute('aria-pressed', active ? 'true' : 'false');
            });
            optionGroups.forEach(group => {
                const active = group.dataset.options === type;
                group.hidden = !active;
                const radios = [...group.querySelectorAll('input[name="id_item"]')];
                radios.forEach(radio => {
                    radio.disabled = !active;
                    radio.required = active && radios[0] === radio;
                    if (!active) radio.checked = false;
                });
            });
            updateSummary();
        }

        function updateSummary() {
            const selectedItem = document.querySelector('input[name="id_item"]:checked');
            const selectedQuantity = Math.max(1, Number(quantityInput.value) || 1);
            const selected = selectedItem && !selectedItem.disabled ? selectedItem : null;
            const price = selected ? Number(selected.dataset.price) : 0;

            itemLabel.textContent = typeInput.value === 'paket' ? 'Paket dipilih' : (typeInput.value === 'layanan' ? 'Layanan dipilih' : 'Pilihan');
            packageName.textContent = selected ? selected.dataset.name : 'Belum ada pilihan';
            unitPrice.textContent = 'Rp ' + formatPrice(price);
            quantity.textContent = selectedQuantity;
            total.textContent = 'Rp ' + formatPrice(price * selectedQuantity);
        }

        typeButtons.forEach(button => button.addEventListener('click', () => showOptions(button.dataset.typeChoice)));
        document.querySelectorAll('input[name="id_item"]').forEach(input => input.addEventListener('change', updateSummary));
        quantityInput.addEventListener('input', updateSummary);
        if (typeInput.value) showOptions(typeInput.value);
        else updateSummary();
    });
</script>
@endsection
