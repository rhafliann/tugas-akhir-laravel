<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    use HasFactory;

    protected $table = 'url';

    protected $primaryKey = 'id_url';

    protected $fillable = [
        'url_short',
        'url_address',
        'qrcode_image',
        'jenis',
        'id_users',
        'nama_kegiatan'
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'id_users', 'id_users');
    }

    public function kegiatan(){
        return $this->belongsTo(Kegiatan::class, 'nama_kegiatan', 'id_kegiatan');
    }
}
