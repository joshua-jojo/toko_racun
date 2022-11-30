<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\settings\SettingsController;
use App\Http\Controllers\settings\TokoController;
use App\Http\Controllers\settings\UserController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('dashboard.index');
});

Route::group(['middleware' => ['login', 'lock_mode']], function () {
    Route::resource('dashboard', DashboardController::class);

    Route::resource('satuan', SatuanController::class);
    Route::resource('kategori', KategoriController::class);
    Route::resource('produk', ProdukController::class);

    Route::resource('penjualan', PenjualanController::class);
    Route::resource('transaksi', TransaksiController::class);
    Route::resource('pengeluaran', PengeluaranController::class);
    Route::resource('pembelian', PembelianController::class);
    Route::resource('member', MemberController::class);
    Route::resource('supplier', SupplierController::class);
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::resource('menu', SettingsController::class);
        Route::resource('toko', TokoController::class);
        Route::resource('user', UserController::class);
    });
});

Route::prefix('auth')->group(function () {
    Route::get('lock', [TransaksiController::class, 'lock'])->name('lock');
    Route::post('unlock', [TransaksiController::class, 'unlock'])->name('unlock');
    Route::get('login', [LoginController::class, 'index'])->name('form-login');
    Route::post('login', [LoginController::class, 'login'])->name('cek-login');
    Route::get('logout', [LoginController::class, 'logout'])->name('logout_user');
    Route::get('get/user', [LoginController::class, 'get_user'])->name('get_user');
});

require __DIR__ . '/auth.php';
