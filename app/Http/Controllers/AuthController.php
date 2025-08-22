<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function loginPage()
    {
        return view('auth.login');
    }

    public function registerPage()
    {
        return view('auth.register');
    }


    public function login(Request $request)
    {
        dd($request->all());
    }

    public function register(Request $request)
    {
        dd($request->all());
    }

    public function logout()
    {
        // ini untuk logout
    }
}
