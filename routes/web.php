<?php
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\LelangController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VarianController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/loginadmin', [AdminController::class, 'index'])->name('loginadmin');

Route::get('/login', [CustomerController::class, 'login'])->name('login');
Route::get('/dashboard', [CustomerController::class, 'dashboard'])->name('dashboard');
Route::get('/detailproduk/{id}', [CustomerController::class, 'detailproduk'])->name('detailproduk');
Route::get('/pesanan', [CustomerController::class, 'pesanan'])->name('pesanan');
Route::get('/bantuan', [CustomerController::class, 'bantuan'])->name('bantuan');
// Route::get('/detaillelang', [CustomerController::class, 'detaillelang'])->name('detaillelang');
// // Route::get('/riwayatlelang', [CustomerController::class, 'riwayatlelang'])->name('riwayatlelang');
// Route::get('/profil', [CustomerController::class, 'profil'])->name('profil');
// // Route::get('/riwayat', [CustomerController::class, 'riwayat'])->name('riwayat');
// Route::get('/detailpembelian', [CustomerController::class, 'detailpembelian'])->name('detailpembelian');

Route::get('/produkreg', [CustomerController::class, 'produkreg'])->name('produkreg');
Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware('guest:admin')->group(function () {
    Route::get('/loginadmin', [AuthController::class, 'login'])->name('loginadmin');
    Route::post('login', [AuthController::class, 'processlogin'])->name('login');
});

Route::middleware('guest:web')->group(function () {
    Route::get('/loginuser', [AuthController::class, 'loginCustomer'])->name('loginuser');
    Route::post('login', [AuthController::class, 'processlogin'])->name('login');
    Route::resource('user', UserController::class);
});
Route::middleware('auth:web')->group(function () {
    Route::resource('keranjang', KeranjangController::class);
    Route::post('/keranjang/{id}', [KeranjangController::class, 'store'])->name('keranjang.store');
    
    Route::resource('profil', ProfilController::class);
    Route::put('profil', [ProfilController::class, 'editPassword'])->name('profil.editpass');
    Route::put('alamat', [ProfilController::class, 'updateAlamat'])->name('profil.updateAlamat');
    Route::get('logoutuser', [AuthController::class, 'logoutuser'])->name('logoutuser');
    Route::get('lelangprod', [LelangController::class, 'lelangShow'])->name('lelangprod');
    Route::get('detail/{id}/api', [LelangController::class, 'data_lelang'])->name('lelang.api');
    Route::get('detail/{id}', [LelangController::class, 'lelangDetail'])->name('lelang.detail');
    Route::post('/pengingat/{id_produk_lelang}', [LelangController::class, 'addPengingat'])->name('lelang.pengingat');
    Route::post('/pengingat/{id_produk_lelang}/detail', [LelangController::class, 'addPengingatDetail'])->name('lelang.pengingat.detail');
    Route::post('/penawaran/{id}', [LelangController::class, 'addPenawaran'])->name('lelang.penawaran');
    Route::post('/cancel/{id}/{id_lelang}', [LelangController::class, 'lelangCancel'])->name('lelang.cancel');
    Route::post('riwayatconfirm/{id}', [LelangController::class, 'riwayatlelangConfirm'])->name('riwayatlelang.confirm');
    Route::post('/confirm/{id}/{id_lelang}', [LelangController::class, 'lelangConfirm'])->name('lelang.confirm');
    Route::post('/riwayatcancel/{id}/{id_lelang}', [LelangController::class, 'riwayatlelangCancel'])->name('riwayatlelang.cancel');
    Route::get('riwayatlelang', [LelangController::class, 'riwayatLelang'])->name('lelang.riwayat');
    Route::get('pesananlelang/{id}', [LelangController::class, 'pesananLelang'])->name('lelang.pesanan');
    Route::post('/pembayaran/{id}', [LelangController::class, 'checkoutLelang'])->name('lelang.checkout');
    Route::get('/pembayaran/{id}', [LelangController::class, 'checkoutLelangView'])->name('lelang.checkout.view');
    
    Route::get('/belilangsung/{id}', [ProdukController::class, 'beliLangsung'])->name('produk.langsung');

    Route::get('/pesananproduk', [ProdukController::class, 'pesananProduk'])->name('produk.pesanan');
    Route::get('/bayar/{id}', [ProdukController::class, 'beliProdukView'])->name('produk.beli.view');
    Route::post('/beliproduk', [ProdukController::class, 'beliProduk'])->name('produk.beli');
    Route::get('/terima/{id}', [ProdukController::class, 'Terima'])->name('produk.terima');
    Route::get('/lelangterima/{id}', [LelangController::class, 'LelangTerima'])->name('lelang.terima');
    Route::get('/riwayat', [ProdukController::class, 'riwayat'])->name('produk.riwayat');
    Route::post('/ulasan', [ProdukController::class, 'ulasan'])->name('produk.ulasan');

});
Route::middleware('auth:admin')->group(function () {
    Route::resource('lelang', LelangController::class);
    Route::put('/produk/edit/{produk}', [ProdukController::class, 'update'])->name('produk.update');
    Route::resource('produk', ProdukController::class);
    Route::get('produk/edit/{id}', [ProdukController::class, 'edit'])->name('produk.edit');
    Route::get('/varian/edit/{id}', [VarianController::class, 'edit'])->name('varian.edit');
    Route::put('/varian/edit/{id}', [VarianController::class, 'update'])->name('varian.update');
    Route::resource('varian', VarianController::class);
    Route::post('/lelang/{id}', [LelangController::class, 'lelangStart'])->name('lelang.start');
    Route::post('/lelangs/{id}', [LelangController::class, 'lelangEnd'])->name('lelang.end');
    Route::delete('/varian/destroy/{id}/{id_produk}', [VarianController::class, 'destroy'])->name('varian.destroy');
    Route::get('/dashboardadmin', [AdminController::class, 'dashboard'])->name('dashboardadmin');
    Route::get('/transaksiproduk', [AdminController::class, 'transaksiIndex'])->name('transaksi.index');
    Route::get('transaksidetail/{id}', [AdminController::class, 'transaksiDetail'])->name('transaksi.detail');

    Route::get('/customer', [AdminController::class, 'CustomerIndex'])->name('customer.index');
    Route::get('customerdetail/{id}', [AdminController::class, 'CustomerDetail'])->name('customer.detail');

    Route::get('/transaksilelang', [AdminController::class, 'transaksiLelangIndex'])->name('transaksi.lelang.index');
    Route::get('transaksidlelangetail/{id}', [AdminController::class, 'transaksiLelangDetail'])->name('transaksi.lelang.detail');
    Route::post('/addresi/{id}', [ProdukController::class, 'addResi'])->name('addResi');
    Route::get('/confirm/{id}', [ProdukController::class, 'TransaksiConfirm'])->name('confirm');
    Route::get('/aktif/{id}', [LelangController::class, 'AktConfirm'])->name('confirm');
    Route::get('/aktif/{id}', [LelangController::class, 'Aktif'])->name('lelang.aktif');
    Route::get('/nonaktif/{id}', [LelangController::class, 'nonAktif'])->name('lelang.nonaktif');
    Route::get('/cancel/{id}', [ProdukController::class, 'TransaksiCancel'])->name('cancel');
    Route::get('/end/{id}', [ProdukController::class, 'TransaksiEnd'])->name('end');
    Route::post('/addresilelang/{id}', [LelangController::class, 'addResi'])->name('addResi.lelang');
    Route::get('/confirmlelang/{id}', [LelangController::class, 'TransaksiConfirm'])->name('confirm.lelang');
    Route::get('/cancellelang/{id}', [LelangController::class, 'TransaksiCancel'])->name('cancel.lelang');
    Route::get('/cancelpenawaran/{id}', [LelangController::class, 'CancelLelang'])->name('cancel.penawaran');
    Route::get('/endlelang/{id}', [LelangController::class, 'TransaksiEnd'])->name('end.lelang');
    Route::get('/public-disk', function () {
        Storage::disk('public');
        Route::get('/retrieve-public-file', function () {
            if (Storage::disk('public')) {
                $contents = Storage::disk('public');
            } else {
                $contents = 'File does not exist';
            }
            return $contents;
        });
    });
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
});




// Route::get('/data', [AdminController::class, 'showData'])->name('data');