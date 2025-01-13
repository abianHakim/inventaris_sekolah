<?php

use App\Http\Controllers\AuthContoller;
use App\Http\Controllers\SuperHomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});



Route::get('login', [AuthContoller::class, 'index'])->name('login');

Route::get('superhome', [SuperHomeController::class, 'index'])->name('superhome');
