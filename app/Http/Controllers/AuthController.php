<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //
    public function index()
    {
        return view('auth.loginUser');
    }

    public function logged(Request $request)
    {
        $validate = $request->validate([
            'username' => 'required|string|max:255',
            'password' => 'required|string|max:255',
            'remember' => 'nullable|boolean',
        ]);

        if (Auth::attempt([
            'username' => $validate['username'],
            'password' => $validate['password']
        ], $request->filled('remember'))) {
            // Log aktivitas login sukses
            logActivity('login', 'User logged in successfully', $request);

            return redirect()->intended('/');
        }

        // Log aktivitas login gagal
        logActivity('login_error', 'Failed login attempt for username: ' . $validate['username'], $request);

        return back()->with([
            'error' => 'Username atau Password Salah'
        ]);
    }


    public function logout(Request $request)
    {
        // Log aktivitas logout
        logActivity('logout', 'User logged out successfully', $request);

        Auth::logout();

        return redirect()->route('login');
    }
}
