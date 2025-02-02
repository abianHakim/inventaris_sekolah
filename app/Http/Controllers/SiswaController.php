<?php

namespace App\Http\Controllers;

use App\Models\kelas;
use App\Models\siswa;
use App\Http\Requests\StoresiswaRequest;
use App\Http\Requests\UpdatesiswaRequest;
use App\Models\peserta;
use Illuminate\Http\Request;

class SiswaController extends Controller
{

    public function index()
    {

        $data['Siswa'] = Siswa::with('kelas')->orderBy('no_siswa', 'asc')->get();
        $data['Kelas'] = Kelas::all();
        return view('super_user.daftar_siswa.dsiswa', $data);
    }


    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nisn' => 'required|string|max:20',
            'nama_siswa' => 'required|string|max:255',
            'kelas_id' => 'required|integer',
        ]);


        $lastSiswa = Siswa::orderBy('siswa_id', 'desc')->first();
        $newSiswaId = $lastSiswa ? $lastSiswa->siswa_id + 1 : 1;


        $newNoSiswa = 'SWS' . str_pad($newSiswaId, 5, '0', STR_PAD_LEFT);

        // Simpan data siswa
        Siswa::create([
            'siswa_id' => $newSiswaId,
            'nisn' => $request->nisn,
            'nama_siswa' => $request->nama_siswa,
            'kelas_id' => $request->kelas_id,
            'no_siswa' => $newNoSiswa,
        ]);

        return redirect()->route('siswa')->with('success', 'Data Siswa Berhasil Ditambahkan!');
    }

    public function update(Request $request, $siswa_id)
    {
        // Validasi data
        $validated = $request->validate([
            'nisn' => 'required|unique:siswa,nisn,' . $siswa_id . ',siswa_id',
            'nama_siswa' => 'required',
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        // Cari data siswa berdasarkan id dan update
        $siswa = Siswa::findOrFail($siswa_id);
        $siswa->update($validated);

        return redirect()->route('siswa')->with('success', 'Data siswa berhasil diperbarui!');
    }


    public function destroy($id)
    {
        $siswa = Siswa::findOrFail($id);
        $siswa->delete();


        $siswaList = Siswa::orderBy('siswa_id', 'asc')->get(); // Ambil semua siswa berdasarkan urutan siswa_id
        foreach ($siswaList as $index => $data) {
            $data->update([
                'siswa_id' => $index + 1, // Sesuaikan siswa_id agar berurutan
                'no_siswa' => 'SWS' . str_pad($index + 1, 5, '0', STR_PAD_LEFT),
            ]);
        }

        return redirect()->route('siswa')->with('success', 'Data siswa berhasil dihapus!');
    }
}
