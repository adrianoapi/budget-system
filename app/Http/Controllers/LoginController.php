<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function auth(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if(!filter_var($request->email, FILTER_VALIDATE_EMAIL)){
            return \redirect()->back()->withInput()->withErrors(['Email informado não é válido!']);
        }

        if(Auth::attempt($credentials)){
            return \redirect()->route('dashboard.index');
        }

        return \redirect()->back()->withInput()->withErrors(['Dados informados não conferem!']);
    }

    public function logout()
    {
        Auth::logout();
        return \redirect()->route('auth.login');
    }

    public function recover()
    {
        return view('auth.recover');
    }

}
