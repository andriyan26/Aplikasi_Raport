<?php

namespace App\Http\Controllers\Siswa\K13;

use App\Http\Controllers\Controller;
use App\Models\AnggotaKelas;
use App\Models\K13NilaiAkhirRaport;
use App\Models\Kelas;
use App\Models\Pembelajaran;
use App\Models\Siswa;
use App\Models\Tapel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NilaiAkhirSemesterController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Nilai Akhir Semester';

        $user = Auth::user();
        if (!$user) {
            abort(403, 'Unauthorized');
        }

        $siswa = Siswa::where('user_id', $user->id)->first();
        if (!$siswa) {
            abort(404, 'Data siswa tidak ditemukan');
        }

        $data_tapel = Tapel::orderBy('tahun_pelajaran', 'desc')->get();
        $tahun_pelajaran_id = $request->input('tahun_pelajaran_id');

        $data_pembelajaran = collect();
        $anggota_kelas = null;

        if ($tahun_pelajaran_id) {
            $data_id_kelas = Kelas::where('tapel_id', $tahun_pelajaran_id)->pluck('id');

            $anggota_kelas = AnggotaKelas::whereIn('kelas_id', $data_id_kelas)
                ->where('siswa_id', $siswa->id)
                ->first();

            if ($anggota_kelas) {
                $data_pembelajaran = Pembelajaran::where('kelas_id', $anggota_kelas->kelas_id)
                    ->where('status', 1)
                    ->get();

                foreach ($data_pembelajaran as $pembelajaran) {
                    $pembelajaran->nilai = K13NilaiAkhirRaport::where('pembelajaran_id', $pembelajaran->id)
                        ->where('anggota_kelas_id', $anggota_kelas->id)
                        ->first();
                }
            }
        }

        return view('siswa.k13.nilaiakhir.index', compact(
            'title',
            'siswa',
            'data_tapel',
            'tahun_pelajaran_id',
            'data_pembelajaran',
            'anggota_kelas'
        ));
    }
}
