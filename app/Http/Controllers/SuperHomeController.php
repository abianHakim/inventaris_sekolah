<?php

namespace App\Http\Controllers;

use App\Models\tm_barang_inventaris;
use Illuminate\Http\Request;

class SuperHomeController extends Controller
{
    public function index()
    {
        return view("super_user.home");
    }

    public function jumlahBarang()
    {
        $jumlahBarang = tm_barang_inventaris::count();

        return view("super_user.home", compact("jumlahBarang"));
    }
}
