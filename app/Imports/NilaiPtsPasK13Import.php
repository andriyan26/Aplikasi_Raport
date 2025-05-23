<?php

namespace App\Imports;

use App\Models\K13NilaiPtsPas;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class NilaiPtsPasK13Import implements ToCollection
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection $collection)
    {
        foreach ($collection as $key => $row) {
            if ($key >= 10) {
                if (($row[4] > 0 && $row[4] <= 100) || ($row[5] > 0 && $row[5] <= 100)) {
                    $cek_nilai = K13NilaiPtsPas::where('pembelajaran_id', $row[1])->where('anggota_kelas_id', $row[2])->first();
                    if (is_null($cek_nilai)) {
                        K13NilaiPtsPas::create([
                            'pembelajaran_id' => $row[1],
                            'anggota_kelas_id' => $row[2],
                            'nilai_pts' => $row[4],
                            'nilai_pas' => $row[5]
                        ]);
                    } else {
                        $cek_nilai->update([
                            'nilai_pts' => $row[4],
                            'nilai_pas' => $row[5]
                        ]);
                    }
                } else {
                    return back()->with('toast_warning', 'Maaf, Nilai baris nomor ' . $row[0] . ' harus bernilai antara 0 sampai 100');
                }
            }
        }
    }
}
