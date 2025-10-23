<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
     public function index()
    {
        return view('login-form' );
    }

    public function login()
    {

    }
}
