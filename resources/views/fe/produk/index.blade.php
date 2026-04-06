@extends('fe.master')
@section('navbar')
    @include('fe.navbar')
@endsection

@section('produk-list')

<style>
/* ══ PRODUCT LIST — Self Contained ══ */
.pl-breadcrumb {
    background: linear-gradient(135deg, #1A3A7A 0%, #2B5FC1 60%, #4A90D9 100%);
    padding: 52px 0 48px;
    position: relative;
    overflow: hidden;
}
.pl-breadcrumb::before {
    content: '';
    position: absolute;
    width: 380px; height: 380px;
    border-radius: 50%;
    background: rgba(255,255,255,.06);
    top: -140px; right: -60px;
    pointer-events: none;
}
.pl-breadcrumb::after {
    content: '';
    position: absolute;
    width: 200px; height: 200px;
    border-radius: 50%;
    background: rgba(255,255,255,.04);
    bottom: -50px; left: 80px;
    pointer-events: none;
}
.pl-bc-inner {
    position: relative;
    z-index: 1;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.pl-bc-left h2 {
    font-size: clamp(26px, 4vw, 38px);
    font-weight: 700;
    color: #fff;
    letter-spacing: -.02em;
    margin-bottom: 8px;
    font-family: 'Lora', serif;
}
.pl-bc-nav {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    color: rgba(255,255,255,.7);
}
.pl-bc-nav a { color: rgba(255,255,255,.9); text-decoration: none; }
.pl-bc-nav a:hover { color: #fff; }
.pl-bc-nav .sep { opacity: .5; font-size: 10px; }
.pl-bc-nav .cur { color: #D6E4FB; }
.pl-bc-pill {
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
.pl-bc-pill i { color: #D6E4FB; }

/* ── Section wrapper ── */
.pl-section {
    background: #EEF3FB;
    padding: 48px 0 80px;
    min-height: 60vh;
}
.pl-section .container { max-width: 1200px; }

/* ── Grid ── */
.pl-grid {
    display: grid;
    grid-template-columns: 270px 1fr;
    gap: 28px;
    align-items: start;
}

/* ── SIDEBAR ── */
.pl-sidebar {
    display: flex;
    flex-direction: column;
    gap: 18px;
    position: sticky;
    top: 24px;
}

/* Search */
.pl-search-box {
    background: #fff;
    border: 1.5px solid #D0DDEF;
    border-radius: 14px;
    padding: 14px 16px;
}
.pl-search-box form {
    display: flex;
    gap: 8px;
    align-items: center;
}
.pl-search-box input {
    flex: 1;
    border: 1.5px solid #D0DDEF;
    border-radius: 10px;
    padding: 9px 14px;
    font-size: 13px;
    color: #0C1E45;
    outline: none;
    font-family: inherit;
    background: #EEF3FB;
    transition: border .2s;
}
.pl-search-box input:focus { border-color: #4476D9; background: #fff; }
.pl-search-box input::placeholder { color: #7A8CAD; }
.pl-search-box button {
    padding: 9px 18px;
    background: #2B5FC1;
    color: #fff;
    border: none;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    font-family: inherit;
    transition: background .2s;
    white-space: nowrap;
}
.pl-search-box button:hover { background: #1A3A7A; }

/* Stats */
.pl-stats-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
}
.pl-stat-mini {
    background: #D6E4FB;
    border-radius: 12px;
    padding: 14px 16px;
}
.pl-stat-mini__num {
    font-size: 22px;
    font-weight: 800;
    color: #1A3A7A;
    line-height: 1;
}
.pl-stat-mini__label {
    font-size: 11px;
    color: #2B5FC1;
    margin-top: 4px;
    font-weight: 600;
}

/* Category card */
.pl-cat-card {
    background: #fff;
    border: 1.5px solid #D0DDEF;
    border-radius: 14px;
    overflow: hidden;
}
.pl-cat-card__head {
    padding: 14px 18px;
    border-bottom: 1.5px solid #D0DDEF;
    display: flex;
    align-items: center;
    gap: 10px;
    background: #fff;
}
.pl-cat-card__head-icon {
    width: 30px; height: 30px;
    border-radius: 8px;
    background: #D6E4FB;
    display: flex; align-items: center; justify-content: center;
}
.pl-cat-card__head-icon i { font-size: 12px; color: #2B5FC1; }
.pl-cat-card__head span { font-size: 13px; font-weight: 700; color: #0C1E45; }
.pl-cat-card__list { padding: 6px 0; }
.pl-cat-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 18px;
    font-size: 13px;
    color: #3A4E72;
    text-decoration: none;
    transition: background .15s;
    border-left: 3px solid transparent;
}
.pl-cat-item:hover {
    background: #EEF3FB;
    color: #2B5FC1;
    text-decoration: none;
}
.pl-cat-item.active {
    background: #D6E4FB;
    color: #2B5FC1;
    font-weight: 700;
    border-left-color: #2B5FC1;
}
.pl-cat-dot {
    width: 6px; height: 6px;
    border-radius: 50%;
    background: #7AAAF0;
    flex-shrink: 0;
}
.pl-cat-item.active .pl-cat-dot { background: #2B5FC1; }

/* ── Main header ── */
.pl-main-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    margin-bottom: 24px;
    flex-wrap: wrap;
    gap: 12px;
}
.pl-main-header h3 {
    font-family: 'Lora', serif;
    font-size: 24px;
    font-weight: 600;
    color: #0C1E45;
    letter-spacing: -.01em;
    margin: 0;
}
.pl-main-header p { font-size: 13px; color: #7A8CAD; margin: 4px 0 0; }

/* ── Product Grid ── */
.pl-products {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 18px;
}

/* ── Single Product Card ── */
.pl-product-card {
    background: #fff;
    border: 1.5px solid #D0DDEF;
    border-radius: 16px;
    overflow: hidden;
    transition: transform .22s ease, box-shadow .22s ease, border-color .2s;
    display: flex;
    flex-direction: column;
}
.pl-product-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 32px rgba(43,95,193,.15);
    border-color: #7AAAF0;
}

/* Image */
.pl-product-card__img {
    position: relative;
    aspect-ratio: 1 / 1;
    overflow: hidden;
    background: #EEF3FB;
}
.pl-product-card__img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: transform .5s ease;
}
.pl-product-card:hover .pl-product-card__img img { transform: scale(1.06); }
.pl-product-card__img-fallback {
    width: 100%; height: 100%;
    display: flex; flex-direction: column; align-items: center; justify-content: center;
    gap: 8px; color: #7AAAF0;
}
.pl-product-card__img-fallback i { font-size: 36px; opacity: .5; }
.pl-product-card__img-fallback span { font-size: 11px; opacity: .5; }

.pl-product-card__badge {
    position: absolute;
    top: 10px; left: 10px;
    padding: 3px 10px;
    border-radius: 100px;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: .04em;
}
.pl-product-card__badge.ok { background: rgba(29,158,117,.15); color: #0F6E56; }
.pl-product-card__badge.no { background: rgba(226,75,74,.12); color: #A32D2D; }

/* Body */
.pl-product-card__body {
    padding: 14px 16px;
    display: flex;
    flex-direction: column;
    flex: 1;
}
.pl-product-card__cat {
    font-size: 10px;
    font-weight: 700;
    letter-spacing: .1em;
    text-transform: uppercase;
    color: #4476D9;
    margin-bottom: 5px;
}
.pl-product-card__name {
    font-size: 14px;
    font-weight: 700;
    color: #0C1E45;
    line-height: 1.35;
    margin-bottom: 6px;
    flex: 1;
}
.pl-product-card__name a { color: inherit; text-decoration: none; }
.pl-product-card__name a:hover { color: #2B5FC1; }
.pl-product-card__price {
    font-size: 15px;
    font-weight: 800;
    color: #2B5FC1;
    margin-bottom: 12px;
}
.pl-product-card__footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-top: 1px solid #D0DDEF;
    padding-top: 10px;
}
.pl-product-card__stock {
    display: flex;
    align-items: center;
    gap: 5px;
}
.pl-stock-dot {
    width: 7px; height: 7px;
    border-radius: 50%;
    display: inline-block;
}
.pl-stock-dot.ok { background: #1D9E75; }
.pl-stock-dot.no { background: #E24B4A; }
.pl-stock-text { font-size: 11px; font-weight: 600; color: #7A8CAD; }
.pl-product-card__btn {
    display: flex; align-items: center; justify-content: center;
    width: 30px; height: 30px;
    border-radius: 8px;
    background: #2B5FC1;
    color: #fff;
    text-decoration: none;
    transition: background .18s, transform .15s;
    font-size: 11px;
}
.pl-product-card__btn:hover { background: #1A3A7A; transform: scale(1.1); color: #fff; }

/* Empty */
.pl-empty {
    grid-column: 1 / -1;
    text-align: center;
    padding: 60px 20px;
    color: #7A8CAD;
    background: #fff;
    border-radius: 16px;
    border: 1.5px dashed #D0DDEF;
}
.pl-empty i { font-size: 44px; margin-bottom: 14px; display: block; opacity: .35; }
.pl-empty p { font-size: 15px; }

/* Pagination */
.pl-pagination-wrap {
    margin-top: 36px;
    display: flex;
    justify-content: center;
}
.pl-pagination-wrap .pagination {
    display: flex;
    gap: 6px;
    list-style: none;
    padding: 0;
    margin: 0;
    flex-wrap: wrap;
}
.pl-pagination-wrap .pagination li a,
.pl-pagination-wrap .pagination li span {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 38px; height: 38px;
    border-radius: 10px;
    border: 1.5px solid #D0DDEF;
    background: #fff;
    color: #3A4E72;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    transition: all .18s;
}
.pl-pagination-wrap .pagination li.active span,
.pl-pagination-wrap .pagination li a:hover {
    background: #2B5FC1;
    border-color: #2B5FC1;
    color: #fff;
}
.pl-pagination-wrap .pagination li.disabled span {
    opacity: .4;
    pointer-events: none;
}

/* Responsive */
@media (max-width: 900px) {
    .pl-grid { grid-template-columns: 1fr; }
    .pl-sidebar { position: static; }
    .pl-bc-pill { display: none; }
}
@media (max-width: 520px) {
    .pl-products { grid-template-columns: 1fr 1fr; }
}
</style>

{{-- BREADCRUMB --}}
<section class="pl-breadcrumb">
    <div class="container">
        <div class="pl-bc-inner">
            <div class="pl-bc-left">
                <h2>Daftar Produk Obat</h2>
                <nav class="pl-bc-nav">
                    <a href="{{ url('/') }}">
                        <i class="fas fa-home" style="font-size:11px;margin-right:3px;"></i>Beranda
                    </a>
                    <span class="sep">›</span>
                    <span class="cur">Daftar Produk</span>
                </nav>
            </div>
            <div class="pl-bc-pill">
                <i class="fas fa-pills"></i>
                Apotek ClouPills
            </div>
        </div>
    </div>
</section>

{{-- PRODUCT LIST --}}
<section class="pl-section">
    <div class="container">
        <div class="pl-grid">

            {{-- SIDEBAR --}}
            <aside class="pl-sidebar">

                {{-- Search --}}
                <div class="pl-search-box">
                    <form action="{{ route('products.search') }}" method="GET">
                        <input type="text" name="query"
                               placeholder="Cari obat, suplemen..."
                               value="{{ request('query') }}">
                        <button type="submit">
                            <i class="fas fa-search" style="margin-right:5px;"></i>Cari
                        </button>
                    </form>
                </div>

                {{-- Stats --}}
                <div class="pl-stats-row">
                    <div class="pl-stat-mini">
                        <div class="pl-stat-mini__num">{{ $products->total() }}</div>
                        <div class="pl-stat-mini__label">Total Produk</div>
                    </div>
                    <div class="pl-stat-mini">
                        <div class="pl-stat-mini__num">{{ $categories->count() }}</div>
                        <div class="pl-stat-mini__label">Kategori</div>
                    </div>
                </div>

                {{-- Kategori --}}
                <div class="pl-cat-card">
                    <div class="pl-cat-card__head">
                        <div class="pl-cat-card__head-icon">
                            <i class="fas fa-list"></i>
                        </div>
                        <span>Jenis Obat</span>
                    </div>
                    <div class="pl-cat-card__list">
                        <a class="pl-cat-item {{ !request('category') ? 'active' : '' }}"
                           href="{{ route('products.index') }}">
                            <span class="pl-cat-dot"></span>
                            Semua Produk
                        </a>
                        @foreach($categories as $category)
                        <a class="pl-cat-item {{ request('category') == $category->id ? 'active' : '' }}"
                           href="{{ route('products.search', array_filter(['category' => $category->id, 'query' => request('query')])) }}">
                            <span class="pl-cat-dot"></span>
                            {{ $category->jenis }}
                        </a>
                        @endforeach
                    </div>
                </div>

            </aside>

            {{-- MAIN --}}
            <div>
                <div class="pl-main-header">
                    <div>
                        <h3>
                            @if(request('category'))
                                {{ $categories->firstWhere('id', request('category'))?->jenis ?? 'Produk' }}
                            @elseif(request('query'))
                                Hasil pencarian "{{ request('query') }}"
                            @else
                                Semua Produk
                            @endif
                        </h3>
                        <p>Menampilkan {{ $products->total() }} produk tersedia</p>
                    </div>
                </div>

                {{-- Grid Produk --}}
                <div class="pl-products">
                    @forelse($products as $product)
                    <div class="pl-product-card">
                        <div class="pl-product-card__img">
                            @if($product->foto1)
                                <img src="{{ asset('storage/obat/'.$product->foto1) }}"
                                     alt="{{ $product->nama_obat }}"
                                     onerror="this.parentElement.innerHTML='<div class=\'pl-product-card__img-fallback\'><i class=\'fas fa-capsules\'></i><span>Foto produk</span></div>'">
                            @else
                                <div class="pl-product-card__img-fallback">
                                    <i class="fas fa-capsules"></i>
                                    <span>Foto produk</span>
                                </div>
                            @endif
                            <span class="pl-product-card__badge {{ $product->stok > 0 ? 'ok' : 'no' }}">
                                {{ $product->stok > 0 ? 'Tersedia' : 'Habis' }}
                            </span>
                        </div>
                        <div class="pl-product-card__body">
                            <div class="pl-product-card__cat">
                                {{ $product->jenisObat->jenis ?? '-' }}
                            </div>
                            <div class="pl-product-card__name">
                                <a href="{{ route('products.show', $product->id) }}">
                                    {{ $product->nama_obat }}
                                </a>
                            </div>
                            <div class="pl-product-card__price">
                                Rp {{ number_format($product->harga_jual, 0, ',', '.') }}
                            </div>
                            <div class="pl-product-card__footer">
                                <div class="pl-product-card__stock">
                                    <span class="pl-stock-dot {{ $product->stok > 0 ? 'ok' : 'no' }}"></span>
                                    <span class="pl-stock-text">
                                        {{ $product->stok > 0 ? 'Stok tersedia' : 'Stok habis' }}
                                    </span>
                                </div>
                                <a href="{{ route('products.show', $product->id) }}"
                                   class="pl-product-card__btn" title="Lihat Produk">
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="pl-empty">
                        <i class="fas fa-box-open"></i>
                        <p>Produk tidak ditemukan.</p>
                    </div>
                    @endforelse
                </div>

                {{-- Pagination --}}
                <div class="pl-pagination-wrap">
                    {{ $products->links() }}
                </div>
            </div>

        </div>
    </div>
</section>

@endsection
