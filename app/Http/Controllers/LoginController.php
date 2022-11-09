<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class LoginController extends Controller
{
    public function index()
    {
        return Inertia::render('login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if(Auth::attempt($data)){
            return Inertia::location(route('dashboard'));
        }
    }
    public function logout()
    {
        Auth::logout();
    }

    public function get_user()
    {
        return response()->json(Auth::user());
    }
}
