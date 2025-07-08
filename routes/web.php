<?php

use App\Models\Barang;
use App\Models\Cabangtoko;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\CabangtokoController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PengeluaranController;

Route::group(['middleware' => ['guest']], function () {

    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/authenticate', [AuthController::class, 'authenticate'])->name('authenticate');
  
});

Route::group(['middleware' => ['auth']], function () {

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/pegawai', [PegawaiController::class, 'index'])->name('pegawai.index');
    Route::get('/pegawai/create', [PegawaiController::class, 'create'])->name('pegawai.create');
    Route::get('/pegawai/edit/{id}', [PegawaiController::class, 'edit'])->name('pegawai.edit');
    Route::post('/pegawai/store', [PegawaiController::class, 'store'])->name('pegawai.store');
    Route::post('/pegawai/update/{id}', [PegawaiController::class, 'update'])->name('pegawai.update');
    Route::post('/pegawai/delete/{id}', [PegawaiController::class, 'destroy'])->name('pegawai.delete');

    Route::get('/cabang', [CabangtokoController::class, 'index'])->name('cabang.index');
    Route::get('/cabang/create', [CabangtokoController::class, 'create'])->name('cabang.create');
    Route::post('/cabang/store', [CabangtokoController::class, 'store'])->name('cabang.store');
    Route::get('/cabang/show/{cabangtoko}', [CabangtokoController::class, 'show'])->name('cabang.show');


    Route::get('/barang', [BarangController::class, 'index'])->name('barang.index');
    Route::get('/barang/create', [BarangController::class, 'create'])->name('barang.create');
    Route::get('/barang/edit/{barang}', [BarangController::class, 'edit'])->name('barang.edit');
    Route::post('/barang/store', [BarangController::class, 'store'])->name('barang.store');
    Route::post('/barang/update/{barang}', [BarangController::class, 'update'])->name('barang.update');
    Route::post('/barang/delete/{barang}', [BarangController::class, 'destroy'])->name('barang.delete');

    Route::get('/penjualan', [PenjualanController::class, 'index'])->name('penjualan.index');
    Route::get('/penjualan/create', [PenjualanController::class, 'create'])->name('penjualan.create');
    Route::get('/penjualan/edit/{penjualan}', [PenjualanController::class, 'edit'])->name('penjualan.edit');
    Route::post('/penjualan/store', [PenjualanController::class, 'store'])->name('penjualan.store');
    Route::post('/penjualan/update/{penjualan}', [PenjualanController::class, 'update'])->name('penjualan.update');


    Route::get('/pengeluaran', [PengeluaranController::class, 'index'])->name('pengeluaran.index');
    Route::get('/pengeluaran/create', [PengeluaranController::class, 'create'])->name('pengeluaran.create');
    Route::post('/pengeluaran/store', [PengeluaranController::class, 'store'])->name('pengeluaran.store');


    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/show/{id}', [LaporanController::class, 'show'])->name('laporan.show');
    Route::get('/laporan/laporanformanajer', [LaporanController::class, 'laporanformanajer'])->name('laporan.laporanformanajer');
    Route::get('/laporan/getpenjualan/{id}', [LaporanController::class, 'get_penjualan'])->name('laporan.getpenjualan');
    Route::get('/laporan/exportpdf', [LaporanController::class, 'exportPdf'])->name('laporan.exportpdf');
});
