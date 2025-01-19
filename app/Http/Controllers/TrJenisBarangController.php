<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tr_jenis_barang;

class TrJenisBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function showindex(Request $request)
    {
        $data["tr_jenis_barang"] = tr_jenis_barang::all();
        return view("super_user.referensi.jbarang")->with($data);
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
    public function store(Request $request)
    {
        $request->validate([
            'jns_brg_nama' => 'required|string|max:255',
        ]);

        // Generate kode otomatis
        $newKode = 'JB' . str_pad((tr_jenis_barang::max('jns_brg_kode') ? (int) substr(tr_jenis_barang::max('jns_brg_kode'), 2) + 1 : 1), 3, '0', STR_PAD_LEFT);

        // Simpan data
        tr_jenis_barang::create([
            'jns_brg_kode' => $newKode,
            'jns_brg_nama' => $request->jns_brg_nama,
        ]);

        return redirect('superjbarang')->with('success', 'Data Jenis Barang Berhasil Ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, tr_jenis_barang $tr_jenis_barang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, tr_jenis_barang $tr_jenis_barang)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, tr_jenis_barang $tr_jenis_barang)
    // {
    //     $validatedData = $request->validate([
    //         'jns_brg_kode' => 'required|unique:tr_jenis_barang,jns_brg_kode,' . $tr_jenis_barang->id,
    //         'jns_brg_nama' => 'required',
    //     ]);

    //     $tr_jenis_barang->update($validatedData);

    //     return redirect('superjbarang')->with('success', 'Data Jenis Barang Berhasil Diubah!');
    // }

    public function update(Request $request, $jns_brg_kode)
    {
        // Mencari data barang berdasarkan kode
        $tr_jenis_barang = tr_jenis_barang::where('jns_brg_kode', $jns_brg_kode)->firstOrFail();

        // Validasi input
        $validatedData = $request->validate([
            'jns_brg_nama' => 'required',
        ]);

        // Update data
        $tr_jenis_barang->update($validatedData);

        return redirect('superjbarang')->with('success', 'Data Jenis Barang Berhasil Diubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $jns_brg_kode)
    {
        // Mencari data barang berdasarkan kode
        $tr_jenis_barang = tr_jenis_barang::where('jns_brg_kode', $jns_brg_kode)->firstOrFail();

        // Hapus data
        $tr_jenis_barang->delete();

        return redirect('superjbarang')->with('success', 'Data Jenis Barang Berhasil Dihapus!');
    }
}
