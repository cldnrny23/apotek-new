<!-- breadcrumb part start-->
<section class="breadcrumb_part">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="breadcrumb_iner">
          <h2>Cart List</h2>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- breadcrumb part end-->

<!--================ Cart Area =================-->
<section class="cart_area">
  <div class="container">

    <div class="cart_header">
      <h2 class="cart_title">Keranjang belanja</h2>
      <p class="cart_subtitle">{{ count($cart) }} produk dipilih</p>
    </div>

    <div class="cart_grid">

      <!-- Items Column -->
      <div class="cart_items_wrap">
        @forelse($cart as $index => $item)
        <div class="cart_item" style="animation-delay: {{ $index * 0.07 }}s">
          <div class="cart_item_img">
            <img src="{{ asset('storage/obat/'.$item['image']) }}" alt="{{ $item['name'] }}" />
          </div>
          <div class="cart_item_info">
            <div class="cart_item_name">{{ $item['name'] }}</div>
            <div class="cart_item_price">Rp {{ number_format($item['price'], 0, ',', '.') }} / pcs</div>
          </div>
          <div class="qty_ctrl">
            <button class="qty_btn" type="button">−</button>
            <div class="qty_num">{{ $item['quantity'] }}</div>
            <button class="qty_btn" type="button">+</button>
          </div>
          <div class="cart_item_total">
            Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
          </div>
          <button class="item_del_btn" type="button" title="Hapus">
            <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
              <path d="M2 2l10 10M12 2L2 12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
          </button>
        </div>
        @empty
        <div class="cart_empty">
          <svg width="48" height="48" viewBox="0 0 24 24" fill="none" style="margin-bottom:12px;opacity:0.3;">
            <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z" stroke="#4476D9" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M3 6h18M16 10a4 4 0 01-8 0" stroke="#4476D9" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
          <p>Keranjang kosong.</p>
          <p>Silakan tambahkan produk terlebih dahulu.</p>
          <a href="{{ route('products.index') }}" class="empty_shop_btn">Mulai belanja</a>
        </div>
        @endforelse
      </div>

      <!-- Sidebar Column -->
      <div class="cart_sidebar">
        <div class="summary_card">
          <div class="summary_title">Ringkasan Pesanan</div>

          <div class="summary_row">
            <span>Subtotal</span>
            <span id="subtotal_display">Rp {{ number_format($total, 0, ',', '.') }}</span>
          </div>

          <div class="summary_row">
            <span>Pengiriman</span>
            <span class="ship_free_badge">Gratis</span>
          </div>

          <div class="summary_divider"></div>

          <div class="summary_row total_row">
            <span>Total</span>
            <span id="total_display">Rp {{ number_format($total, 0, ',', '.') }}</span>
          </div>

          <a href="{{ route('checkout.index') }}" class="checkout_btn">
            Lanjut ke Pembayaran
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" style="margin-left:6px;vertical-align:-2px;">
              <path d="M5 12h14M12 5l7 7-7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </a>
          <a href="{{ route('products.index') }}" class="continue_btn">← Lanjut belanja</a>
        </div>

        <!-- Trust badges -->
        <div class="trust_card">
          <div class="trust_item">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" stroke="#2B5FC1" stroke-width="1.5" stroke-linejoin="round"/></svg>
            <span>Transaksi aman &amp; terenkripsi</span>
          </div>
          <div class="trust_item">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M5 12l5 5L20 7" stroke="#2B5FC1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
            <span>Produk terjamin keasliannya</span>
          </div>
          <div class="trust_item">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z" stroke="#2B5FC1" stroke-width="1.5" stroke-linejoin="round"/><polyline points="9 22 9 12 15 12 15 22" stroke="#2B5FC1" stroke-width="1.5" stroke-linejoin="round"/></svg>
            <span>Dikirim ke seluruh Indonesia</span>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>
<!--================ End Cart Area =================-->

<style>
  /* ── Palet Blue Apotik (sesuai tema about section) ── */
  :root {
    --pl-blue-100:    #D6E4FB;
    --pl-blue-300:    #7AAAF0;
    --pl-blue-400:    #4476D9;
    --pl-blue-500:    #2B5FC1;
    --pl-blue-700:    #1A3A7A;
    --pl-ink:         #0C1E45;
    --pl-ink-3:       #7A8CAD;
    --pl-border:      #D0DDEF;
    --pl-surface:     #FFFFFF;
    --pl-bg:          #EEF3FB;
    --pl-radius:      16px;
    --pl-radius-sm:   10px;
  }

  .cart_area {
    background: var(--pl-bg);
    padding: 40px 0 70px;
    position: relative;
    overflow: hidden;
  }

  /* Decorative blobs - sesuai abt-section */
  .cart_area::before {
    content: '';
    position: absolute;
    width: 500px; height: 500px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(43,95,193,.07) 0%, transparent 70%);
    top: -200px; right: -140px;
    pointer-events: none;
  }

  .cart_area::after {
    content: '';
    position: absolute;
    width: 350px; height: 350px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(43,95,193,.05) 0%, transparent 70%);
    bottom: -80px; left: -80px;
    pointer-events: none;
  }

  .cart_header {
    max-width: 980px;
    margin: 0 auto 24px;
    position: relative;
    z-index: 1;
  }

  .cart_title {
    font-family: var(--font-serif, 'Lora', serif);
    font-size: 22px;
    font-weight: 600;
    color: var(--pl-ink);
    margin: 0 0 4px;
    letter-spacing: -0.3px;
  }

  .cart_subtitle {
    font-size: 13px;
    color: var(--pl-ink-3);
    margin: 0;
  }

  .cart_grid {
    max-width: 980px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 1fr 300px;
    gap: 20px;
    align-items: start;
    position: relative;
    z-index: 1;
  }

  /* ── Items ── */
  .cart_items_wrap {
    background: var(--pl-surface);
    border-radius: var(--pl-radius);
    border: 1.5px solid var(--pl-border);
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(12,30,69,.06), 0 8px 32px rgba(12,30,69,.06);
  }

  .cart_item {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 18px 20px;
    border-bottom: 1px solid var(--pl-border);
    transition: background 0.18s ease;
    animation: slideIn 0.35s ease both;
  }

  .cart_item:last-child { border-bottom: none; }
  .cart_item:hover { background: #f0f5fd; }

  @keyframes slideIn {
    from { opacity: 0; transform: translateY(10px); }
    to   { opacity: 1; transform: translateY(0); }
  }

  .cart_item_img {
    width: 76px;
    height: 76px;
    border-radius: 12px;
    background: var(--pl-blue-100);
    border: 1px solid var(--pl-border);
    flex-shrink: 0;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .cart_item_img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform .6s cubic-bezier(.22,1,.36,1);
  }

  .cart_item:hover .cart_item_img img { transform: scale(1.05); }

  .cart_item_info { flex: 1; min-width: 0; }

  .cart_item_name {
    font-size: 14px;
    font-weight: 600;
    color: var(--pl-ink);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .cart_item_price {
    font-size: 13px;
    color: var(--pl-blue-500);
    font-weight: 500;
    margin-top: 4px;
  }

  /* Qty */
  .qty_ctrl {
    display: inline-flex;
    align-items: center;
    border: 1.5px solid var(--pl-border);
    border-radius: var(--pl-radius-sm);
    overflow: hidden;
    background: var(--pl-surface);
    flex-shrink: 0;
  }

  .qty_btn {
    width: 32px;
    height: 32px;
    background: none;
    border: none;
    color: var(--pl-ink-3);
    font-size: 17px;
    cursor: pointer;
    transition: background 0.15s, color 0.15s;
    line-height: 1;
  }

  .qty_btn:hover {
    background: var(--pl-blue-100);
    color: var(--pl-blue-700);
  }

  .qty_num {
    width: 36px;
    text-align: center;
    font-size: 13px;
    font-weight: 700;
    color: var(--pl-ink);
    border-left: 1px solid var(--pl-border);
    border-right: 1px solid var(--pl-border);
    height: 32px;
    line-height: 32px;
    user-select: none;
  }

  .cart_item_total {
    font-size: 14px;
    font-weight: 700;
    color: var(--pl-ink);
    text-align: right;
    min-width: 95px;
    flex-shrink: 0;
  }

  .item_del_btn {
    width: 30px;
    height: 30px;
    border: none;
    background: none;
    cursor: pointer;
    color: #ccc;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background 0.15s, color 0.15s;
    flex-shrink: 0;
  }

  .item_del_btn:hover { background: #fff0f0; color: #e53935; }

  .cart_empty {
    padding: 56px 24px;
    text-align: center;
    color: var(--pl-ink-3);
    font-size: 14px;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 4px;
  }

  .empty_shop_btn {
    margin-top: 16px;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 24px;
    border-radius: var(--pl-radius-sm);
    background: var(--pl-blue-500);
    color: #fff;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    transition: background 0.2s, transform 0.18s, box-shadow 0.2s;
    box-shadow: 0 4px 16px rgba(43,95,193,.3);
  }

  .empty_shop_btn:hover {
    background: var(--pl-blue-700);
    color: #fff;
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(43,95,193,.38);
  }

  /* ── Sidebar ── */
  .cart_sidebar { display: flex; flex-direction: column; gap: 14px; }

  .summary_card {
    background: var(--pl-surface);
    border-radius: var(--pl-radius);
    border: 1.5px solid var(--pl-border);
    padding: 22px;
    box-shadow: 0 2px 8px rgba(12,30,69,.06), 0 8px 32px rgba(12,30,69,.06);
    animation: slideIn 0.4s ease 0.12s both;
  }

  .summary_title {
    font-size: 11px;
    font-weight: 700;
    color: var(--pl-blue-500);
    text-transform: uppercase;
    letter-spacing: 0.14em;
    margin-bottom: 18px;
  }

  .summary_row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 14px;
    color: var(--pl-ink-3);
    padding: 9px 0;
  }

  .ship_free_badge {
    font-size: 11px;
    padding: 3px 9px;
    border-radius: 20px;
    background: #eaf7ef;
    color: #2e7d52;
    font-weight: 700;
  }

  .summary_divider {
    height: 1px;
    background: var(--pl-border);
    margin: 8px 0;
  }

  .total_row {
    font-size: 16px;
    font-weight: 700;
    color: var(--pl-ink);
    padding: 10px 0 0;
  }

  .checkout_btn {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    padding: 13px;
    border-radius: var(--pl-radius-sm);
    background: var(--pl-blue-500);
    color: #fff;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    margin-top: 18px;
    transition: background 0.2s, transform 0.12s, box-shadow 0.2s;
    box-shadow: 0 4px 14px rgba(43,95,193,.35);
    letter-spacing: .01em;
  }

  .checkout_btn:hover {
    background: var(--pl-blue-700);
    color: #fff;
    transform: translateY(-1px);
    box-shadow: 0 6px 18px rgba(43,95,193,.45);
  }

  .checkout_btn:active { transform: scale(0.98); }

  .continue_btn {
    display: block;
    width: 100%;
    padding: 11px;
    border-radius: var(--pl-radius-sm);
    border: 1.5px solid var(--pl-border);
    background: none;
    color: var(--pl-ink-3);
    text-align: center;
    font-size: 13px;
    text-decoration: none;
    margin-top: 10px;
    transition: background 0.15s, color 0.15s, border-color 0.15s;
  }

  .continue_btn:hover {
    background: #f0f5fd;
    color: var(--pl-blue-700);
    border-color: var(--pl-blue-400);
  }

  /* Trust card */
  .trust_card {
    background: var(--pl-surface);
    border-radius: 14px;
    border: 1.5px solid var(--pl-border);
    padding: 16px 18px;
    box-shadow: 0 2px 8px rgba(12,30,69,.04);
    animation: slideIn 0.4s ease 0.2s both;
  }

  .trust_item {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 12px;
    color: var(--pl-ink-3);
    padding: 7px 0;
    border-bottom: 1px solid var(--pl-border);
    transition: color 0.15s;
  }

  .trust_item:hover { color: var(--pl-ink); }
  .trust_item:last-child { border-bottom: none; }

  /* ── Responsive ── */
  @media (max-width: 740px) {
    .cart_grid { grid-template-columns: 1fr; }
    .cart_item { flex-wrap: wrap; gap: 12px; }
    .cart_item_total { min-width: unset; flex: 1; text-align: left; }
    .item_del_btn { margin-left: auto; }
  }
</style>

<script>
  document.addEventListener('DOMContentLoaded', function () {

    // ── Qty Controls ──
    document.querySelectorAll('.qty_btn').forEach(function (btn) {
      btn.addEventListener('click', function () {
        var ctrl = btn.closest('.qty_ctrl');
        var numEl = ctrl.querySelector('.qty_num');
        var val = parseInt(numEl.textContent);
        var delta = btn.textContent.trim() === '+' ? 1 : -1;
        if (val + delta < 1) return;
        numEl.textContent = val + delta;
        updateItemTotal(btn.closest('.cart_item'));
        recalcTotal();
      });
    });

    // ── Remove Item ──
    document.querySelectorAll('.item_del_btn').forEach(function (btn) {
      btn.addEventListener('click', function () {
        var item = btn.closest('.cart_item');
        item.style.transition = 'opacity 0.22s, transform 0.22s';
        item.style.opacity = '0';
        item.style.transform = 'translateX(14px)';
        setTimeout(function () {
          item.remove();
          if (!document.querySelector('.cart_item')) {
            document.querySelector('.cart_items_wrap').innerHTML =
              '<div class="cart_empty">' +
              '<svg width="48" height="48" viewBox="0 0 24 24" fill="none" style="margin-bottom:12px;opacity:0.3;">' +
              '<path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z" stroke="#4476D9" stroke-width="1.5" stroke-linejoin="round"/>' +
              '<path d="M3 6h18M16 10a4 4 0 01-8 0" stroke="#4476D9" stroke-width="1.5" stroke-linecap="round"/></svg>' +
              '<p>Keranjang kosong.</p><p>Silakan tambahkan produk terlebih dahulu.</p>' +
              '</div>';
          }
          recalcTotal();
        }, 230);
      });
    });

    // ── Helpers ──
    function updateItemTotal(item) {
      var priceText = item.querySelector('.cart_item_price').textContent;
      var price = parseInt(priceText.replace(/[^0-9]/g, ''));
      var qty = parseInt(item.querySelector('.qty_num').textContent);
      item.querySelector('.cart_item_total').textContent =
        'Rp ' + (price * qty).toLocaleString('id-ID');
    }

    function getSubtotal() {
      var sub = 0;
      document.querySelectorAll('.cart_item').forEach(function (item) {
        var priceText = item.querySelector('.cart_item_price').textContent;
        var price = parseInt(priceText.replace(/[^0-9]/g, ''));
        var qty = parseInt(item.querySelector('.qty_num').textContent);
        sub += price * qty;
      });
      return sub;
    }

    function recalcTotal() {
      var sub = getSubtotal();
      document.getElementById('subtotal_display').textContent = 'Rp ' + sub.toLocaleString('id-ID');
      document.getElementById('total_display').textContent = 'Rp ' + sub.toLocaleString('id-ID');
    }
  });
</script>
