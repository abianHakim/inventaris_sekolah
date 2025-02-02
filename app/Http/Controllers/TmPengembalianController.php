<?php

namespace App\Http\Controllers;

use App\Models\tm_pengembalian;
use App\Http\Requests\Storetm_pengembalianRequest;
use App\Http\Requests\Updatetm_pengembalianRequest;

class TmPengembalianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pengembalian = tm_pengembalian::with(['peminjaman', 'user'])->get();

        // Kirim data ke view
        return view("super_user.peminjaman_barang.pebarang", compact('pengembalian'));
    }


    public function belumkembali()
    {
        return view("super_user.peminjaman_barang.barangbk");
    }
}
