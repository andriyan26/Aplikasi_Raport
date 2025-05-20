<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    public function showLoginFormSiswa()
    {
        return view('auth.login-siswa', [
            'title' => 'Login Siswa'
        ]);
    }

    public function loginSiswa(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('username', $request->username)
                    ->where('role', '3') // hanya siswa
                    ->first();

        if ($user && Hash::check($request->password, $user->password)) {
            if ($user->status != 1) {
                return back()->with('error', 'Akun Anda belum aktif.');
            }

            Auth::login($user);
            return redirect()->intended('/siswa/dashboard');
        }

        return back()->with('error', 'Username atau password salah.');
    }
}
