<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DaftarPengguna;
use App\Http\Controllers\SuperHomeController;
use App\Http\Controllers\TmBarangInventarisController;
use App\Http\Controllers\TrJenisBarangController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
});


Route::get('login', [AuthController::class, 'index'])->name('showlogin');
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('register', [AuthController::class, 'register'])->name('buatAkun');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');


//dashboard
Route::get('superhome', [SuperHomeController::class, 'indexhome'])->name('superhome');
//daftar barang
Route::get('superdbarang', [TmBarangInventarisController::class, 'index'])->name('dbarang');
Route::patch('superdbarang/{br_kode}/update', [TmBarangInventarisController::class, 'update'])->name('pbarang.update');
Route::delete('superdbarang/{br_kode}/destroy', [TmBarangInventarisController::class, 'destroy'])->name('pbarang.destroy');


//penerimaan barang
Route::get('superpbarang', [TmBarangInventarisController::class, 'showpenerimaan'])->name('pbarang');
Route::post('superpbarang', [TmBarangInventarisController::class, 'store'])->name('pbarang.store');



// cek barang terkait
Route::get('check-barang-terkait/{kode}', [TrJenisBarangController::class, 'checkBarangTerkait']);
//jenis barang
Route::get('superjbarang', [TrJenisBarangController::class, 'showindex'])->name('jbarang');
Route::post('superjbarang', [TrJenisBarangController::class, 'store'])->name('jbarang.store');
Route::patch('superjbarang/{jns_brg_kode}', [TrJenisBarangController::class, 'update'])->name('jbarang.update');
Route::delete('superjbarang/{jns_brg_kode}', [TrJenisBarangController::class, 'destroy'])->name('jbarang.destroy');

//daftar pengguna
Route::get('superdpengguna', [daftarPengguna::class, 'index'])->name('dpengguna');
