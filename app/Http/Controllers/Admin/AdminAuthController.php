<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AdminAuthController extends Controller
{
    public function showloginform()
    {
        return Inertia::render('Admin/Auth/Login');
    }

    public function login(Request $request)
    {
        if(Auth::attempt(['email'=>$request->email, 'password'=>$request->password, 'is_admin'=>1])){
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('admin.login')->with('error', 'Email atau Password anda salah');
    }

}
