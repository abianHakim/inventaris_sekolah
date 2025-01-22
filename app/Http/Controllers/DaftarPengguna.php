<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

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

    // public function index()
    // {

    //     $data["Users"] = User::all();

    //     return view("super_user.referensi.dPengguna")->with($data);
    // }
}
