{{-- ── BREADCRUMB ── --}}
<section class="breadcrumb_part abt-breadcrumb">
    <div class="container">
        <div class="abt-breadcrumb__inner">
            <div class="breadcrumb_iner">
                <h2>Tentang Kami</h2>
                <nav class="abt-breadcrumb__nav">
                    <a href="{{ url('/') }}"><i class="fas fa-home"></i> Beranda</a>
                    <span class="sep"><i class="fas fa-chevron-right"></i></span>
                    <span class="current">Tentang Kami</span>
                </nav>
            </div>
            <div class="abt-breadcrumb__deco">
                <i class="fas fa-pills"></i>
                Apotek ClouPills
            </div>
        </div>
    </div>
</section>


<hr class="abt-divider">

<style>
    /* ── BREADCRUMB — Blue Apotik Theme ── */
.abt-breadcrumb {
    background: linear-gradient(135deg, var(--pl-blue-700, #1A3A7A) 0%, var(--pl-blue-500, #2B5FC1) 60%, #4A90D9 100%);
    padding: 56px 0 52px;
    position: relative;
    overflow: hidden;
}
.abt-breadcrumb::before {
    content: '';
    position: absolute;
    width: 420px; height: 420px;
    border-radius: 50%;
    background: rgba(255,255,255,.06);
    top: -160px; right: -80px;
    pointer-events: none;
}
.abt-breadcrumb::after {
    content: '';
    position: absolute;
    width: 220px; height: 220px;
    border-radius: 50%;
    background: rgba(255,255,255,.04);
    bottom: -60px; left: 60px;
    pointer-events: none;
}
.abt-breadcrumb__inner {
    position: relative;
    z-index: 1;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.abt-breadcrumb .breadcrumb_iner h2 {
    font-family: var(--font-serif, 'Lora', serif);
    font-size: clamp(28px, 4vw, 42px);
    font-weight: 600;
    color: #fff;
    letter-spacing: -.02em;
    line-height: 1.2;
    margin-bottom: 8px;
}
.abt-breadcrumb__nav {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    font-weight: 500;
    color: rgba(255,255,255,.7);
}
.abt-breadcrumb__nav a {
    color: rgba(255,255,255,.9);
    text-decoration: none;
    transition: color .2s;
}
.abt-breadcrumb__nav a:hover { color: #fff; }
.abt-breadcrumb__nav .sep { font-size: 9px; opacity: .5; }
.abt-breadcrumb__nav .current { color: var(--pl-blue-100, #D6E4FB); }
.abt-breadcrumb__deco {
    display: flex;
    align-items: center;
    gap: 10px;
    background: rgba(255,255,255,.1);
    border: 1px solid rgba(255,255,255,.2);
    backdrop-filter: blur(8px);
    padding: 10px 20px;
    border-radius: 100px;
    color: rgba(255,255,255,.85);
    font-size: 13px;
    font-weight: 600;
    flex-shrink: 0;
}
.abt-breadcrumb__deco i { color: var(--pl-blue-100, #D6E4FB); }

/* ── Mission block ── */
.abt-mission {
    background: var(--pl-surface, #FFFFFF);
    border: 1.5px solid var(--pl-border, #D0DDEF);
    border-radius: var(--pl-radius, 16px);
    padding: 22px 24px;
    margin-bottom: 28px;
    position: relative;
    overflow: hidden;
}
.abt-mission::before {
    content: '';
    position: absolute;
    top: 0; left: 0;
    width: 4px; height: 100%;
    background: linear-gradient(180deg, var(--pl-blue-400, #4476D9), var(--pl-blue-300, #7AAAF0));
    border-radius: 4px 0 0 4px;
}
.abt-mission__label {
    font-size: 10px;
    font-weight: 700;
    letter-spacing: .12em;
    text-transform: uppercase;
    color: var(--pl-blue-500, #2B5FC1);
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    gap: 6px;
}
.abt-mission__text {
    font-family: var(--font-serif, 'Lora', serif);
    font-size: 15px;
    font-weight: 600;
    font-style: italic;
    color: var(--pl-ink-2, #3A4E72);
    line-height: 1.55;
    margin: 0;
}

/* ── Mission floating card (on image) ── */
.abt-mission-card {
    position: absolute;
    bottom: -18px; right: -20px;
    background: var(--pl-blue-500, #2B5FC1);
    border-radius: var(--pl-radius-sm, 10px);
    padding: 14px 20px;
    display: flex;
    align-items: center;
    gap: 12px;
    animation: abt-float 4.4s ease-in-out infinite reverse;
    z-index: 2;
    box-shadow: 0 6px 20px rgba(43,95,193,.3);
}
.abt-mission-card > i { font-size: 20px; color: rgba(255,255,255,.8); }
.abt-mission-card__title { font-size: 12px; font-weight: 700; color: rgba(255,255,255,.9); }
.abt-mission-card__sub { font-size: 11px; color: rgba(255,255,255,.6); margin-top: 1px; }

/* ── Responsive tambahan ── */
@media (max-width: 768px) {
    .abt-breadcrumb__deco { display: none; }
    .abt-mission-card { display: none; }
}
</style>
