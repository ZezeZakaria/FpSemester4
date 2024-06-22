<?php

namespace App\Http\Controllers;

use App\Http\Requests\Login;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class AuthController extends Controller
{
    public function index()
    {
        return view("login");
    }

    public function auth(Login $request)
    {
        $user = $request->validated();


        if (Auth::attempt($user)) {
            if (auth()->user()->role === 'admin') {
                // Alert::success('Berhasil', 'Selamat datang dihalaman admin Bulletin Board!');
                return redirect()->route('dashboard_index');
            }
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
