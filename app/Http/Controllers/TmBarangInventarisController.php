<?php

namespace App\Http\Controllers;

use App\Models\tm_barang_inventaris;
use App\Http\Requests\Storetm_barang_inventarisRequest;
use App\Http\Requests\Updatetm_barang_inventarisRequest;
use App\Models\tr_jenis_barang;

class TmBarangInventarisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data["barangInventaris"] = Tm_barang_inventaris::all();
        return view("super_user.barang_inventaris.dbarang")->with($data);
    }

    public function showpenerimaan()
    {
        $data["jenisBarang"] = tr_jenis_barang::all();
        return view("super_user.barang_inventaris.pbarang")->with($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Storetm_barang_inventarisRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(tm_barang_inventaris $tm_barang_inventaris)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(tm_barang_inventaris $tm_barang_inventaris)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Updatetm_barang_inventarisRequest $request, tm_barang_inventaris $tm_barang_inventaris)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(tm_barang_inventaris $tm_barang_inventaris)
    {
        //
    }
}
