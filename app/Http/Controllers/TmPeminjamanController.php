<?php

namespace App\Http\Controllers;

use App\Models\siswa;
use App\Models\td_peminjaman_barang;
use App\Models\tm_barang_inventaris;
use App\Models\tm_peminjaman;
use App\Http\Requests\Storetm_peminjamanRequest;
use App\Http\Requests\Updatetm_peminjamanRequest;
use App\Models\tr_jenis_barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

// use Illuminate\Support\Facades\Request;

class TmPeminjamanController extends Controller
{

    public function  index()
    {
        $peminjaman = tm_peminjaman::with(['siswa', 'user', 'detailPeminjaman.barang'])->get();
        $siswa = siswa::all();
        $barang = tm_barang_inventaris::where('br_status', 1)->get();

        return view('super_user.peminjaman_barang.dpeminjaman', compact('peminjaman', 'siswa', 'barang'));
    }

    public function transaksi()
    {
        $peminjaman = tm_peminjaman::with(['siswa', 'user', 'detailPeminjaman.barang'])->get();
        $siswa = siswa::all();
        $barang = tm_barang_inventaris::with('jenisBarang')->where('br_status', 1)->get();
        return view('super_user.peminjaman_barang.transaksi', compact('peminjaman', 'siswa', 'barang'));
    }


    public function store(Request $request)
    {
        Log::info('Data request:', $request->all());
        $request->validate([
            'siswa_id' => 'required',
            'user_id' => 'required',
            'barang' => 'required|array',
            'tanggal_kembali' => 'required|date',
        ]);

        $barangArray = $request->barang;

        $tahunBulan = now()->format('Ym');
        $latestPeminjaman = tm_peminjaman::where('pb_id', 'LIKE', "PJ$tahunBulan%")
            ->latest('pb_id')
            ->first();

        $noUrut = $latestPeminjaman ? ((int)substr($latestPeminjaman->pb_id, -4)) + 1 : 1;
        $pbId = "PJ$tahunBulan" . sprintf('%04d', $noUrut);

        DB::beginTransaction();

        try {
            // Membuat data peminjaman utama
            $peminjaman = tm_peminjaman::create([
                'pb_id' => $pbId,
                'user_id' => $request->user_id,
                'siswa_id' => $request->siswa_id,
                'pb_tgl' => now(),
                'pb_harus_kembali_tgl' => $request->tanggal_kembali,
                'pb_stat' => 1,
            ]);

            // Membuat detail peminjaman barang
            foreach ($barangArray as $index => $brKode) {
                $pbdId = $pbId . sprintf('%03d', $index + 1);

                td_peminjaman_barang::create([
                    'pbd_id' => $pbdId,
                    'pb_id' => $pbId,
                    'br_kode' => $brKode,
                    'pdb_tgl' => now(),
                    'pdb_sts' => 1, // Status "masih dipinjam"
                ]);

                // Update status barang menjadi tidak tersedia
                tm_barang_inventaris::where('br_kode', $brKode)->update(['br_status' => 0]);
            }

            DB::commit();

            session()->flash('success', 'Peminjaman berhasil dibuat!');
            return redirect()->route('peminjaman.index');
        } catch (\Exception $e) {
            // Rollback jika ada error
            DB::rollBack();

            // Mengirim session error jika terjadi kesalahan
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
            return redirect()->route('peminjaman.index');
        }
    }
}
