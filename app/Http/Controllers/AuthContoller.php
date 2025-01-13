<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthContoller extends Controller
{
    public function index()
    {
        return view("login");
    }
}
