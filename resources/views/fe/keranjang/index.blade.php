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
            <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z" stroke="#9b8fc7" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M3 6h18M16 10a4 4 0 01-8 0" stroke="#9b8fc7" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
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
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" stroke="#9b8fc7" stroke-width="1.5" stroke-linejoin="round"/></svg>
            <span>Transaksi aman &amp; terenkripsi</span>
          </div>
          <div class="trust_item">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M5 12l5 5L20 7" stroke="#9b8fc7" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
            <span>Produk terjamin keasliannya</span>
          </div>
          <div class="trust_item">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z" stroke="#9b8fc7" stroke-width="1.5" stroke-linejoin="round"/><polyline points="9 22 9 12 15 12 15 22" stroke="#9b8fc7" stroke-width="1.5" stroke-linejoin="round"/></svg>
            <span>Dikirim ke seluruh Indonesia</span>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>
<!--================ End Cart Area =================-->

<style>
  /* ── Palet ClouPills ── */
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

  .cart_area {
    background: var(--cp-bg);
    padding: 40px 0 70px;
  }

  .cart_header {
    max-width: 980px;
    margin: 0 auto 24px;
  }

  .cart_title {
    font-size: 22px;
    font-weight: 700;
    color: var(--cp-text);
    margin: 0 0 4px;
    letter-spacing: -0.3px;
  }

  .cart_subtitle {
    font-size: 13px;
    color: var(--cp-muted);
    margin: 0;
  }

  .cart_grid {
    max-width: 980px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 1fr 300px;
    gap: 20px;
    align-items: start;
  }

  /* ── Items ── */
  .cart_items_wrap {
    background: var(--cp-white);
    border-radius: 16px;
    border: 1px solid var(--cp-border);
    overflow: hidden;
  }

  .cart_item {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 18px 20px;
    border-bottom: 1px solid var(--cp-border);
    transition: background 0.18s ease;
    animation: slideIn 0.35s ease both;
  }

  .cart_item:last-child { border-bottom: none; }
  .cart_item:hover { background: var(--cp-purple-soft); }

  @keyframes slideIn {
    from { opacity: 0; transform: translateY(10px); }
    to   { opacity: 1; transform: translateY(0); }
  }

  .cart_item_img {
    width: 76px;
    height: 76px;
    border-radius: 12px;
    background: var(--cp-purple-soft);
    border: 1px solid var(--cp-border);
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
  }

  .cart_item_info { flex: 1; min-width: 0; }

  .cart_item_name {
    font-size: 14px;
    font-weight: 600;
    color: var(--cp-text);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .cart_item_price {
    font-size: 13px;
    color: var(--cp-purple);
    font-weight: 500;
    margin-top: 4px;
  }

  /* Qty */
  .qty_ctrl {
    display: inline-flex;
    align-items: center;
    border: 1px solid var(--cp-border);
    border-radius: 10px;
    overflow: hidden;
    background: var(--cp-white);
    flex-shrink: 0;
  }

  .qty_btn {
    width: 32px;
    height: 32px;
    background: none;
    border: none;
    color: var(--cp-muted);
    font-size: 17px;
    cursor: pointer;
    transition: background 0.15s, color 0.15s;
    line-height: 1;
  }

  .qty_btn:hover {
    background: var(--cp-purple-bg);
    color: var(--cp-purple-dark);
  }

  .qty_num {
    width: 36px;
    text-align: center;
    font-size: 13px;
    font-weight: 700;
    color: var(--cp-text);
    border-left: 1px solid var(--cp-border);
    border-right: 1px solid var(--cp-border);
    height: 32px;
    line-height: 32px;
    user-select: none;
  }

  .cart_item_total {
    font-size: 14px;
    font-weight: 700;
    color: var(--cp-text);
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
    color: var(--cp-muted);
    font-size: 14px;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 4px;
  }

  .empty_shop_btn {
    margin-top: 16px;
    display: inline-block;
    padding: 10px 24px;
    border-radius: 10px;
    background: var(--cp-purple);
    color: #fff;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    transition: background 0.18s;
  }

  .empty_shop_btn:hover { background: var(--cp-purple-dark); color: #fff; }

  /* ── Sidebar ── */
  .cart_sidebar { display: flex; flex-direction: column; gap: 14px; }

  .summary_card {
    background: var(--cp-white);
    border-radius: 16px;
    border: 1px solid var(--cp-border);
    padding: 22px;
    animation: slideIn 0.4s ease 0.12s both;
  }

  .summary_title {
    font-size: 11px;
    font-weight: 700;
    color: var(--cp-purple);
    text-transform: uppercase;
    letter-spacing: 0.1em;
    margin-bottom: 18px;
  }

  .summary_row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 14px;
    color: var(--cp-muted);
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
    background: var(--cp-border);
    margin: 8px 0;
  }

  .total_row {
    font-size: 16px;
    font-weight: 700;
    color: var(--cp-text);
    padding: 10px 0 0;
  }

  .checkout_btn {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    padding: 13px;
    border-radius: 12px;
    background: var(--cp-purple);
    color: #fff;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    margin-top: 18px;
    transition: background 0.2s, transform 0.12s, box-shadow 0.2s;
    box-shadow: 0 4px 14px rgba(155, 143, 199, 0.35);
  }

  .checkout_btn:hover {
    background: var(--cp-purple-dark);
    color: #fff;
    transform: translateY(-1px);
    box-shadow: 0 6px 18px rgba(155, 143, 199, 0.45);
  }

  .checkout_btn:active { transform: scale(0.98); }

  .continue_btn {
    display: block;
    width: 100%;
    padding: 11px;
    border-radius: 10px;
    border: 1px solid var(--cp-border);
    background: none;
    color: var(--cp-muted);
    text-align: center;
    font-size: 13px;
    text-decoration: none;
    margin-top: 10px;
    transition: background 0.15s, color 0.15s, border-color 0.15s;
  }

  .continue_btn:hover {
    background: var(--cp-purple-soft);
    color: var(--cp-purple-dark);
    border-color: var(--cp-purple);
  }

  /* Trust card */
  .trust_card {
    background: var(--cp-white);
    border-radius: 14px;
    border: 1px solid var(--cp-border);
    padding: 16px 18px;
    animation: slideIn 0.4s ease 0.2s both;
  }

  .trust_item {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 12px;
    color: var(--cp-muted);
    padding: 7px 0;
    border-bottom: 1px solid var(--cp-border);
  }

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
              '<path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z" stroke="#9b8fc7" stroke-width="1.5" stroke-linejoin="round"/>' +
              '<path d="M3 6h18M16 10a4 4 0 01-8 0" stroke="#9b8fc7" stroke-width="1.5" stroke-linecap="round"/></svg>' +
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
