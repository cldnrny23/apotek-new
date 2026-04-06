@extends('fe.master')
@section('navbar')
    @include('fe.navbar')
@endsection

@section('checkout')

{{-- ===== Hero Banner ===== --}}
<div class="chk-hero">
    <div class="chk-hero__bg-orb chk-hero__bg-orb--1"></div>
    <div class="chk-hero__bg-orb chk-hero__bg-orb--2"></div>
    <div class="chk-hero__grid"></div>
    <div class="container position-relative" style="z-index:2;">
        <div class="chk-hero__inner">
            <div class="chk-hero__eyebrow">
                <span class="chk-hero__eyebrow-dot"></span>
                Apotek Medicare
            </div>
            <h1 class="chk-hero__title">
                <i class="fas fa-credit-card me-2"></i>
                Halaman <span class="chk-hero__title-accent">Checkout</span>
            </h1>
            <p class="chk-hero__desc">Pilih metode pengiriman dan pembayaran favoritmu. Transaksi aman dan proses cepat!</p>
            <div class="chk-hero__badges">
                <span class="chk-hero__badge"><i class="fas fa-lock"></i> Transaksi Aman</span>
                <span class="chk-hero__badge"><i class="fas fa-shipping-fast"></i> Pengiriman Seluruh Indonesia</span>
                <span class="chk-hero__badge"><i class="fas fa-headset"></i> Dukungan 24/7</span>
            </div>
        </div>
    </div>
</div>

{{-- ===== Main Checkout Area ===== --}}
<div class="chk-main">
    <div class="container">

        <form id="order-form" action="{{ route('checkout.process') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Pengiriman & Pembayaran Selects --}}
            <div class="chk-selects">
                <div class="chk-select-wrap">
                    <label class="chk-select-wrap__label">
                        <i class="fas fa-shipping-fast"></i> Jenis Pengiriman
                    </label>
                    <div class="chk-select-field-wrap">
                        <span class="chk-select-icon"><i class="fas fa-truck"></i></span>
                        <select class="chk-select" name="id_jenis_kirim" id="jenis_pengiriman_select" required>
                            <option value="">Pilih jenis pengiriman...</option>
                            @foreach($jenis_pengirimans as $jp)
                                <option value="{{ $jp->id }}" data-cost="{{ $jp->ongkos_kirim ?? 0 }}">
                                    {{ $jp->nama_ekspedisi }} — {{ $jp->jenis_kirim }}
                                    (Rp {{ number_format($jp->ongkos_kirim ?? 0, 0, ',', '.') }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="chk-select-wrap">
                    <label class="chk-select-wrap__label">
                        <i class="fas fa-credit-card"></i> Metode Pembayaran
                    </label>
                    <div class="chk-select-field-wrap">
                        <span class="chk-select-icon"><i class="fas fa-wallet"></i></span>
                        <select class="chk-select" name="id_metode_bayar" id="id_metode_bayar_select" required>
                            <option value="">Pilih metode pembayaran...</option>
                            @foreach($metode_bayars as $mb)
                                <option value="{{ $mb->id }}">
                                    {{ $mb->metode_pembayaran }} — {{ $mb->tempat_bayar }}
                                    @if($mb->no_rekening) ({{ $mb->no_rekening }}) @endif
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            {{-- Main grid --}}
            <div class="chk-layout">

                {{-- ===== Left: Product List ===== --}}
                <div class="chk-products">
                <div class="chk-products__header">
                    <h2 class="chk-products__title">
                        <i class="fas fa-box-open me-2"></i>Produk yang Dibeli
                    </h2>
                    <span class="chk-products__count">{{ count($checkout_items) }} item</span>
                </div>

                @forelse($checkout_items as $index => $item)
                    <div class="chk-item">
                        <div class="chk-item__img-wrap">
                            <img src="{{ asset('storage/' . $item['image']) }}"
                                 class="chk-item__img"
                                 alt="{{ $item['name'] }}">
                        </div>
                        <div class="chk-item__info">
                            <h3 class="chk-item__name">{{ $item['name'] }}</h3>
                            <div class="chk-item__qty">
                                {{ $item['quantity'] }} × Rp {{ number_format($item['price'], 0, ',', '.') }}
                            </div>
                            @if($item['is_keras'] ?? false)
                                <span class="chk-item__keras-badge">
                                    <i class="fas fa-exclamation-triangle"></i> Obat Keras
                                </span>
                            @endif
                        </div>
                        <div class="chk-item__subtotal">
                            Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                        </div>
                    </div>
                @empty
                    <div class="chk-empty">
                        <i class="fas fa-box-open chk-empty__icon"></i>
                        <p>Tidak ada produk yang di-checkout.</p>
                    </div>
                @endforelse
            </div>

            {{-- ===== Right: Summary + Form ===== --}}
            <div class="chk-summary-col">
                    <input type="hidden" name="ongkir" id="input-ongkir">
                    <input type="hidden" name="total_bayar" id="input-total-bayar">
                    <input type="hidden" name="produk" id="input-produk">
                    <input type="hidden" id="has-obat-keras" value="{{ isset($has_obat_keras) && $has_obat_keras ? '1' : '0' }}">

                    <div class="chk-summary">
                        <div class="chk-summary__header">
                            <h3 class="chk-summary__title">Ringkasan Belanja</h3>
                        </div>
                        <div class="chk-summary__body">
                            <div class="chk-summary__row">
                                <span class="chk-summary__label">Total Produk ({{ count($checkout_items) }})</span>
                                <span class="chk-summary__value">Rp {{ number_format($total_price, 0, ',', '.') }}</span>
                            </div>
                            <div class="chk-summary__row">
                                <span class="chk-summary__label">Biaya Pengiriman</span>
                                <span class="chk-summary__value" id="ongkir">Rp 0</span>
                            </div>
                            <div class="chk-summary__divider"></div>
                            <div class="chk-summary__row chk-summary__row--total">
                                <span class="chk-summary__label">Total Bayar</span>
                                <strong class="chk-summary__total" id="total">Rp {{ number_format($total_price, 0, ',', '.') }}</strong>
                            </div>

                            {{-- Upload Resep --}}
                            <div class="chk-resep">
                                <div class="chk-resep__header">
                                    <i class="fas fa-file-medical chk-resep__header-icon"></i>
                                    <span>Upload Foto Resep</span>
                                    <span class="chk-resep__optional">Opsional</span>
                                </div>
                                <div class="chk-resep__input-wrap">
                                    <i class="fas fa-cloud-upload-alt chk-resep__icon"></i>
                                    <input type="file"
                                           class="chk-resep__input"
                                           name="url_resep"
                                           id="url_resep"
                                           accept="image/*">
                                </div>
                                <p class="chk-resep__hint">Wajib untuk obat keras. Format: JPG, PNG, max 2MB.</p>
                            </div>

                            <button type="submit" class="chk-submit-btn" id="pay-button">
                                <i class="fas fa-shopping-cart me-2"></i>
                                Buat Pesanan
                                <i class="fas fa-arrow-right chk-submit-btn__arrow"></i>
                            </button>

                            <div class="chk-secure">
                                <i class="fas fa-lock"></i>
                                <span>Pembayaran aman & terenkripsi</span>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const orderForm               = document.getElementById('order-form');
    const jenisPengirimanSelect   = document.getElementById('jenis_pengiriman_select');
    const metodeBayarSelect       = document.getElementById('id_metode_bayar_select');
    const ongkirSpan              = document.getElementById('ongkir');
    const totalSpan               = document.getElementById('total');
    let totalPrice = {{ $total_price }};

    jenisPengirimanSelect.addEventListener('change', function () {
        const ongkir     = parseInt(this.options[this.selectedIndex].dataset.cost) || 0;
        const totalBayar = totalPrice + ongkir;
        ongkirSpan.textContent = 'Rp ' + ongkir.toLocaleString('id-ID');
        totalSpan.textContent  = 'Rp ' + totalBayar.toLocaleString('id-ID');
    });

    orderForm.addEventListener('submit', function (e) {
        e.preventDefault();

        // If any product requires a prescription, ensure resep file uploaded
        const hasObatKeras = document.getElementById('has-obat-keras').value === '1';
        const resepInput = document.getElementById('url_resep');
        if (hasObatKeras && resepInput && resepInput.files.length === 0) {
            Swal.fire({ icon: 'warning', title: 'Resep Diperlukan', text: 'Terdapat produk yang memerlukan resep. Silakan upload foto resep sebelum melanjutkan.' });
            return;
        }

        if (!jenisPengirimanSelect.value) {
            Swal.fire({ icon: 'error', title: 'Oops!', text: 'Silakan pilih metode pengiriman!' }); return;
        }
        if (!metodeBayarSelect.value) {
            Swal.fire({ icon: 'error', title: 'Oops!', text: 'Silakan pilih metode pembayaran!' }); return;
        }

        const ongkir = parseInt(jenisPengirimanSelect.options[jenisPengirimanSelect.selectedIndex].dataset.cost) || 0;
        document.getElementById('input-ongkir').value      = ongkir;
        document.getElementById('input-total-bayar').value = totalPrice + ongkir;

        let produk = [];
        @foreach($checkout_items as $item)
            produk.push({ id: {{ $item['product_id'] ?? $item['id'] }}, name: "{{ $item['name'] }}", qty: {{ $item['quantity'] }}, price: {{ $item['price'] }}, image: "{{ $item['image'] }}" });
        @endforeach
        document.getElementById('input-produk').value = JSON.stringify(produk);

        this.submit();
    });
});
</script>

@endsection


