@extends('fe.master')
@section('navbar')
    @include('fe.navbar')
@endsection

@section('checkout')

{{-- ===== Hero Banner ===== --}}
<div class="chk-hero">
    <div class="chk-hero__bg-orb chk-hero__bg-orb--1"></div>
    <div class="chk-hero__bg-orb chk-hero__bg-orb--2"></div>
    <div class="container position-relative" style="z-index:2;">
        <div class="chk-hero__inner">
            <div class="chk-hero__eyebrow">
                <span class="chk-hero__eyebrow-line"></span>
                ClouPills
                <span class="chk-hero__eyebrow-line"></span>
            </div>
            <h1 class="chk-hero__title">
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
            <div class="row gx-3 mb-4">
                <div class="col-md-6">
                    <label class="chk-label" for="jenis_pengiriman_select">Jenis Pengiriman</label>
                    <select class="chk-select" name="id_jenis_kirim" id="jenis_pengiriman_select" required>
                        <option value="" disabled selected hidden>Pilih jenis pengiriman...</option>
                        @foreach($jenis_pengirimans as $jp)
                            <option
                                value="{{ $jp->id }}"
                                data-cost="{{ (int) ($jp->ongkos_kirim ?? 0) }}">
                                {{ $jp->nama_ekspedisi }} — {{ $jp->jenis_kirim }}
                                (Rp {{ number_format($jp->ongkos_kirim ?? 0, 0, ',', '.') }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="chk-label" for="id_metode_bayar_select">Metode Pembayaran</label>
                    <select class="chk-select" name="id_metode_bayar" id="id_metode_bayar_select" required>
                        <option value="" disabled selected hidden>Pilih metode pembayaran...</option>
                        @foreach($metode_bayars as $mb)
                            <option value="{{ $mb->id }}">
                                {{ $mb->metode_pembayaran }} — {{ $mb->tempat_bayar }}
                                {{ $mb->no_rekening ? '(' . $mb->no_rekening . ')' : '' }}
                            </option>
                        @endforeach
                    </select>
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
                        <div class="chk-item" style="animation-delay: {{ $index * 0.07 }}s">
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
                            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" style="opacity:0.3;margin-bottom:12px;">
                                <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z" stroke="#4476D9" stroke-width="1.5" stroke-linejoin="round"/>
                                <path d="M3 6h18M16 10a4 4 0 01-8 0" stroke="#4476D9" stroke-width="1.5" stroke-linecap="round"/>
                            </svg>
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
                                <span>Pembayaran aman &amp; terenkripsi</span>
                            </div>
                        </div>
                    </div>

                    {{-- Trust badges --}}
                    <div class="chk-trust">
                        <div class="chk-trust__item">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" stroke="#2B5FC1" stroke-width="1.5" stroke-linejoin="round"/></svg>
                            <span>Transaksi aman &amp; terenkripsi</span>
                        </div>
                        <div class="chk-trust__item">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M5 12l5 5L20 7" stroke="#2B5FC1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            <span>Produk terjamin keasliannya</span>
                        </div>
                        <div class="chk-trust__item">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z" stroke="#2B5FC1" stroke-width="1.5" stroke-linejoin="round"/><polyline points="9 22 9 12 15 12 15 22" stroke="#2B5FC1" stroke-width="1.5" stroke-linejoin="round"/></svg>
                            <span>Dikirim ke seluruh Indonesia</span>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- ===== Styles ===== --}}
<style>
  /* ── Palet Blue Apotik ── */
  :root {
    --pl-blue-100:  #D6E4FB;
    --pl-blue-300:  #7AAAF0;
    --pl-blue-400:  #4476D9;
    --pl-blue-500:  #2B5FC1;
    --pl-blue-700:  #1A3A7A;
    --pl-ink:       #0C1E45;
    --pl-ink-3:     #7A8CAD;
    --pl-border:    #D0DDEF;
    --pl-surface:   #FFFFFF;
    --pl-bg:        #EEF3FB;
    --pl-radius:    16px;
    --pl-radius-sm: 10px;
    --pl-shadow:    0 2px 8px rgba(12,30,69,.06), 0 8px 32px rgba(12,30,69,.08);
  }

  /* ── Hero ── */
  .chk-hero {
    background: var(--pl-ink);
    padding: 64px 0 52px;
    position: relative;
    overflow: hidden;
  }

  .chk-hero__bg-orb {
    position: absolute;
    border-radius: 50%;
    pointer-events: none;
  }

  .chk-hero__bg-orb--1 {
    width: 520px; height: 520px;
    background: radial-gradient(circle, rgba(43,95,193,.35) 0%, transparent 70%);
    top: -200px; right: -100px;
  }

  .chk-hero__bg-orb--2 {
    width: 360px; height: 360px;
    background: radial-gradient(circle, rgba(68,118,217,.2) 0%, transparent 70%);
    bottom: -120px; left: -80px;
  }

  .chk-hero__inner {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    gap: 16px;
  }

  .chk-hero__eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: .14em;
    text-transform: uppercase;
    color: var(--pl-blue-300);
  }

  .chk-hero__eyebrow-line {
    display: inline-block;
    width: 18px; height: 2px;
    background: var(--pl-blue-400);
    border-radius: 2px;
  }

  .chk-hero__title {
    font-family: 'Lora', serif;
    font-size: clamp(28px, 4vw, 42px);
    font-weight: 600;
    color: #ffffff;
    margin: 0;
    letter-spacing: -.02em;
    line-height: 1.2;
  }

  .chk-hero__title-accent {
    color: var(--pl-blue-300);
    font-style: italic;
  }

  .chk-hero__desc {
    font-size: 15px;
    font-weight: 300;
    color: rgba(255,255,255,.6);
    margin: 0;
    max-width: 480px;
    line-height: 1.65;
  }

  .chk-hero__badges {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 10px;
    margin-top: 4px;
  }

  .chk-hero__badge {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 6px 14px;
    border-radius: 100px;
    background: rgba(43,95,193,.25);
    border: 1px solid rgba(122,170,240,.3);
    color: var(--pl-blue-300);
    font-size: 12px;
    font-weight: 500;
  }

  .chk-hero__badge i { font-size: 11px; }

  /* ── Main Area ── */
  .chk-main {
    background: var(--pl-bg);
    padding: 40px 0 70px;
    position: relative;
    overflow: hidden;
  }

  .chk-main::before {
    content: '';
    position: absolute;
    width: 500px; height: 500px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(43,95,193,.07) 0%, transparent 70%);
    top: -200px; right: -140px;
    pointer-events: none;
  }

  .chk-main::after {
    content: '';
    position: absolute;
    width: 350px; height: 350px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(43,95,193,.05) 0%, transparent 70%);
    bottom: -80px; left: -80px;
    pointer-events: none;
  }

  .chk-main .container { position: relative; z-index: 1; }

  /* ── Labels & Selects ── */
  .chk-label {
    display: block;
    font-size: 13px;
    font-weight: 600;
    color: var(--pl-ink);
    margin-bottom: 6px;
    letter-spacing: .01em;
  }

  .chk-select {
    width: 100%;
    padding: 11px 16px;
    border-radius: var(--pl-radius-sm);
    border: 1.5px solid var(--pl-border);
    background: var(--pl-surface);
    color: var(--pl-ink);
    font-size: 14px;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none'%3E%3Cpath d='M6 9l6 6 6-6' stroke='%237A8CAD' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 14px center;
    padding-right: 36px;
    transition: border-color .2s, box-shadow .2s;
    box-shadow: var(--pl-shadow);
    cursor: pointer;
  }

  .chk-select:focus {
    outline: none;
    border-color: var(--pl-blue-400);
    box-shadow: 0 0 0 3px rgba(43,95,193,.12);
  }

  /* ── Layout Grid ── */
  .chk-layout {
    display: grid;
    grid-template-columns: 1fr 320px;
    gap: 20px;
    align-items: start;
  }

  /* ── Product List ── */
  .chk-products {
    background: var(--pl-surface);
    border-radius: var(--pl-radius);
    border: 1.5px solid var(--pl-border);
    box-shadow: var(--pl-shadow);
    overflow: hidden;
  }

  .chk-products__header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 18px 22px 16px;
    border-bottom: 1px solid var(--pl-border);
  }

  .chk-products__title {
    font-family: 'Lora', serif;
    font-size: 16px;
    font-weight: 600;
    color: var(--pl-ink);
    margin: 0;
  }

  .chk-products__title i { color: var(--pl-blue-500); }

  .chk-products__count {
    font-size: 11px;
    font-weight: 700;
    padding: 4px 12px;
    border-radius: 100px;
    background: var(--pl-blue-100);
    color: var(--pl-blue-700);
    letter-spacing: .06em;
  }

  .chk-item {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 16px 22px;
    border-bottom: 1px solid var(--pl-border);
    transition: background .18s;
    animation: slideIn .35s ease both;
  }

  .chk-item:last-child { border-bottom: none; }
  .chk-item:hover { background: #f0f5fd; }

  @keyframes slideIn {
    from { opacity: 0; transform: translateY(10px); }
    to   { opacity: 1; transform: translateY(0); }
  }

  .chk-item__img-wrap {
    width: 72px; height: 72px;
    border-radius: 12px;
    background: var(--pl-blue-100);
    border: 1px solid var(--pl-border);
    overflow: hidden;
    flex-shrink: 0;
  }

  .chk-item__img {
    width: 100%; height: 100%;
    object-fit: cover;
    transition: transform .5s cubic-bezier(.22,1,.36,1);
  }

  .chk-item:hover .chk-item__img { transform: scale(1.06); }

  .chk-item__info { flex: 1; min-width: 0; }

  .chk-item__name {
    font-size: 14px;
    font-weight: 600;
    color: var(--pl-ink);
    margin: 0 0 4px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .chk-item__qty {
    font-size: 13px;
    color: var(--pl-blue-500);
    font-weight: 500;
  }

  .chk-item__keras-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    margin-top: 6px;
    padding: 3px 10px;
    border-radius: 100px;
    background: #fff5e6;
    color: #b45309;
    font-size: 11px;
    font-weight: 700;
  }

  .chk-item__subtotal {
    font-size: 14px;
    font-weight: 700;
    color: var(--pl-ink);
    text-align: right;
    min-width: 110px;
    flex-shrink: 0;
  }

  .chk-empty {
    padding: 48px 24px;
    text-align: center;
    color: var(--pl-ink-3);
    font-size: 14px;
    display: flex;
    flex-direction: column;
    align-items: center;
  }

  /* ── Summary Column ── */
  .chk-summary-col {
    display: flex;
    flex-direction: column;
    gap: 14px;
  }

  .chk-summary {
    background: var(--pl-surface);
    border-radius: var(--pl-radius);
    border: 1.5px solid var(--pl-border);
    box-shadow: var(--pl-shadow);
    overflow: hidden;
    animation: slideIn .4s ease .1s both;
  }

  .chk-summary__header {
    padding: 16px 22px 14px;
    border-bottom: 1px solid var(--pl-border);
    background: var(--pl-blue-100);
  }

  .chk-summary__title {
    font-size: 11px;
    font-weight: 700;
    color: var(--pl-blue-700);
    text-transform: uppercase;
    letter-spacing: .14em;
    margin: 0;
  }

  .chk-summary__body { padding: 18px 22px 22px; }

  .chk-summary__row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 9px 0;
  }

  .chk-summary__label {
    font-size: 13px;
    color: var(--pl-ink-3);
  }

  .chk-summary__value {
    font-size: 13px;
    font-weight: 600;
    color: var(--pl-ink);
  }

  .chk-summary__divider {
    height: 1px;
    background: var(--pl-border);
    margin: 8px 0;
  }

  .chk-summary__row--total { padding: 10px 0 0; }

  .chk-summary__label { font-size: 14px; }

  .chk-summary__total {
    font-size: 18px;
    font-weight: 800;
    color: var(--pl-blue-500);
  }

  /* Resep upload */
  .chk-resep {
    background: #f0f5fd;
    border: 1.5px dashed var(--pl-blue-300);
    border-radius: var(--pl-radius-sm);
    padding: 14px 16px;
    margin: 18px 0 16px;
  }

  .chk-resep__header {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    font-weight: 600;
    color: var(--pl-ink);
    margin-bottom: 10px;
  }

  .chk-resep__header-icon { color: var(--pl-blue-500); font-size: 14px; }

  .chk-resep__optional {
    margin-left: auto;
    font-size: 10px;
    font-weight: 700;
    padding: 2px 8px;
    border-radius: 100px;
    background: var(--pl-blue-100);
    color: var(--pl-blue-700);
    letter-spacing: .06em;
  }

  .chk-resep__input-wrap {
    display: flex;
    align-items: center;
    gap: 10px;
    background: var(--pl-surface);
    border: 1.5px solid var(--pl-border);
    border-radius: 8px;
    padding: 8px 12px;
  }

  .chk-resep__icon { color: var(--pl-blue-400); font-size: 15px; flex-shrink: 0; }

  .chk-resep__input {
    flex: 1;
    border: none;
    background: transparent;
    font-size: 13px;
    color: var(--pl-ink);
    outline: none;
    cursor: pointer;
  }

  .chk-resep__hint {
    font-size: 11px;
    color: var(--pl-ink-3);
    margin: 8px 0 0;
  }

  /* Submit button */
  .chk-submit-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    width: 100%;
    padding: 14px;
    border-radius: var(--pl-radius-sm);
    background: var(--pl-blue-500);
    color: #fff;
    font-size: 14px;
    font-weight: 600;
    border: none;
    cursor: pointer;
    transition: background .2s, transform .12s, box-shadow .2s;
    box-shadow: 0 4px 14px rgba(43,95,193,.35);
    letter-spacing: .01em;
  }

  .chk-submit-btn:hover {
    background: var(--pl-blue-700);
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(43,95,193,.45);
  }

  .chk-submit-btn:active { transform: scale(0.98); }

  .chk-submit-btn__arrow {
    margin-left: auto;
    font-size: 12px;
    transition: transform .2s;
  }

  .chk-submit-btn:hover .chk-submit-btn__arrow { transform: translateX(4px); }

  /* Secure note */
  .chk-secure {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    margin-top: 12px;
    font-size: 11px;
    color: var(--pl-ink-3);
  }

  .chk-secure i { color: var(--pl-blue-500); font-size: 10px; }

  /* Trust card */
  .chk-trust {
    background: var(--pl-surface);
    border-radius: 14px;
    border: 1.5px solid var(--pl-border);
    padding: 14px 18px;
    box-shadow: 0 2px 8px rgba(12,30,69,.04);
    animation: slideIn .4s ease .2s both;
  }

  .chk-trust__item {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 12px;
    color: var(--pl-ink-3);
    padding: 7px 0;
    border-bottom: 1px solid var(--pl-border);
    transition: color .15s;
  }

  .chk-trust__item:last-child { border-bottom: none; }
  .chk-trust__item:hover { color: var(--pl-ink); }

  /* ── Responsive ── */
  @media (max-width: 820px) {
    .chk-layout { grid-template-columns: 1fr; }
    .chk-hero { padding: 48px 0 40px; }
  }

  @media (max-width: 480px) {
    .chk-item { flex-wrap: wrap; }
    .chk-item__subtotal { min-width: unset; text-align: left; }
    .chk-hero__badges { flex-direction: column; align-items: center; }
  }
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.getElementById('order-form').addEventListener('submit', function (e) {
    e.preventDefault();

    const hasObatKeras = document.getElementById('has-obat-keras').value === '1';
    const resepInput = document.getElementById('url_resep');
    const jenisPengirimanSelect = document.getElementById('jenis_pengiriman_select');
    const metodeBayarSelect = document.getElementById('id_metode_bayar_select');
    const totalPriceValue = {{ $total_price }};

    // Validasi obat keras dan resep
    if (hasObatKeras && resepInput && resepInput.files.length === 0) {
        Swal.fire({
            icon: 'warning',
            title: 'Resep Diperlukan',
            text: 'Terdapat produk yang memerlukan resep. Silakan upload foto resep sebelum melanjutkan.'
        });
        return;
    }

    // Validasi pengiriman
    if (!jenisPengirimanSelect.value) {
        Swal.fire({
            icon: 'error',
            title: 'Oops!',
            text: 'Silakan pilih metode pengiriman!'
        });
        return;
    }

    // Validasi pembayaran
    if (!metodeBayarSelect.value) {
        Swal.fire({
            icon: 'error',
            title: 'Oops!',
            text: 'Silakan pilih metode pembayaran!'
        });
        return;
    }

    // Isi hidden fields
    const ongkir = parseInt(jenisPengirimanSelect.options[jenisPengirimanSelect.selectedIndex].dataset.cost) || 0;
    document.getElementById('input-ongkir').value = ongkir;
    document.getElementById('input-total-bayar').value = totalPriceValue + ongkir;

    // Isi produk
    let produk = [];
    @foreach($checkout_items as $item)
        produk.push({
            id: {{ $item['product_id'] ?? $item['id'] }},
            name: "{{ $item['name'] }}",
            qty: {{ $item['quantity'] }},
            price: {{ $item['price'] }},
            image: "{{ $item['image'] }}"
        });
    @endforeach
    document.getElementById('input-produk').value = JSON.stringify(produk);

    // Submit
    this.submit();
});
</script>

@endsection
