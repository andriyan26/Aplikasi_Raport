<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WakilKurikulum extends Model
{
    use HasFactory;

    protected $table = 'wakil_kurikulum';

    protected $fillable = [
        'user_id',
        'nama_lengkap',
        'gelar',
        'nip',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'nuptk',
        'alamat',
        'avatar',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
