<?php

namespace App\Http\Controllers;

use App\Models\GeneralSetting;
use App\Models\Notifikasi;
use App\Models\Perizinan;
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
        $kode_finger     = $request->kode_finger ?? null;
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
            unset($where['kode_finger']);
        } else {
            $where['kode_finger'] = $user->kode_finger;
        }


        if ($tgl_absen_awal != null && $tgl_absen_akhir != null) {
            $ajuanperizinan
            ->where('tgl_absen_awal', '>=', date($tgl_absen_awal))
            ->where('tgl_absen_akhir', '<=', date($tgl_absen_akhir));
        }

        if ($kode_finger != null && $kode_finger != 'all') {
            $where['kode_finger'] = $kode_finger;
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
            'pengguna' => User::where('kode_finger', $kode_finger)->first(),
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
        $request->validate([
            'id_atasan' => 'required',
            'kode_finger' => 'required',
            'jenis_perizinan' => 'required',
            'jumlah_hari_pengajuan' => 'required',
            'tgl_absen_awal' => 'required',
            'tgl_absen_akhir' => 'required',
            'keterangan' => 'required',
            'file_perizinan' => 'mimes:pdf,doc,docx,png,jpg,jpeg',
        ]);

        $ajuanperizinan = new Perizinan();
        $kode_finger    = $request->kode_finger || null; 
        $jumlah_hari_pengajuan = $request->jumlah_hari_pengajuan || null;

        $pengguna = User::where('kode_finger', $kode_finger)->first();

        if (! $pengguna) {
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
        $ajuanperizinan->kode_finger = $request->kode_finger;
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
        if (auth()->user()->level === 'bod' || auth()->user()->level === 'kadiv') {
            $rules = [
                'status_izin_atasan' => 'required',
            ];

            $ajuanperizinan = Perizinan::find($id_perizinan);
            $request->validate($rules);
            $ajuanperizinan->status_izin_atasan = $request->status_izin_atasan;

            if ($request->status_izin_atasan === PersetujuanIzin::Ditolak) {
                $ajuanperizinan->alasan_ditolak_atasan = $request->alasan_ditolak_atasan;
            } else {
                $statusPPK = $ajuanperizinan->status_izin_ppk;
                $CutiTahunan = $ajuanperizinan->jenis_perizinan;

                if ($statusPPK === '1' && $CutiTahunan === 'CT') {
                    $kodeFinger = $ajuanperizinan->kode_finger;
                    $perizinanUser = User::with('cuti')->where('kode_finger', $kodeFinger)->first();

                    if ($perizinanUser) {
                        if ($perizinanUser->cuti == null) {
                            return redirect()->back()->with('error', 'Anda belum memiliki cuti tahunan.');
                        }

                        $jumlahCuti = $ajuanperizinan->jumlah_hari_pengajuan;
                        $jatahCutiTahunan = $perizinanUser->cuti->jatah_cuti;

                        if ($jatahCutiTahunan < $jumlahCuti) {
                            return redirect()->back()->with('error', 'Anda tidak memiliki jatah cuti tahunan yang cukup.');
                        }

                        $perizinanUser->cuti->jatah_cuti -= $jumlahCuti;

                        if ($perizinanUser->cuti->save()) {
                            // Logika tambahan setelah mengurangkan jatah cuti.
                        } else {
                            return redirect()->back()->with('error', 'Gagal mengurangi jatah cuti pengguna.');
                        }

                    } else {
                        return redirect()->back()->with('error', 'Pengguna dengan kode finger tersebut tidak ditemukan.');
                    }
                }

            }
            // dd($request);
            // dd($statusPPK, $request->jenis_perizinan);
            $ajuanperizinan->save();

            $pengguna = User::where('kode_finger', $ajuanperizinan->kode_finger)->first();
            if($ajuanperizinan->jenis_perizinan === 'I') {
                if ($ajuanperizinan->status_izin_atasan === '1' && $ajuanperizinan->status_izin_ppk === null) {
                    
                    $tanggalAwalIzin = Carbon::parse($ajuanperizinan->tgl_absen_awal);
                    $tanggalAkhirIzin = Carbon::parse($ajuanperizinan->tgl_absen_akhir);
                  
                    // Jenis perizinan
                    $jenisPerizinan = $ajuanperizinan->jenis_perizinan;
                    $pegawai = $ajuanperizinan ->kode_finger;
    
                    // Perulangan untuk mengisi data presensi harian
                    while ($tanggalAwalIzin <= $tanggalAkhirIzin) {
                        if ($tanggalAwalIzin->isWeekend()) {
                            // Lewati hari Sabtu dan Minggu
                            $tanggalAwalIzin->addDay();
                            continue;
                        }
                        
                        // Periksa apakah tanggal izin harian sudah ada dalam tabel presensi
                        $tanggalPresensi = $tanggalAwalIzin->toDateString();
    
                        $presensiHarian = Presensi::where([
                            'kode_finger' => $pegawai,
                            'tanggal' => $tanggalPresensi,
                            'jenis_perizinan' => $jenisPerizinan
                        ])->first();
    
                        if (!$presensiHarian) {
                            // Jika tidak ada presensi untuk tanggal ini, buat entri presensi baru
                            Presensi::create([
                                'kode_finger' => $pegawai,
                                'tanggal' => $tanggalPresensi,
                                'jenis_perizinan' => $jenisPerizinan, // Simpan jenis perizinan di sini
                            ]);
                        } else {
                            // Jika sudah ada entri presensi untuk tanggal ini, Anda dapat memperbarui jenis perizinan atau status presensinya sesuai kebutuhan
                            $presensiHarian->jenis_perizinan = $jenisPerizinan;
                            $presensiHarian->save();
                        }
                        
    
                        // Lanjutkan ke tanggal berikutnya
                        $tanggalAwalIzin->addDay();
                    }
                    $notifikasi = new Notifikasi();
                    $notifikasi->judul = 'Persetujuan Izin ';
                    $notifikasi->pesan = 'Pengajuan perizinan anda sudah berhasil disetujui. Klik link di bawah ini untuk melihat info lebih lanjut.';
                    $notifikasi->is_dibaca = 'tidak_dibaca';
                    $notifikasi->send_email = 'yes';
                    $notifikasi->label = 'info';
                    $notifikasi->link = '/perizinan';
                    $notifikasi->id_users = $pengguna->id_users;
                    $notifikasi->save();

                    return redirect()->route('ajuanperizinan.index')->with('success_message', 'Data telah tersimpan');

                } elseif ($ajuanperizinan->status_izin_atasan === PersetujuanIzin::Ditolak && $ajuanperizinan->status_izin_ppk === null) {
                    $notifikasi = new Notifikasi();
                    $notifikasi->judul = 'Persetujuan Izin ';
                    $notifikasi->pesan = 'Pengajuan perizinan anda gagal mendapatkan persetujuan. Klik link di bawah ini untuk melihat info lebih lanjut.';
                    $notifikasi->is_dibaca = 'tidak_dibaca';
                    $notifikasi->send_email = 'yes';
                    $notifikasi->label = 'info';
                    $notifikasi->link = '/perizinan';
                    $notifikasi->id_users = $pengguna->id_users;
                    $notifikasi->save();

                    return redirect()->route('ajuanperizinan.index')->with('success_message', 'Data telah tersimpan');

                }

            }
            if ($ajuanperizinan->jenis_perizinan != 'I') {
                if ($ajuanperizinan->status_izin_atasan === '1' && $ajuanperizinan->status_izin_ppk === '1') {
                    
                    $tanggalAwalIzin = Carbon::parse($ajuanperizinan->tgl_absen_awal);
                    $tanggalAkhirIzin = Carbon::parse($ajuanperizinan->tgl_absen_akhir);
                  
                    // Jenis perizinan
                    $jenisPerizinan = $ajuanperizinan->jenis_perizinan;
                    $pegawai = $ajuanperizinan ->kode_finger;
    
                    // Perulangan untuk mengisi data presensi harian
                    while ($tanggalAwalIzin <= $tanggalAkhirIzin) {
                        if ($tanggalAwalIzin->isWeekend()) {
                            // Lewati hari Sabtu dan Minggu
                            $tanggalAwalIzin->addDay();
                            continue;
                        }

                        $tanggalPresensi = $tanggalAwalIzin->toDateString();
    
                        $presensiHarian = Presensi::where([
                            'kode_finger' => $pegawai,
                            'tanggal' => $tanggalPresensi,
                            'jenis_perizinan' => $jenisPerizinan
                        ])->first();
    
                        if (!$presensiHarian) {
                            // Jika tidak ada presensi untuk tanggal ini, buat entri presensi baru
                            Presensi::create([
                                'kode_finger' => $pegawai,
                                'tanggal' => $tanggalPresensi,
                                'jenis_perizinan' => $jenisPerizinan, // Simpan jenis perizinan di sini
                            ]);
                        } else {
                            // Jika sudah ada entri presensi untuk tanggal ini, Anda dapat memperbarui jenis perizinan atau status presensinya sesuai kebutuhan
                            $presensiHarian->jenis_perizinan = $jenisPerizinan;
                            $presensiHarian->save();
                        }
                        
    
                        // Lanjutkan ke tanggal berikutnya
                        $tanggalAwalIzin->addDay();
                    }
                    $notifikasi = new Notifikasi();
                    $notifikasi->judul = 'Persetujuan Izin ';
                    $notifikasi->pesan = 'Pengajuan perizinan anda sudah berhasil disetujui. Klik link di bawah ini untuk melihat info lebih lanjut.';
                    $notifikasi->is_dibaca = 'tidak_dibaca';
                    $notifikasi->send_email = 'yes';
                    $notifikasi->label = 'info';
                    $notifikasi->link = '/perizinan';
                    $notifikasi->id_users = $pengguna->id_users;
                    $notifikasi->save();

                    return redirect()->route('ajuanperizinan.index')->with('success_message', 'Data telah tersimpan');
                }elseif($ajuanperizinan->status_izin_atasan === '1' && $ajuanperizinan->status_izin_ppk === null) {
                    $notifikasi = new Notifikasi();
                    $notifikasi->judul = 'Persetujuan Izin ';
                    $notifikasi->pesan = 'Pengajuan perizinan anda sudah berhasil disetujui oleh atasan. Klik link di bawah ini untuk melihat info lebih lanjut.';
                    $notifikasi->is_dibaca = 'tidak_dibaca';
                    $notifikasi->send_email = 'yes';
                    $notifikasi->label = 'info';
                    $notifikasi->link = '/perizinan';
                    $notifikasi->id_users = $pengguna->id_users;
                    $notifikasi->save();

                    return redirect()->route('ajuanperizinan.index')->with('success_message', 'Data telah tersimpan');
                
                }elseif($ajuanperizinan->status_izin_atasan === PersetujuanIzin::Ditolak && $ajuanperizinan->status_izin_ppk === null) {
                    $notifikasi = new Notifikasi();
                    $notifikasi->judul = 'Persetujuan Izin ';
                    $notifikasi->pesan = 'Pengajuan perizinan anda gagal mendapatkan persetujuan oleh atasan. Klik link di bawah ini untuk melihat info lebih lanjut.';
                    $notifikasi->is_dibaca = 'tidak_dibaca';
                    $notifikasi->send_email = 'yes';
                    $notifikasi->label = 'info';
                    $notifikasi->link = '/perizinan';
                    $notifikasi->id_users = $pengguna->id_users;
                    $notifikasi->save();

                    return redirect()->route('ajuanperizinan.index')->with('success_message', 'Data telah tersimpan');
                }elseif($ajuanperizinan->status_izin_atasan === null && $ajuanperizinan->status_izin_ppk === '1') {
                    $notifikasi = new Notifikasi();
                    $notifikasi->judul = 'Persetujuan Izin ';
                    $notifikasi->pesan = 'Pengajuan perizinan anda sudah berhasil disetujui oleh ppk. Klik link di bawah ini untuk melihat info lebih lanjut.';
                    $notifikasi->is_dibaca = 'tidak_dibaca';
                    $notifikasi->send_email = 'yes';
                    $notifikasi->label = 'info';
                    $notifikasi->link = '/perizinan';
                    $notifikasi->id_users = $pengguna->id_users;
                    $notifikasi->save();

                    return redirect()->route('ajuanperizinan.index')->with('success_message', 'Data telah tersimpan');
                
                }elseif($ajuanperizinan->status_izin_atasan === null && $ajuanperizinan->status_izin_ppk === PersetujuanIzin::Ditolak) {
                    $notifikasi = new Notifikasi();
                    $notifikasi->judul = 'Persetujuan Izin ';
                    $notifikasi->pesan = 'Pengajuan perizinan anda gagal mendapatkan persetujuan oleh ppk. Klik link di bawah ini untuk melihat info lebih lanjut.';
                    $notifikasi->is_dibaca = 'tidak_dibaca';
                    $notifikasi->send_email = 'yes';
                    $notifikasi->label = 'info';
                    $notifikasi->link = '/perizinan';
                    $notifikasi->id_users = $pengguna->id_users;
                    $notifikasi->save();

                    return redirect()->route('ajuanperizinan.index')->with('success_message', 'Data telah tersimpan');
                    
                } elseif ($ajuanperizinan->status_izin_atasan === PersetujuanIzin::Ditolak && $ajuanperizinan->status_izin_ppk === PersetujuanIzin::Ditolak) {
                    $notifikasi = new Notifikasi();
                    $notifikasi->judul = 'Persetujuan Izin ';
                    $notifikasi->pesan = 'Pengajuan perizinan anda gagal mendapatkan persetujuan. Klik link di bawah ini untuk melihat info lebih lanjut.';
                    $notifikasi->is_dibaca = 'tidak_dibaca';
                    $notifikasi->send_email = 'yes';
                    $notifikasi->label = 'info';
                    $notifikasi->link = '/perizinan';
                    $notifikasi->id_users = $pengguna->id_users;
                    $notifikasi->save();

                    return redirect()->route('ajuanperizinan.index')->with('success_message', 'Data telah tersimpan');
                }
            }
            
      
            

            return redirect()->route('ajuanperizinan.index')->with('success_message', 'Data telah tersimpan');
        } elseif (auth()->user()->level === UserLevel::PPK) {
            $ajuanperizinan = Perizinan::find($id_perizinan);

            $rules = [
                'status_izin_ppk' => 'required',
            ];

            if ($ajuanperizinan) {
                if ($ajuanperizinan->id_atasan === auth()->user()->id_users) {
                    $rules['status_izin_atasan'] = 'required';
                }
            }

            $request->validate($rules);

            $ajuanperizinan->status_izin_ppk = $request->status_izin_ppk;
            if ($ajuanperizinan) {
                if ($ajuanperizinan->id_atasan === auth()->user()->id_users) {
                    $ajuanperizinan->status_izin_atasan = $request->status_izin_atasan;
                }
            }

            $statusAtasan = $ajuanperizinan->status_izin_atasan;

            if ($request->status_izin_ppk === PersetujuanIzin::Ditolak) {
                $ajuanperizinan->alasan_ditolak_ppk = $request->alasan_ditolak_ppk;
            }
            if ($request->status_izin_atasan === PersetujuanIzin::Ditolak) {
                $ajuanperizinan->alasan_ditolak_atasan = $request->alasan_ditolak_atasan;
            }

            if ($request->status_izin_ppk === '1' || $request->status_izin_atasan === '1') {
                $statusAtasan = $ajuanperizinan->status_izin_atasan;
                $CutiTahunan = $ajuanperizinan->jenis_perizinan;

                if ($statusAtasan === '1' && $CutiTahunan === 'CT') {
                    $kodeFinger = $ajuanperizinan->kode_finger;
                    $perizinanUser = User::with('cuti')->where('kode_finger', $kodeFinger)->first();

                    if ($perizinanUser) {
                        $jumlahCuti = $ajuanperizinan->jumlah_hari_pengajuan;
                        $jatahCutiTahunan = $perizinanUser->cuti->jatah_cuti;
                        if ($jatahCutiTahunan < $jumlahCuti) {
                            return redirect()->back()->with('error', 'Anda tidak memiliki jatah cuti tahunan yang cukup.');
                        }
                        if ($perizinanUser->cuti) {
                            $perizinanUser->cuti->jatah_cuti -= $jumlahCuti;
                            if ($perizinanUser->cuti->save()) {

                            } else {
                                return redirect()->back()->with('error', 'Gagal mengurangi jatah cuti pengguna.');
                            }
                        }
                    } else {
                        return redirect()->back()->with('error', 'Pengguna dengan kode finger tersebut tidak ditemukan.');
                    }

                }
            }
            $ajuanperizinan->status_izin_atasan = $statusAtasan;
            // dd($request);

            $ajuanperizinan->save();
            $pengguna = User::where('kode_finger', $ajuanperizinan->kode_finger)->first();
            if($ajuanperizinan->jenis_perizinan === 'I') {
                if ($ajuanperizinan->status_izin_atasan === '1' && $ajuanperizinan->status_izin_ppk === null) {
                    
                    $tanggalAwalIzin = Carbon::parse($ajuanperizinan->tgl_absen_awal);
                    $tanggalAkhirIzin = Carbon::parse($ajuanperizinan->tgl_absen_akhir);
                  
                    // Jenis perizinan
                    $jenisPerizinan = $ajuanperizinan->jenis_perizinan;
                    $pegawai = $ajuanperizinan ->kode_finger;
    
                    // Perulangan untuk mengisi data presensi harian
                    while ($tanggalAwalIzin <= $tanggalAkhirIzin) {
                        if ($tanggalAwalIzin->isWeekend()) {
                            // Lewati hari Sabtu dan Minggu
                            $tanggalAwalIzin->addDay();
                            continue;
                        }
                        
                        // Periksa apakah tanggal izin harian sudah ada dalam tabel presensi
                        $tanggalPresensi = $tanggalAwalIzin->toDateString();
    
                        $presensiHarian = Presensi::where([
                            'kode_finger' => $pegawai,
                            'tanggal' => $tanggalPresensi,
                            'jenis_perizinan' => $jenisPerizinan
                        ])->first();
    
                        if (!$presensiHarian) {
                            // Jika tidak ada presensi untuk tanggal ini, buat entri presensi baru
                            Presensi::create([
                                'kode_finger' => $pegawai,
                                'tanggal' => $tanggalPresensi,
                                'jenis_perizinan' => $jenisPerizinan, // Simpan jenis perizinan di sini
                            ]);
                        } else {
                            // Jika sudah ada entri presensi untuk tanggal ini, Anda dapat memperbarui jenis perizinan atau status presensinya sesuai kebutuhan
                            $presensiHarian->jenis_perizinan = $jenisPerizinan;
                            $presensiHarian->save();
                        }
                        
    
                        // Lanjutkan ke tanggal berikutnya
                        $tanggalAwalIzin->addDay();
                    }
                    $notifikasi = new Notifikasi();
                    $notifikasi->judul = 'Persetujuan Izin ';
                    $notifikasi->pesan = 'Pengajuan perizinan anda sudah berhasil disetujui. Klik link di bawah ini untuk melihat info lebih lanjut.';
                    $notifikasi->is_dibaca = 'tidak_dibaca';
                    $notifikasi->send_email = 'yes';
                    $notifikasi->label = 'info';
                    $notifikasi->link = '/perizinan';
                    $notifikasi->id_users = $pengguna->id_users;
                    $notifikasi->save();

                    return redirect()->route('ajuanperizinan.index')->with('success_message', 'Data telah tersimpan');

                } elseif ($ajuanperizinan->status_izin_atasan === PersetujuanIzin::Ditolak && $ajuanperizinan->status_izin_ppk === null) {
                    $notifikasi = new Notifikasi();
                    $notifikasi->judul = 'Persetujuan Izin ';
                    $notifikasi->pesan = 'Pengajuan perizinan anda gagal mendapatkan persetujuan. Klik link di bawah ini untuk melihat info lebih lanjut.';
                    $notifikasi->is_dibaca = 'tidak_dibaca';
                    $notifikasi->send_email = 'yes';
                    $notifikasi->label = 'info';
                    $notifikasi->link = '/perizinan';
                    $notifikasi->id_users = $pengguna->id_users;
                    $notifikasi->save();

                    return redirect()->route('ajuanperizinan.index')->with('success_message', 'Data telah tersimpan');

                }

            }
            if ($ajuanperizinan->jenis_perizinan != 'I') {
                if ($ajuanperizinan->status_izin_atasan === '1' && $ajuanperizinan->status_izin_ppk === '1') {
                    
                    $tanggalAwalIzin = Carbon::parse($ajuanperizinan->tgl_absen_awal);
                    $tanggalAkhirIzin = Carbon::parse($ajuanperizinan->tgl_absen_akhir);
                  
                    // Jenis perizinan
                    $jenisPerizinan = $ajuanperizinan->jenis_perizinan;
                    $pegawai = $ajuanperizinan ->kode_finger;
    
                    // Perulangan untuk mengisi data presensi harian
                    while ($tanggalAwalIzin <= $tanggalAkhirIzin) {

                        if ($tanggalAwalIzin->isWeekend()) {
                            // Lewati hari Sabtu dan Minggu
                            $tanggalAwalIzin->addDay();
                            continue;
                        }
                        
                        // Periksa apakah tanggal izin harian sudah ada dalam tabel presensi
                        $tanggalPresensi = $tanggalAwalIzin->toDateString();
    
                        $presensiHarian = Presensi::where([
                            'kode_finger' => $pegawai,
                            'tanggal' => $tanggalPresensi,
                            'jenis_perizinan' => $jenisPerizinan
                        ])->first();
    
                        if (!$presensiHarian) {
                            // Jika tidak ada presensi untuk tanggal ini, buat entri presensi baru
                            Presensi::create([
                                'kode_finger' => $pegawai,
                                'tanggal' => $tanggalPresensi,
                                'jenis_perizinan' => $jenisPerizinan, // Simpan jenis perizinan di sini
                            ]);
                        } else {
                            // Jika sudah ada entri presensi untuk tanggal ini, Anda dapat memperbarui jenis perizinan atau status presensinya sesuai kebutuhan
                            $presensiHarian->jenis_perizinan = $jenisPerizinan;
                            $presensiHarian->save();
                        }
                        
    
                        // Lanjutkan ke tanggal berikutnya
                        $tanggalAwalIzin->addDay();
                    }
                    $notifikasi = new Notifikasi();
                    $notifikasi->judul = 'Persetujuan Izin ';
                    $notifikasi->pesan = 'Pengajuan perizinan anda sudah berhasil disetujui. Klik link di bawah ini untuk melihat info lebih lanjut.';
                    $notifikasi->is_dibaca = 'tidak_dibaca';
                    $notifikasi->send_email = 'yes';
                    $notifikasi->label = 'info';
                    $notifikasi->link = '/perizinan';
                    $notifikasi->id_users = $pengguna->id_users;
                    $notifikasi->save();

                    return redirect()->route('ajuanperizinan.index')->with('success_message', 'Data telah tersimpan');
                }elseif($ajuanperizinan->status_izin_atasan === '1' && $ajuanperizinan->status_izin_ppk === null) {
                    $notifikasi = new Notifikasi();
                    $notifikasi->judul = 'Persetujuan Izin ';
                    $notifikasi->pesan = 'Pengajuan perizinan anda sudah berhasil disetujui oleh atasan. Klik link di bawah ini untuk melihat info lebih lanjut.';
                    $notifikasi->is_dibaca = 'tidak_dibaca';
                    $notifikasi->send_email = 'yes';
                    $notifikasi->label = 'info';
                    $notifikasi->link = '/perizinan';
                    $notifikasi->id_users = $pengguna->id_users;
                    $notifikasi->save();

                    return redirect()->route('ajuanperizinan.index')->with('success_message', 'Data telah tersimpan');
                
                }elseif($ajuanperizinan->status_izin_atasan === PersetujuanIzin::Ditolak && $ajuanperizinan->status_izin_ppk === null) {
                    $notifikasi = new Notifikasi();
                    $notifikasi->judul = 'Persetujuan Izin ';
                    $notifikasi->pesan = 'Pengajuan perizinan anda gagal mendapatkan persetujuan oleh atasan. Klik link di bawah ini untuk melihat info lebih lanjut.';
                    $notifikasi->is_dibaca = 'tidak_dibaca';
                    $notifikasi->send_email = 'yes';
                    $notifikasi->label = 'info';
                    $notifikasi->link = '/perizinan';
                    $notifikasi->id_users = $pengguna->id_users;
                    $notifikasi->save();

                    return redirect()->route('ajuanperizinan.index')->with('success_message', 'Data telah tersimpan');
                }elseif($ajuanperizinan->status_izin_atasan === null && $ajuanperizinan->status_izin_ppk === '1') {
                    $notifikasi = new Notifikasi();
                    $notifikasi->judul = 'Persetujuan Izin ';
                    $notifikasi->pesan = 'Pengajuan perizinan anda sudah berhasil disetujui oleh ppk. Klik link di bawah ini untuk melihat info lebih lanjut.';
                    $notifikasi->is_dibaca = 'tidak_dibaca';
                    $notifikasi->send_email = 'yes';
                    $notifikasi->label = 'info';
                    $notifikasi->link = '/perizinan';
                    $notifikasi->id_users = $pengguna->id_users;
                    $notifikasi->save();

                    return redirect()->route('ajuanperizinan.index')->with('success_message', 'Data telah tersimpan');
                
                }elseif($ajuanperizinan->status_izin_atasan === null && $ajuanperizinan->status_izin_ppk === PersetujuanIzin::Ditolak) {
                    $notifikasi = new Notifikasi();
                    $notifikasi->judul = 'Persetujuan Izin ';
                    $notifikasi->pesan = 'Pengajuan perizinan anda gagal mendapatkan persetujuan oleh ppk. Klik link di bawah ini untuk melihat info lebih lanjut.';
                    $notifikasi->is_dibaca = 'tidak_dibaca';
                    $notifikasi->send_email = 'yes';
                    $notifikasi->label = 'info';
                    $notifikasi->link = '/perizinan';
                    $notifikasi->id_users = $pengguna->id_users;
                    $notifikasi->save();

                    return redirect()->route('ajuanperizinan.index')->with('success_message', 'Data telah tersimpan');
                    
                } elseif ($ajuanperizinan->status_izin_atasan === PersetujuanIzin::Ditolak && $ajuanperizinan->status_izin_ppk === PersetujuanIzin::Ditolak) {
                    $notifikasi = new Notifikasi();
                    $notifikasi->judul = 'Persetujuan Izin ';
                    $notifikasi->pesan = 'Pengajuan perizinan anda gagal mendapatkan persetujuan. Klik link di bawah ini untuk melihat info lebih lanjut.';
                    $notifikasi->is_dibaca = 'tidak_dibaca';
                    $notifikasi->send_email = 'yes';
                    $notifikasi->label = 'info';
                    $notifikasi->link = '/perizinan';
                    $notifikasi->id_users = $pengguna->id_users;
                    $notifikasi->save();

                    return redirect()->route('ajuanperizinan.index')->with('success_message', 'Data telah tersimpan');
                }
            }

            return redirect()->route('ajuanperizinan.index')->with('success_message', 'Data telah tersimpan');
        } else {
            $rules = [
                'kode_finger' => 'required',
                'id_atasan' => 'required',
                'jenis_perizinan' => 'required',
                // 'tgl_ajuan' => 'required',
                'tgl_absen_awal' => 'required',
                'tgl_absen_akhir' => 'required',
                'keterangan' => 'required',
                // 'status_izin_atasan' => 'required',
                // 'status_izin_ppk' => 'required',
            ];

            if ($request->file('file_perizinan')) {
                $rules['file_perizinan'] = 'required|mimes:pdf,doc,docx,png,jpg,jpeg';
            }

            if (isset($request->status_izin_atasan)) {
                if ($request->status_izin_atasan === PersetujuanIzin::Ditolak) {
                    $rules['alasan_ditolak_atasan'] = 'required';
                }
            }

            if (isset($request->status_izin_ppk)) {
                if ($request->status_izin_ppk === PersetujuanIzin::Ditolak) {
                    $rules['alasan_ditolak_ppk'] = 'required';
                }
            }

            $request->validate($rules);

            $ajuanperizinan = Perizinan::find($id_perizinan);

            if (! $ajuanperizinan) {
                return redirect()->route('ajuanperizinan.index')->with('error', 'Data tidak ditemukan');
            }
            $ajuanperizinan->id_atasan = $request->id_atasan;
            $ajuanperizinan->kode_finger = $request->kode_finger;
            $ajuanperizinan->jenis_perizinan = $request->jenis_perizinan;
            $ajuanperizinan->tgl_absen_awal = $request->tgl_absen_awal;
            $ajuanperizinan->tgl_absen_akhir = $request->tgl_absen_akhir;
            $ajuanperizinan->keterangan = $request->keterangan;

            if (isset($request->status_izin_atasan)) {
                $ajuanperizinan->status_izin_atasan = $request->status_izin_atasan;
            }
            if (isset($request->status_izin_ppk)) {
                $ajuanperizinan->status_izin_ppk = $request->status_izin_ppk;
            }

            if (isset($request->status_izin_atasan)) {
                if ($request->status_izin_atasan === PersetujuanIzin::Ditolak) {
                    $ajuanperizinan->alasan_ditolak_atasan = $request->alasan_ditolak_atasan;
                }
            }
            if (isset($request->status_izin_ppk)) {
                if ($request->status_izin_ppk === PersetujuanIzin::Ditolak) {
                    $ajuanperizinan->alasan_ditolak_ppk = $request->alasan_ditolak_ppk;
                }
            }

            if ($request->status_izin_ppk && $request->status_izin_atasan) {
                if ($request->jenis_perizinan === 'CT') {
                    $perizinanUser = User::with('cuti')->where('kode_finger', $request->kode_finger)->first();

                    if ($perizinanUser) {
                        if ($perizinanUser->cuti == null) {
                            return redirect()->back()->with('error', 'Anda belum memiliki cuti tahunan.');
                        }
                        $jumlahCuti = $ajuanperizinan->jumlah_hari_pengajuan;
                        $jatahCutiTahunan = $perizinanUser->cuti->jatah_cuti;
                        if ($jatahCutiTahunan < $jumlahCuti) {
                            return redirect()->back()->with('error', 'Anda tidak memiliki jatah cuti tahunan yang cukup.');
                        }
                        if ($perizinanUser->cuti) {
                            $perizinanUser->cuti->jatah_cuti -= $jumlahCuti;
                            if ($perizinanUser->cuti->save()) {

                            } else {
                                return redirect()->back()->with('error', 'Gagal mengurangi jatah cuti pengguna.');
                            }
                        }
                    } else {
                        return redirect()->back()->with('error', 'Pengguna dengan kode finger tersebut tidak ditemukan.');
                    }
                }

            }
            // dd($request, $ajuanperizinan);

            if ($request->hasFile('file_perizinan')) {
                // Menghapus file file_perizinan sebelumnya
                if ($ajuanperizinan->file_perizinan) {
                    Storage::disk('public')->delete('file_perizinan/'.$ajuanperizinan->file_perizinan);
                }

                // Upload file file_perizinan baru
                $file_perizinan = $request->file('file_perizinan');
                $namafile_perizinan = time().'.'.$file_perizinan->getClientOriginalExtension();
                Storage::disk('public')->put('file_perizinan/'.$namafile_perizinan, file_get_contents($file_perizinan));
                $ajuanperizinan->file_perizinan = $namafile_perizinan;
            }

            $request->validate($rules);

            $ajuanperizinan->save();

            $pengguna = User::where('kode_finger', $request->kode_finger)->first();
            if($ajuanperizinan->jenis_perizinan === 'I') {
                if ($ajuanperizinan->status_izin_atasan === '1' && $ajuanperizinan->status_izin_ppk === null) {
                    
                    $tanggalAwalIzin = Carbon::parse($ajuanperizinan->tgl_absen_awal);
                    $tanggalAkhirIzin = Carbon::parse($ajuanperizinan->tgl_absen_akhir);
                  
                    // Jenis perizinan
                    $jenisPerizinan = $ajuanperizinan->jenis_perizinan;
                    $pegawai = $ajuanperizinan ->kode_finger;
    
                    // Perulangan untuk mengisi data presensi harian
                    while ($tanggalAwalIzin <= $tanggalAkhirIzin) {
                        if ($tanggalAwalIzin->isWeekend()) {
                            // Lewati hari Sabtu dan Minggu
                            $tanggalAwalIzin->addDay();
                            continue;
                        }
                        
                        // Periksa apakah tanggal izin harian sudah ada dalam tabel presensi
                        $tanggalPresensi = $tanggalAwalIzin->toDateString();
    
                        $presensiHarian = Presensi::where([
                            'kode_finger' => $pegawai,
                            'tanggal' => $tanggalPresensi,
                            'jenis_perizinan' => $jenisPerizinan
                        ])->first();
    
                        if (!$presensiHarian) {
                            // Jika tidak ada presensi untuk tanggal ini, buat entri presensi baru
                            Presensi::create([
                                'kode_finger' => $pegawai,
                                'tanggal' => $tanggalPresensi,
                                'jenis_perizinan' => $jenisPerizinan, // Simpan jenis perizinan di sini
                            ]);
                        } else {
                            // Jika sudah ada entri presensi untuk tanggal ini, Anda dapat memperbarui jenis perizinan atau status presensinya sesuai kebutuhan
                            $presensiHarian->jenis_perizinan = $jenisPerizinan;
                            $presensiHarian->save();
                        }
                        
    
                        // Lanjutkan ke tanggal berikutnya
                        $tanggalAwalIzin->addDay();
                    }
                    $notifikasi = new Notifikasi();
                    $notifikasi->judul = 'Persetujuan Izin ';
                    $notifikasi->pesan = 'Pengajuan perizinan anda sudah berhasil disetujui. Klik link di bawah ini untuk melihat info lebih lanjut.';
                    $notifikasi->is_dibaca = 'tidak_dibaca';
                    $notifikasi->send_email = 'yes';
                    $notifikasi->label = 'info';
                    $notifikasi->link = '/perizinan';
                    $notifikasi->id_users = $pengguna->id_users;
                    $notifikasi->save();

                    return redirect()->route('ajuanperizinan.index')->with('success_message', 'Data telah tersimpan');

                } elseif ($ajuanperizinan->status_izin_atasan === PersetujuanIzin::Ditolak && $ajuanperizinan->status_izin_ppk === null) {
                    $notifikasi = new Notifikasi();
                    $notifikasi->judul = 'Persetujuan Izin ';
                    $notifikasi->pesan = 'Pengajuan perizinan anda gagal mendapatkan persetujuan. Klik link di bawah ini untuk melihat info lebih lanjut.';
                    $notifikasi->is_dibaca = 'tidak_dibaca';
                    $notifikasi->send_email = 'yes';
                    $notifikasi->label = 'info';
                    $notifikasi->link = '/perizinan';
                    $notifikasi->id_users = $pengguna->id_users;
                    $notifikasi->save();

                    return redirect()->route('ajuanperizinan.index')->with('success_message', 'Data telah tersimpan');

                }

            }
            if ($ajuanperizinan->jenis_perizinan != 'I') {
                if ($ajuanperizinan->status_izin_atasan === '1' && $ajuanperizinan->status_izin_ppk === '1') {
                
                        $tanggalAwalIzin = Carbon::parse($ajuanperizinan->tgl_absen_awal);
                        $tanggalAkhirIzin = Carbon::parse($ajuanperizinan->tgl_absen_akhir);
                      
                        // Jenis perizinan
                        $jenisPerizinan = $ajuanperizinan->jenis_perizinan;
                        $pegawai = $ajuanperizinan ->kode_finger;
        
                        // Perulangan untuk mengisi data presensi harian
                        while ($tanggalAwalIzin <= $tanggalAkhirIzin) {
                            if ($tanggalAwalIzin->isWeekend()) {
                                // Lewati hari Sabtu dan Minggu
                                $tanggalAwalIzin->addDay();
                                continue;
                            }
                            
                            // Periksa apakah tanggal izin harian sudah ada dalam tabel presensi
                            $tanggalPresensi = $tanggalAwalIzin->toDateString();
        
                            $presensiHarian = Presensi::where([
                                'kode_finger' => $pegawai,
                                'tanggal' => $tanggalPresensi,
                                'jenis_perizinan' => $jenisPerizinan
                            ])->first();
        
                            if (!$presensiHarian) {
                                // Jika tidak ada presensi untuk tanggal ini, buat entri presensi baru
                                Presensi::create([
                                    'kode_finger' => $pegawai,
                                    'tanggal' => $tanggalPresensi,
                                    'jenis_perizinan' => $jenisPerizinan, // Simpan jenis perizinan di sini
                                ]);
                            } else {
                                // Jika sudah ada entri presensi untuk tanggal ini, Anda dapat memperbarui jenis perizinan atau status presensinya sesuai kebutuhan
                                $presensiHarian->jenis_perizinan = $jenisPerizinan;
                                $presensiHarian->save();
                            }
                            
        
                            // Lanjutkan ke tanggal berikutnya
                            $tanggalAwalIzin->addDay();
                        }
                    
                    $notifikasi = new Notifikasi();
                    $notifikasi->judul = 'Persetujuan Izin ';
                    $notifikasi->pesan = 'Pengajuan perizinan anda sudah berhasil disetujui. Klik link di bawah ini untuk melihat info lebih lanjut.';
                    $notifikasi->is_dibaca = 'tidak_dibaca';
                    $notifikasi->send_email = 'yes';
                    $notifikasi->label = 'info';
                    $notifikasi->link = '/perizinan';
                    $notifikasi->id_users = $pengguna->id_users;
                    $notifikasi->save();

                    return redirect()->route('ajuanperizinan.index')->with('success_message', 'Data telah tersimpan');
                }elseif($ajuanperizinan->status_izin_atasan === '1' && $ajuanperizinan->status_izin_ppk === null) {
                    $notifikasi = new Notifikasi();
                    $notifikasi->judul = 'Persetujuan Izin ';
                    $notifikasi->pesan = 'Pengajuan perizinan anda sudah berhasil disetujui oleh atasan. Klik link di bawah ini untuk melihat info lebih lanjut.';
                    $notifikasi->is_dibaca = 'tidak_dibaca';
                    $notifikasi->send_email = 'yes';
                    $notifikasi->label = 'info';
                    $notifikasi->link = '/perizinan';
                    $notifikasi->id_users = $pengguna->id_users;
                    $notifikasi->save();

                    return redirect()->route('ajuanperizinan.index')->with('success_message', 'Data telah tersimpan');
                
                }elseif($ajuanperizinan->status_izin_atasan === PersetujuanIzin::Ditolak && $ajuanperizinan->status_izin_ppk === null) {
                    $notifikasi = new Notifikasi();
                    $notifikasi->judul = 'Persetujuan Izin ';
                    $notifikasi->pesan = 'Pengajuan perizinan anda gagal mendapatkan persetujuan oleh atasan. Klik link di bawah ini untuk melihat info lebih lanjut.';
                    $notifikasi->is_dibaca = 'tidak_dibaca';
                    $notifikasi->send_email = 'yes';
                    $notifikasi->label = 'info';
                    $notifikasi->link = '/perizinan';
                    $notifikasi->id_users = $pengguna->id_users;
                    $notifikasi->save();

                    return redirect()->route('ajuanperizinan.index')->with('success_message', 'Data telah tersimpan');
                }elseif($ajuanperizinan->status_izin_atasan === null && $ajuanperizinan->status_izin_ppk === '1') {
                    $notifikasi = new Notifikasi();
                    $notifikasi->judul = 'Persetujuan Izin ';
                    $notifikasi->pesan = 'Pengajuan perizinan anda sudah berhasil disetujui oleh ppk. Klik link di bawah ini untuk melihat info lebih lanjut.';
                    $notifikasi->is_dibaca = 'tidak_dibaca';
                    $notifikasi->send_email = 'yes';
                    $notifikasi->label = 'info';
                    $notifikasi->link = '/perizinan';
                    $notifikasi->id_users = $pengguna->id_users;
                    $notifikasi->save();

                    return redirect()->route('ajuanperizinan.index')->with('success_message', 'Data telah tersimpan');
                
                }elseif($ajuanperizinan->status_izin_atasan === null && $ajuanperizinan->status_izin_ppk === PersetujuanIzin::Ditolak) {
                    $notifikasi = new Notifikasi();
                    $notifikasi->judul = 'Persetujuan Izin ';
                    $notifikasi->pesan = 'Pengajuan perizinan anda gagal mendapatkan persetujuan oleh ppk. Klik link di bawah ini untuk melihat info lebih lanjut.';
                    $notifikasi->is_dibaca = 'tidak_dibaca';
                    $notifikasi->send_email = 'yes';
                    $notifikasi->label = 'info';
                    $notifikasi->link = '/perizinan';
                    $notifikasi->id_users = $pengguna->id_users;
                    $notifikasi->save();

                    return redirect()->route('ajuanperizinan.index')->with('success_message', 'Data telah tersimpan');
                    
                } elseif($ajuanperizinan->status_izin_atasan === '1' && $ajuanperizinan->status_izin_ppk === null) {
                    $notifikasi = new Notifikasi();
                    $notifikasi->judul = 'Persetujuan Izin ';
                    $notifikasi->pesan = 'Pengajuan perizinan anda sudah berhasil disetujui oleh kadiv. Klik link di bawah ini untuk melihat info lebih lanjut.';
                    $notifikasi->is_dibaca = 'tidak_dibaca';
                    $notifikasi->send_email = 'yes';
                    $notifikasi->label = 'info';
                    $notifikasi->link = '/perizinan';
                    $notifikasi->id_users = $pengguna->id_users;
                    $notifikasi->save();

                    return redirect()->route('ajuanperizinan.index')->with('success_message', 'Data telah tersimpan');
                    
                } elseif ($ajuanperizinan->status_izin_atasan === PersetujuanIzin::Ditolak && $ajuanperizinan->status_izin_ppk === PersetujuanIzin::Ditolak) {
                    $notifikasi = new Notifikasi();
                    $notifikasi->judul = 'Persetujuan Izin ';
                    $notifikasi->pesan = 'Pengajuan perizinan anda gagal mendapatkan persetujuan. Klik link di bawah ini untuk melihat info lebih lanjut.';
                    $notifikasi->is_dibaca = 'tidak_dibaca';
                    $notifikasi->send_email = 'yes';
                    $notifikasi->label = 'info';
                    $notifikasi->link = '/perizinan';
                    $notifikasi->id_users = $pengguna->id_users;
                    $notifikasi->save();

                    return redirect()->route('ajuanperizinan.index')->with('success_message', 'Data telah tersimpan');
                }
            }
            // $pengguna = User::where('kode_finger', $request->kode_finger)->first();
        
            

        }

        return redirect()->route('ajuanperizinan.index')->with('success_message', 'Data telah tersimpan');

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