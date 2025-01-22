<?php

namespace App\Http\Controllers;

use App\Models\tm_barang_inventaris;
use App\Http\Requests\Storetm_barang_inventarisRequest;
use App\Http\Requests\Updatetm_barang_inventarisRequest;
use App\Models\tr_jenis_barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TmBarangInventarisController extends Controller
{


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data["barangInventaris"] = Tm_barang_inventaris::all();
        $data["jenisBarang"] = tr_jenis_barang::all();
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
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'user_id' => 'required|string',
            'jns_brg_kode' => 'required|string',
            'br_nama' => 'required|string|max:50',
            'br_tgl_terima' => 'required|date',
            'br_status' => 'required|in:0,1',
        ]);

        // Buat kode barang (langsung di sini)
        $tahun = date('Y');
        $prefix = "INV{$tahun}";

        // Cari kode barang terakhir berdasarkan tahun ini
        $lastBarang = tm_barang_inventaris::where('br_kode', 'LIKE', "$prefix%")
            ->orderBy('br_kode', 'desc')
            ->first();

        // Hitung nomor urut
        $lastNumber = $lastBarang ? intval(substr($lastBarang->br_kode, -5)) : 0;
        $newNumber = str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);

        // Gabungkan prefix dan nomor urut untuk kode barang
        $kodeBarang = "{$prefix}{$newNumber}";

        // Simpan data ke database
        tm_barang_inventaris::create([
            'br_kode' => $kodeBarang, // Kode barang yang dihasilkan
            'jns_brg_kode' => $validated['jns_brg_kode'],
            'user_id' => $validated['user_id'], // Diambil dari input hidden form
            'br_nama' => $validated['br_nama'],
            'br_tgl_terima' => $validated['br_tgl_terima'],
            'br_tgl_entry' => now(),
            'br_status' => $validated['br_status'],
        ]);

        session()->flash('success', 'Data Barang berhasil ditambahkan.');

        return redirect()->route('dbarang')->with('success', 'Data berhasil disimpan dengan kode barang: ' . $kodeBarang);
    }


    public function update(Request $request, $br_kode)
    {
        $validated = $request->validate([
            'br_nama' => 'required|string|max:50',
            'jns_brg_kode' => 'required|string',
            'br_tgl_terima' => 'required|date',
            'br_status' => 'required|in:0,1',
        ]);

        // Update data barang
        $barang = tm_barang_inventaris::where('br_kode', $br_kode)->first();
        $barang->update([
            'br_nama' => $validated['br_nama'],
            'jns_brg_kode' => $validated['jns_brg_kode'],
            'br_tgl_terima' => $validated['br_tgl_terima'],
            'br_status' => $validated['br_status'],
        ]);

        return redirect()->route('dbarang')->with('success', 'Data barang berhasil diperbarui.');
    }

    public function destroy($br_kode)
    {
        $barang = Tm_barang_inventaris::find($br_kode);

        if ($barang) {
            $barang->delete();
            return redirect()->route('dbarang')->with('success', 'Barang berhasil dihapus.');
        } else {
            return redirect()->route('dbarang')->with('error', 'Barang tidak ditemukan.');
        }
    }

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
}
