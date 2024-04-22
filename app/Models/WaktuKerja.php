<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WaktuKerja extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'waktu_kerja';

    protected $fillable = [
        'nama_waktu',
        'jam_masuk',
        'jam_pulang'
    ];
}
