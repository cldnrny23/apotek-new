<style>
/* =====================================================
   ABOUT — Blue Apotik Theme
   ===================================================== */
.abt-section {
    background: var(--pl-bg, #EEF3FB);
    padding: 80px 0;
    position: relative;
    overflow: hidden;
    font-family: var(--font-display, 'Plus Jakarta Sans', sans-serif);
}

.abt-section::before {
    content: '';
    position: absolute;
    width: 500px; height: 500px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(43,95,193,.08) 0%, transparent 70%);
    top: -180px; right: -120px;
    pointer-events: none;
}

.abt-section::after {
    content: '';
    position: absolute;
    width: 350px; height: 350px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(43,95,193,.06) 0%, transparent 70%);
    bottom: -80px; left: -80px;
    pointer-events: none;
}

/* ── Grid ── */
.abt-inner {
    position: relative;
    z-index: 1;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 64px;
    align-items: center;
}

/* ── Image side ── */
.abt-img-col {
    position: relative;
}

.abt-img-wrap {
    position: relative;
    border-radius: var(--pl-radius, 16px);
    overflow: hidden;
    box-shadow: var(--pl-shadow-hover, 0 8px 24px rgba(43,95,193,.14), 0 24px 56px rgba(43,95,193,.12));
    aspect-ratio: 4/3;
}

.abt-img-wrap img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: transform .6s cubic-bezier(.22,1,.36,1);
}

.abt-img-wrap:hover img { transform: scale(1.04); }

/* Blue tint overlay */
.abt-img-wrap::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(43,95,193,.1) 0%, transparent 60%);
    pointer-events: none;
}

/* Accent border decoration */
.abt-img-deco {
    position: absolute;
    bottom: -20px; right: -20px;
    width: 60%; height: 60%;
    border: 3px solid var(--pl-blue-300, #7AAAF0);
    border-radius: var(--pl-radius, 16px);
    z-index: -1;
    opacity: .4;
}

/* Floating stat card */
.abt-stat-card {
    position: absolute;
    top: -20px; left: -24px;
    background: var(--pl-surface, #FFFFFF);
    border: 1.5px solid var(--pl-border, #D0DDEF);
    border-radius: var(--pl-radius, 16px);
    box-shadow: var(--pl-shadow, 0 2px 8px rgba(12,30,69,.06), 0 8px 32px rgba(12,30,69,.08));
    padding: 16px 22px;
    display: flex;
    align-items: center;
    gap: 14px;
    animation: abt-float 3.8s ease-in-out infinite;
    z-index: 2;
}

.abt-stat-card__icon {
    width: 44px; height: 44px;
    border-radius: 12px;
    background: var(--pl-blue-100, #D6E4FB);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}

.abt-stat-card__icon i {
    font-size: 18px;
    color: var(--pl-blue-500, #2B5FC1);
}

.abt-stat-card__num {
    font-size: 22px;
    font-weight: 800;
    color: var(--pl-ink, #0C1E45);
    line-height: 1;
}

.abt-stat-card__label {
    font-size: 11px;
    font-weight: 400;
    color: var(--pl-ink-3, #7A8CAD);
    margin-top: 2px;
}

/* ── Text side ── */
.abt-text {
    display: flex;
    flex-direction: column;
    gap: 0;
    animation: abt-fadein .55s .1s ease both;
}

.abt-text__eyebrow {
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
    margin-bottom: 18px;
    align-self: flex-start;
}

.abt-text__eyebrow-line {
    width: 18px; height: 2px;
    background: var(--pl-blue-400, #4476D9);
    border-radius: 2px;
}

.abt-text__title {
    font-family: var(--font-serif, 'Lora', serif);
    font-size: clamp(24px, 3vw, 36px);
    font-weight: 600;
    color: var(--pl-ink, #0C1E45);
    line-height: 1.22;
    letter-spacing: -.02em;
    margin: 0 0 16px;
}

.abt-text__title em {
    font-style: italic;
    color: var(--pl-blue-500, #2B5FC1);
}

.abt-text__desc {
    font-size: 15px;
    font-weight: 300;
    color: var(--pl-ink-3, #7A8CAD);
    line-height: 1.7;
    margin: 0 0 28px;
}

/* Feature list */
.abt-features {
    display: flex;
    flex-direction: column;
    gap: 14px;
    margin-bottom: 32px;
}

.abt-feature {
    display: flex;
    align-items: flex-start;
    gap: 14px;
}

.abt-feature__icon {
    width: 36px; height: 36px;
    border-radius: 10px;
    background: var(--pl-blue-100, #D6E4FB);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    margin-top: 1px;
    transition: background .2s, transform .2s;
}

.abt-feature:hover .abt-feature__icon {
    background: var(--pl-blue-500, #2B5FC1);
    transform: scale(1.08);
}

.abt-feature__icon i {
    font-size: 14px;
    color: var(--pl-blue-500, #2B5FC1);
    transition: color .2s;
}

.abt-feature:hover .abt-feature__icon i { color: #fff; }

.abt-feature__title {
    font-size: 14px;
    font-weight: 700;
    color: var(--pl-ink, #0C1E45);
    margin-bottom: 2px;
}

.abt-feature__desc {
    font-size: 13px;
    font-weight: 300;
    color: var(--pl-ink-3, #7A8CAD);
    line-height: 1.5;
    margin: 0;
}

/* CTA */
.abt-cta {
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

.abt-cta:hover {
    background: var(--pl-blue-700, #1A3A7A);
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(43,95,193,.38);
    color: #fff;
    text-decoration: none;
}

.abt-cta i { font-size: 12px; transition: transform .2s; }
.abt-cta:hover i { transform: translateX(4px); }

/* Divider antara abt dan spl */
.abt-divider {
    height: 2px;
    background: linear-gradient(90deg, transparent, var(--pl-blue-100, #D6E4FB), transparent);
    margin: 0;
    border: none;
    position: relative;
    z-index: 1;
}

/* ── Animations ── */
@keyframes abt-fadein {
    from { opacity: 0; transform: translateY(18px); }
    to   { opacity: 1; transform: translateY(0); }
}

@keyframes abt-float {
    0%, 100% { transform: translateY(0); }
    50%       { transform: translateY(-7px); }
}

/* ── Responsive ── */
@media (max-width: 900px) {
    .abt-inner {
        grid-template-columns: 1fr;
        gap: 40px;
    }

    .abt-stat-card { top: 12px; left: 12px; }
    .abt-img-deco  { display: none; }
}

@media (max-width: 480px) {
    .abt-section { padding: 56px 0; }
}
</style>

{{-- About section — letakkan di atas spl-section --}}
<section class="abt-section">
    <div class="container">
        <div class="abt-inner">

            {{-- ── Gambar ── --}}
            <div class="abt-img-col">
                <div class="abt-img-wrap">
                    <img src="{{ asset('fe/img/apotek.jpg') }}" alt="Apotek ClouPills">
                </div>
                <div class="abt-img-deco"></div>

                <div class="abt-stat-card">
                    <div class="abt-stat-card__icon">
                        <i class="fas fa-award"></i>
                    </div>
                    <div>
                        <div class="abt-stat-card__num">10+</div>
                        <div class="abt-stat-card__label">Tahun Berpengalaman</div>
                    </div>
                </div>
            </div>

            {{-- ── Teks ── --}}
            <div class="abt-text">
                <div class="abt-text__eyebrow">
                    <span class="abt-text__eyebrow-line"></span>
                    Tentang Kami
                    <span class="abt-text__eyebrow-line"></span>
                </div>

                <h2 class="abt-text__title">
                    Apotek <em>Terpercaya</em><br>untuk Keluarga Anda
                </h2>

                <p class="abt-text__desc">
                    ClouPills hadir sebagai solusi kebutuhan obat dan suplemen keluarga Anda.
                    Kami berkomitmen menyediakan produk berkualitas dengan pelayanan profesional
                    dari apoteker berpengalaman — mudah diakses, kapan saja dan di mana saja.
                </p>

                <div class="abt-features">
                    <div class="abt-feature">
                        <div class="abt-feature__icon">
                            <i class="fas fa-certificate"></i>
                        </div>
                        <div>
                            <div class="abt-feature__title">Produk Bersertifikat BPOM</div>
                            <p class="abt-feature__desc">Seluruh produk telah terdaftar dan mendapat izin edar resmi dari BPOM.</p>
                        </div>
                    </div>
                    <div class="abt-feature">
                        <div class="abt-feature__icon">
                            <i class="fas fa-user-md"></i>
                        </div>
                        <div>
                            <div class="abt-feature__title">Apoteker Profesional</div>
                            <p class="abt-feature__desc">Didukung tenaga apoteker tersertifikasi siap memberi konsultasi gratis.</p>
                        </div>
                    </div>
                    <div class="abt-feature">
                        <div class="abt-feature__icon">
                            <i class="fas fa-shipping-fast"></i>
                        </div>
                        <div>
                            <div class="abt-feature__title">Pengiriman Cepat & Aman</div>
                            <p class="abt-feature__desc">Pesanan dikemas dengan standar farmasi dan dikirim ke seluruh Indonesia.</p>
                        </div>
                    </div>
                </div>

                <a href="{{ route('list.index') }}" class="abt-cta">
                    Lihat Semua Produk <i class="fas fa-arrow-right"></i>
                </a>
            </div>

        </div>
    </div>
</section>

{{-- Divider tipis sebelum section produk --}}
<hr class="abt-divider">
