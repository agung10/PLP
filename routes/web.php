<?php

use Illuminate\Support\Facades\Route;

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
Route::get('admin-management/tagihan/pembayaran-tagihan/{pelangganId}', [App\Http\Controllers\TagihanController::class, 'pembayaranTagihan'])->name('tagihan.pembayaranTagihan');
Route::get('pelanggan-management/tagihan-pelanggan/pembayaran/{tagihanId}', [App\Http\Controllers\TagihanController::class, 'pembayaranPelanggan'])->name('tagihan-pelanggan.pembayaranPelanggan');

Route::get('laporan/cetak-penggunaan/{bulanOrTahun}', [App\Http\Controllers\PrintController::class, 'printPenggunaan'])->name('laporan.printPenggunaan');
Route::get('laporan/cetak-tagihan/{bulanOrTahun}', [App\Http\Controllers\PrintController::class, 'printTagihan'])->name('laporan.printTagihan');
Route::get('laporan/cetak-pembayaran/{bulanOrTahun}', [App\Http\Controllers\PrintController::class, 'printPembayaran'])->name('laporan.printPembayaran');

Route::group(['middleware' => ['auth', 'web', 'check.route']], function () {
    // LANDING PAGE
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    // DASHBOARD
    Route::get('dashboard', [App\Http\Controllers\Dashboard\DashboardController::class, 'index'])->name('dashboard.index');

    // ROLE MANAGEMENT
    Route::prefix('role-management')->group(function () {
        // role
        Route::get('/role/ajaxDatatable', [App\Http\Controllers\RoleManagement\RoleController::class, 'ajaxDatatable'])->name('role.ajaxDatatable');
        Route::resource('role', 'App\Http\Controllers\RoleManagement\RoleController', ['names' => 'role']);

        // menu
        Route::get('/menu/ajaxDatatable', [App\Http\Controllers\RoleManagement\MenuController::class, 'ajaxDatatable'])->name('menu.ajaxDatatable');
        Route::resource('menu', 'App\Http\Controllers\RoleManagement\MenuController', ['names' => 'menu']);

        // permission
        Route::get('/permission/ajaxDatatable', [App\Http\Controllers\RoleManagement\PermissionController::class, 'ajaxDatatable'])->name('permission.ajaxDatatable');
        Route::resource('permission', 'App\Http\Controllers\RoleManagement\PermissionController', ['names' => 'permission']);

        // role-menu
        Route::get('/role-menu/ajaxDatatable', [App\Http\Controllers\RoleManagement\RoleMenuController::class, 'ajaxDatatable'])->name('role-menu.ajaxDatatable');
        Route::resource('role-menu', 'App\Http\Controllers\RoleManagement\RoleMenuController', ['names' => 'role-menu']);

        // menu-permission
        Route::get('/menu-permission/ajaxDatatable', [App\Http\Controllers\RoleManagement\MenuPermissionController::class, 'ajaxDatatable'])->name('menu-permission.ajaxDatatable');
        Route::resource('menu-permission', 'App\Http\Controllers\RoleManagement\MenuPermissionController', ['names' => 'menu-permission']);

        // user
        Route::get('/user/ajaxDatatable', [App\Http\Controllers\RoleManagement\UserController::class, 'ajaxDatatable'])->name('user.ajaxDatatable');
        Route::resource('user', 'App\Http\Controllers\RoleManagement\UserController', ['names' => 'user']);

    });
    /** END:ROLE MANAGEMENT **/

    // ADMIN MANAGEMENT
    Route::prefix('admin-management')->group(function () {
        // tarif
        Route::get('/tarif-listrik/ajaxDatatable', [App\Http\Controllers\TarifController::class, 'ajaxDatatable'])->name('tarif-listrik.ajaxDatatable');
        Route::resource('tarif-listrik', 'App\Http\Controllers\TarifController', ['names' => 'tarif-listrik']);

        // pelanggan
        Route::get('/pelanggan/ajaxDatatable', [App\Http\Controllers\PelangganController::class, 'ajaxDatatable'])->name('pelanggan.ajaxDatatable');
        Route::resource('pelanggan', 'App\Http\Controllers\PelangganController', ['names' => 'pelanggan']);

        // penggunaan
        Route::get('/penggunaan/ajaxDatatable', [App\Http\Controllers\PenggunaanController::class, 'ajaxDatatable'])->name('penggunaan.ajaxDatatable');
        Route::resource('penggunaan', 'App\Http\Controllers\PenggunaanController', ['names' => 'penggunaan']);

        // tagihan
        Route::get('/tagihan/getDataPenggunaan', [App\Http\Controllers\TagihanController::class, 'getDataPenggunaan'])->name('tagihan.getDataPenggunaan');
        Route::get('/tagihan/ajaxDatatable', [App\Http\Controllers\TagihanController::class, 'ajaxDatatable'])->name('tagihan.ajaxDatatable');
        Route::resource('tagihan', 'App\Http\Controllers\TagihanController', ['names' => 'tagihan']);

        // pembayaran
        Route::get('/pembayaran/getDataPelanggan', [App\Http\Controllers\PembayaranController::class, 'getDataPelanggan'])->name('pembayaran.getDataPelanggan');
        Route::get('/pembayaran/ajaxDatatable', [App\Http\Controllers\PembayaranController::class, 'ajaxDatatable'])->name('pembayaran.ajaxDatatable');
        Route::resource('pembayaran', 'App\Http\Controllers\PembayaranController', ['names' => 'pembayaran']);
    });
    /** END:ADMIN MANAGEMENT **/

    // PELANGGAN MANAGEMENT
    Route::prefix('pelanggan-management')->group(function () {
        Route::get('/pelanggan-pelanggan/ajaxDatatable', [App\Http\Controllers\PelangganController::class, 'ajaxDatatable'])->name('pelanggan-pelanggan.ajaxDatatable');
        Route::resource('pelanggan-pelanggan', 'App\Http\Controllers\PelangganController', ['names' => 'pelanggan-pelanggan']);

        Route::get('/penggunaan-pelanggan/ajaxDatatable', [App\Http\Controllers\PenggunaanController::class, 'ajaxDatatable'])->name('penggunaan-pelanggan.ajaxDatatable');
        Route::resource('penggunaan-pelanggan', 'App\Http\Controllers\PenggunaanController', ['names' => 'penggunaan-pelanggan']);
        
        Route::get('/tagihan-pelanggan/ajaxDatatable', [App\Http\Controllers\TagihanController::class, 'ajaxDatatable'])->name('tagihan-pelanggan.ajaxDatatable');
        Route::resource('tagihan-pelanggan', 'App\Http\Controllers\TagihanController', ['names' => 'tagihan-pelanggan']);

        Route::get('/pembayaran-pelanggan/ajaxDatatable', [App\Http\Controllers\PembayaranController::class, 'ajaxDatatable'])->name('pembayaran-pelanggan.ajaxDatatable');
        Route::resource('pembayaran-pelanggan', 'App\Http\Controllers\PembayaranController', ['names' => 'pembayaran-pelanggan']);
    });
    /** END:PELANGGAN MANAGEMENT **/
});

Auth::routes();
