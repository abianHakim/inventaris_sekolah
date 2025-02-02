<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index()
    {
        return view("login");
    }

    public function showRegisterForm()
    {
        return view('register');
    }

    public function login(Request $request)
    {
        // Validate input fields
        $request->validate([
            'user_name' => 'required',
            'user_pass' => 'required',
        ]);


        // Get the credentials from the request
        $credentials = [
            'user_name' => $request->user_name,
            'user_pass' => $request->user_pass, // password should match the field name used in the database
        ];

        $user = User::where('user_name', $credentials['user_name'])->first();

        if ($user && Hash::check($credentials['user_pass'], $user->user_pass)) {
            // dd('test');
            Auth::login($user);

            return redirect('superhome')->with('success', 'Login berhasil!');
        }


        return back()->withErrors(['user_id' => 'ID pengguna atau password salah.']);
    }


    public function register(Request $request)
    {

        // dd($request->all());
        // Validasi data input dari user
        $request->validate([
            'user_name' => 'required|string|max:255',
            // 'user_id' => 'required|string|unique:tm_users',
            'user_pass' => 'required|string|min:8',
            // 'user_hak' => 'required|string',
            // 'user_sts' => 'required|string',
        ]);

        // Menyimpan data ke database
        $user = User::create([
            'user_id' => rand(111, 999),
            'user_name' => $request->user_name,
            'user_pass' => Hash::make($request->user_pass), 
            'user_hak' => null,
            'user_sts' => null,
        ]);

        // Menyimpan user yang baru didaftarkan ke session
        // Auth::login($user);

        // Redirect ke halaman barang.index setelah registrasi berhasil
        return redirect('login')->with('success', 'Account created successfully. Welcome!');
    }

    public function logout(Request $request)
    {
        // Logout user and invalidate session
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        logger('User logged out successfully.');
        return redirect()->route('showlogin');
    }
}
