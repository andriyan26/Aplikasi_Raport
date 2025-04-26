<?php

namespace App\Http\Controllers\KepalaSekolah;

use App\Http\Controllers\Controller;
use App\Models\KepalaSekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Ambil data kepala sekolah berdasarkan ID
        $kepalaSekolah = KepalaSekolah::findOrFail($id);

        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required|min:3|max:100',
            'gelar' => 'required|min:2|max:10',
            'nip' => 'nullable|digits:18|unique:kepala_sekolah,nip,' . $kepalaSekolah->id,
            'jenis_kelamin' => 'required',
            'tempat_lahir' => 'required|min:3',
            'tanggal_lahir' => 'required|date',
            'nuptk' => 'nullable|digits:16|unique:kepala_sekolah,nuptk,' . $kepalaSekolah->id,
            'alamat' => 'required|min:4|max:255',
        ]);

        if ($validator->fails()) {
            return back()->with('toast_error', $validator->messages()->first())->withInput();
        }

        // Siapkan data untuk update
        $data = [
            'nama_lengkap' => strtoupper($request->nama_lengkap),
            'gelar' => $request->gelar,
            'nip' => $request->nip,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'nuptk' => $request->nuptk,
            'alamat' => $request->alamat,
        ];

        // Jika ada file avatar
        if ($request->hasFile('avatar')) {
            $avatar_file = $request->file('avatar');
            $name_avatar = 'profile_' . strtolower(str_replace(' ', '_', $request->nama_lengkap)) . '.' . $avatar_file->getClientOriginalExtension();
            $avatar_file->move(public_path('assets/dist/img/avatar_kepala_sekolah/'), $name_avatar);
            $data['avatar'] = $name_avatar;
        }

        // Update data
        $kepalaSekolah->update($data);

        return back()->with('toast_success', 'Profil Kepala Sekolah berhasil diperbarui.');
    }
}
