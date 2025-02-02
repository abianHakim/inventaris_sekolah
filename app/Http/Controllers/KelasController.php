<?php

namespace App\Http\Controllers;

use App\Models\kelas;
use App\Http\Requests\StorekelasRequest;
use App\Http\Requests\UpdatekelasRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['kelas'] = kelas::all();
        return view('super_user.daftar_siswa.dkelas')->with($data);
    }


    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:255',
            'nama_jurusan' => 'required|string|max:255',
        ]);

        $lastKelas = Kelas::latest()->first();
        $lastNo = $lastKelas ? $lastKelas->id : 0;

        // Buat nomor baru berikutnya
        $newNo = $lastNo + 1;

        // Simpan data kelas dengan nomor baru
        Kelas::create([
            'id' => $newNo,
            'nama_kelas' => $request->nama_kelas,
            'nama_jurusan' => $request->nama_jurusan,
        ]);

        return redirect()->route('kelas')->with('success', 'Data kelas berhasil ditambahkan.');
    }


    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'nama_kelas' => 'required|string|max:255',
            'nama_jurusan' => 'required|string|max:255',
        ]);

        // Cari data kelas berdasarkan ID
        $kelas = Kelas::findOrFail($id);

        // Update data
        $kelas->update([
            'nama_kelas' => $request->nama_kelas,
            'nama_jurusan' => $request->nama_jurusan,
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('kelas')->with('success', 'Data kelas berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $kelas = Kelas::findOrFail($id);

        $kelas->delete();

        // Redirect dengan pesan sukses
        return redirect()->route('kelas')->with('success', 'Data kelas berhasil dihapus.');
    }
}
