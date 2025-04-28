<?php

namespace App\Http\Controllers\WakilKurikulum\K13;

use App\Http\Controllers\Controller;
use App\Models\K13DeskripsiNilaiSiswa;
use App\Models\K13NilaiAkhirRaport;
use App\Models\K13NilaiKeterampilan;
use App\Models\K13NilaiPengetahuan;
use App\Models\K13NilaiPtsPas;
use App\Models\K13NilaiSosial;
use App\Models\K13NilaiSpiritual;
use App\Models\K13RencanaBobotPenilaian;
use App\Models\K13RencanaNilaiKeterampilan;
use App\Models\K13RencanaNilaiPengetahuan;
use App\Models\K13RencanaNilaiSosial;
use App\Models\K13RencanaNilaiSpiritual;
use App\Models\Kelas;
use App\Models\Pembelajaran;
use App\Models\Tapel;
use Illuminate\Support\Facades\Auth;

class StatusPenilaianGuruController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Status Penilaian Oleh Guru';

        // Ambil data tahun ajaran aktif
        $tapel = Tapel::findOrFail(session()->get('tapel_id'));

        // Dapatkan kelas yang diajarkan oleh Wakil Kurikulum (menggunakan peran langsung, tanpa cek guru)
        $id_kelas_diampu = Kelas::where('tapel_id', $tapel->id)->pluck('id'); // Mendapatkan semua kelas untuk tapel aktif

        // Mendapatkan data pembelajaran kelas aktif
        $data_pembelajaran_kelas = Pembelajaran::whereIn('kelas_id', $id_kelas_diampu)->where('status', 1)->get();

        // Loop untuk proses validasi dan pengambilan nilai
        foreach ($data_pembelajaran_kelas as $pembelajaran) {

            // Validasi nilai untuk pengetahuan
            $rencana_pengetahuan = K13RencanaNilaiPengetahuan::where('pembelajaran_id', $pembelajaran->id)->first();
            $pembelajaran->rencana_pengetahuan = $rencana_pengetahuan ? 1 : 0;
            $pembelajaran->nilai_pengetahuan = $rencana_pengetahuan ? K13NilaiPengetahuan::where('k13_rencana_nilai_pengetahuan_id', $rencana_pengetahuan->id)->exists() : 0;

            // Validasi nilai untuk keterampilan
            $rencana_keterampilan = K13RencanaNilaiKeterampilan::where('pembelajaran_id', $pembelajaran->id)->first();
            $pembelajaran->rencana_keterampilan = $rencana_keterampilan ? 1 : 0;
            $pembelajaran->nilai_keterampilan = $rencana_keterampilan ? K13NilaiKeterampilan::where('k13_rencana_nilai_keterampilan_id', $rencana_keterampilan->id)->exists() : 0;

            // Validasi nilai spiritual
            $rencana_spiritual = K13RencanaNilaiSpiritual::where('pembelajaran_id', $pembelajaran->id)->first();
            $pembelajaran->rencana_spiritual = $rencana_spiritual ? 1 : 0;
            $pembelajaran->nilai_spiritual = $rencana_spiritual ? K13NilaiSpiritual::where('k13_rencana_nilai_spiritual_id', $rencana_spiritual->id)->exists() : 0;

            // Validasi nilai sosial
            $rencana_sosial = K13RencanaNilaiSosial::where('pembelajaran_id', $pembelajaran->id)->first();
            $pembelajaran->rencana_sosial = $rencana_sosial ? 1 : 0;
            $pembelajaran->nilai_sosial = $rencana_sosial ? K13NilaiSosial::where('k13_rencana_nilai_sosial_id', $rencana_sosial->id)->exists() : 0;

            // Validasi bobot penilaian
            $rencana_bobot = K13RencanaBobotPenilaian::where('pembelajaran_id', $pembelajaran->id)->first();
            $pembelajaran->rencana_bobot = $rencana_bobot ? 1 : 0;

            // Validasi nilai untuk PTS/PAS
            $pts_pas = K13NilaiPtsPas::where('pembelajaran_id', $pembelajaran->id)->first();
            $pembelajaran->pts_pas = $pts_pas ? 1 : 0;

            // Validasi nilai akhir raport
            $nilai_akhir = K13NilaiAkhirRaport::where('pembelajaran_id', $pembelajaran->id)->first();
            $pembelajaran->nilai_akhir = $nilai_akhir ? 1 : 0;

            // Deskripsi nilai siswa
            $deskripsi = K13DeskripsiNilaiSiswa::where('pembelajaran_id', $pembelajaran->id)->first();
            $pembelajaran->deskripsi = $deskripsi ? 1 : 0;
        }

        return view('wakilkurikulum.k13.statusnilaiguru.index', compact('title', 'data_pembelajaran_kelas'));
    }
}
