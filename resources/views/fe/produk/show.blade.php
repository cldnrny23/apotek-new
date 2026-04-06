@extends('fe.master')
@section('navbar')
    @include('fe.navbar')
@endsection

@section('single-produk')

<!-- breadcrumb part start-->
<section class="breadcrumb_part">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb_iner">
                    <h2>Detail Produk</h2>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- breadcrumb part end-->

<!-- product detail part start -->
<section class="pd_area">
    <div class="pd_container">

        {{-- ── Main Card ── --}}
        <div class="pd_card">

            {{-- LEFT: Images --}}
            <div class="pd_images">
                <div class="pd_main_img" id="mainImgWrap">
                    <img src="{{ asset('storage/obat/'.$product->foto1) }}"
                         alt="{{ $product->nama_obat }}"
                         id="mainImg" class="pd_main_img_el" />
                </div>

                <div class="pd_thumbs">
                    @if($product->foto1)
                    <div class="pd_thumb active" onclick="switchImg(this, '{{ asset('storage/obat/'.$product->foto1) }}')">
                        <img src="{{ asset('storage/obat/'.$product->foto1) }}" alt="foto 1" />
                    </div>
                    @endif
                    @if($product->foto2)
                    <div class="pd_thumb" onclick="switchImg(this, '{{ asset('storage/obat/'.$product->foto2) }}')">
                        <img src="{{ asset('storage/obat/'.$product->foto2) }}" alt="foto 2" />
                    </div>
                    @endif
                    @if($product->foto3)
                    <div class="pd_thumb" onclick="switchImg(this, '{{ asset('storage/obat/'.$product->foto3) }}')">
                        <img src="{{ asset('storage/obat/'.$product->foto3) }}" alt="foto 3" />
                    </div>
                    @endif
                </div>
            </div>

            {{-- RIGHT: Info --}}
            <div class="pd_info">

                {{-- Badges --}}
                <div class="pd_badges">
                    <span class="pd_badge pd_badge_cat">{{ $product->jenisObat->jenis }}</span>
                    @if($product->stok > 0)
                        <span class="pd_badge pd_badge_stock">Tersedia</span>
                    @else
                        <span class="pd_badge pd_badge_empty">Habis</span>
                    @endif
                </div>

                {{-- Name --}}
                <h1 class="pd_name">{{ $product->nama_obat }}</h1>

                {{-- Price --}}
                <div class="pd_price">Rp {{ number_format($product->harga_jual, 0, ',', '.') }}</div>

                {{-- Divider --}}
                <div class="pd_divider"></div>

                {{-- Description --}}
                <div class="pd_desc_block">
                    <div class="pd_block_label">Deskripsi Produk</div>
                    <p class="pd_desc_text">{{ $product->deskripsi_obat ?? $product->deskripsi ?? 'Tidak ada deskripsi tersedia.' }}</p>
                </div>

                {{-- Meta info --}}
                <div class="pd_meta_grid">
                    <div class="pd_meta_item">
                        <span class="pd_meta_key">Nama Obat</span>
                        <span class="pd_meta_val">{{ $product->nama_obat }}</span>
                    </div>
                    <div class="pd_meta_item">
                        <span class="pd_meta_key">Jenis Obat</span>
                        <span class="pd_meta_val">{{ $product->jenisObat->jenis }}</span>
                    </div>
                    <div class="pd_meta_item">
                        <span class="pd_meta_key">Harga Jual</span>
                        <span class="pd_meta_val">Rp {{ number_format($product->harga_jual, 0, ',', '.') }}</span>
                    </div>
                    <div class="pd_meta_item">
                        <span class="pd_meta_key">Stok</span>
                        <span class="pd_meta_val">{{ $product->stok }} pcs</span>
                    </div>
                </div>

                <div class="pd_divider"></div>

                {{-- Add to cart --}}
                @if($product->stok > 0)
                <form action="{{ route('cart.store') }}" method="POST" id="add-to-cart-form">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" id="unitPrice" value="{{ $product->harga_jual }}">

                    <div class="pd_atc_row">
                        <div class="pd_qty_block">
                            <div class="pd_qty_label">Jumlah</div>
                            <div class="pd_qty_ctrl">
                                <button type="button" class="pd_qty_btn" onclick="decreaseQuantity()">−</button>
                                <input type="number" class="pd_qty_input" id="quantity" name="quantity"
                                       value="1" min="1" max="{{ $product->stok }}" step="1"
                                       oninput="updateTotalPrice()"
                                       onkeydown="return event.key !== 'e' && event.key !== 'E' && event.key !== '+' && event.key !== '-'" />
                                <button type="button" class="pd_qty_btn" onclick="increaseQuantity({{ $product->stok }})">+</button>
                            </div>
                        </div>

                        <div class="pd_total_block">
                            <div class="pd_qty_label">Total Harga</div>
                            <div class="pd_total_val" id="totalPrice">Rp {{ number_format($product->harga_jual, 0, ',', '.') }}</div>
                        </div>
                    </div>

                    <div class="pd_action_row">
                        <button type="submit" class="pd_btn_primary">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" style="vertical-align:-2px;margin-right:6px;">
                                <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                                <path d="M16 10a4 4 0 01-8 0" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                            </svg>
                            Tambah ke Keranjang
                        </button>
                        <a href="{{ route('cart.index') }}" class="pd_btn_secondary">Lihat Keranjang</a>
                    </div>
                </form>
                @else
                <div class="pd_out_of_stock">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" style="vertical-align:-2px;margin-right:6px;"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1.5"/><path d="M12 8v4M12 16h.01" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                    Stok habis — produk tidak tersedia saat ini
                </div>
                @endif

                {{-- Footer meta --}}
                <div class="pd_footer_meta">
                    <span>Kode Produk: <strong>#{{ $product->id }}</strong></span>
                    <span>Diperbarui: <strong>{{ $product->updated_at->format('d M Y') }}</strong></span>
                </div>

            </div>
        </div>

        {{-- ── Related Products ── --}}
        @if($relatedProducts->count() > 0)
        <div class="pd_related">
            <div class="pd_related_header">
                <h3 class="pd_related_title">Produk Terkait</h3>
                <a href="{{ route('products.index') }}" class="pd_related_all">Lihat semua →</a>
            </div>
            <div class="pd_related_grid">
                @foreach($relatedProducts as $related)
                <a href="{{ route('products.show', $related->id) }}" class="pd_related_card">
                    <div class="pd_related_img">
                        <img src="{{ asset('storage/obat/'.$related->foto1) }}" alt="{{ $related->nama_obat }}" />
                    </div>
                    <div class="pd_related_info">
                        <div class="pd_related_name">{{ $related->nama_obat }}</div>
                        <div class="pd_related_price">Rp {{ number_format($related->harga_jual, 0, ',', '.') }}</div>
                    </div>
                    <div class="pd_related_hover">Lihat Produk</div>
                </a>
                @endforeach
            </div>
        </div>
        @endif

    </div>
</section>
<!-- product detail part end -->

<style>
    :root {
        --cp-purple:      #9b8fc7;
        --cp-purple-dark: #7c6fb5;
        --cp-purple-bg:   #ede9f8;
        --cp-purple-soft: #f5f3fc;
        --cp-text:        #2d2d3a;
        --cp-muted:       #8a8a9a;
        --cp-border:      #e8e4f3;
        --cp-white:       #ffffff;
        --cp-bg:          #f8f7fc;
    }

    /* ── Layout ── */
    .pd_area {
        background: var(--cp-bg);
        padding: 36px 0 60px;
    }

    .pd_container {
        max-width: 1040px;
        margin: 0 auto;
        padding: 0 20px;
    }

    /* ── Main Card ── */
    .pd_card {
        background: var(--cp-white);
        border-radius: 20px;
        border: 1px solid var(--cp-border);
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0;
        overflow: hidden;
        animation: fadeUp 0.4s ease both;
    }

    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(14px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* ── Images ── */
    .pd_images {
        padding: 32px 28px;
        border-right: 1px solid var(--cp-border);
        display: flex;
        flex-direction: column;
        gap: 16px;
        background: var(--cp-purple-soft);
    }

    .pd_main_img {
        width: 100%;
        aspect-ratio: 1;
        border-radius: 14px;
        overflow: hidden;
        background: var(--cp-white);
        border: 1px solid var(--cp-border);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .pd_main_img_el {
        width: 100%;
        height: 100%;
        object-fit: contain;
        transition: opacity 0.22s ease;
    }

    .pd_thumbs {
        display: flex;
        gap: 10px;
    }

    .pd_thumb {
        width: 64px; height: 64px;
        border-radius: 10px;
        overflow: hidden;
        border: 2px solid transparent;
        cursor: pointer;
        background: var(--cp-white);
        transition: border-color 0.16s;
        flex-shrink: 0;
    }

    .pd_thumb img {
        width: 100%; height: 100%;
        object-fit: cover;
    }

    .pd_thumb.active,
    .pd_thumb:hover {
        border-color: var(--cp-purple);
    }

    /* ── Info Panel ── */
    .pd_info {
        padding: 32px 32px;
        display: flex;
        flex-direction: column;
        gap: 0;
    }

    .pd_badges {
        display: flex;
        gap: 8px;
        margin-bottom: 14px;
    }

    .pd_badge {
        font-size: 11px;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 20px;
    }

    .pd_badge_cat {
        background: var(--cp-purple-bg);
        color: var(--cp-purple-dark);
    }

    .pd_badge_stock {
        background: #eaf7ef;
        color: #2e7d52;
    }

    .pd_badge_empty {
        background: #fff0f0;
        color: #c62828;
    }

    .pd_name {
        font-size: 24px;
        font-weight: 700;
        color: var(--cp-text);
        line-height: 1.3;
        margin: 0 0 12px;
        letter-spacing: -0.4px;
    }

    .pd_price {
        font-size: 22px;
        font-weight: 800;
        color: var(--cp-purple-dark);
        margin-bottom: 20px;
        letter-spacing: -0.3px;
    }

    .pd_divider {
        height: 1px;
        background: var(--cp-border);
        margin: 18px 0;
    }

    .pd_block_label {
        font-size: 11px;
        font-weight: 700;
        color: var(--cp-purple);
        text-transform: uppercase;
        letter-spacing: 0.08em;
        margin-bottom: 8px;
    }

    .pd_desc_text {
        font-size: 13.5px;
        color: var(--cp-muted);
        line-height: 1.7;
        margin: 0 0 18px;
    }

    /* Meta grid */
    .pd_meta_grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
    }

    .pd_meta_item {
        background: var(--cp-purple-soft);
        border-radius: 10px;
        padding: 10px 14px;
        display: flex;
        flex-direction: column;
        gap: 3px;
    }

    .pd_meta_key {
        font-size: 11px;
        color: var(--cp-muted);
        font-weight: 500;
    }

    .pd_meta_val {
        font-size: 13px;
        color: var(--cp-text);
        font-weight: 700;
    }

    /* ATC */
    .pd_atc_row {
        display: flex;
        align-items: flex-end;
        gap: 20px;
        margin-bottom: 14px;
    }

    .pd_qty_label {
        font-size: 11px;
        font-weight: 600;
        color: var(--cp-muted);
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .pd_qty_ctrl {
        display: inline-flex;
        align-items: center;
        border: 1.5px solid var(--cp-border);
        border-radius: 10px;
        overflow: hidden;
        background: var(--cp-white);
    }

    .pd_qty_btn {
        width: 36px; height: 36px;
        background: none; border: none;
        color: var(--cp-muted); font-size: 18px;
        cursor: pointer;
        transition: background 0.14s, color 0.14s;
        line-height: 1;
    }

    .pd_qty_btn:hover {
        background: var(--cp-purple-bg);
        color: var(--cp-purple-dark);
    }

    .pd_qty_input {
        width: 50px; height: 36px;
        border: none;
        border-left: 1px solid var(--cp-border);
        border-right: 1px solid var(--cp-border);
        text-align: center;
        font-size: 14px; font-weight: 700;
        color: var(--cp-text);
        background: transparent;
        outline: none;
        -moz-appearance: textfield;
    }

    .pd_qty_input::-webkit-outer-spin-button,
    .pd_qty_input::-webkit-inner-spin-button { -webkit-appearance: none; }

    .pd_total_block { flex: 1; }

    .pd_total_val {
        font-size: 18px;
        font-weight: 800;
        color: var(--cp-purple-dark);
        letter-spacing: -0.3px;
    }

    /* Action buttons */
    .pd_action_row {
        display: flex;
        gap: 10px;
    }

    .pd_btn_primary {
        flex: 1;
        padding: 12px 20px;
        border-radius: 11px;
        background: var(--cp-purple);
        color: #fff;
        font-size: 14px; font-weight: 700;
        border: none; cursor: pointer;
        text-align: center;
        transition: background 0.18s, transform 0.12s, box-shadow 0.18s;
        box-shadow: 0 4px 12px rgba(155,143,199,0.35);
    }

    .pd_btn_primary:hover {
        background: var(--cp-purple-dark);
        transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(155,143,199,0.42);
    }

    .pd_btn_primary:active { transform: scale(0.98); }

    .pd_btn_secondary {
        padding: 12px 20px;
        border-radius: 11px;
        border: 1.5px solid var(--cp-border);
        background: none;
        color: var(--cp-muted);
        font-size: 14px; font-weight: 600;
        text-decoration: none;
        white-space: nowrap;
        transition: background 0.14s, color 0.14s, border-color 0.14s;
    }

    .pd_btn_secondary:hover {
        background: var(--cp-purple-soft);
        color: var(--cp-purple-dark);
        border-color: var(--cp-purple);
    }

    .pd_out_of_stock {
        padding: 14px 18px;
        border-radius: 10px;
        background: #fff4f4;
        border: 1px solid #fcd6d6;
        color: #c62828;
        font-size: 13px; font-weight: 600;
        margin-bottom: 12px;
    }

    .pd_footer_meta {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
        margin-top: 16px;
        padding-top: 14px;
        border-top: 1px solid var(--cp-border);
        font-size: 12px;
        color: var(--cp-muted);
    }

    .pd_footer_meta strong { color: var(--cp-text); }

    /* ── Related Products ── */
    .pd_related {
        margin-top: 36px;
        animation: fadeUp 0.4s ease 0.15s both;
    }

    .pd_related_header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 16px;
    }

    .pd_related_title {
        font-size: 16px;
        font-weight: 700;
        color: var(--cp-text);
        margin: 0;
    }

    .pd_related_all {
        font-size: 12px;
        color: var(--cp-purple);
        text-decoration: none;
        font-weight: 500;
    }

    .pd_related_all:hover { color: var(--cp-purple-dark); }

    .pd_related_grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 14px;
    }

    .pd_related_card {
        background: var(--cp-white);
        border-radius: 14px;
        border: 1px solid var(--cp-border);
        overflow: hidden;
        text-decoration: none;
        display: flex;
        flex-direction: column;
        transition: transform 0.18s, box-shadow 0.18s;
        position: relative;
    }

    .pd_related_card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 24px rgba(155,143,199,0.18);
    }

    .pd_related_img {
        width: 100%;
        aspect-ratio: 1;
        overflow: hidden;
        background: var(--cp-purple-soft);
    }

    .pd_related_img img {
        width: 100%; height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .pd_related_card:hover .pd_related_img img {
        transform: scale(1.04);
    }

    .pd_related_info {
        padding: 12px 14px;
    }

    .pd_related_name {
        font-size: 13px;
        font-weight: 600;
        color: var(--cp-text);
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        line-height: 1.4;
        margin-bottom: 6px;
    }

    .pd_related_price {
        font-size: 13px;
        font-weight: 700;
        color: var(--cp-purple-dark);
    }

    .pd_related_hover {
        position: absolute;
        bottom: 0; left: 0; right: 0;
        padding: 10px;
        background: var(--cp-purple);
        color: #fff;
        font-size: 12px; font-weight: 600;
        text-align: center;
        transform: translateY(100%);
        transition: transform 0.2s ease;
    }

    .pd_related_card:hover .pd_related_hover {
        transform: translateY(0);
    }

    /* ── Responsive ── */
    @media (max-width: 780px) {
        .pd_card { grid-template-columns: 1fr; }
        .pd_images { border-right: none; border-bottom: 1px solid var(--cp-border); padding: 24px; }
        .pd_info { padding: 24px; }
        .pd_related_grid { grid-template-columns: repeat(2, 1fr); }
        .pd_name { font-size: 20px; }
    }
</style>

<script>
function formatCurrency(value) {
    return 'Rp ' + Number(value).toLocaleString('id-ID');
}

function updateTotalPrice() {
    const quantityInput = document.getElementById('quantity');
    const unitPriceInput = document.getElementById('unitPrice');
    const totalPriceDisplay = document.getElementById('totalPrice');
    if (!quantityInput || !unitPriceInput || !totalPriceDisplay) return;

    let quantity = parseInt(quantityInput.value);
    if (isNaN(quantity) || quantity < 1) quantity = 1;
    const max = parseInt(quantityInput.max);
    if (!isNaN(max) && quantity > max) quantity = max;
    quantityInput.value = quantity;

    const unitPrice = parseFloat(unitPriceInput.value) || 0;
    totalPriceDisplay.innerText = formatCurrency(unitPrice * quantity);
}

function increaseQuantity(max) {
    const q = document.getElementById('quantity');
    let v = parseInt(q.value, 10);
    if (isNaN(v)) v = 1;
    q.value = Math.min(max, v + 1);
    updateTotalPrice();
}

function decreaseQuantity() {
    const q = document.getElementById('quantity');
    let v = parseInt(q.value, 10);
    q.value = (isNaN(v) || v <= 1) ? 1 : v - 1;
    updateTotalPrice();
}

function switchImg(el, src) {
    document.querySelectorAll('.pd_thumb').forEach(t => t.classList.remove('active'));
    el.classList.add('active');
    const main = document.getElementById('mainImg');
    main.style.opacity = '0';
    setTimeout(() => { main.src = src; main.style.opacity = '1'; }, 180);
}

document.addEventListener('DOMContentLoaded', function () {
    const q = document.getElementById('quantity');
    if (q) {
        q.addEventListener('input', updateTotalPrice);
        q.addEventListener('change', updateTotalPrice);
        q.addEventListener('keyup', updateTotalPrice);
        updateTotalPrice();
    }
});
</script>

@endsection
