<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_presensi';

    protected $table = 'presensi';

    protected $fillable = [
        'tanggal',
        'jam_masuk',
        'jam_pulang',
        'scan_masuk',
        'scan_pulang',
        'terlambat',
        'pulang_cepat',
        'kehadiran',
        'jenis_perizinan',
        'nik',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'kode_finger', 'kode_finger');
    }
    
    public function profile_user()
    {
        return $this->belongsTo(Profile::class, 'nik', 'nik');
    }

    public function profile_pemagang(){
        return $this->belongsTo(Pemagang::class, 'nik', 'nik');
    }
}
