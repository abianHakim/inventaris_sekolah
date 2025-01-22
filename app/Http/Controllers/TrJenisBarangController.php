<?php

namespace App\Http\Controllers;

use App\Models\tm_barang_inventaris;
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
        // Mencari data jenis barang berdasarkan kode
        $tr_jenis_barang = tr_jenis_barang::where('jns_brg_kode', $jns_brg_kode)->firstOrFail();

        // Cek apakah ada barang yang terkait dengan jenis barang ini
        $barangTerkait = tm_barang_inventaris::where('jns_brg_kode', $jns_brg_kode)->exists();

        if ($barangTerkait) {
            // Jika ada barang yang terkait, redirect dengan pesan error
            return redirect('superjbarang')->with('error', 'Jenis Barang ini tidak dapat dihapus karena ada barang yang terkait.');
        }

        // Jika tidak ada barang yang terkait, lanjutkan dengan penghapusan data jenis barang
        $tr_jenis_barang->delete();

        // Redirect dengan pesan sukses
        return redirect('superjbarang')->with('success', 'Data Jenis Barang Berhasil Dihapus!');
    }

    public function checkBarangTerkait($kode)
    {
        // Cek apakah ada barang yang terkait dengan jenis barang ini
        $barangTerkait = tm_barang_inventaris::where('jns_brg_kode', $kode)->exists();

        // Mengembalikan response dalam format JSON
        return response()->json(['barangTerkait' => $barangTerkait]);
    }
}
