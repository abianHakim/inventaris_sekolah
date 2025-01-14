<?php

use App\Http\Controllers\AuthContoller;
use App\Http\Controllers\SuperHomeController;
use App\Http\Controllers\TmBarangInventarisController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('super_user.home');
});



Route::get('login', [AuthContoller::class, 'index'])->name('login');
Route::get('register', [AuthContoller::class, 'showRegisterForm'])->name('register');
Route::post('register', [AuthContoller::class, 'register'])->name('buatAkun');
Route::post('login', [AuthContoller::class, 'login'])->name('login');


Route::get('superhome', [SuperHomeController::class, 'index'])->name('superhome');
Route::get('superdbarang', [TmBarangInventarisController::class, 'index'])->name('dbarang');
Route::get('superpbarang', [TmBarangInventarisController::class, 'showpenerimaan'])->name('pbarang');
