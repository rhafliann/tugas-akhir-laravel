<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    use HasFactory;

    protected $table = 'kegiatan';

    protected $primaryKey = 'id_kegiatan';

    protected $fillable = [
        'nama_kegiatan',
        'tgl_mulai',
        'tgl_selesai',
        'lokasi',
        'peserta',
        'is_deleted',

    ];

    public function timkegiatan()
    {
        return $this->hasMany(TimKegiatan::class, 'id_kegiatan', 'id_kegiatan');
    }

    protected $appends = ['status'];

    public function getStatusAttribute()
    {
        $today = Carbon::now();
        $start = Carbon::parse($this->attributes['tgl_mulai']);
        $end = Carbon::parse($this->attributes['tgl_selesai']);

        // Pertama, periksa apakah tanggal mulai dan tanggal selesai sama
        if ($today->greaterThanOrEqualTo($start) && $today->lessThan($end)) {
            return 'Sedang Berlangsung';
        }

        // Kedua, periksa kondisi jika tanggal mulai dan tanggal selesai berbeda
        if ($today->lt($start)) {
            return 'Belum Dimulai';
        } elseif ($today->gt($end)) {
            return 'Selesai';
        }
    }
}
