<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Lora:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet">

<style>
/* =====================================================
   TOKENS — Blue Apotik Theme
   ===================================================== */
:root {
    --pl-bg:           #EEF3FB;
    --pl-surface:      #FFFFFF;
    --pl-surface-2:    #F4F7FD;

    --pl-blue-900:     #0C1E45;
    --pl-blue-700:     #1A3A7A;
    --pl-blue-500:     #2B5FC1;
    --pl-blue-400:     #4476D9;
    --pl-blue-300:     #7AAAF0;
    --pl-blue-100:     #D6E4FB;
    --pl-blue-50:      #EEF3FB;

    --pl-ink:          #0C1E45;
    --pl-ink-2:        #334166;
    --pl-ink-3:        #7A8CAD;

    --pl-border:       #D0DDEF;
    --pl-border-dark:  #A8BEDD;

    --pl-accent:       #F0A500;   /* gold accent pop */

    --pl-radius:       16px;
    --pl-radius-sm:    10px;

    --pl-shadow:       0 2px 8px rgba(12,30,69,.06), 0 8px 32px rgba(12,30,69,.08);
    --pl-shadow-hover: 0 8px 24px rgba(43,95,193,.14), 0 24px 56px rgba(43,95,193,.12);

    --font-display: 'Plus Jakarta Sans', sans-serif;
    --font-serif:   'Lora', serif;
}

/* =====================================================
   SECTION WRAPPER
   ===================================================== */
.spl-section {
    background: var(--pl-bg);
    padding: 72px 0 80px;
    position: relative;
    overflow: hidden;
    font-family: var(--font-display);
}

/* Background decoration */
.spl-section::before {
    content: '';
    position: absolute;
    width: 600px; height: 600px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(43,95,193,.08) 0%, transparent 70%);
    top: -200px; right: -150px;
    pointer-events: none;
}

.spl-section::after {
    content: '';
    position: absolute;
    width: 400px; height: 400px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(43,95,193,.06) 0%, transparent 70%);
    bottom: -100px; left: -100px;
    pointer-events: none;
}

/* =====================================================
   SECTION HEADER
   ===================================================== */
.spl-header {
    text-align: center;
    margin-bottom: 52px;
}

.spl-header__eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: .14em;
    text-transform: uppercase;
    color: var(--pl-blue-500);
    background: var(--pl-blue-100);
    padding: 5px 14px;
    border-radius: 100px;
    margin-bottom: 14px;
}

.spl-header__eyebrow-line {
    width: 18px; height: 2px;
    background: var(--pl-blue-400);
    border-radius: 2px;
}

.spl-header__title {
    font-family: var(--font-serif);
    font-size: clamp(26px, 3.5vw, 38px);
    font-weight: 600;
    color: var(--pl-ink);
    margin: 0 0 10px;
    line-height: 1.2;
    letter-spacing: -.02em;
}

.spl-header__title em {
    font-style: italic;
    color: var(--pl-blue-500);
}

.spl-header__sub {
    font-size: 15px;
    color: var(--pl-ink-3);
    font-weight: 300;
    margin: 0;
}

/* =====================================================
   PRODUCT CARDS STACKED LIST
   ===================================================== */
.spl-list {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.spl-item {
    background: var(--pl-surface);
    border: 1.5px solid var(--pl-border);
    border-radius: var(--pl-radius);
    box-shadow: var(--pl-shadow);
    overflow: hidden;
    display: grid;
    grid-template-columns: 320px 1fr;
    min-height: 240px;
    transition: transform .28s cubic-bezier(.22,1,.36,1),
                box-shadow .28s cubic-bezier(.22,1,.36,1),
                border-color .2s;
    position: relative;
}

/* Alternate: odd items flip image to the right */
.spl-item:nth-child(even) {
    grid-template-columns: 1fr 320px;
}

.spl-item:nth-child(even) .spl-item__img-col {
    order: 2;
}

.spl-item:nth-child(even) .spl-item__content {
    order: 1;
}

.spl-item:hover {
    transform: translateY(-4px);
    box-shadow: var(--pl-shadow-hover);
    border-color: var(--pl-blue-300);
}

/* Blue left-edge accent bar */
.spl-item::before {
    content: '';
    position: absolute;
    left: 0; top: 0; bottom: 0;
    width: 4px;
    background: linear-gradient(180deg, var(--pl-blue-500) 0%, var(--pl-blue-300) 100%);
    border-radius: 4px 0 0 4px;
    opacity: 0;
    transition: opacity .25s;
}

.spl-item:hover::before { opacity: 1; }

/* ── Image column ── */
.spl-item__img-col {
    position: relative;
    overflow: hidden;
    background: var(--pl-surface-2);
}

.spl-item__img-col::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(43,95,193,.12) 0%, transparent 60%);
    pointer-events: none;
    transition: opacity .3s;
    opacity: 0;
}

.spl-item:hover .spl-item__img-col::after { opacity: 1; }

.spl-item__img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform .5s cubic-bezier(.22,1,.36,1);
    display: block;
}

.spl-item:hover .spl-item__img { transform: scale(1.04); }

/* Badge on image */
.spl-item__badge {
    position: absolute;
    top: 14px; left: 14px;
    background: var(--pl-blue-500);
    color: #fff;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: .08em;
    text-transform: uppercase;
    padding: 4px 10px;
    border-radius: 100px;
    z-index: 1;
}

.spl-item:nth-child(even) .spl-item__badge {
    left: auto; right: 14px;
}

/* ── Content column ── */
.spl-item__content {
    padding: 32px 36px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    gap: 6px;
}

.spl-item__number {
    font-size: 11px;
    font-weight: 700;
    letter-spacing: .12em;
    text-transform: uppercase;
    color: var(--pl-blue-400);
    opacity: .6;
    margin-bottom: 2px;
}

.spl-item__price-line {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 4px;
}

.spl-item__price-label {
    font-size: 11px;
    color: var(--pl-ink-3);
    font-weight: 400;
    letter-spacing: .04em;
}

.spl-item__price {
    font-size: 13px;
    font-weight: 700;
    color: var(--pl-blue-500);
    background: var(--pl-blue-100);
    padding: 2px 10px;
    border-radius: 100px;
    letter-spacing: -.01em;
}

.spl-item__name {
    font-family: var(--font-serif);
    font-size: clamp(20px, 2.2vw, 26px);
    font-weight: 600;
    color: var(--pl-ink);
    margin: 0 0 8px;
    line-height: 1.25;
    letter-spacing: -.02em;
}

.spl-item__name a {
    color: inherit;
    text-decoration: none;
    transition: color .2s;
}

.spl-item__name a:hover { color: var(--pl-blue-500); }

.spl-item__desc {
    font-size: 14px;
    color: var(--pl-ink-3);
    font-weight: 300;
    line-height: 1.6;
    margin: 0 0 20px;
}

/* CTA button */
.spl-item__cta {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 22px;
    background: var(--pl-blue-500);
    color: #fff;
    font-family: var(--font-display);
    font-size: 13px;
    font-weight: 600;
    border-radius: var(--pl-radius-sm);
    text-decoration: none;
    align-self: flex-start;
    transition: background .2s, transform .18s, box-shadow .2s;
    box-shadow: 0 2px 8px rgba(43,95,193,.25);
    letter-spacing: .01em;
}

.spl-item__cta:hover {
    background: var(--pl-blue-700);
    transform: translateY(-1px);
    box-shadow: 0 4px 16px rgba(43,95,193,.35);
    color: #fff;
    text-decoration: none;
}

.spl-item__cta i {
    font-size: 11px;
    transition: transform .2s;
}

.spl-item__cta:hover i { transform: translateX(3px); }

/* =====================================================
   EMPTY STATE
   ===================================================== */
.spl-empty {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 72px 24px;
    color: var(--pl-ink-3);
    gap: 12px;
    text-align: center;
    background: var(--pl-surface);
    border: 1.5px solid var(--pl-border);
    border-radius: var(--pl-radius);
}

.spl-empty i { font-size: 40px; opacity: .25; color: var(--pl-blue-400); }
.spl-empty p { font-size: 15px; margin: 0; font-weight: 300; }

/* =====================================================
   STAGGER ANIMATION ON LOAD
   ===================================================== */
.spl-item {
    animation: spl-fadein .5s ease both;
}

.spl-item:nth-child(1) { animation-delay: .05s; }
.spl-item:nth-child(2) { animation-delay: .12s; }
.spl-item:nth-child(3) { animation-delay: .19s; }
.spl-item:nth-child(4) { animation-delay: .26s; }

@keyframes spl-fadein {
    from { opacity: 0; transform: translateY(16px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* =====================================================
   RESPONSIVE
   ===================================================== */
@media (max-width: 900px) {
    .spl-item,
    .spl-item:nth-child(even) {
        grid-template-columns: 1fr;
        min-height: unset;
    }

    .spl-item:nth-child(even) .spl-item__img-col,
    .spl-item:nth-child(even) .spl-item__content {
        order: unset;
    }

    .spl-item__img-col { height: 220px; }
    .spl-item__content { padding: 24px 24px 28px; }

    .spl-item:nth-child(even) .spl-item__badge {
        left: 14px; right: auto;
    }
}

@media (max-width: 480px) {
    .spl-section { padding: 48px 0 56px; }
    .spl-header  { margin-bottom: 36px; }
}
</style>

<!-- product list start -->
<section class="spl-section">
    <div class="container" style="position:relative; z-index:1;">

        {{-- Section header --}}
        <div class="spl-header">
            <div class="spl-header__eyebrow">
                <span class="spl-header__eyebrow-line"></span>
                Produk Unggulan
                <span class="spl-header__eyebrow-line"></span>
            </div>
            <h2 class="spl-header__title">Obat &amp; Suplemen <em>Terpilih</em></h2>
            <p class="spl-header__sub">Kualitas terjamin, harga terjangkau, langsung dari apotek terpercaya.</p>
        </div>

        {{-- Product list --}}
        <div class="spl-list">
            @forelse(collect($products)->take(4) as $index => $product)
            <div class="spl-item">

                {{-- Image --}}
                <div class="spl-item__img-col">
                    <span class="spl-item__badge">Apotek</span>
                    <img src="{{ $product->foto1 ? asset('storage/obat/'.$product->foto1) : asset('fe/img/single_product_1.png') }}"
                         class="spl-item__img"
                         alt="{{ $product->nama_obat }}">
                </div>

                {{-- Content --}}
                <div class="spl-item__content">
                    <div class="spl-item__number">Produk #{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</div>

                    <div class="spl-item__price-line">
                        <span class="spl-item__price-label">Mulai dari</span>
                        <span class="spl-item__price">Rp {{ number_format($product->harga_jual, 0, ',', '.') }}</span>
                    </div>

                    <h3 class="spl-item__name">
                        <a href="{{ route('products.show', $product->id) }}">{{ $product->nama_obat }}</a>
                    </h3>

                    <p class="spl-item__desc">Tersedia di Apotek Medicare. Klik untuk melihat detail lengkap produk ini.</p>

                    <a href="{{ route('products.show', $product->id) }}" class="spl-item__cta">
                        Lihat Produk <i class="fas fa-arrow-right"></i>
                    </a>
                </div>

            </div>
            @empty
            <div class="spl-empty">
                <i class="fas fa-box-open"></i>
                <p>Belum ada produk yang tersedia.</p>
            </div>
            @endforelse
        </div>

    </div>
</section>
<!-- product list end -->
