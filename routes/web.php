<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\DetailPenjualanController;
use App\Http\Controllers\DetailPembelianController;
use App\Http\Controllers\MetodeBayarController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\PengirimanController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthFeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\JenisObatController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\PemilikController;
use App\Http\Controllers\ApotekerController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\DistributorController;
use App\Http\Controllers\ProfileUserController;
use App\Http\Controllers\ProfilePelangganController;
use App\Http\Controllers\JenisPengirimanController;
use App\Http\Controllers\LaporanKeuanganController;
use App\Http\Controllers\KurirController;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\RoleAuth;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::get('/about', [AboutController::class, 'index'])->name('fe.about.index');

// Admin/auth routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'loginUser'])->name('login-user');
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'registerUser'])->name('register-user');
});

Route::middleware('guest:pelanggan')->group(function () {
    Route::get('/loginfe', [AuthFeController::class, 'signin'])->name('loginfe');
    Route::post('/loginfe', [AuthFeController::class, 'loginPelanggan'])->name('login-pelanggan');
    Route::get('/registerfe', [AuthFeController::class, 'signup'])->name('registerfe');
    Route::post('/registerfe', [AuthFeController::class, 'registerPelanggan'])->name('register-pelanggan');
});

// Logout Routes
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/logoutfe', [AuthFeController::class, 'signout'])->name('logout-pelanggan');


//Resource Routes
Route::resource('detail-penjualan', DetailPenjualanController::class);
Route::resource('detail-pembelian', DetailPembelianController::class);
Route::resource('metode-bayar', MetodeBayarController::class);
Route::resource('list', ProdukController::class);
Route::resource('pelanggan', PelangganController::class);
Route::resource('pembelian', PembelianController::class);
Route::resource('cart', KeranjangController::class);
Route::get('/checkout', [KeranjangController::class, 'checkout'])->name('checkout.index');
Route::post('/checkout', [KeranjangController::class, 'processCheckout'])->name('checkout.process');
Route::get('/payment/{penjualanId}', [KeranjangController::class, 'showPayment'])->name('payment.show');
Route::post('/payment/{penjualanId}/confirm', [KeranjangController::class, 'confirmPayment'])->name('payment.confirm');

// Admin Routes with Middleware
Route::middleware(['auth', RoleAuth::class . ':admin,apoteker,kasir,pemilik,karyawan,kurir'])->group(function () {
    Route::resource('pengiriman', PengirimanController::class);
    Route::put('pengiriman/{pengiriman}/update-status', [PengirimanController::class, 'updateStatus'])->name('pengiriman.updateStatus');
});

// Role-based Dashboard Routes
Route::get('/admin', [AdminController::class, 'index'])
    ->middleware(['auth', RoleAuth::class . ':admin'])
    ->name('admin');

Route::get('/karyawan', [KaryawanController::class, 'index'])
    ->middleware(['auth', RoleAuth::class . ':karyawan'])
    ->name('karyawan');
Route::get('/pemilik', [PemilikController::class, 'index'])
    ->middleware(['auth', RoleAuth::class . ':pemilik'])
    ->name('pemilik');

Route::get('/apoteker', [ApotekerController::class, 'index'])
    ->middleware(['auth', RoleAuth::class . ':apoteker'])
    ->name('apoteker');

Route::get('/kasir', [KasirController::class, 'index'])
    ->middleware(['auth', RoleAuth::class . ':kasir'])
    ->name('kasir');

Route::get('/kurir', [KurirController::class, 'index'])
    ->middleware(['auth', RoleAuth::class . ':kurir'])
    ->name('kurir');

// Main Dashboard Route
Route::get('/dashboard', function () {
    $user = Auth::user();

    switch ($user->jabatan) {
        case 'admin':
            return redirect()->route('admin');
        case 'karyawan':
            return redirect()->route('karyawan');
        case 'apoteker':
            return redirect()->route('apoteker');
        case 'pemilik':
            return redirect()->route('pemilik');
        case 'kasir':
            return redirect()->route('kasir');
        case 'kurir':
            return redirect()->route('kurir');
        default:
            return redirect()->back()->withErrors('Unauthorized access.');
    }
})->middleware('auth')->name('dashboard');

//fe to be
Route::group(['namespace' => 'Frontend'], function() {
    Route::get('/products',  [ProdukController::class, 'index'])->name('products.index');
    Route::get('/products/search',  [ProdukController::class, 'search'])->name('products.search');
    Route::get('/products/{id}',  [ProdukController::class, 'show'])->name('products.show');
});

// Profile User Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/user-profile', [ProfileUserController::class, 'index'])->name('profile.index');
    Route::put('/user-profile', [ProfileUserController::class, 'update'])->name('profile.update');
});

// Profile Pelanggan Routes
Route::middleware(['auth:pelanggan'])->group(function () {
    Route::get('/profile-pelanggan', [ProfilePelangganController::class, 'index'])->name('profilefe.index');
    Route::put('/profile-pelanggan', [ProfilePelangganController::class, 'update'])->name('profilefe.update');
});

// Laporan Keuangan Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/laporan-keuangan', [LaporanKeuanganController::class, 'index'])->name('laporan_keuangan.index');
});

// User Management Routes
Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('users.index');
    Route::get('/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/store', [UserController::class, 'store'])->name('users.store');
    Route::get('/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/{id}', [UserController::class, 'destroy'])->name('users.destroy');
});

// Jenis Obat Routes
Route::prefix('jenis_obat')->group(function () {
    Route::get('/', [JenisObatController::class, 'index'])->name('jenis_obats.index');
    Route::get('/create', [JenisObatController::class, 'create'])->name('jenis_obats.create');
    Route::post('/', [JenisObatController::class, 'store'])->name('jenis_obats.store');
    Route::get('/{jenisObat}/edit', [JenisObatController::class, 'edit'])->name('jenis_obats.edit');
    Route::put('/{jenisObat}', [JenisObatController::class, 'update'])->name('jenis_obats.update');
    Route::delete('/{jenisObat}', [JenisObatController::class, 'destroy'])->name('jenis_obats.destroy');
});

// Obat Routes
Route::prefix('obat')->group(function () {
    Route::get('/', [ObatController::class, 'index'])->name('obat.index');
    Route::get('/create', [ObatController::class, 'create'])->name('obat.create');
    Route::post('/store', [ObatController::class, 'store'])->name('obat.store');
    Route::get('/{id}/edit', [ObatController::class, 'edit'])->name('obat.edit');
    Route::put('/{id}', [ObatController::class, 'update'])->name('obat.update');
    Route::delete('/{id}', [ObatController::class, 'destroy'])->name('obat.destroy');
});

// Distributor Routes
Route::prefix('distributor')->group(function () {
    Route::get('/', [DistributorController::class, 'index'])->name('distributors.index');
    Route::get('/create', [DistributorController::class, 'create'])->name('distributors.create');
    Route::post('/', [DistributorController::class, 'store'])->name('distributors.store');
    Route::get('/{id}/edit', [DistributorController::class, 'edit'])->name('distributors.edit');
    Route::put('/{id}', [DistributorController::class, 'update'])->name('distributors.update');
    Route::delete('/{id}', [DistributorController::class, 'destroy'])->name('distributors.destroy');
});

Route::prefix('pembelian')->group(function () {
    Route::get('/', [PembelianController::class, 'index'])->name('pembelian.index');
    Route::get('/create', [PembelianController::class, 'create'])->name('pembelian.create');
    Route::post('/', [PembelianController::class, 'store'])->name('pembelian.store');
    Route::get('/{id}/edit', [PembelianController::class, 'edit'])->name('pembelian.edit');
    Route::put('/{id}', [PembelianController::class, 'update'])->name('pembelian.update');
    Route::delete('/{id}', [PembelianController::class, 'destroy'])->name('pembelian.destroy');
});

// Admin Pelanggan Management Routes
Route::prefix('pelanggans')->middleware(['auth:web'])->group(function () {
    Route::get('/', [PelangganController::class, 'index'])->name('pelanggans.index');
    Route::get('/create', [PelangganController::class, 'create'])->name('pelanggans.create');
    Route::post('/', [PelangganController::class, 'store'])->name('pelanggans.store');
    Route::get('/{pelanggan}/edit', [PelangganController::class, 'edit'])->name('pelanggans.edit');
    Route::put('/{pelanggan}', [PelangganController::class, 'update'])->name('pelanggans.update');
    Route::delete('/{pelanggan}', [PelangganController::class, 'destroy'])->name('pelanggans.destroy');
});

Route::prefix('penjualan')->middleware(['auth', RoleAuth::class . ':admin,apoteker,kasir,pemilik'])->group(function () {
    Route::get('/', [PenjualanController::class, 'index'])->name('penjualans.index');
    Route::get('/create', [PenjualanController::class, 'create'])->name('penjualans.create');
    Route::post('/', [PenjualanController::class, 'store'])->name('penjualans.store');
    Route::get('/{penjualan}/edit', [PenjualanController::class, 'edit'])->name('penjualans.edit');
    Route::put('/{penjualan}', [PenjualanController::class, 'update'])->name('penjualans.update');
    Route::post('/{penjualan}/confirm', [PenjualanController::class, 'confirm'])->name('penjualans.confirm');
    Route::delete('/{penjualan}', [PenjualanController::class, 'destroy'])->name('penjualans.destroy');
});

Route::prefix('jenis_pengiriman')->group(function () {
    Route::get('/', [JenisPengirimanController::class, 'index'])->name('jenis_pengirimans.index');
    Route::get('/create', [JenisPengirimanController::class, 'create'])->name('jenis_pengirimans.create');
    Route::post('/', [JenisPengirimanController::class, 'store'])->name('jenis_pengirimans.store');
    Route::get('/{id}/edit', [JenisPengirimanController::class, 'edit'])->name('jenis_pengirimans.edit');
    Route::get('/{id}', [JenisPengirimanController::class, 'show'])->name('jenis_pengirimans.show');
    Route::put('/{id}', [JenisPengirimanController::class, 'update'])->name('jenis_pengirimans.update');
    Route::delete('/{id}', [JenisPengirimanController::class, 'destroy'])->name('jenis_pengirimans.destroy');
});
