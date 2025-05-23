<?php

namespace App\Http\Controllers\Guru\K13;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\K13ButirSikap;
use App\Models\K13RencanaNilaiSpiritual;
use App\Models\Kelas;
use App\Models\Pembelajaran;
use App\Models\Tapel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RencanaNilaiSpiritualController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Rencana KD/Butir Spiritual';
        $tapel = Tapel::findorfail(session()->get('tapel_id'));

        $guru = Guru::where('user_id', Auth::user()->id)->first();
        $id_kelas = Kelas::where('tapel_id', $tapel->id)->get('id');

        $data_rencana_penilaian = Pembelajaran::where('guru_id', $guru->id)->whereIn('kelas_id', $id_kelas)->where('status', 1)->orderBy('mapel_id', 'ASC')->orderBy('kelas_id', 'ASC')->get();
        foreach ($data_rencana_penilaian as $penilaian) {
            $rencana_penilaian = K13RencanaNilaiSpiritual::where('pembelajaran_id', $penilaian->id)->get();
            $penilaian->jumlah_rencana_penilaian = count($rencana_penilaian);
        }

        return view('guru.k13.rencanaspiritual.index', compact('title', 'data_rencana_penilaian'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $title = 'Pilih KD/Butir Spiritual';

        $pembelajaran = Pembelajaran::findorfail($request->pembelajaran_id);
        $data_sikap = K13ButirSikap::where('jenis_kompetensi', 1)->orderBy('kode', 'ASC')->get();

        if (count($data_sikap) == 0) {
            return back()->with('toast_error', 'Data butir sikap spiritual belum ditambahkan oleh admin.');
        } else {
            return view('guru.k13.rencanaspiritual.create', compact('title', 'pembelajaran', 'data_sikap'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'k13_butir_sikap_id' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->with('toast_error', 'Tidak ada butir sikap yang dipilih');
        } else {
            for ($count = 0; $count < count($request->k13_butir_sikap_id); $count++) {
                $data_sikap = array(
                    'pembelajaran_id' => $request->pembelajaran_id,
                    'k13_butir_sikap_id' => $request->k13_butir_sikap_id[$count],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                );
                $store_data_sikap[] = $data_sikap;
            }
            K13RencanaNilaiSpiritual::insert($store_data_sikap);
            return redirect('guru/rencanaspiritual')->with('toast_success', 'Rencana nilai spiritual berhasil dipilih');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $title = 'Data KD/Butir Spiritual';
        $pembelajaran = Pembelajaran::findorfail($id);
        $data_rencana_penilaian = K13RencanaNilaiSpiritual::where('pembelajaran_id', $id)->orderBy('k13_butir_sikap_id', 'ASC')->get();
        return view('guru.k13.rencanaspiritual.show', compact('title', 'pembelajaran', 'data_rencana_penilaian'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = 'Edit KD/Butir Spiritual';
        $pembelajaran = Pembelajaran::findorfail($id);
        $data_sikap = K13ButirSikap::where('jenis_kompetensi', 1)->orderBy('kode', 'ASC')->get();

        return view('guru.k13.rencanaspiritual.edit', compact('title', 'pembelajaran', 'data_sikap'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'k13_butir_sikap_id' => 'required',

        ]);
        if ($validator->fails()) {
            return back()->with('toast_error', 'Tidak ada butir sikap yang dipilih');
        } else {
            for ($count = 0; $count < count($request->k13_butir_sikap_id); $count++) {
                $data_sikap = array(
                    'pembelajaran_id' => $id,
                    'k13_butir_sikap_id' => $request->k13_butir_sikap_id[$count],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                );
                $store_data_sikap[] = $data_sikap;
            }
            try {
                K13RencanaNilaiSpiritual::where('pembelajaran_id', $id)->delete();
                K13RencanaNilaiSpiritual::insert($store_data_sikap);
                return redirect('guru/rencanaspiritual')->with('toast_success', 'Rencana nilai spiritual berhasil diupdate');
            } catch (\Throwable $th) {
                return back()->with('toast_warning', 'Rencana nilai sosial tidak dapat diupdate');
            }
        }
    }
}
