   <!-- product list start-->
   <section class="single_product_list">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                @foreach($products as $product)
                <div class="single_product_iner">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-lg-6 col-sm-6">
                            <div class="single_product_img">
                                <img src="{{ $product->foto1 ? asset('storage/obat/'.$product->foto1) : asset('fe/img/single_product_1.png') }}"
                                     class="img-fluid" alt="{{ $product->nama_obat }}">
                                <img src="{{asset('fe/img/product_overlay.png')}}" alt="#" class="product_overlay img-fluid">
                            </div>
                        </div>
                        <div class="col-lg-5 col-sm-6">
                            <div class="single_product_content">
                                <h5>Started from Rp {{ number_format($product->harga_jual, 0, ',', '.') }}</h5>
                                <h2>
                                    <a href="{{ route('products.show', $product->id) }}">{{ $product->nama_obat }}</a>
                                </h2>
                                <a href="{{ route('products.show', $product->id) }}" class="btn_3">Lihat Produk</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
<!-- product list end-->
