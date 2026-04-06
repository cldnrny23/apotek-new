@extends('fe.master')
@section('navbar')
    @include('fe.navbar')
@endsection

@section('produk-list')
 <!-- breadcrumb part start-->
 <section class="breadcrumb_part">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb_iner">
                    <h2>Daftar Produk Obat</h2>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- breadcrumb part end-->

<!-- product list part start-->
<section class="product_list section_padding">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="product_sidebar">
                    <div class="single_sedebar">
                        <form action="{{ route('products.search') }}" method="GET">
                            <input type="text" name="query" placeholder="Cari Obat..." value="{{ request('query') }}">
                            <i class="ti-search"></i>
                        </form>
                    </div>
                    <div class="single_sidebar">
                        <div class="select_option">
                            <div class="select_option_list">Jenis Obat  <i class="right fas fa-caret-down"></i></div>
                            <div class="select_option_dropdown">
                                <p><a href="{{ route('products.index') }}">Semua Produk</a></p>
                                @foreach($categories as $category)
                                    <p>
                                        <a href="{{ route('products.search', array_filter(['category' => $category->id, 'query' => request('query')])) }}">
                                            {{ $category->jenis }}
                                        </a>
                                    </p>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="product_list">
                    <div class="row">
                        @foreach($products as $product)
                        <div class="col-lg-6 col-sm-6">
                            <div class="single_product_item">
                                <!-- Gunakan foto1 sebagai gambar utama -->
                                <img src="{{ asset('storage/obat/'.$product->foto1) }}" alt="{{ $product->nama_obat }}" class="img-fluid" style="height: 200px; object-fit: cover;">
                                <h3>
                                    <a href="{{ route('products.show', $product->id) }}">{{ $product->nama_obat }}</a>
                                </h3>
                                <p class="product-category">{{ $product->jenisObat->jenis ?? '-' }}</p>
                                <p class="product-price">Rp {{ number_format($product->harga_jual, 0, ',', '.') }}</p>
                                <p class="product-stock {{ $product->stok > 0 ? 'in-stock' : 'out-stock' }}">
                                    {{ $product->stok > 0 ? 'Tersedia' : 'Habis' }}
                                </p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="load_more_btn text-center">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
