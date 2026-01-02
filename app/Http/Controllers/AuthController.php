<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /* ======================
    |  TAMPIL HALAMAN
     ====================== */

    public function showRegister()
    {
        return view('auth.register');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    /* ======================
    |  PROSES REGISTER
     ====================== */

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:8',
            'no_hp'    => 'nullable|string',
            'alamat'   => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'no_hp'    => $request->no_hp,
            'alamat'   => $request->alamat,
            'role'     => 'pelanggan'
        ]);

        return redirect('/login')->with('success', 'Registrasi berhasil, silakan login');
    }

    /* ======================
    |  PROSES LOGIN
     ====================== */

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return redirect()->back()->with('error', 'Email atau password salah');
        }

        $request->session()->regenerate();

        return redirect('/');
    }

    /* ======================
    |  LOGOUT
     ====================== */

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Logout berhasil');
    }
}
