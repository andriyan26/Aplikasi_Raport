<?php

use App\Models\Admin;
use App\Models\User;
use App\Models\KepalaSekolah;
use App\Models\WakilKurikulum; // <-- Tambahan penting
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        // Buat user admin
        $adminUser = User::create([
            'username' => 'admin',
            'password' => bcrypt('admin123'),
            'role' => '1',
            'status' => true,
        ]);

        // Buat user kepala sekolah
        $kepsekUser = User::create([
            'username' => 'kepalasekolah',
            'password' => bcrypt('admin123'),
            'role' => '4',
            'status' => true,
        ]);

        // Buat user wakil kurikulum
        $wakilKurikulumUser = User::create([
            'username' => 'wakilkurikulum',
            'password' => bcrypt('admin123'),
            'role' => '5', // misal role wakil kurikulum adalah 5
            'status' => true,
        ]);

        // Buat data admin (relasi ke user admin)
        Admin::create([
            'user_id' => $adminUser->id,
            'nama_lengkap' => 'Admin',
            'jenis_kelamin' => 'L',
            'tanggal_lahir' => '1998-05-30',
            'email' => 'admin@mail.com',
            'nomor_hp' => '085232077932',
            'avatar' => 'default.png',
        ]);

        // Buat data kepala sekolah (relasi ke user kepala sekolah)
        KepalaSekolah::create([
            'user_id' => $kepsekUser->id,
            'nama_lengkap' => 'Budi Santoso',
            'gelar' => 'M.Pd',
            'nip' => '197809202005011002',
            'jenis_kelamin' => 'L',
            'tempat_lahir' => 'Bandung',
            'tanggal_lahir' => '1978-09-20',
            'nuptk' => '1234567890123456',
            'alamat' => 'Jl. Merdeka No. 10',
            'avatar' => 'default.png',
        ]);

        // Buat data wakil kurikulum (relasi ke user wakil kurikulum)
        WakilKurikulum::create([
            'user_id' => $wakilKurikulumUser->id,
            'nama_lengkap' => 'Siti Rohmah',
            'gelar' => 'M.Pd',
            'nip' => '198003152007012003',
            'jenis_kelamin' => 'P',
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '1980-03-15',
            'nuptk' => '6543210987654321',
            'alamat' => 'Jl. Kebangsaan No. 20',
            'avatar' => 'default.png',
        ]);
    }
}
