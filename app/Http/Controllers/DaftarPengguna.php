<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DaftarPengguna extends Controller
{
    public function index()
    {
        $Users = User::all()->map(function ($user) {
            $user->user_status_label = $user->user_sts == 1 ? 'Aktif' : 'Tidak Aktif';
            return $user;
        });

        return view("super_user.referensi.dPengguna", compact('Users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_name' => 'required|string|max:255',
            'user_pass' => 'required|string|min:8',
            'user_hak' => 'required|string',
            'user_sts' => 'required',
        ]);

        // Menyimpan data ke database
        $user = User::create([
            'user_id' => rand(111, 999),
            'user_name' => $request->user_name,
            'user_pass' => Hash::make($request->user_pass),
            'user_hak' => $request->user_hak,
            'user_sts' =>  $request->user_sts,
        ]);

        // Mengembalikan respons JSON
        return response()->json(['success' => true, 'message' => 'Account created successfully']);
    }
}
