<?php

namespace App\Http\Controllers;

use App\Models\tm_barang_inventaris;
use App\Models\tm_peminjaman;
use Illuminate\Http\Request;

class SuperHomeController extends Controller
{
    public function index()
    {
        return view("superhome");
    }

    public function indexhome()
    {
        $jumlahBarang = tm_barang_inventaris::where('br_status', 1)->count();
        $jumlahBarangNonAktif = tm_barang_inventaris::where('br_status', 0)->count();

        $tanggalSekarang = date('Y-m-d');
        $barangMasukHariIni = tm_barang_inventaris::where('br_tgl_terima', '>=', $tanggalSekarang)
            ->where('br_tgl_terima', '<', date('Y-m-d', strtotime($tanggalSekarang . ' +1 days')))
            ->count();


        $peminjamanPerBulan = tm_peminjaman::selectRaw('MONTH(pb_tgl) as bulan, COUNT(*) as total')
            ->groupBy('bulan')
            ->pluck('total', 'bulan')
            ->toArray();

        $dataGrafik = [];
        for ($i = 1; $i <= 12; $i++) {
            $dataGrafik[] = $peminjamanPerBulan[$i] ?? 0;
        }

        return view("super_user.home", compact("jumlahBarang", 'jumlahBarangNonAktif', 'barangMasukHariIni', "dataGrafik"));
    }
}
