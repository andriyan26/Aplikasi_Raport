<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\KepalaSekolah;

use Illuminate\Support\Facades\Auth;

class ProfileUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Profile';

        if (Auth::user()->role == 1) {
            $admin = Admin::where('user_id', Auth::user()->id)->first();
            return view('admin.profile.index', compact('title', 'admin'));
        } elseif (Auth::user()->role == 2) {
            $guru = Guru::where('user_id', Auth::user()->id)->first();
            return view('guru.profile.index', compact('title', 'guru'));
        } elseif (Auth::user()->role == 3) {
            $siswa = Siswa::where('user_id', Auth::user()->id)->first();
            return view('siswa.profile.index', compact('title', 'siswa'));
        } elseif (Auth::user()->role == 4) {
            $kepalaSekolah = KepalaSekolah::where('user_id', Auth::user()->id)->first();
            return view('kepalasekolah.profile.index', compact('title', 'kepalaSekolah'));
        } elseif (Auth::user()->role == 5) {
            $wakilKurikulum = WakilKurikulum::where('user_id', Auth::user()->id)->first();
            return view('wakilkurikulum.profile.index', compact('title', 'wakilKurikulum'));
        }
    }
}
