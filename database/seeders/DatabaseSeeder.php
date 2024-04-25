<?php

namespace Database\Seeders;

use App\Models\Cuti;
use App\Models\EmailConfiguration;
use App\Models\GeneralSetting;
use App\Models\HubunganKeluarga;
use App\Models\Jabatan;
use App\Models\JenisDiklat;
use App\Models\Kegiatan;
use App\Models\KodeSurat;
use App\Models\Peran;
use App\Models\Presensi;
use App\Models\Ruangan;
use App\Models\BarangTik;
use App\Models\BarangPpr;
use App\Models\TimKegiatan;
use App\Models\TingkatPendidikan;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Jabatan::create([
            'nama_jabatan' => 'Admin',
        ]);

        Jabatan::create([
            'nama_jabatan' => 'kadiv',
        ]);


        Jabatan::create([
            'nama_jabatan' => 'dda',
        ]);

        Jabatan::create([
            'nama_jabatan' => 'staf',
        ]);

        Jabatan::create([
            'nama_jabatan' => 'ppk',
        ]);

        Jabatan::create([
            'nama_jabatan' => 'bod',
        ]);

        Jabatan::create([
            'nama_jabatan' => 'direktur',
        ]);

        Jabatan::create([
            'nama_jabatan' => 'Kadiv TIK',
        ]);

        Jabatan::create([
            'nama_jabatan' => 'Kadiv KSHM',
        ]);

        TingkatPendidikan::create([
            'nama_tingkat_pendidikan' => 'Sarjana',
        ]);

        TingkatPendidikan::create([
            'nama_tingkat_pendidikan' => 'Magister',
        ]);

        TingkatPendidikan::create([
            'nama_tingkat_pendidikan' => 'Doktor',
        ]);

        JenisDiklat::create([
            'nama_jenis_diklat' => 'Diklat kepemimpinan',
        ]);

        JenisDiklat::create([
            'nama_jenis_diklat' => 'Diklat Fungsional',
        ]);

        JenisDiklat::create([
            'nama_jenis_diklat' => 'Diklat Teknis',
        ]);

        HubunganKeluarga::create([
            'urutan' => '1',
            'nama' => 'Ibu',
        ]);

        HubunganKeluarga::create([
            'urutan' => '2',
            'nama' => 'Ayah',
        ]);

        HubunganKeluarga::create([
            'urutan' => '3',
            'nama' => 'Anak Kandung',
        ]);

        Peran::create([
            'nama_peran' => 'Pembawa Acara',
        ]);

        Peran::create([
            'nama_peran' => 'Panitia',
        ]);

        User::create([
            'nama_pegawai' => 'almer',
            'email' => 'kevinalmer4@gmail.com',
            'password' => '12345678',
            '_password_' => '12345678',
            'level' => 'staf',
            'id_jabatan' => '4',
            'is_deleted' => '0',
            // 'kode_finger' => '82121',
        ]);

        User::create([
            'nama_pegawai' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => '12345678',
            '_password_' => '12345678',
            'level' => 'admin',
            // 'kode_finger' => '989898',
            'id_jabatan' => '1',
            'is_deleted' => '0',
        ]);

        User::create([
            'nama_pegawai' => 'kadiv',
            'email' => 'kadiv@kadiv.com',
            'password' => '12345678',
            '_password_' => '12345678',
            'level' => 'kadiv',
            // 'kode_finger' => '989898',
            'id_jabatan' => '2',
            'is_deleted' => '0',
        ]);

        User::create([
            'nama_pegawai' => 'Kadiv Tik',
            'email' => 'ghina.athaya05@gmail.com',
            'password' => '12345678',
            '_password_' => '12345678',
            'level' => 'kadiv',
            // 'kode_finger' => '989898',
            'id_jabatan' => '8',
            'is_deleted' => '0',
        ]);

        User::create([
            'nama_pegawai' => 'Kadiv KSHM',
            'email' => 'fadiahnurafidah@gmail.com',
            'password' => '12345678',
            '_password_' => '12345678',
            'level' => 'kadiv',
            // 'kode_finger' => '989390',
            'id_jabatan' => '9',
            'is_deleted' => '0',
        ]);

        User::create([
            'nama_pegawai' => 'bod',
            'email' => 'bod@bod.com',
            'password' => '12345678',
            '_password_' => '12345678',
            'level' => 'bod',
            // 'kode_finger' => '919898',
            'id_jabatan' => '6',
            'is_deleted' => '0',
        ]);

        User::create([
            'nama_pegawai' => 'ppk',
            'email' => 'ppk@ppk.com',
            'password' => '12345678',
            '_password_' => '12345678',
            'level' => 'ppk',
            // 'kode_finger' => '983898',
            'id_jabatan' => '6',
            'is_deleted' => '0',

        ]);

        User::create([
            'nama_pegawai' => 'staf',
            'email' => 'staf@staf.com',
            'password' => '12345678',
            '_password_' => '12345678',
            'level' => 'staf',
            // 'kode_finger' => '545621',
            'id_jabatan' => '4',
            'is_deleted' => '0',
        ]);

        User::create([
            'nama_pegawai' => 'direktur',
            'email' => 'direktur@direktur.com',
            'password' => '12345678',
            '_password_' => '12345678',
            'level' => 'bod',
            // 'kode_finger' => '784028',
            'id_jabatan' => '7',
            'is_deleted' => '0',
        ]);

        KodeSurat::create([
            'divisi' => 'Direktur',
            'kode_surat' => 'I',
            'is_deleted' => '0',
        ]);

        KodeSurat::create([
            'divisi' => 'DDA',
            'kode_surat' => 'I.B',
            'is_deleted' => '0',
        ]);

        KodeSurat::create([
            'divisi' => 'DDP',
            'kode_surat' => 'I.A',
            'is_deleted' => '0',
        ]);

        KodeSurat::create([
            'divisi' => 'HRGA',
            'kode_surat' => 'II.E',
            'is_deleted' => '0',
        ]);

        KodeSurat::create([
            'divisi' => 'PPR',
            'kode_surat' => 'II.D',
            'is_deleted' => '0',
        ]);
        KodeSurat::create([
            'divisi' => 'ICT',
            'kode_surat' => 'II.C',
            'is_deleted' => '0',
        ]);
        KodeSurat::create([
            'divisi' => 'RDP',
            'kode_surat' => 'II.B',
            'is_deleted' => '0',
        ]);

        KodeSurat::create([
            'divisi' => 'Training',
            'kode_surat' => 'II.A',
            'is_deleted' => '0',
        ]);

        KodeSurat::create([
            'divisi' => 'Keuangan',
            'kode_surat' => 'II.F',
            'is_deleted' => '0',
        ]);

        KodeSurat::create([
            'divisi' => 'Keuangan',
            'kode_surat' => 'II.F',
            'is_deleted' => '0',
        ]);

        Ruangan::create([
            'nama_ruangan' => 'Master Control',
            'is_deleted' => '0',
        ]);
        
        Ruangan::create([
            'nama_ruangan' => 'Studio',
            'is_deleted' => '0',
        ]);

        Ruangan::create([
            'nama_ruangan' => 'Ruang Rapat',
            'is_deleted' => '0',
        ]);

        GeneralSetting::create([
            'tahun_aktif' => '2023',
            'id_users' => 4,
            'status' => '1',
        ]);

        User::factory(10)->create();
        Kegiatan::factory(40)->create();
        TimKegiatan::factory(40)->create();
        BarangTik::factory(40)->create();
        BarangPPR::factory(40)->create();
        // Presensi::factory(100)->create();
        User::all()->each(function ($user) {
            Cuti::factory()->create([
                'id_users' => $user->id_users,
            ]);
        });

        EmailConfiguration::create([
            'protocol' => 'smtp', // 'smtp', 'sendmail', 'mail', 'qmail
            'host' => 'smtp.gmail.com',
            'port' => '465',
            'timeout' => '30',
            'username' => 'kevinalmer.bisnis@gmail.com',
            'email' => 'kevinalmer.bisnis@gmail.com',
            'password' => 'szjnbcpcbkpvggte',
        ]);
    }
}