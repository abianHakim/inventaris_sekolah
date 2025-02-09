<?php

namespace App\Http\Controllers;

use App\Models\tm_barang_inventaris;
use App\Models\tm_pengembalian;
use App\Models\tr_jenis_barang;
use Illuminate\Http\Request;

class laporan extends Controller
{
    public function laporanbarang()
    {
        $barang = tm_barang_inventaris::with('jenisBarang')->where('br_status', 1)->get();
        $jenisBarang = tr_jenis_barang::all();
        return view("super_user.laporan.barangtersedia", compact("barang", "jenisBarang"));
    }

    public function pengembalian()
    {
        $pengembalian = tm_pengembalian::with([
            'user',
            'peminjaman.detailPeminjaman.barang'
        ])->get();

        return view("super_user.laporan.laporanpengembalian", compact("pengembalian"));
    }



    public function laporanstatus()
    {
        $barang = tm_barang_inventaris::with('jenisBarang')->get();
        return view("super_user.laporan.laporanstatus", compact("barang"));
    }
}
