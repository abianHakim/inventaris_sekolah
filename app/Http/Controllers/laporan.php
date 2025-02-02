<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class laporan extends Controller
{
    public function laporanbarang()
    {
        return view("super_user.laporan.laporanbarang");
    }

    public function pengembalian()
    {
        return view("super_user.laporan.laporanpengembalian");
    }

    public function laporanstatus()
    {
        return view("super_user.laporan.laporanstatus");
    }
}
