<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DaftarPengguna;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\laporan;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\SuperHomeController;
use App\Http\Controllers\TmBarangInventarisController;
use App\Http\Controllers\TmPeminjamanController;
use App\Http\Controllers\TmPengembalianController;
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

// PEMINAJAMN BARANG
Route::get('supertransaksi', [TmPeminjamanController::class, 'transaksi'])->name('transaksi');
Route::get('superpeminjaman', [TmPeminjamanController::class, 'index'])->name('peminjaman.index');
Route::post('superpeminjaman', [TmPeminjamanController::class, 'store'])->name('peminjaman.store');
Route::get('superpebarang', [TmPengembalianController::class, 'index'])->name('pebarang');
Route::get('superbarangbelumkembali', [TmPengembalianController::class, 'belumkembali'])->name('barangbk');
Route::post('superpengembalian', [TmPengembalianController::class, 'store'])->name('pengembalian.store');

// LAPORAN
Route::get('super-laporan-barang', [laporan::class, 'laporanbarang'])->name('laporanbarang');
Route::get('super-laporan-pengembalian', [laporan::class, 'pengembalian'])->name('pengembalianbarang');
Route::get('super-laporan-status', [laporan::class, 'laporanstatus'])->name('statusbarang');

// REFERENSI
// cek barang terkait
Route::get('check-barang-terkait/{kode}', [TrJenisBarangController::class, 'checkBarangTerkait']);
//jenis barang
Route::get('superjbarang', [TrJenisBarangController::class, 'showindex'])->name('jbarang');
Route::post('superjbarang', [TrJenisBarangController::class, 'store'])->name('jbarang.store');
Route::patch('superjbarang/{jns_brg_kode}', [TrJenisBarangController::class, 'update'])->name('jbarang.update');
Route::delete('superjbarang/{jns_brg_kode}', [TrJenisBarangController::class, 'destroy'])->name('jbarang.destroy');

//daftar pengguna
Route::get('superdpengguna', [daftarPengguna::class, 'index'])->name('dpengguna');
Route::post('superdpengguna', [daftarPengguna::class, 'store'])->name('dpengguna.store');
Route::patch('superdpengguna/{id}', [DaftarPengguna::class, 'update'])->name('dpengguna.update');
Route::delete('superdpengguna/{id}', [DaftarPengguna::class, 'destroy'])->name('dpengguna.destroy');


//data siswa
Route::get('supersiswa', [SiswaController::class, 'index'])->name('siswa');
Route::post('supersiswa', [SiswaController::class, 'store'])->name('siswa.store');
Route::patch('supersiswa/{siswa_id}', [SiswaController::class, 'update'])->name('siswa.update');
Route::delete('supersiswa/{siswa_id}', [SiswaController::class, 'destroy'])->name('siswa.destroy');

//kelas
Route::get('superkelas', [KelasController::class, 'index'])->name('kelas');
Route::post('superkelas', action: [KelasController::class, 'store'])->name('kelas.store');
Route::patch('superkelas/{id}', [KelasController::class, 'update'])->name('kelas.update');
Route::delete('superkelas/{id}', [KelasController::class, 'destroy'])->name('kelas.destroy');
