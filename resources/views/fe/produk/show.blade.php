@extends('fe.master')
@section('navbar')
    @include('fe.navbar')
@endsection

@section('single-produk')

<style>
/* ══ PRODUCT DETAIL — Blue Apotik Theme (Self Contained) ══ */

.pd-breadcrumb {
    background: linear-gradient(135deg, #1A3A7A 0%, #2B5FC1 60%, #4A90D9 100%);
    padding: 48px 0 44px;
    position: relative;
    overflow: hidden;
}
.pd-breadcrumb::before {
    content: '';
    position: absolute;
    width: 380px; height: 380px;
    border-radius: 50%;
    background: rgba(255,255,255,.06);
    top: -140px; right: -60px;
    pointer-events: none;
}
.pd-bc-inner {
    position: relative;
    z-index: 1;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.pd-bc-inner h2 {
    font-family: 'Lora', serif;
    font-size: clamp(24px, 3.5vw, 36px);
    font-weight: 600;
    color: #fff;
    letter-spacing: -.02em;
    margin-bottom: 8px;
}
.pd-bc-nav {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    color: rgba(255,255,255,.7);
}
.pd-bc-nav a { color: rgba(255,255,255,.9); text-decoration: none; }
.pd-bc-nav a:hover { color: #fff; }
.pd-bc-nav .sep { opacity: .5; }
.pd-bc-nav .cur { color: #D6E4FB; }
.pd-bc-pill {
    display: flex;
    align-items: center;
    gap: 9px;
    background: rgba(255,255,255,.12);
    border: 1px solid rgba(255,255,255,.22);
    padding: 10px 20px;
    border-radius: 100px;
    color: rgba(255,255,255,.88);
    font-size: 13px;
    font-weight: 600;
}
.pd-bc-pill i { color: #D6E4FB; }

/* ── Section ── */
.pd-section {
    background: #EEF3FB;
    padding: 40px 0 72px;
}
.pd-section .container { max-width: 1080px; }

/* ── Main Card ── */
.pd-card {
    background: #fff;
    border-radius: 20px;
    border: 1.5px solid #D0DDEF;
    display: grid;
    grid-template-columns: 1fr 1fr;
    overflow: hidden;
    box-shadow: 0 4px 24px rgba(43,95,193,.07);
    animation: pdFadeUp .4s ease both;
}
@keyframes pdFadeUp {
    from { opacity: 0; transform: translateY(14px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* ── Image Side ── */
.pd-images {
    padding: 32px 28px;
    background: #EEF3FB;
    border-right: 1.5px solid #D0DDEF;
    display: flex;
    flex-direction: column;
    gap: 14px;
}
.pd-main-img {
    width: 100%;
    aspect-ratio: 1;
    border-radius: 14px;
    overflow: hidden;
    background: #fff;
    border: 1.5px solid #D0DDEF;
    display: flex;
    align-items: center;
    justify-content: center;
}
.pd-main-img-el {
    width: 100%; height: 100%;
    object-fit: contain;
    transition: opacity .22s ease;
}
.pd-thumbs { display: flex; gap: 10px; }
.pd-thumb {
    width: 62px; height: 62px;
    border-radius: 10px;
    overflow: hidden;
    border: 2px solid #D0DDEF;
    cursor: pointer;
    background: #fff;
    transition: border-color .16s;
    flex-shrink: 0;
}
.pd-thumb img { width: 100%; height: 100%; object-fit: cover; }
.pd-thumb.active, .pd-thumb:hover { border-color: #2B5FC1; }

/* ── Info Side ── */
.pd-info {
    padding: 32px;
    display: flex;
    flex-direction: column;
}
.pd-badges { display: flex; gap: 8px; margin-bottom: 14px; }
.pd-badge {
    font-size: 11px;
    font-weight: 700;
    padding: 4px 12px;
    border-radius: 100px;
}
.pd-badge-cat { background: #D6E4FB; color: #1A3A7A; }
.pd-badge-stock { background: rgba(29,158,117,.12); color: #0F6E56; }
.pd-badge-empty { background: rgba(226,75,74,.1); color: #A32D2D; }

.pd-name {
    font-family: 'Lora', serif;
    font-size: clamp(20px, 2.5vw, 26px);
    font-weight: 600;
    color: #0C1E45;
    line-height: 1.25;
    margin: 0 0 10px;
    letter-spacing: -.02em;
}
.pd-price {
    font-size: 24px;
    font-weight: 800;
    color: #2B5FC1;
    margin-bottom: 18px;
    letter-spacing: -.02em;
}
.pd-divider {
    height: 1.5px;
    background: #EEF3FB;
    margin: 16px 0;
}
.pd-block-label {
    font-size: 10px;
    font-weight: 700;
    color: #4476D9;
    text-transform: uppercase;
    letter-spacing: .1em;
    margin-bottom: 7px;
}
.pd-desc-text {
    font-size: 13.5px;
    color: #7A8CAD;
    line-height: 1.75;
    margin: 0 0 18px;
}

/* Meta Grid */
.pd-meta-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 9px;
}
.pd-meta-item {
    background: #EEF3FB;
    border-radius: 10px;
    padding: 10px 14px;
    display: flex;
    flex-direction: column;
    gap: 3px;
}
.pd-meta-key { font-size: 11px; color: #7A8CAD; font-weight: 500; }
.pd-meta-val { font-size: 13px; color: #0C1E45; font-weight: 700; }

/* Qty */
.pd-atc-row {
    display: flex;
    align-items: flex-end;
    gap: 20px;
    margin-bottom: 14px;
}
.pd-qty-label {
    font-size: 10px;
    font-weight: 700;
    color: #7A8CAD;
    margin-bottom: 7px;
    text-transform: uppercase;
    letter-spacing: .06em;
}
.pd-qty-ctrl {
    display: inline-flex;
    align-items: center;
    border: 1.5px solid #D0DDEF;
    border-radius: 10px;
    overflow: hidden;
    background: #fff;
}
.pd-qty-btn {
    width: 36px; height: 36px;
    background: none; border: none;
    color: #7A8CAD; font-size: 18px;
    cursor: pointer;
    transition: background .14s, color .14s;
    line-height: 1;
}
.pd-qty-btn:hover { background: #D6E4FB; color: #2B5FC1; }
.pd-qty-input {
    width: 50px; height: 36px;
    border: none;
    border-left: 1px solid #D0DDEF;
    border-right: 1px solid #D0DDEF;
    text-align: center;
    font-size: 14px; font-weight: 700;
    color: #0C1E45;
    background: transparent;
    outline: none;
    font-family: 'Plus Jakarta Sans', sans-serif;
    -moz-appearance: textfield;
}
.pd-qty-input::-webkit-outer-spin-button,
.pd-qty-input::-webkit-inner-spin-button { -webkit-appearance: none; }
.pd-total-block { flex: 1; }
.pd-total-val { font-size: 18px; font-weight: 800; color: #2B5FC1; }

/* Action buttons */
.pd-action-row { display: flex; gap: 10px; }
.pd-btn-primary {
    flex: 1;
    padding: 13px 20px;
    border-radius: 12px;
    background: #2B5FC1;
    color: #fff;
    font-size: 14px; font-weight: 700;
    border: none; cursor: pointer;
    text-align: center;
    font-family: 'Plus Jakarta Sans', sans-serif;
    transition: background .18s, transform .12s, box-shadow .18s;
    box-shadow: 0 4px 16px rgba(43,95,193,.3);
}
.pd-btn-primary:hover {
    background: #1A3A7A;
    transform: translateY(-1px);
    box-shadow: 0 7px 22px rgba(43,95,193,.38);
}
.pd-btn-primary:active { transform: scale(0.98); }
.pd-btn-secondary {
    padding: 13px 20px;
    border-radius: 12px;
    border: 1.5px solid #D0DDEF;
    background: none;
    color: #7A8CAD;
    font-size: 14px; font-weight: 600;
    text-decoration: none;
    white-space: nowrap;
    transition: all .14s;
    display: inline-flex;
    align-items: center;
}
.pd-btn-secondary:hover {
    background: #D6E4FB;
    color: #2B5FC1;
    border-color: #4476D9;
}
.pd-out-of-stock {
    padding: 14px 18px;
    border-radius: 10px;
    background: #fff4f4;
    border: 1px solid #fcd6d6;
    color: #c62828;
    font-size: 13px; font-weight: 600;
    margin-bottom: 12px;
}
.pd-footer-meta {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
    margin-top: 16px;
    padding-top: 14px;
    border-top: 1.5px solid #EEF3FB;
    font-size: 12px;
    color: #7A8CAD;
}
.pd-footer-meta strong { color: #0C1E45; }

/* ── Related Products ── */
.pd-related { margin-top: 32px; animation: pdFadeUp .4s ease .15s both; }
.pd-related-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 16px;
}
.pd-related-title {
    font-family: 'Lora', serif;
    font-size: 20px;
    font-weight: 600;
    color: #0C1E45;
    margin: 0;
}
.pd-related-all { font-size: 13px; color: #2B5FC1; text-decoration: none; font-weight: 600; }
.pd-related-all:hover { color: #1A3A7A; }
.pd-related-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; }
.pd-related-card {
    background: #fff;
    border-radius: 14px;
    border: 1.5px solid #D0DDEF;
    overflow: hidden;
    text-decoration: none;
    display: flex;
    flex-direction: column;
    transition: transform .18s, box-shadow .18s, border-color .18s;
    position: relative;
}
.pd-related-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 28px rgba(43,95,193,.14);
    border-color: #7AAAF0;
}
.pd-related-img { width: 100%; aspect-ratio: 1; overflow: hidden; background: #EEF3FB; }
.pd-related-img img { width: 100%; height: 100%; object-fit: cover; transition: transform .3s; }
.pd-related-card:hover .pd-related-img img { transform: scale(1.05); }
.pd-related-info { padding: 12px 14px; }
.pd-related-name {
    font-size: 13px; font-weight: 700; color: #0C1E45;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    line-height: 1.4; margin-bottom: 5px;
}
.pd-related-price { font-size: 13px; font-weight: 800; color: #2B5FC1; }
.pd-related-hover {
    position: absolute; bottom: 0; left: 0; right: 0;
    padding: 10px;
    background: #2B5FC1;
    color: #fff;
    font-size: 12px; font-weight: 600;
    text-align: center;
    transform: translateY(100%);
    transition: transform .2s;
}
.pd-related-card:hover .pd-related-hover { transform: translateY(0); }

/* ── Responsive ── */
@media (max-width: 780px) {
    .pd-card { grid-template-columns: 1fr; }
    .pd-images { border-right: none; border-bottom: 1.5px solid #D0DDEF; padding: 24px; }
    .pd-info { padding: 24px; }
    .pd-related-grid { grid-template-columns: repeat(2, 1fr); }
    .pd-bc-pill { display: none; }
}
@media (max-width: 480px) {
    .pd-atc-row { flex-direction: column; align-items: flex-start; }
    .pd-action-row { flex-direction: column; }
    .pd-btn-secondary { text-align: center; justify-content: center; }
}
</style>

{{-- ── BREADCRUMB ── --}}
<section class="pd-breadcrumb">
    <div class="container">
        <div class="pd-bc-inner">
            <div>
                <h2>Detail Produk</h2>
                <nav class="pd-bc-nav">
                    <a href="{{ url('/') }}">
                        <i class="fas fa-home" style="font-size:11px;margin-right:3px;"></i>Beranda
                    </a>
                    <span class="sep">›</span>
                    <a href="{{ route('products.index') }}">Daftar Produk</a>
                    <span class="sep">›</span>
                    <span class="cur">{{ Str::limit($product->nama_obat, 30) }}</span>
                </nav>
            </div>
            <div class="pd-bc-pill">
                <i class="fas fa-pills"></i>
                Apotek ClouPills
            </div>
        </div>
    </div>
</section>

{{-- ── PRODUCT DETAIL ── --}}
<section class="pd-section">
    <div class="container">

        {{-- Main Card --}}
        <div class="pd-card">

            {{-- LEFT: Images --}}
            <div class="pd-images">
                <div class="pd-main-img" id="mainImgWrap">
                    <img src="{{ asset('storage/obat/'.$product->foto1) }}"
                         alt="{{ $product->nama_obat }}"
                         id="mainImg" class="pd-main-img-el" />
                </div>
                <div class="pd-thumbs">
                    @if($product->foto1)
                    <div class="pd-thumb active"
                         onclick="pdSwitchImg(this, '{{ asset('storage/obat/'.$product->foto1) }}')">
                        <img src="{{ asset('storage/obat/'.$product->foto1) }}" alt="foto 1">
                    </div>
                    @endif
                    @if($product->foto2)
                    <div class="pd-thumb"
                         onclick="pdSwitchImg(this, '{{ asset('storage/obat/'.$product->foto2) }}')">
                        <img src="{{ asset('storage/obat/'.$product->foto2) }}" alt="foto 2">
                    </div>
                    @endif
                    @if($product->foto3)
                    <div class="pd-thumb"
                         onclick="pdSwitchImg(this, '{{ asset('storage/obat/'.$product->foto3) }}')">
                        <img src="{{ asset('storage/obat/'.$product->foto3) }}" alt="foto 3">
                    </div>
                    @endif
                </div>
            </div>

            {{-- RIGHT: Info --}}
            <div class="pd-info">

                <div class="pd-badges">
                    <span class="pd-badge pd-badge-cat">{{ $product->jenisObat->jenis }}</span>
                    @if($product->stok > 0)
                        <span class="pd-badge pd-badge-stock">Tersedia</span>
                    @else
                        <span class="pd-badge pd-badge-empty">Habis</span>
                    @endif
                </div>

                <h1 class="pd-name">{{ $product->nama_obat }}</h1>
                <div class="pd-price">Rp {{ number_format($product->harga_jual, 0, ',', '.') }}</div>

                <div class="pd-divider"></div>

                <div class="pd-block-label">Deskripsi Produk</div>
                <p class="pd-desc-text">
                    {{ $product->deskripsi_obat ?? $product->deskripsi ?? 'Tidak ada deskripsi tersedia.' }}
                </p>

                <div class="pd-meta-grid">
                    <div class="pd-meta-item">
                        <span class="pd-meta-key">Nama Obat</span>
                        <span class="pd-meta-val">{{ $product->nama_obat }}</span>
                    </div>
                    <div class="pd-meta-item">
                        <span class="pd-meta-key">Jenis Obat</span>
                        <span class="pd-meta-val">{{ $product->jenisObat->jenis }}</span>
                    </div>
                    <div class="pd-meta-item">
                        <span class="pd-meta-key">Harga Jual</span>
                        <span class="pd-meta-val">Rp {{ number_format($product->harga_jual, 0, ',', '.') }}</span>
                    </div>
                    <div class="pd-meta-item">
                        <span class="pd-meta-key">Stok</span>
                        <span class="pd-meta-val">{{ $product->stok }} pcs</span>
                    </div>
                </div>

                <div class="pd-divider"></div>

                @if($product->stok > 0)
                <form action="{{ route('cart.store') }}" method="POST" id="add-to-cart-form">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" id="unitPrice" value="{{ $product->harga_jual }}">

                    <div class="pd-atc-row">
                        <div>
                            <div class="pd-qty-label">Jumlah</div>
                            <div class="pd-qty-ctrl">
                                <button type="button" class="pd-qty-btn"
                                        onclick="pdDecQty()">−</button>
                                <input type="number" class="pd-qty-input" id="quantity"
                                       name="quantity" value="1" min="1"
                                       max="{{ $product->stok }}" step="1"
                                       oninput="pdUpdateTotal()"
                                       onkeydown="return event.key !== 'e' && event.key !== 'E' && event.key !== '+' && event.key !== '-'">
                                <button type="button" class="pd-qty-btn"
                                        onclick="pdIncQty({{ $product->stok }})">+</button>
                            </div>
                        </div>
                        <div class="pd-total-block">
                            <div class="pd-qty-label">Total Harga</div>
                            <div class="pd-total-val" id="totalPrice">
                                Rp {{ number_format($product->harga_jual, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>

                    <div class="pd-action-row">
                        <button type="submit" class="pd-btn-primary">
                            <i class="fas fa-shopping-bag" style="margin-right:7px;"></i>
                            Tambah ke Keranjang
                        </button>
                        <a href="{{ route('cart.index') }}" class="pd-btn-secondary">
                            Lihat Keranjang
                        </a>
                    </div>
                </form>
                @else
                <div class="pd-out-of-stock">
                    <i class="fas fa-exclamation-circle" style="margin-right:7px;"></i>
                    Stok habis — produk tidak tersedia saat ini
                </div>
                @endif

                <div class="pd-footer-meta">
                    <span>Kode Produk: <strong>#{{ $product->id }}</strong></span>
                    <span>Diperbarui: <strong>{{ $product->updated_at->format('d M Y') }}</strong></span>
                </div>

            </div>
        </div>

        {{-- Related Products --}}
        @if($relatedProducts->count() > 0)
        <div class="pd-related">
            <div class="pd-related-header">
                <h3 class="pd-related-title">Produk Terkait</h3>
                <a href="{{ route('products.index') }}" class="pd-related-all">Lihat semua →</a>
            </div>
            <div class="pd-related-grid">
                @foreach($relatedProducts as $related)
                <a href="{{ route('products.show', $related->id) }}" class="pd-related-card">
                    <div class="pd-related-img">
                        <img src="{{ asset('storage/obat/'.$related->foto1) }}"
                             alt="{{ $related->nama_obat }}">
                    </div>
                    <div class="pd-related-info">
                        <div class="pd-related-name">{{ $related->nama_obat }}</div>
                        <div class="pd-related-price">
                            Rp {{ number_format($related->harga_jual, 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="pd-related-hover">Lihat Produk</div>
                </a>
                @endforeach
            </div>
        </div>
        @endif

    </div>
</section>

<script>
function pdFormatCurrency(val) {
    return 'Rp ' + Number(val).toLocaleString('id-ID');
}
function pdUpdateTotal() {
    const q = document.getElementById('quantity');
    const up = document.getElementById('unitPrice');
    const tp = document.getElementById('totalPrice');
    if (!q || !up || !tp) return;
    let v = parseInt(q.value);
    if (isNaN(v) || v < 1) v = 1;
    const max = parseInt(q.max);
    if (!isNaN(max) && v > max) v = max;
    q.value = v;
    tp.innerText = pdFormatCurrency(parseFloat(up.value) * v);
}
function pdIncQty(max) {
    const q = document.getElementById('quantity');
    q.value = Math.min(max, (parseInt(q.value) || 1) + 1);
    pdUpdateTotal();
}
function pdDecQty() {
    const q = document.getElementById('quantity');
    const v = parseInt(q.value) || 1;
    q.value = v <= 1 ? 1 : v - 1;
    pdUpdateTotal();
}
function pdSwitchImg(el, src) {
    document.querySelectorAll('.pd-thumb').forEach(t => t.classList.remove('active'));
    el.classList.add('active');
    const m = document.getElementById('mainImg');
    m.style.opacity = '0';
    setTimeout(() => { m.src = src; m.style.opacity = '1'; }, 180);
}
document.addEventListener('DOMContentLoaded', function () {
    const m = document.getElementById('mainImg');
    if (m) m.style.transition = 'opacity .22s ease';
    const q = document.getElementById('quantity');
    if (q) {
        q.addEventListener('input', pdUpdateTotal);
        q.addEventListener('change', pdUpdateTotal);
        pdUpdateTotal();
    }
});
</script>

@endsection
