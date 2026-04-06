{{-- =====================================================
     BANNER — Blue Apotik Theme (matches spl-section)
     ===================================================== --}}
<style>
/* Re-uses tokens from spl-section; define here if loaded standalone */
.ban-section {
    background: var(--pl-bg, #EEF3FB);
    position: relative;
    overflow: hidden;
    font-family: var(--font-display, 'Plus Jakarta Sans', sans-serif);
    padding: 0;
    min-height: 540px;
    display: flex;
    align-items: stretch;
}

/* Radial bg decorations — mirrors spl-section */
.ban-section::before {
    content: '';
    position: absolute;
    width: 700px; height: 700px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(43,95,193,.1) 0%, transparent 65%);
    top: -260px; left: -180px;
    pointer-events: none;
    z-index: 0;
}

.ban-section::after {
    content: '';
    position: absolute;
    width: 400px; height: 400px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(43,95,193,.07) 0%, transparent 70%);
    bottom: -120px; right: 380px;
    pointer-events: none;
    z-index: 0;
}

/* ── Container ── */
.ban-inner {
    position: relative;
    z-index: 1;
    width: 100%;
    display: grid;
    grid-template-columns: 1fr 1fr;
    align-items: stretch;
    min-height: 540px;
}

/* ── Text side ── */
.ban-text {
    padding: 72px 56px 72px 0;
    display: flex;
    flex-direction: column;
    justify-content: center;
    gap: 0;
    animation: ban-fadein .55s .08s ease both;
}

.ban-text__eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: .14em;
    text-transform: uppercase;
    color: var(--pl-blue-500, #2B5FC1);
    background: var(--pl-blue-100, #D6E4FB);
    padding: 5px 14px;
    border-radius: 100px;
    margin-bottom: 20px;
    align-self: flex-start;
}

.ban-text__eyebrow-line {
    width: 18px; height: 2px;
    background: var(--pl-blue-400, #4476D9);
    border-radius: 2px;
}

.ban-text__title {
    font-family: var(--font-serif, 'Lora', serif);
    font-size: clamp(28px, 3.8vw, 50px);
    font-weight: 600;
    color: var(--pl-ink, #0C1E45);
    line-height: 1.18;
    letter-spacing: -.025em;
    margin: 0 0 16px;
}

.ban-text__title em {
    font-style: italic;
    color: var(--pl-blue-500, #2B5FC1);
}

.ban-text__sub {
    font-size: 15px;
    font-weight: 300;
    color: var(--pl-ink-3, #7A8CAD);
    line-height: 1.65;
    margin: 0 0 36px;
    max-width: 380px;
}

/* CTA — same style as spl-item__cta */
.ban-cta {
    display: inline-flex;
    align-items: center;
    gap: 9px;
    padding: 13px 28px;
    background: var(--pl-blue-500, #2B5FC1);
    color: #fff;
    font-family: var(--font-display, 'Plus Jakarta Sans', sans-serif);
    font-size: 14px;
    font-weight: 600;
    border-radius: var(--pl-radius-sm, 10px);
    text-decoration: none;
    align-self: flex-start;
    transition: background .2s, transform .18s, box-shadow .2s;
    box-shadow: 0 4px 16px rgba(43,95,193,.3);
    letter-spacing: .01em;
}

.ban-cta:hover {
    background: var(--pl-blue-700, #1A3A7A);
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(43,95,193,.38);
    color: #fff;
    text-decoration: none;
}

.ban-cta i {
    font-size: 12px;
    transition: transform .2s;
}

.ban-cta:hover i { transform: translateX(4px); }

/* Trust badges */
.ban-badges {
    display: flex;
    align-items: center;
    gap: 20px;
    margin-top: 28px;
}

.ban-badge {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 12px;
    font-weight: 500;
    color: var(--pl-ink-2, #334166);
}

.ban-badge i {
    font-size: 13px;
    color: var(--pl-blue-400, #4476D9);
}

.ban-badge-sep {
    width: 1px; height: 18px;
    background: var(--pl-border, #D0DDEF);
}

/* ── Image side ── */
.ban-img-col {
    position: relative;
    overflow: hidden;
    animation: ban-fadein .55s .18s ease both;
}

.ban-img-col::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(
        to right,
        var(--pl-bg, #EEF3FB) 0%,
        transparent 28%
    );
    z-index: 2;
    pointer-events: none;
}

/* Blue overlay tint on image */
.ban-img-col::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(43,95,193,.08) 0%, transparent 55%);
    z-index: 1;
    pointer-events: none;
}

.ban-main-img {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center top;
    display: block;
}

.ban-pattern-img {
    position: absolute;
    bottom: 0; right: 0;
    width: 60%;
    opacity: .12;
    z-index: 3;
    pointer-events: none;
}

/* Card floating over image */
.ban-float-card {
    position: absolute;
    bottom: 36px; left: -28px;
    z-index: 4;
    background: var(--pl-surface, #FFFFFF);
    border: 1.5px solid var(--pl-border, #D0DDEF);
    border-radius: var(--pl-radius, 16px);
    box-shadow: var(--pl-shadow, 0 2px 8px rgba(12,30,69,.06), 0 8px 32px rgba(12,30,69,.08));
    padding: 14px 20px;
    display: flex;
    align-items: center;
    gap: 12px;
    min-width: 200px;
    animation: ban-float 3.6s ease-in-out infinite;
}

.ban-float-card__icon {
    width: 38px; height: 38px;
    border-radius: 10px;
    background: var(--pl-blue-100, #D6E4FB);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.ban-float-card__icon i {
    font-size: 16px;
    color: var(--pl-blue-500, #2B5FC1);
}

.ban-float-card__label {
    font-size: 11px;
    font-weight: 400;
    color: var(--pl-ink-3, #7A8CAD);
    line-height: 1.3;
}

.ban-float-card__value {
    font-size: 14px;
    font-weight: 700;
    color: var(--pl-ink, #0C1E45);
    line-height: 1.2;
}

/* ── Animations ── */
@keyframes ban-fadein {
    from { opacity: 0; transform: translateY(20px); }
    to   { opacity: 1; transform: translateY(0); }
}

@keyframes ban-float {
    0%, 100% { transform: translateY(0); }
    50%       { transform: translateY(-8px); }
}

/* ── Responsive ── */
@media (max-width: 900px) {
    .ban-inner {
        grid-template-columns: 1fr;
        min-height: unset;
    }

    .ban-img-col {
        height: 280px;
        order: -1;
    }

    .ban-img-col::before {
        background: linear-gradient(
            to bottom,
            transparent 60%,
            var(--pl-bg, #EEF3FB) 100%
        );
    }

    .ban-text {
        padding: 36px 0 56px;
    }

    .ban-float-card { display: none; }
}

@media (max-width: 480px) {
    .ban-text__sub { max-width: 100%; }
    .ban-badges { flex-wrap: wrap; gap: 12px; }
    .ban-badge-sep { display: none; }
}
</style>

<!-- banner part start -->
<section class="ban-section">
    <div class="container">
        <div class="ban-inner">

            {{-- ── Text ── --}}
            <div class="ban-text">
                <div class="ban-text__eyebrow">
                    <span class="ban-text__eyebrow-line"></span>
                    Apotek Online Terpercaya
                    <span class="ban-text__eyebrow-line"></span>
                </div>

                <h1 class="ban-text__title">
                    Selamat Datang di <em>ClouPills</em>
                </h1>

                <p class="ban-text__sub">
                    Temukan obat &amp; suplemen berkualitas dengan harga terjangkau.
                    Pesan mudah, pengiriman cepat, langsung ke tangan Anda.
                </p>

                <a href="{{ route('list.index') }}" class="ban-cta">
                    Lihat Produk <i class="fas fa-arrow-right"></i>
                </a>

                <div class="ban-badges">
                    <div class="ban-badge">
                        <i class="fas fa-shield-alt"></i>
                        Produk Resmi
                    </div>
                    <div class="ban-badge-sep"></div>
                    <div class="ban-badge">
                        <i class="fas fa-truck"></i>
                        Pengiriman Cepat
                    </div>
                    <div class="ban-badge-sep"></div>
                    <div class="ban-badge">
                        <i class="fas fa-headset"></i>
                        Konsultasi 24/7
                    </div>
                </div>
            </div>

            {{-- ── Image ── --}}
            <div class="ban-img-col">
                <img src="{{ asset('fe/img/apotek.jpg') }}"
                     alt="Apotek ClouPills"
                     class="ban-main-img">

                <img src="{{ asset('fe/img/banner_pattern.png') }}"
                     alt=""
                     class="ban-pattern-img">

                {{-- Floating info card --}}
                <div class="ban-float-card">
                    <div class="ban-float-card__icon">
                        <i class="fas fa-pills"></i>
                    </div>
  
                </div>
            </div>

        </div>
    </div>
</section>
<!-- banner part end -->
