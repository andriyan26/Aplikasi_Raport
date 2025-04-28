<?php

namespace App\Http\Controllers\WakilKurikulum\K13;

use App\Http\Controllers\Controller;
use App\Models\AnggotaKelas;
use App\Models\K13MappingMapel;
use App\Models\K13NilaiAkhirRaport;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Pembelajaran;
use App\Models\Sekolah;
use App\Models\Tapel;
use Illuminate\Support\Facades\Auth;

class HasilPengelolaanNilaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Hasil Pengelolaan Nilai Siswa';

        // Ambil data sekolah dan tahun ajaran (tapel) aktif
        $sekolah = Sekolah::first();
        $tapel = Tapel::findOrFail(session()->get('tapel_id'));

        // Mengambil semua kelas yang tersedia di tapel yang aktif
        $id_kelas_diampu = Kelas::where('tapel_id', $tapel->id)->pluck('id');

        // Mengambil daftar mapel yang aktif di tapel ini
        $data_id_mapel_semester_ini = Mapel::where('tapel_id', $tapel->id)->pluck('id');

        // Mengambil data mapel yang tergabung dalam kelompok A dan B
        $data_id_mapel_kelompok_a = K13MappingMapel::whereIn('mapel_id', $data_id_mapel_semester_ini)->where('kelompok', 'A')->pluck('mapel_id');
        $data_id_mapel_kelompok_b = K13MappingMapel::whereIn('mapel_id', $data_id_mapel_semester_ini)->where('kelompok', 'B')->pluck('mapel_id');

        // Ambil semua anggota kelas yang ada di kelas-kelas yang diampu
        $data_anggota_kelas = AnggotaKelas::whereIn('kelas_id', $id_kelas_diampu)->get();

        // Iterasi melalui anggota kelas untuk mendapatkan data nilai kelompok A dan B
        foreach ($data_anggota_kelas as $anggota_kelas) {
            // Ambil data pembelajaran untuk kelompok A dan B berdasarkan kelas dan mapel
            $data_id_pembelajaran_a = Pembelajaran::where('kelas_id', $anggota_kelas->kelas_id)
                ->whereIn('mapel_id', $data_id_mapel_kelompok_a)->pluck('id');
            $data_id_pembelajaran_b = Pembelajaran::where('kelas_id', $anggota_kelas->kelas_id)
                ->whereIn('mapel_id', $data_id_mapel_kelompok_b)->pluck('id');

            // Ambil nilai akhir raport untuk kelompok A dan B berdasarkan pembelajaran dan anggota kelas
            $data_nilai_kelompok_a = K13NilaiAkhirRaport::whereIn('pembelajaran_id', $data_id_pembelajaran_a)
                ->where('anggota_kelas_id', $anggota_kelas->id)->get();
            $data_nilai_kelompok_b = K13NilaiAkhirRaport::whereIn('pembelajaran_id', $data_id_pembelajaran_b)
                ->where('anggota_kelas_id', $anggota_kelas->id)->get();

            // Simpan data nilai kelompok A dan B ke objek anggota kelas
            $anggota_kelas->data_nilai_kelompok_a = $data_nilai_kelompok_a;
            $anggota_kelas->data_nilai_kelompok_b = $data_nilai_kelompok_b;
        }

        // Mengembalikan tampilan dengan data yang sudah diproses
        return view('wakilkurikulum.k13.hasilnilai.index', compact('title', 'sekolah', 'data_anggota_kelas'));
    }
}
