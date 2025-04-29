<?php

namespace App\Http\Controllers\KepalaSekolah;

use App\Http\Controllers\Controller;
use App\Models\KepalaSekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function update(Request $request, $id)
    {
        $kepalaSekolah = KepalaSekolah::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required|min:3|max:100',
            'gelar' => 'required|min:2|max:10',
            'nip' => 'nullable|digits:18|unique:kepala_sekolah,nip,' . $kepalaSekolah->id,
            'jenis_kelamin' => 'required',
            'tempat_lahir' => 'required|min:3',
            'tanggal_lahir' => 'required|date',
            'nuptk' => 'nullable|digits:16|unique:kepala_sekolah,nuptk,' . $kepalaSekolah->id,
            'alamat' => 'required|min:4|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->with('toast_error', $validator->messages()->first())->withInput();
        }

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

        if ($request->hasFile('avatar')) {
            if ($kepalaSekolah->avatar && file_exists(public_path('assets/dist/img/avatar_kepala_sekolah/' . $kepalaSekolah->avatar))) {
                unlink(public_path('assets/dist/img/avatar_kepala_sekolah/' . $kepalaSekolah->avatar));
            }

            $avatar_file = $request->file('avatar');
            $name_avatar = 'profile_' . strtolower(str_replace(' ', '_', $request->nama_lengkap)) . '_' . time() . '.' . $avatar_file->getClientOriginalExtension();

            $avatar_file->move(public_path('assets/dist/img/avatar_kepala_sekolah/'), $name_avatar);

            $data['avatar'] = $name_avatar;
        }

        $kepalaSekolah->update($data);

        return back()->with('toast_success', 'Profil Kepala Sekolah berhasil diperbarui.');
    }
}
