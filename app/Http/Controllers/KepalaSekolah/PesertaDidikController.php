<?php

namespace App\Http\Controllers\KepalaSekolah;

use App\Http\Controllers\Controller;
use App\Models\AnggotaKelas;
use App\Models\Kelas;
use App\Models\Tapel;

class PesertaDidikController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Data Peserta Didik';

        // Pastikan tapel_id ada di session
        $tapel = Tapel::find(session()->get('tapel_id'));
        if (!$tapel) {
            return redirect()->route('error.route')->with('error', 'Tapel tidak ditemukan.');
        }

        // Ambil ID kelas yang sesuai dengan tapel_id
        $id_kelas_diampu = Kelas::where('tapel_id', $tapel->id)->pluck('id');  // Mengambil hanya ID kelas

        // Pastikan ada kelas yang terdaftar
        if ($id_kelas_diampu->isEmpty()) {
            return redirect()->route('error.route')->with('error', 'Kelas untuk tapel ini tidak ditemukan.');
        }

        // Ambil data anggota kelas yang terdaftar pada kelas yang ada
        $data_anggota_kelas = AnggotaKelas::whereIn('kelas_id', $id_kelas_diampu)->get();

        // Kembalikan ke view
        return view('kepalasekolah.pesertadidik.index', compact('title', 'data_anggota_kelas'));
    }
}
