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
                                <label for="jumlah_pesanan">Jumlah paket <span>*</span></label>
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
                                <h2>Pilih Paket</h2>
                                <p>Pilih layanan yang ingin Anda pesan.</p>
                            </div>
                        </div>
                        @error('id_paket') <small class="reservation-error">{{ $message }}</small> @enderror

                        @if ($pakets->isNotEmpty())
                            <div class="reservation-package-list">
                                @foreach ($pakets as $paket)
                                    <label class="reservation-package-option">
                                        <input
                                            type="radio"
                                            name="id_paket"
                                            value="{{ $paket->id }}"
                                            data-name="{{ $paket->nama_paket }}"
                                            data-price="{{ $paket->harga }}"
                                            @checked((string) old('id_paket', $selectedPackageId) === (string) $paket->id)
                                            required
                                        >
                                        <span class="reservation-package-check" aria-hidden="true"></span>
                                        <span class="reservation-package-info">
                                            <strong>{{ $paket->nama_paket }}</strong>
                                            <small>{{ $paket->kategoriPaket?->nama_kategori }}</small>
                                            @if ($paket->deskripsi)
                                                <span>{{ $paket->deskripsi }}</span>
                                            @endif
                                        </span>
                                        <span class="reservation-package-price">Rp {{ number_format($paket->harga, 0, ',', '.') }}</span>
                                    </label>
                                @endforeach
                            </div>
                        @else
                            <div class="reservation-no-packages">
                                <strong>Katalog belum memiliki paket aktif.</strong>
                                <p>Silakan hubungi kami melalui WhatsApp untuk informasi layanan.</p>
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
                        <span>Paket dipilih</span>
                        <strong id="summary-package-name">{{ $pakets->firstWhere('id', old('id_paket', $selectedPackageId))?->nama_paket ?? 'Belum ada paket' }}</strong>
                    </div>
                    <div class="reservation-summary-row">
                        <span>Harga per paket</span>
                        <strong id="summary-unit-price">Rp {{ number_format($pakets->firstWhere('id', old('id_paket', $selectedPackageId))?->harga ?? 0, 0, ',', '.') }}</strong>
                    </div>
                    <div class="reservation-summary-row">
                        <span>Jumlah paket</span>
                        <strong id="summary-quantity">{{ old('jumlah_pesanan', 1) }}</strong>
                    </div>
                    <div class="reservation-summary-total">
                        <span>Estimasi biaya sewa</span>
                        <strong id="summary-total">Rp {{ number_format(($pakets->firstWhere('id', old('id_paket', $selectedPackageId))?->harga ?? 0) * (int) old('jumlah_pesanan', 1), 0, ',', '.') }}</strong>
                    </div>
                    <p class="reservation-summary-note">Harga akhir dan ketersediaan jadwal akan dikonfirmasi oleh tim kami. Pembayaran dilakukan setelah reservasi disetujui.</p>
                    <button class="reservation-submit" type="submit" @disabled($pakets->isEmpty())>
                        Ajukan Reservasi <span aria-hidden="true">→</span>
                    </button>
                    <a class="reservation-back-link" href="{{ route('client.dashboard') }}">Kembali ke katalog</a>
                </aside>
            </div>
        </form>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const packageInputs = document.querySelectorAll('input[name="id_paket"]');
        const quantityInput = document.getElementById('jumlah_pesanan');
        const packageName = document.getElementById('summary-package-name');
        const unitPrice = document.getElementById('summary-unit-price');
        const quantity = document.getElementById('summary-quantity');
        const total = document.getElementById('summary-total');
        const formatPrice = value => new Intl.NumberFormat('id-ID').format(value);

        function updateSummary() {
            const selectedPackage = document.querySelector('input[name="id_paket"]:checked');
            const selectedQuantity = Math.max(1, Number(quantityInput.value) || 1);
            const price = selectedPackage ? Number(selectedPackage.dataset.price) : 0;

            packageName.textContent = selectedPackage ? selectedPackage.dataset.name : 'Belum ada paket';
            unitPrice.textContent = 'Rp ' + formatPrice(price);
            quantity.textContent = selectedQuantity;
            total.textContent = 'Rp ' + formatPrice(price * selectedQuantity);
        }

        packageInputs.forEach(input => input.addEventListener('change', updateSummary));
        quantityInput.addEventListener('input', updateSummary);
        updateSummary();
    });
</script>
@endsection
