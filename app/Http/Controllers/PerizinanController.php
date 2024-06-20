<?php

namespace App\Http\Controllers;

use App\Models\GeneralSetting;
use App\Models\Notifikasi;
use App\Models\Perizinan;
use App\Models\User;
use App\Models\Cuti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PerizinanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function indexStaff()
    {
        $user = auth()->user();

        // Mendapatkan data pengguna
        $pengguna = User::where('id_users', $user->id_users)->first();

        // Mendapatkan data jatah cuti terkait dengan pengguna
        $jatahCuti = $pengguna->cutis->first();

        $perizinan = Perizinan::where('is_deleted', '0')
            ->whereIn('id_users', $user->ajuanperizinans->pluck('id_users'))->orderBy('id_perizinan', 'desc')
            ->get();


        return view('izin.staff', [
            'perizinan' => $perizinan,
            'users' => User::where('is_deleted', '0')->orderByRaw("LOWER(nama_pegawai)")->get(),
            'settingperizinan' => User::with(['setting'])->get(),
            'jatahCuti' => $jatahCuti
        ]);
    }

    public function index()
    {
        //
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
        //
    }

    public function Pengajuan(Request $request)
    {
        // dd($request);
        //Menyimpan Data User Baru
        $request->validate([
            'id_users' => 'required',
            'tgl_absen_awal' => 'required',
            'tgl_absen_akhir' => 'required',
            'jumlah_hari_pengajuan' => 'required',
            'id_atasan' => 'nullable',
            'keterangan' => 'required',
            'jenis_perizinan' => 'required',
            'file_perizinan' => 'mimes:pdf,doc,docx,png,jpg,jpeg',
        ]);

        $perizinan = new Perizinan();

        // Temukan pengguna berdasarkan kode finger
        $pengguna = User::where('id_users', $request->id_users)->first();

        if (!$pengguna) {
            return redirect()->back()->with('error', 'Pengguna dengan kode finger tersebut tidak ditemukan.');
        }

        // Hitung jumlah hari pengajuan
        $jumlah_hari_pengajuan = $request->jumlah_hari_pengajuan;
        // dd($jumlah_hari_pengajuan);

        // Periksa apakah jatah cuti tahunan mencukupi
        if ($request->jenis_perizinan === 'CT' && $pengguna->cuti) {
            if ($pengguna->cuti->jatah_cuti < $jumlah_hari_pengajuan) {
                return redirect()->back()->with('error', 'Jatah cuti tidak mencukupi untuk pengajuan ini.');
            }
        }

        if ($request->hasFile('file_perizinan')) {
            // Upload dan simpan file jika ada
            $file_perizinan = $request->file('file_perizinan');
            $namafile_perizinan = Str::random(10) . '.' . $file_perizinan->getClientOriginalExtension();
            Storage::disk('public')->put('file_perizinan/' . $namafile_perizinan, file_get_contents($file_perizinan));
            $perizinan->file_perizinan = $namafile_perizinan;
        } else {
            $perizinan->file_perizinan = null; // Atur kolom file_perizinan menjadi NULL jika tidak ada file diunggah
        }

        $perizinan->id_users = $request->id_users;
        $perizinan->tgl_absen_awal = $request->tgl_absen_awal;
        $perizinan->jenis_perizinan = $request->jenis_perizinan;
        $perizinan->tgl_absen_akhir = $request->tgl_absen_akhir;
        $perizinan->jumlah_hari_pengajuan = $jumlah_hari_pengajuan;
        $perizinan->keterangan = $request->keterangan;

        if ($pengguna->id_jabatan == '7') {
            $perizinan->id_atasan = null;
        } else {
            $perizinan->id_atasan = $request->id_atasan;
        }

        if ($pengguna->id_jabatan == '7') {
            $perizinan->status_izin_atasan = '1';
        } else {
            $perizinan->status_izin_atasan = null;
        }

        $perizinan->status_izin_ppk = null;

        $perizinan->save();

        $notifikasi = new Notifikasi();
        $notifikasi->judul = 'Pengajuan Izin';
        $notifikasi->pesan = 'Pengajuan perizinan anda sudah berhasil dikirimkan. Kami telah mengirimkan notifikasi untuk memproses pengajuanmu.';
        $notifikasi->is_dibaca = 'tidak_dibaca';
        $notifikasi->send_email = 'yes';
        $notifikasi->label = 'info';
        $notifikasi->link = '/perizinan';
        $notifikasi->id_users = $pengguna->id_users;
        $notifikasi->save();

        if ($pengguna->id_jabatan != '7') {
            $notifikasi = new Notifikasi();
            $notifikasi->judul = 'Pengajuan Izin ';
            $notifikasi->pesan = 'Pengajuan perizinan dari ' . $pengguna->nama_pegawai . '. Mohon berikan persetujan kepada pemohon.'; // Sesuaikan pesan notifikasi sesuai kebutuhan Anda.
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
            $notifikasi->pesan = 'Pengajuan perizinan dari ' . $pengguna->nama_pegawai . '. Mohon berikan persetujan kepada pemohon.'; // Sesuaikan pesan notifikasi sesuai kebutuhan Anda.
            $notifikasi->is_dibaca = 'tidak_dibaca';
            $notifikasi->send_email = 'yes';
            $notifikasi->label = 'info';
            $notifikasi->link = '/ajuanperizinan';
            $notifikasi->id_users = $ppk->id_users;
            $notifikasi->save();
        }

        $notifikasiAdmin = User::where('level', 'admin')->get();

        foreach ($notifikasiAdmin as $na) {
            $notifikasi = new Notifikasi();
            $notifikasi->judul = 'Pengajuan Izin ';
            $notifikasi->pesan = 'Pengajuan perizinan dari ' . $pengguna->nama_pegawai . '. Mohon berikan persetujan kepada pemohon.'; // Sesuaikan pesan notifikasi sesuai kebutuhan Anda.
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
        $rules = [
            'id_users' => 'required',
            'tgl_absen_awal' => 'required',
            'tgl_absen_akhir' => 'required',
            'jumlah_hari_pengajuan' => 'required',
            'id_atasan' => 'required',
            'keterangan' => 'required',
            'jenis_perizinan' => 'required',
            'file_perizinan' => 'mimes:pdf,doc,docx,png,jpg,jpeg',
        ];
        $request->validate($rules);

        $perizinan = Perizinan::find($id_perizinan);

        if ($request->hasFile('file_perizinan')) {
            // Menghapus file file_perizinan sebelumnya
            if ($perizinan->file_perizinan) {
                Storage::disk('public')->delete('file_perizinan/' . $perizinan->file_perizinan);
            }

            // Upload file file_perizinan baru
            $file_perizinan = $request->file('file_perizinan');
            $namafile_perizinan = Str::random(10) . '.' . $file_perizinan->getClientOriginalExtension();
            Storage::disk('public')->put('file_perizinan/' . $namafile_perizinan, file_get_contents($file_perizinan));
            $perizinan->file_perizinan = $namafile_perizinan;
        }

        if ($request->jenis_perizinan === 'CT') {
            $perizinanUser = User::with('cuti')->where('id_users', $request->id_users)->first();
            if ($perizinanUser) {
                if ($perizinanUser->cuti == null) {
                    return redirect()->back()->with('error', 'Anda belum memiliki cuti tahunan.');
                }
                $jumlahCuti = $request->jumlah_hari_pengajuan;
                $jatahCutiTahunan = $perizinanUser->cuti->jatah_cuti;
                if ($jatahCutiTahunan < $jumlahCuti) {
                    return redirect()->back()->with('error', 'Anda tidak memiliki jatah cuti tahunan yang cukup.');
                }
                if ($perizinanUser->cuti->save()) {

                } else {
                    return redirect()->back()->with('error', 'Gagal mengurangi jatah cuti pengguna.');
                }
            }
        }
        $perizinan->id_users = $request->id_users;
        $perizinan->tgl_absen_awal = $request->tgl_absen_awal;
        $perizinan->jenis_perizinan = $request->jenis_perizinan;
        $perizinan->tgl_absen_akhir = $request->tgl_absen_akhir;
        $perizinan->jumlah_hari_pengajuan = $request->jumlah_hari_pengajuan;
        $perizinan->id_atasan = $request->id_atasan;
        $perizinan->keterangan = $request->keterangan;
        $perizinan->status_izin_atasan = null;
        $perizinan->status_izin_ppk = null;

        $perizinan->save();
        $pengguna = User::where('id_users', $request->id_users)->first();


        $notifikasi = new Notifikasi();
        $notifikasi->judul = 'Pengajuan Izin';
        $notifikasi->pesan = 'Pengajuan perizinan anda sudah berhasil dikirimkan. Kami telah mengirimkan notifikasi untuk memproses pengajuanmu.';
        $notifikasi->is_dibaca = 'tidak_dibaca';
        $notifikasi->send_email = 'yes';
        $notifikasi->label = 'info';
        $notifikasi->link = '/perizinan';
        $notifikasi->id_users = $pengguna->id_users;
        $notifikasi->save();

        $notifikasi = new Notifikasi();
        $notifikasi->judul = 'Pengajuan Izin ';
        $notifikasi->pesan = 'Pengajuan perizinan dari ' . $pengguna->nama_pegawai . '. Mohon berikan persetujan kepada pemohon.'; // Sesuaikan pesan notifikasi sesuai kebutuhan Anda.
        $notifikasi->is_dibaca = 'tidak_dibaca';
        $notifikasi->send_email = 'yes';
        $notifikasi->label = 'info';
        $notifikasi->link = '/ajuanperizinan';
        $notifikasi->id_users = $request->id_atasan;
        $notifikasi->save();


        $ppk = GeneralSetting::where('status', '1')->first();
        if ($request->jenis_perizinan !== 'I') {
            $notifikasi = new Notifikasi();
            $notifikasi->judul = 'Pengajuan Izin ';
            $notifikasi->pesan = 'Pengajuan perizinan dari ' . $pengguna->nama_pegawai . '. Mohon berikan persetujan kepada pemohon.'; // Sesuaikan pesan notifikasi sesuai kebutuhan Anda.
            $notifikasi->is_dibaca = 'tidak_dibaca';
            $notifikasi->send_email = 'yes';
            $notifikasi->label = 'info';
            $notifikasi->link = '/ajuanperizinan';
            $notifikasi->id_users = $ppk->id_users;
            $notifikasi->save();
        }

        $notifikasiAdmin = User::where('level', 'admin')->get();

        foreach ($notifikasiAdmin as $na) {
            $notifikasi = new Notifikasi();
            $notifikasi->judul = 'Pengajuan Izin ';
            $notifikasi->pesan = 'Pengajuan perizinan dari ' . $pengguna->nama_pegawai . '. Mohon berikan persetujan kepada pemohon.'; // Sesuaikan pesan notifikasi sesuai kebutuhan Anda.
            $notifikasi->is_dibaca = 'tidak_dibaca';
            $notifikasi->send_email = 'yes';
            $notifikasi->label = 'info';
            $notifikasi->link = '/ajuanperizinan';
            $notifikasi->id_users = $na->id_users;
            $notifikasi->save();
        }

        return redirect()->back()->with('success_message', 'Data telah tersimpan.');


        return redirect()->back()->with('success_message', 'Data telah tersimpan.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_perizinan)
    {
        $perizinan = Perizinan::find($id_perizinan);
        if ($perizinan) {
            $perizinan->update([
                'is_deleted' => '1',
            ]);
        }

        return redirect()->back()->with('success_message', 'Data telah terhapus.');
    }
}