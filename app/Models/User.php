<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_pegawai',
        'kode_finger',
        'email',
        'password',
        'level',
        'id_jabatan',
        '_password_',
    ];

    public function profile(){
        return $this->belongsTo(Profile::class, 'id_users', 'id_users');
    }

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'id_jabatan', 'id_jabatan');
    }

    public function timkegiatans()
    {
        return $this->hasMany(TimKegiatan::class, 'id_users', 'id_users');
    }

    public function pengalamanKerja()
    {
        return $this->hasMany(PengalamanKerja::class, 'id_users', 'id_users');
    }

    public function Pendidikan()
    {
        return $this->hasMany(Pendidikan::class, 'id_users', 'id_users');
    }

    public function keluarga()
    {
        return $this->hasMany(Keluarga::class, 'id_users', 'id_users');
    }

    public function arsip()
    {
        return $this->hasMany(Arsip::class, 'id_users', 'id_users');
    }

       public function cutis()
    {
        return $this->hasMany(Cuti::class, 'id_users', 'id_users');
    }
    
    public function cuti()
    {
        return $this->hasOne(Cuti::class, 'id_users'); // Assuming 'id_users' is the foreign key in the 'cuti' table
    }

    public function diklat()
    {
        return $this->hasMany(Diklat::class, 'id_users', 'id_users');
    }

    public function setting()
    {
        return $this->hasOne(GeneralSetting::class, 'id_users', 'id_users');
    }

    public function presensi()
    {
        return $this->hasMany(Presensi::class, 'nik', 'nik');
    }

    public function ajuanperizinan()
    {
        return $this->hasMany(Perizinan::class, 'id_atasan', 'id_users');
    }

    public function ajuanperizinans()
    {
        return $this->hasMany(Perizinan::class, 'kode_finger', 'kode_finger');
    }

    public function lembur()
    {
        return $this->hasMany(Lembur::class, 'kode_finger', 'kode_finger');
    }

    public function lemburs()
    {
        return $this->hasMany(Lembur::class, 'id_atasan', 'id_users');
    }

    public function notifikasi()
    {
        return $this->hasMany(Notifikasi::class, 'id_users', 'id_users');
    }

    public function surat()
    {
        return $this->hasMany(Surat::class, 'id_users', 'id_users');
    }

    public function peminjaman()
    {
        return $this->hasMany(PeminjamanBarang::class, 'id_users', 'id_users');
    }


    public function blastemail()
    {
        return $this->hasMany(PengajuanBlastemail::class, 'id_users', 'id_users');
    }


    public function ajuansinglelink()
    {
        return $this->hasMany(PengajuanSingleLink::class, 'id_users', 'id_users');
    }
    
    public function zoom()
    {
        return $this->hasMany(PengajuanZoom::class, 'id_users', 'id_users');

    }
    public function form()
    {
        return $this->hasMany(PengajuanForm::class, 'id_users', 'id_users');

    }
    


    protected $primaryKey = 'id_users';

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */

    protected $hidden = [
        'password',
        // 'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',

    ];
}