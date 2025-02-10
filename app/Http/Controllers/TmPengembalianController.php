<?php

namespace App\Http\Controllers;

use App\Models\tm_peminjaman;
use App\Models\tm_pengembalian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;  // Tambahkan Import Auth

class TmPengembalianController extends Controller
{
    public function index()
    {
        // Ambil semua peminjaman yang BELUM dikembalikan
        $peminjaman = tm_peminjaman::with(['siswa', 'detailPeminjaman.barang'])
            ->whereDoesntHave('pengembalian')
            ->get();

        return view("super_user.peminjaman_barang.pebarang", compact('peminjaman'));
    }

    public function belumkembali()
    {
        $peminjaman = tm_peminjaman::with(['siswa', 'detailPeminjaman.barang'])
            ->whereDoesntHave('pengembalian')
            ->where('pb_stat', 1)
            ->get();
        return view("super_user.peminjaman_barang.barangbk", compact("peminjaman"));
    }

    public function store(Request $request)
    {
        // Validasi request
        $request->validate([
            'pb_id' => 'required|exists:tm_peminjaman,pb_id',
        ]);

        // Ambil data peminjaman berdasarkan pb_id
        $peminjaman = tm_peminjaman::with('detailPeminjaman.barang')->findOrFail($request->pb_id);

        // Membuat ID pengembalian otomatis
        $tahun = date('Y');
        $bulan = date('m');
        $lastReturn = tm_pengembalian::whereYear('kembali_tgl', $tahun)
            ->whereMonth('kembali_tgl', $bulan)
            ->orderBy('kembali_id', 'desc')
            ->first();
        $newNumber = str_pad(($lastReturn ? (int) substr($lastReturn->kembali_id, -3) + 1 : 1), 3, '0', STR_PAD_LEFT);
        $kembali_id = "KB{$tahun}{$bulan}{$newNumber}";

        // Simpan data pengembalian
        $pengembalian = tm_pengembalian::create([
            'kembali_id' => $kembali_id,
            'pb_id' => $peminjaman->pb_id,
            'user_id' => Auth::id(),
            'kembali_tgl' => now(),
            'kembali_sts' => 1,
        ]);

        // Update status barang menjadi tersedia kembali
        foreach ($peminjaman->detailPeminjaman as $detail) {
            $detail->barang->update(['br_status' => 1]);
        }

        // Update status peminjaman menjadi dikembalikan
        $peminjaman->update(['pb_stat' => 0]);

        // Flash message dan redirect ke daftar peminjaman
        session()->flash('success', 'Barang berhasil dikembalikan!');
        return redirect()->route('pebarang');
    }
}
