@extends('fe.master')
@section('navbar')
    @include('fe.navbar')
@endsection

@section('checkout')

{{-- ===== Hero Banner ===== --}}
<div class="pay-hero">
    <div class="pay-hero__orb pay-hero__orb--1"></div>
    <div class="pay-hero__orb pay-hero__orb--2"></div>
    <div class="container position-relative" style="z-index:2;">
        <div class="pay-hero__inner">
            <div class="pay-hero__eyebrow">
                <span class="pay-hero__eyebrow-line"></span>
                Apotek Kami
                <span class="pay-hero__eyebrow-line"></span>
            </div>
            <h1 class="pay-hero__title">
                Halaman <span class="pay-hero__title-accent">Pembayaran</span>
            </h1>
            <p class="pay-hero__desc">Lakukan pembayaran sesuai instruksi di bawah ini. Pesanan akan diproses setelah pembayaran dikonfirmasi.</p>
            <div class="pay-hero__badges">
                <span class="pay-hero__badge"><i class="fas fa-lock"></i> Transaksi Aman</span>
                <span class="pay-hero__badge"><i class="fas fa-clock"></i> Konfirmasi Cepat</span>
                <span class="pay-hero__badge"><i class="fas fa-headset"></i> Dukungan 24/7</span>
            </div>
        </div>
    </div>
</div>

{{-- ===== Payment Area ===== --}}
<div class="pay-main">
    <div class="container">

        @if(session('success'))
            <div class="pay-alert pay-alert--success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
                <button type="button" class="pay-alert__close" onclick="this.parentElement.remove()">×</button>
            </div>
        @endif

        @if(session('error'))
            <div class="pay-alert pay-alert--danger">
                <i class="fas fa-exclamation-circle"></i>
                {{ session('error') }}
                <button type="button" class="pay-alert__close" onclick="this.parentElement.remove()">×</button>
            </div>
        @endif

        <div class="pay-layout">

            {{-- ===== Left: Order Summary ===== --}}
            <div class="pay-order">

                {{-- Invoice Meta --}}
                <div class="pay-card">
                    <div class="pay-card__header">
                        <i class="fas fa-receipt pay-card__header-icon"></i>
                        <span>Ringkasan Pesanan</span>
                    </div>
                    <div class="pay-card__body">
                        <div class="pay-meta-grid">
                            <div class="pay-meta-item">
                                <span class="pay-meta-item__label">No. Invoice</span>
                                <span class="pay-meta-item__value pay-meta-item__value--accent">#{{ str_pad($penjualan->id, 5, '0', STR_PAD_LEFT) }}</span>
                            </div>
                            <div class="pay-meta-item">
                                <span class="pay-meta-item__label">Tanggal Pesanan</span>
                                <span class="pay-meta-item__value">{{ $penjualan->tgl_penjualan ? $penjualan->tgl_penjualan->format('d M Y H:i') : 'N/A' }}</span>
                            </div>
                            <div class="pay-meta-item">
                                <span class="pay-meta-item__label">Status Pesanan</span>
                                <span class="pay-status-badge">{{ $penjualan->status_order }}</span>
                            </div>
                            <div class="pay-meta-item">
                                <span class="pay-meta-item__label">Metode Pembayaran</span>
                                <span class="pay-meta-item__value">{{ $penjualan->metodeBayar->metode_pembayaran }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Product Table --}}
                <div class="pay-card" style="margin-top:16px;">
                    <div class="pay-card__header">
                        <i class="fas fa-box-open pay-card__header-icon"></i>
                        <span>Detail Produk</span>
                    </div>
                    <div class="pay-card__body pay-card__body--flush">
                        <div class="pay-table-wrap">
                            <table class="pay-table">
                                <thead>
                                    <tr>
                                        <th>Produk</th>
                                        <th class="text-center">Qty</th>
                                        <th class="text-end">Harga</th>
                                        <th class="text-end">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($penjualan->detailPenjualans as $detail)
                                    <tr>
                                        <td>
                                            <div class="pay-product">
                                                <div class="pay-product__img-wrap">
                                                    <img src="{{ asset('storage/' . $detail->obat->gambar) }}"
                                                         alt="{{ $detail->obat->nama_obat }}"
                                                         class="pay-product__img">
                                                </div>
                                                <div>
                                                    <div class="pay-product__name">{{ $detail->obat->nama_obat }}</div>
                                                    @if($detail->obat->kategori)
                                                        <div class="pay-product__cat">{{ $detail->obat->kategori }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">{{ $detail->jumlah_beli }}</td>
                                        <td class="text-end">Rp {{ number_format($detail->harga_beli, 0, ',', '.') }}</td>
                                        <td class="text-end">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="pay-table__foot-row">
                                        <td colspan="3" class="text-end">Ongkos Kirim</td>
                                        <td class="text-end">Rp {{ number_format($penjualan->ongkos_kirim, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr class="pay-table__foot-row">
                                        <td colspan="3" class="text-end">Biaya Aplikasi</td>
                                        <td class="text-end">Rp {{ number_format($penjualan->biaya_app, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr class="pay-table__total-row">
                                        <td colspan="3" class="text-end">Total Bayar</td>
                                        <td class="text-end">Rp {{ number_format($penjualan->total_bayar, 0, ',', '.') }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ===== Right: Payment + Shipping ===== --}}
            <div class="pay-sidebar">

                {{-- Payment Instructions --}}
                <div class="pay-card pay-card--animated">
                    <div class="pay-card__header pay-card__header--green">
                        <i class="fas fa-money-bill-wave pay-card__header-icon"></i>
                        <span>Instruksi Pembayaran</span>
                    </div>
                    <div class="pay-card__body">

                        {{-- Midtrans warnings --}}
                        @if(!$penjualan->snap_token && $penjualan->metodeBayar && $penjualan->metodeBayar->midtrans_payment_type)
                            <div class="pay-info pay-info--warning">
                                <i class="fas fa-exclamation-triangle"></i>
                                Token Midtrans belum dibuat. Silakan muat ulang halaman untuk mencoba kembali.
                            </div>
                        @endif

                        @if(str_contains(strtolower($penjualan->keterangan_status ?? ''), 'expired via midtrans') || str_contains(strtolower($penjualan->keterangan_status ?? ''), 'dibatalkan via midtrans') || str_contains(strtolower($penjualan->keterangan_status ?? ''), 'ditolak oleh midtrans'))
                            <div class="pay-info pay-info--warning">
                                <i class="fas fa-exclamation-triangle"></i>
                                Pembayaran sebelumnya sudah kadaluarsa atau dibatalkan. Halaman ini akan membuat tautan baru.
                            </div>
                        @endif

                        @if($penjualan->snap_token)
                            {{-- Midtrans --}}
                            <div class="pay-midtrans-label">
                                <i class="fas fa-credit-card"></i>
                                Pembayaran Online
                            </div>
                            <p class="pay-midtrans-desc">Klik tombol di bawah untuk melanjutkan pembayaran.</p>

                            <button id="pay-button" class="pay-btn pay-btn--primary">
                                <i class="fas fa-credit-card me-2"></i>Bayar Sekarang
                            </button>

                            <a href="{{ route('payment.link', $penjualan->id) }}" target="_blank" class="pay-btn pay-btn--outline" style="margin-top:10px;">
                                <i class="fas fa-external-link-alt me-2"></i>
                                Bayar via Link ({{ config('midtrans.is_production') ? 'Production' : 'Simulator' }})
                            </a>

                            <div class="pay-info pay-info--blue" style="margin-top:14px;">
                                <i class="fas fa-info-circle"></i>
                                Pilih "Bayar Sekarang" untuk popup Midtrans, atau "Bayar via Link" untuk tab baru.
                                {{ config('midtrans.is_production') ? 'Mode Production aktif.' : 'Mode Sandbox aktif — untuk testing.' }}
                            </div>

                            @if($penjualan->metodeBayar && $penjualan->metodeBayar->midtrans_payment_type)
                                <div class="pay-method-tag">
                                    <strong>Midtrans Method:</strong>
                                    {{ ucwords(str_replace('_', ' ', $penjualan->metodeBayar->midtrans_payment_type)) }}
                                </div>
                            @endif

                        @else
                            {{-- Manual Payment --}}
                            <div class="pay-manual-title">{{ $penjualan->metodeBayar->metode_pembayaran }}</div>

                            @if($penjualan->metodeBayar->no_rekening)
                                <div class="pay-rekening-label">No. Rekening</div>
                                <div class="pay-rekening-box">
                                    {{ $penjualan->metodeBayar->no_rekening }}
                                </div>
                            @endif

                            <div class="pay-manual-place">
                                <span class="pay-manual-place__label">Tempat Pembayaran</span>
                                <span>{{ $penjualan->metodeBayar->tempat_bayar }}</span>
                            </div>

                            <div class="pay-info pay-info--blue">
                                <i class="fas fa-info-circle"></i>
                                Harap transfer sesuai nominal yang tertera. Pesanan akan diproses setelah pembayaran dikonfirmasi oleh admin.
                            </div>

                            <form action="{{ route('payment.confirm', $penjualan->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="pay-btn pay-btn--green"
                                        onclick="return confirm('Apakah Anda sudah melakukan pembayaran?')">
                                    <i class="fas fa-check-circle me-2"></i>Saya Sudah Bayar
                                </button>
                            </form>
                        @endif

                        @if(!in_array($penjualan->status_order, ['Diproses', 'Menunggu Kurir', 'Selesai']))
                            <form action="{{ route('payment.cancel', $penjualan->id) }}" method="POST" style="margin-top:10px;">
                                @csrf
                                @method('POST')
                                <button type="submit" class="pay-btn pay-btn--danger"
                                        onclick="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')">
                                    <i class="fas fa-times-circle me-2"></i>Batalkan Pesanan
                                </button>
                            </form>
                        @endif

                        <a href="{{ route('home') }}" class="pay-btn pay-btn--outline" style="margin-top:10px;">
                            <i class="fas fa-home me-2"></i>Kembali ke Beranda
                        </a>

                    </div>
                </div>

                {{-- Shipping Info --}}
                <div class="pay-card pay-card--animated" style="animation-delay:.15s;">
                    <div class="pay-card__header">
                        <i class="fas fa-shipping-fast pay-card__header-icon"></i>
                        <span>Info Pengiriman</span>
                    </div>
                    <div class="pay-card__body">
                        <div class="pay-ship-row">
                            <span class="pay-ship-row__label">Ekspedisi</span>
                            <span class="pay-ship-row__value">{{ $penjualan->jenisPengiriman->nama_ekspedisi }} — {{ $penjualan->jenisPengiriman->jenis_kirim }}</span>
                        </div>
                        <div class="pay-ship-row">
                            <span class="pay-ship-row__label">Ongkos Kirim</span>
                            <span class="pay-ship-row__value pay-ship-row__value--accent">Rp {{ number_format($penjualan->ongkos_kirim, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                {{-- Trust --}}
                <div class="pay-trust">
                    <div class="pay-trust__item">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" stroke="#2B5FC1" stroke-width="1.5" stroke-linejoin="round"/></svg>
                        <span>Transaksi aman &amp; terenkripsi</span>
                    </div>
                    <div class="pay-trust__item">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M5 12l5 5L20 7" stroke="#2B5FC1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        <span>Produk terjamin keasliannya</span>
                    </div>
                    <div class="pay-trust__item">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z" stroke="#2B5FC1" stroke-width="1.5" stroke-linejoin="round"/><polyline points="9 22 9 12 15 12 15 22" stroke="#2B5FC1" stroke-width="1.5" stroke-linejoin="round"/></svg>
                        <span>Dikirim ke seluruh Indonesia</span>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

{{-- ===== Styles ===== --}}
<style>
  :root {
    --pl-blue-100:  #D6E4FB;
    --pl-blue-300:  #7AAAF0;
    --pl-blue-400:  #4476D9;
    --pl-blue-500:  #2B5FC1;
    --pl-blue-700:  #1A3A7A;
    --pl-green:     #1B7A4A;
    --pl-green-bg:  #EAF7EF;
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
  .pay-hero {
    background: var(--pl-ink);
    padding: 60px 0 48px;
    position: relative;
    overflow: hidden;
  }

  .pay-hero__orb {
    position: absolute;
    border-radius: 50%;
    pointer-events: none;
  }

  .pay-hero__orb--1 {
    width: 520px; height: 520px;
    background: radial-gradient(circle, rgba(43,95,193,.35) 0%, transparent 70%);
    top: -200px; right: -100px;
  }

  .pay-hero__orb--2 {
    width: 360px; height: 360px;
    background: radial-gradient(circle, rgba(68,118,217,.2) 0%, transparent 70%);
    bottom: -120px; left: -80px;
  }

  .pay-hero__inner {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    gap: 14px;
  }

  .pay-hero__eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: .14em;
    text-transform: uppercase;
    color: var(--pl-blue-300);
  }

  .pay-hero__eyebrow-line {
    display: inline-block;
    width: 18px; height: 2px;
    background: var(--pl-blue-400);
    border-radius: 2px;
  }

  .pay-hero__title {
    font-family: 'Lora', serif;
    font-size: clamp(26px, 4vw, 40px);
    font-weight: 600;
    color: #fff;
    margin: 0;
    letter-spacing: -.02em;
    line-height: 1.2;
  }

  .pay-hero__title-accent {
    color: var(--pl-blue-300);
    font-style: italic;
  }

  .pay-hero__desc {
    font-size: 15px;
    font-weight: 300;
    color: rgba(255,255,255,.58);
    margin: 0;
    max-width: 460px;
    line-height: 1.65;
  }

  .pay-hero__badges {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 10px;
    margin-top: 4px;
  }

  .pay-hero__badge {
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

  .pay-hero__badge i { font-size: 11px; }

  /* ── Main ── */
  .pay-main {
    background: var(--pl-bg);
    padding: 40px 0 70px;
    position: relative;
    overflow: hidden;
  }

  .pay-main::before {
    content: '';
    position: absolute;
    width: 500px; height: 500px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(43,95,193,.07) 0%, transparent 70%);
    top: -200px; right: -140px;
    pointer-events: none;
  }

  .pay-main::after {
    content: '';
    position: absolute;
    width: 350px; height: 350px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(43,95,193,.05) 0%, transparent 70%);
    bottom: -80px; left: -80px;
    pointer-events: none;
  }

  .pay-main .container { position: relative; z-index: 1; }

  /* ── Layout ── */
  .pay-layout {
    display: grid;
    grid-template-columns: 1fr 300px;
    gap: 20px;
    align-items: start;
  }

  /* ── Alerts ── */
  .pay-alert {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 13px 18px;
    border-radius: var(--pl-radius-sm);
    font-size: 14px;
    margin-bottom: 20px;
    position: relative;
  }

  .pay-alert--success { background: var(--pl-green-bg); color: var(--pl-green); border: 1px solid #b2dfce; }
  .pay-alert--danger  { background: #fff0f0; color: #b91c1c; border: 1px solid #fca5a5; }

  .pay-alert__close {
    margin-left: auto;
    background: none;
    border: none;
    font-size: 18px;
    cursor: pointer;
    color: inherit;
    opacity: .6;
    line-height: 1;
  }

  .pay-alert__close:hover { opacity: 1; }

  /* ── Card ── */
  .pay-card {
    background: var(--pl-surface);
    border-radius: var(--pl-radius);
    border: 1.5px solid var(--pl-border);
    box-shadow: var(--pl-shadow);
    overflow: hidden;
  }

  .pay-card--animated { animation: paySlideIn .4s ease both; }

  @keyframes paySlideIn {
    from { opacity: 0; transform: translateY(12px); }
    to   { opacity: 1; transform: translateY(0); }
  }

  .pay-card__header {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 15px 22px;
    background: var(--pl-blue-100);
    border-bottom: 1px solid var(--pl-border);
    font-size: 13px;
    font-weight: 700;
    color: var(--pl-blue-700);
    letter-spacing: .03em;
  }

  .pay-card__header--green {
    background: var(--pl-green-bg);
    border-bottom-color: #b2dfce;
    color: var(--pl-green);
  }

  .pay-card__header-icon { font-size: 14px; }

  .pay-card__body { padding: 20px 22px; }
  .pay-card__body--flush { padding: 0; }

  /* ── Invoice Meta ── */
  .pay-meta-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
  }

  .pay-meta-item { display: flex; flex-direction: column; gap: 4px; }

  .pay-meta-item__label {
    font-size: 11px;
    font-weight: 700;
    color: var(--pl-ink-3);
    text-transform: uppercase;
    letter-spacing: .08em;
  }

  .pay-meta-item__value {
    font-size: 14px;
    font-weight: 600;
    color: var(--pl-ink);
  }

  .pay-meta-item__value--accent { color: var(--pl-blue-500); }

  .pay-status-badge {
    display: inline-flex;
    align-items: center;
    padding: 4px 12px;
    border-radius: 100px;
    background: #fff5e6;
    color: #b45309;
    font-size: 12px;
    font-weight: 700;
    align-self: flex-start;
  }

  /* ── Table ── */
  .pay-table-wrap { overflow-x: auto; }

  .pay-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 13px;
  }

  .pay-table thead th {
    padding: 12px 18px;
    background: #f0f5fd;
    color: var(--pl-ink-3);
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .08em;
    border-bottom: 1px solid var(--pl-border);
    white-space: nowrap;
  }

  .pay-table tbody tr {
    border-bottom: 1px solid var(--pl-border);
    transition: background .15s;
  }

  .pay-table tbody tr:last-child { border-bottom: none; }
  .pay-table tbody tr:hover { background: #f8faff; }

  .pay-table tbody td {
    padding: 14px 18px;
    color: var(--pl-ink);
    vertical-align: middle;
  }

  .pay-table__foot-row td {
    padding: 10px 18px;
    color: var(--pl-ink-3);
    font-size: 13px;
    border-top: 1px solid var(--pl-border);
  }

  .pay-table__total-row td {
    padding: 13px 18px;
    background: var(--pl-blue-100);
    color: var(--pl-blue-700);
    font-weight: 700;
    font-size: 15px;
  }

  .pay-product {
    display: flex;
    align-items: center;
    gap: 12px;
  }

  .pay-product__img-wrap {
    width: 52px; height: 52px;
    border-radius: 10px;
    overflow: hidden;
    border: 1px solid var(--pl-border);
    background: var(--pl-blue-100);
    flex-shrink: 0;
  }

  .pay-product__img {
    width: 100%; height: 100%;
    object-fit: cover;
  }

  .pay-product__name {
    font-size: 13px;
    font-weight: 600;
    color: var(--pl-ink);
  }

  .pay-product__cat {
    font-size: 11px;
    color: var(--pl-ink-3);
    margin-top: 2px;
  }

  /* ── Sidebar ── */
  .pay-sidebar { display: flex; flex-direction: column; gap: 14px; }

  /* Midtrans label */
  .pay-midtrans-label {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
    font-weight: 700;
    color: var(--pl-blue-500);
    margin-bottom: 6px;
  }

  .pay-midtrans-desc {
    font-size: 13px;
    color: var(--pl-ink-3);
    margin: 0 0 14px;
  }

  /* Manual payment */
  .pay-manual-title {
    font-size: 15px;
    font-weight: 700;
    color: var(--pl-ink);
    margin-bottom: 12px;
  }

  .pay-rekening-label {
    font-size: 11px;
    font-weight: 700;
    color: var(--pl-ink-3);
    text-transform: uppercase;
    letter-spacing: .08em;
    margin-bottom: 6px;
  }

  .pay-rekening-box {
    background: var(--pl-blue-100);
    border: 1.5px solid var(--pl-border);
    border-radius: var(--pl-radius-sm);
    padding: 12px 16px;
    text-align: center;
    font-size: 18px;
    font-weight: 800;
    color: var(--pl-blue-700);
    letter-spacing: .06em;
    margin-bottom: 14px;
  }

  .pay-manual-place {
    display: flex;
    flex-direction: column;
    gap: 3px;
    font-size: 13px;
    color: var(--pl-ink);
    margin-bottom: 14px;
  }

  .pay-manual-place__label {
    font-size: 11px;
    font-weight: 700;
    color: var(--pl-ink-3);
    text-transform: uppercase;
    letter-spacing: .08em;
  }

  /* Info boxes */
  .pay-info {
    display: flex;
    gap: 9px;
    padding: 12px 14px;
    border-radius: var(--pl-radius-sm);
    font-size: 12px;
    line-height: 1.55;
    margin-bottom: 4px;
  }

  .pay-info i { flex-shrink: 0; margin-top: 2px; }

  .pay-info--blue   { background: #f0f5fd; color: var(--pl-blue-700); border: 1px solid var(--pl-blue-100); }
  .pay-info--warning { background: #fff9ec; color: #92400e; border: 1px solid #fde68a; }

  .pay-method-tag {
    margin-top: 12px;
    padding: 10px 14px;
    border-radius: var(--pl-radius-sm);
    background: #f0f5fd;
    border: 1px solid var(--pl-border);
    font-size: 12px;
    color: var(--pl-ink-3);
  }

  /* Buttons */
  .pay-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    padding: 13px;
    border-radius: var(--pl-radius-sm);
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    border: none;
    text-decoration: none;
    transition: background .2s, transform .12s, box-shadow .2s, color .2s;
    letter-spacing: .01em;
  }

  .pay-btn--primary {
    background: var(--pl-blue-500);
    color: #fff;
    box-shadow: 0 4px 14px rgba(43,95,193,.35);
  }

  .pay-btn--primary:hover {
    background: var(--pl-blue-700);
    color: #fff;
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(43,95,193,.45);
  }

  .pay-btn--green {
    background: var(--pl-green);
    color: #fff;
    box-shadow: 0 4px 14px rgba(27,122,74,.28);
  }

  .pay-btn--green:hover {
    background: #145c38;
    color: #fff;
    transform: translateY(-1px);
  }

  .pay-btn--danger {
    background: #dc2626;
    color: #fff;
    box-shadow: 0 4px 14px rgba(220,38,38,.25);
  }

  .pay-btn--danger:hover {
    background: #b91c1c;
    color: #fff;
    transform: translateY(-1px);
  }

  .pay-btn--outline {
    background: none;
    color: var(--pl-ink-3);
    border: 1.5px solid var(--pl-border);
  }

  .pay-btn--outline:hover {
    background: #f0f5fd;
    color: var(--pl-blue-700);
    border-color: var(--pl-blue-400);
  }

  .pay-btn:active { transform: scale(0.98) !important; }

  /* Shipping rows */
  .pay-ship-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 9px 0;
    border-bottom: 1px solid var(--pl-border);
    font-size: 13px;
  }

  .pay-ship-row:last-child { border-bottom: none; }

  .pay-ship-row__label {
    font-size: 11px;
    font-weight: 700;
    color: var(--pl-ink-3);
    text-transform: uppercase;
    letter-spacing: .08em;
  }

  .pay-ship-row__value { font-weight: 600; color: var(--pl-ink); }
  .pay-ship-row__value--accent { color: var(--pl-blue-500); }

  /* Trust */
  .pay-trust {
    background: var(--pl-surface);
    border-radius: 14px;
    border: 1.5px solid var(--pl-border);
    padding: 14px 18px;
    box-shadow: 0 2px 8px rgba(12,30,69,.04);
  }

  .pay-trust__item {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 12px;
    color: var(--pl-ink-3);
    padding: 7px 0;
    border-bottom: 1px solid var(--pl-border);
    transition: color .15s;
  }

  .pay-trust__item:last-child { border-bottom: none; }
  .pay-trust__item:hover { color: var(--pl-ink); }

  /* ── Responsive ── */
  @media (max-width: 860px) {
    .pay-layout { grid-template-columns: 1fr; }
    .pay-hero { padding: 44px 0 36px; }
  }

  @media (max-width: 540px) {
    .pay-meta-grid { grid-template-columns: 1fr; }
    .pay-hero__badges { flex-direction: column; align-items: center; }
  }
</style>

{{-- Midtrans Snap Script --}}
@if($penjualan->snap_token)
    @php
        $snapJsUrl = config('midtrans.is_production')
            ? 'https://app.midtrans.com/snap/snap.js'
            : 'https://app.sandbox.midtrans.com/snap/snap.js';
    @endphp
    <script src="{{ $snapJsUrl }}" data-client-key="{{ config('midtrans.client_key') }}"></script>
    <script>
        document.getElementById('pay-button').onclick = function () {
            fetch('{{ route('payment.link', $penjualan->id) }}?ajax=1', {
                headers: { 'Accept': 'application/json' }
            })
            .then(response => response.json())
            .then(data => {
                if (data.snap_token) {
                    snap.pay(data.snap_token, {
                        onSuccess: function () {
                            window.location.href = '{{ route("payment.success", $penjualan->id) }}';
                        },
                        onPending: function () {
                            window.location.href = '{{ route("payment.show", $penjualan->id) }}';
                        },
                        onError: function () {
                            alert('Pembayaran gagal. Silakan coba lagi.');
                        }
                    });
                } else {
                    alert('Gagal membuat token pembayaran.');
                }
            })
            .catch(() => alert('Terjadi kesalahan.'));
        };
    </script>
@endif

@endsection
