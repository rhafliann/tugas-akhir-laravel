<?php

namespace App\Http\Controllers;

use App\Models\Cuti;
use App\Models\GeneralSetting;
use App\Models\Notifikasi;
use App\Models\Perizinan;
use App\Models\Profile;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Presensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

enum PersetujuanIzin: int {
    case Ditolak = 0;
    case Disetujui = 1;
};

enum UserLevel: String {
    case PPK   = 'ppk';
    case Kadiv = 'kadiv';
    case Admin = 'admin';
    case BOD   = 'bod';
};

class AjuanPerizinanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $ajuanperizinan  = Perizinan::where(['is_deleted' => '0']);
        $id_users     = $request->id_users ?? null;
        $tgl_absen_awal  = $request->tgl_absen_awal ?? null;
        $tgl_absen_akhir = $request->tgl_absen_akhir ?? null;
        $jenis_perizinan = $request->jenis_perizinan ?? null;

        $where = [];

        if ($user->level == UserLevel::BOD->value or $user->level == UserLevel::Kadiv->value) {
            $where['id_atasan'] = $user->id_users;
        }

        if(
            $user->level == UserLevel::Admin->value ||
            $user->level == UserLevel::BOD->value   ||
            $user->level == UserLevel::Kadiv->value ||
            $user->level == UserLevel::PPK->value
        ){
            unset($where['id_users']);
        } else {
            $where['id_users'] = $user->id_users;
        }


        if ($tgl_absen_awal != null && $tgl_absen_akhir != null) {
            $ajuanperizinan
            ->where('tgl_absen_awal', '>=', date($tgl_absen_awal))
            ->where('tgl_absen_akhir', '<=', date($tgl_absen_akhir));
        }

        if ($id_users != null && $id_users != 'all') {
            $where['id_users'] = $id_users;
        }

        if ($jenis_perizinan != null && $jenis_perizinan != 'all') {
            $where['jenis_perizinan'] = $jenis_perizinan;    
        }
        
        $ajuanperizinan->where($where);
        $ajuanperizinan->orderBy('id_perizinan', 'desc');

        return view('izin.index', [
            'ajuanperizinan' => $ajuanperizinan->get(),
            'users' => User::where('is_deleted', '0')->orderByRaw("LOWER(nama_pegawai)")->get(),
            'settingperizinan' => User::with(['setting'])->get(),
            'pengguna' => User::where('id_users', $id_users)->first(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'id_atasan' => 'required',
            'id_users' => 'required',
            'jenis_perizinan' => 'required',
            'jumlah_hari_pengajuan' => 'required',
            'tgl_absen_awal' => 'required',
            'tgl_absen_akhir' => 'required',
            'keterangan' => 'required',
            'file_perizinan' => 'mimes:pdf,doc,docx,png,jpg,jpeg',
        ]);

        $ajuanperizinan = new Perizinan();
        $id_users   = $request->id_users || null; 
        $jumlah_hari_pengajuan = $request->jumlah_hari_pengajuan || null;

        $pengguna = User::where('id_users', $id_users)->first();

        if (!$pengguna) {
            return redirect()->back()->with('error', 'Pengguna dengan kode finger tersebut tidak ditemukan.');
        }

        // Periksa apakah jatah cuti tahunan mencukupi
        if ($request->jenis_perizinan === 'CT' && $pengguna->cuti) {
            if ($pengguna->cuti->jatah_cuti < $jumlah_hari_pengajuan) {
                return redirect()->back()->with('error', 'Jatah cuti tidak mencukupi untuk pengajuan ini.');
            }
        }

        if ($request->hasFile('file_perizinan')) {
            // Upload dan simpan file jika ada
            $file = $request->file('file_perizinan');
            $fileExtension = $file->getClientOriginalExtension();

            $fileName = Str::random(20).'.'.$fileExtension;
            $file->storeAs('file_perizinan', $fileName, 'public');

            // Update the file_perizinan attribute in the $perizinan object
            $ajuanperizinan->file_perizinan = $fileName;
        } else {
            // If no file is uploaded, set the file_perizinan attribute to NULL
            $ajuanperizinan->file_perizinan = null;
        }

        if($pengguna->id_jabatan == '7'){
            $ajuanperizinan->id_atasan = null;
        }else {
            $ajuanperizinan->id_atasan = $request->id_atasan;
        }

        $ajuanperizinan->id_users = $request->id_users;
        $ajuanperizinan->jenis_perizinan = $request->jenis_perizinan;
        $ajuanperizinan->tgl_ajuan = $request->tgl_ajuan;
        $ajuanperizinan->tgl_absen_awal = $request->tgl_absen_awal;
        $ajuanperizinan->tgl_absen_akhir = $request->tgl_absen_akhir;
        $ajuanperizinan->jumlah_hari_pengajuan = $request->jumlah_hari_pengajuan;
        $ajuanperizinan->keterangan = $request->keterangan;
        // $ajuanperizinan->file_perizinan = $fileName;
        if($pengguna->id_jabatan == '7'){
            $ajuanperizinan->status_izin_atasan = '1';    
        }else{
            $ajuanperizinan->status_izin_atasan = null;
        } // Default menunggu persetujuan
        
        $ajuanperizinan->status_izin_ppk = null; // Default menunggu persetujuan
        $ajuanperizinan->save();

        $notifikasi = new Notifikasi();
        $notifikasi->judul = 'Pengajuan Izin';
        $notifikasi->pesan = 'Pengajuan perizinan anda sudah berhasil dikirimkan.  Kami telah mengirimkan notifikasi untuk memproses pengajuanmu..';
        $notifikasi->is_dibaca = 'tidak_dibaca';
        $notifikasi->label = 'info';
        $notifikasi->send_email = 'yes';
        $notifikasi->link = '/perizinan';
        $notifikasi->id_users = $pengguna->id_users;
        $notifikasi->save();

        if($pengguna->id_jabatan != '7'){
            $notifikasi = new Notifikasi();
            $notifikasi->judul = 'Pengajuan Izin ';
            $notifikasi->pesan = 'Pengajuan perizinan dari '.$pengguna->nama_pegawai.'. Mohon berikan persetujan kepada pemohon.'; // Sesuaikan pesan notifikasi sesuai kebutuhan Anda.
            $notifikasi->is_dibaca = 'tidak_dibaca';
            $notifikasi->send_email = 'yes';
            $notifikasi->label = 'info';
            $notifikasi->link = '/ajuanperizinan';
            $notifikasi->id_users = $request->id_atasan;
            $notifikasi->save();
        }

        $ppk = GeneralSetting::where('status', '1')->first();
        if ($request->jenis_perizinan !== 'I') {
            $notifikasi = new Notifikasi();
            $notifikasi->judul = 'Pengajuan Izin ';
            $notifikasi->pesan = 'Pengajuan perizinan dari '.$pengguna->nama_pegawai.'. Mohon berikan persetujan kepada pemohon.'; // Sesuaikan pesan notifikasi sesuai kebutuhan Anda.
            $notifikasi->is_dibaca = 'tidak_dibaca';
            $notifikasi->label = 'info';
            $notifikasi->link = '/ajuanperizinan';
            $notifikasi->send_email = 'yes';
            $notifikasi->id_users = $ppk->id_users;
            $notifikasi->save();
        }

        $notifikasiAdmin = User::where('level', 'admin')->get();
        
        foreach($notifikasiAdmin as $na){
        $notifikasi = new Notifikasi();
        $notifikasi->judul = 'Pengajuan Izin ';
        $notifikasi->pesan = 'Pengajuan perizinan dari '.$pengguna->nama_pegawai.'. Mohon berikan persetujan kepada pemohon.'; // Sesuaikan pesan notifikasi sesuai kebutuhan Anda.
        $notifikasi->is_dibaca = 'tidak_dibaca';
        $notifikasi->send_email = 'yes';
        $notifikasi->label = 'info';
        $notifikasi->link = '/ajuanperizinan';
        $notifikasi->id_users = $na->id_users;
        $notifikasi->save();
        }

        return redirect()->back()->with('success_message', 'Data telah tersimpan.');

    }

    /**
     * Display the specified resource.
     */
    public function show(Perizinan $perizinan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Perizinan $perizinan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_perizinan)
    {
        $rules = [];
        $user = Auth::user();
        $ajuanPerizinan = Perizinan::where(['id_perizinan' => $id_perizinan])->first();

        if(!$ajuanPerizinan){
            return redirect()->route('ajuanperizinan.index')->with('error', 'Data tidak ditemukan');
        }

        if($user->level == 'bod' || $user->level == 'kadiv'){
            $rules['status_izin_atasan'] = 'required';
        }

        if($user->level == 'ppk'){
            $rules['status_izin_ppk'] = 'required';
        }

        if($ajuanPerizinan->id_atasan == $user->id_users){
            $rules['status_izin_atasan'] = 'required';
        }

        if($user->level == 'admin'){
            $rules = [
                'id_users' => 'required',
                'id_atasan' => 'required',
                'jenis_perizinan' => 'required',
                'tgl_absen_awal' => 'required',
                'tgl_absen_akhir' => 'required',
                'keterangan' => 'required',
            ];
        }

        if ($request->file('file_perizinan')) {
            $rules['file_perizinan'] = 'required|mimes:pdf,doc,docx,png,jpg,jpeg';
        }

        if (isset($request->status_izin_atasan)) {
            if ($request->status_izin_atasan == '0') {
                $rules['alasan_ditolak_atasan'] = 'required';
            }
        }

        if (isset($request->status_izin_ppk)) {
            if ($request->status_izin_ppk == '0') {
                $rules['alasan_ditolak_ppk'] = 'required';
            }
        }
        
        $validated = $request->validate($rules);
        
        if($validated){
            $ajuanPerizinan->id_atasan = $request->id_atasan;
            $ajuanPerizinan->jenis_perizinan = $request->jenis_perizinan;
            $ajuanPerizinan->tgl_absen_awal = $request->tgl_absen_awal;
            $ajuanPerizinan->tgl_absen_akhir = $request->tgl_absen_akhir;
            $ajuanPerizinan->keterangan = $request->keterangan;

            if (isset($request->status_izin_atasan)) {
                $ajuanPerizinan->status_izin_atasan = $request->status_izin_atasan;
            }
            if (isset($request->status_izin_ppk)) {
                $ajuanPerizinan->status_izin_ppk = $request->status_izin_ppk;
            }

            if (isset($request->status_izin_atasan) && $request->status_izin_atasan == '0') {
                $ajuanPerizinan->alasan_ditolak_atasan = $request->alasan_ditolak_atasan;
            }

            if (isset($request->status_izin_ppk) && $request->status_izin_ppk == '0') {
                $ajuanPerizinan->alasan_ditolak_ppk = $request->alasan_ditolak_ppk;
            }

            if ($request->hasFile('file_perizinan')) {
                // Menghapus file file_perizinan sebelumnya
                if ($ajuanPerizinan->file_perizinan && Storage::disk('public')->exists($ajuanPerizinan->file_perizinan)) {
                    Storage::disk('public')->delete('file_perizinan/'.$ajuanPerizinan->file_perizinan);
                }
                // // Upload file file_perizinan baru
                $file = $request->file('file_perizinan');
                $namafile_perizinan = $file->storeAs('file_perizinan', time() . $file->getClientOriginalExtension(), 'public');
                $ajuanPerizinan->file_perizinan = $namafile_perizinan;
            }

            if ($request->jenis_perizinan === 'CT'){
                $izinCutiUser = Cuti::where(['id_users' => $request->id_users])->first();
                
                if(!$izinCutiUser){
                    return redirect()->back()->with('error', 'Anda belum memiliki cuti tahunan.');
                }

                $jumlahCuti = $ajuanPerizinan->jumlah_hari_pengajuan;
                $jatahCutiTahunan = $izinCutiUser->jatah_cuti;

                if ($jatahCutiTahunan < $jumlahCuti) {
                    return redirect()->back()->with('error', 'Anda tidak memiliki jatah cuti tahunan yang cukup.');
                }

                if($izinCutiUser->jatah_cuti >= $jumlahCuti){
                    $izinCutiUser->jatah_cuti -= $jumlahCuti;
                    $izinCutiUser->save();
                } else {
                    return redirect()->back()->with('error', 'Gagal mengurangi jatah cuti pengguna.');
                }
            }

            // save presensi ketika disetujui
            if ($ajuanPerizinan->status_izin_atasan === '1'){

                $tanggalAwalIzin = Carbon::parse($ajuanPerizinan->tgl_absen_awal);
                $tanggalAkhirIzin = Carbon::parse($ajuanPerizinan->tgl_absen_akhir);
                // Jenis perizinan
                $jenisPerizinan = $ajuanPerizinan->jenis_perizinan;
                $pegawai = Profile::where(['id_users' => $ajuanPerizinan->id_users])->first();

                if($pegawai){
                    // Perulangan untuk mengisi data presensi harian
                    while ($tanggalAwalIzin <= $tanggalAkhirIzin) {
                        if ($tanggalAwalIzin->isWeekend()) {
                            // Lewati hari Sabtu dan Minggu
                            $tanggalAwalIzin->addDay();
                            continue;
                        }
                        // Periksa apakah tanggal izin harian sudah ada dalam tabel presensi
                        $tanggalPresensi = $tanggalAwalIzin->toDateString();
        
                        $payloadPresensi = [
                            'nik' => $pegawai->nik,
                            'tanggal' => $tanggalPresensi,
                            'jenis_perizinan' => $jenisPerizinan // Simpan jenis perizinan di sini
                        ];
        
                        $presensiHarian = Presensi::where($payloadPresensi)->first();
        
                        if (!$presensiHarian) {
                            // Jika tidak ada presensi untuk tanggal ini, buat entri presensi baru
                            $presensiHarian = Presensi::create($payloadPresensi);
                        }
        
                        $presensiHarian->jenis_perizinan = $jenisPerizinan; // Simpan jenis perizinan di sini
                        $presensiHarian->save();    
                        // Lanjutkan ke tanggal berikutnya
                        $tanggalAwalIzin->addDay();
                    }
                }

            }

            if($ajuanPerizinan->jenis_perizinan === 'I') {

                $notifikasi = new Notifikasi();
                $notifikasi->judul = 'Persetujuan Izin';        
                $notifikasi->is_dibaca = 'tidak_dibaca';
                $notifikasi->send_email = 'yes';
                $notifikasi->label = 'info';
                $notifikasi->link = '/perizinan';
                $notifikasi->id_users = $ajuanPerizinan->id_users;

                if($ajuanPerizinan->status_izin_atasan === null && $ajuanPerizinan->status_izin_ppk === null){
                    $notifikasi->pesan = 'Pengajuan perizinan anda belum mendapatkan persetujuan. Klik link di bawah ini untuk melihat info lebih lanjut.';
                }

                if ($ajuanPerizinan->status_izin_atasan === '1' && $ajuanPerizinan->status_izin_ppk === null) {
                    // Kondisi pesan notifikasi yang disetujui oleh atasan
                    $notifikasi->pesan = 'Pengajuan perizinan anda sudah berhasil disetujui oleh atasan. Klik link di bawah ini untuk melihat info lebih lanjut.';
                }

                if($ajuanPerizinan->status_izin_atasan === null && $ajuanPerizinan->status_izin_ppk === '1'){
                    $notifikasi->pesan = 'Pengajuan perizinan anda sudah berhasil disetujui oleh ppk. Klik link di bawah ini untuk melihat info lebih lanjut.';
                }

                if($ajuanPerizinan->status_izin_atasan === null && $ajuanPerizinan->status_izin_ppk === '0'){
                    $notifikasi->pesan = 'Pengajuan perizinan anda ditolak oleh ppk. Klik link di bawah ini untuk melihat info lebih lanjut.';
                }

                if($ajuanPerizinan->status_izin_atasan === '0' && $ajuanPerizinan->status_izin_ppk === null){
                    $notifikasi->pesan = 'Pengajuan perizinan anda ditolak oleh atasan. Klik link di bawah ini untuk melihat info lebih lanjut.';
                }

                if($ajuanPerizinan->status_izin_atasan === '0' && $ajuanPerizinan->status_izin_ppk === '0'){
                    $notifikasi->pesan = 'Pengajuan perizinan anda ditolak oleh atasan dan ppk. Klik link di bawah ini untuk melihat info lebih lanjut.';
                }

                if($ajuanPerizinan->status_izin_atasan === '1' && $ajuanPerizinan->status_izin_ppk === '1'){
                    $notifikasi->pesan = 'Pengajuan perizinan anda sudah berhasil disetujui oleh atasan dan ppk. Klik link di bawah ini untuk melihat info lebih lanjut.';
                }
                
                $notifikasi->save();
            }

            $ajuanPerizinan->save();

            return redirect()->route('ajuanperizinan.index')->with('success_message', 'Data telah tersimpan');
        }

        return redirect()->route('ajuanperizinan.index')->with('error_message', 'Gagal Menyimpan data');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Perizinan $id_perizinan)
    {
        if ($id_perizinan) {
            $id_perizinan->update([
                'is_deleted' => '1',
            ]);
        }

        return redirect()->route('ajuanperizinan.index')->with('success_message', 'Data telah terhapus.');
    }
}