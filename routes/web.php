<?php

use App\Http\Controllers\AuthContoller;
use App\Http\Controllers\SuperHomeController;
use App\Http\Controllers\TmBarangInventarisController;
use App\Http\Controllers\TrJenisBarangController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
});

Route::get('login', [AuthContoller::class, 'index'])->name('login');
Route::get('register', [AuthContoller::class, 'showRegisterForm'])->name('register');
Route::post('register', [AuthContoller::class, 'register'])->name('buatAkun');
Route::post('login', [AuthContoller::class, 'login'])->name('login');
Route::post('logout', [AuthContoller::class, 'logout'])->name('logout');


Route::prefix('super-user')->name('superuser.')->group(function () {



    //dashboard
    Route::get('superhome', [SuperHomeController::class, 'jumlahBarang'])->name('superhome');

    //daftar barang
    Route::get('superdbarang', [TmBarangInventarisController::class, 'index'])->name('dbarang');
    //penerimaan barang
    Route::get('superpbarang', [TmBarangInventarisController::class, 'showpenerimaan'])->name('pbarang');

    //jenis barang
    Route::get('superjbarang', [TrJenisBarangController::class, 'showindex'])->name('jbarang');
    Route::post('superjbarang', [TrJenisBarangController::class, 'store'])->name('jbarang.store');
});
