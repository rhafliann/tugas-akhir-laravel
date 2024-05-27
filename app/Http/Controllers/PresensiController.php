<?php

namespace App\Http\Controllers;

use App\Exports\PresensiExportFilter;
use App\Imports\PresensiImport;
use App\Models\Presensi;
use App\Models\User;
use App\Models\WaktuKerja;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class PresensiController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $tanggalAwal = $request->input('tanggal_awal');
        $tanggalAkhir = $request->input('tanggal_akhir');
        $tanggal = $request->input('tanggal');
        $id_users = $request->input('id_users');

        $payloadWaktuKerja = [];

        if(Carbon::now()->isDayOfWeek(CarbonInterface::FRIDAY)){
            $payloadWaktuKerja['nama_waktu'] = 'waktu-jumat';
        } else {
            $payloadWaktuKerja['nama_waktu'] = 'waktu-normal';
        }

        $waktuKerja = WaktuKerja::where($payloadWaktuKerja)->first();

        if ($user->level == 'admin') {
            // Fetch all work experiences for admin
            $presensi = Presensi::where('is_deleted', '0')
                ->whereHas('profile_user')
                ->with(['profile_user:nik,id_users', 'profile_user.user:id_users,nama_pegawai']);
        } else {
            // Fetch user's own work experiences using the relationship
            $presensi = Presensi::where(['nik' => $user->profile->nik])
                ->with(['profile_user:nik,id_users', 'profile_user.user:id_users,nama_pegawai']);
        }
        
        if($id_users){
            $user = User::where(['id_users' => $id_users])->first();
            $presensi->where(['nik' => $user->profile->nik]);
        }

        if(!$tanggalAwal && !$tanggalAkhir){
            $presensi
            ->whereMonth('tanggal', '=', date('m'))
            ->whereYear('tanggal', '=', date('Y'));
        }

        if($tanggal){
            $presensi->whereDate('tanggal', $tanggal);
        }

        if($tanggalAwal && $tanggalAkhir){
            $presensi->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir]);
        }

        $presensi->orderBy('tanggal', 'desc');
        
        $users = User::where('is_deleted', '0');

        if($request->isJson()){
            return response()->json([
                'type' => 'success',
                'data' => $presensi->get()
            ]);
        }
                
        return view('presensi.index', [
            'presensi' => $presensi->get(),
            'users' => $users->get(),
            'waktuKerja' => $waktuKerja
        ]);
    }

    public function create()
    {
        //
        $hari_ini = date('Y-m-d');;
        $jam10pagi = Carbon::parse($hari_ini)->hour(10)->minute(1)->toDateTimeString();

        $now = Carbon::now()->setTimezone('Asia/Jakarta');

        dd($now->greaterThan($jam10pagi), $now ,$jam10pagi);

        // $scanTime = Carbon::parse($logFingerPrint->scan_time);
        // $jamMasuk = Carbon::now()->setTimeFromTimeString($waktuKerja->jam_masuk);
        // $jamPulang = Carbon::now()->setTimeFromTimeString($waktuKerja->jam_pulang);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Presensi $presensi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Presensi $presensi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Presensi $presensi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Presensi $presensi)
    {
        //
    }


    // filter data for export
    public function filterDataAdmin(Request $request)
    {

        $users = User::where('is_deleted', '0')->get();

        $presensis = [];

        $defaultStartDate =  date('Y').'-01-01';
        $defaultEndDate = date('Y-m-d');

        $start_date = $request->input('start_date', $defaultStartDate);
        $end_date = $request->input('end_date', $defaultEndDate);

        $users = User::where('is_deleted', '0')
        ->whereNotIn('id_users', [1,2,3,4,5])
        ->with([
            'profile', 
            'profile.presensi' => function($query) use ($start_date, $end_date) {
                $query->whereBetween('tanggal', [ Carbon::parse($start_date)->format('Y-m-d'), Carbon::parse($end_date)->format('Y-m-d')]);
            }
        ])->get();

        $presensis = [];
    
        foreach($users as $key => $user)
        {
            $kehadiran = 0;
            $terlambat = 0;
            $ijin = 0;
            $sakit = 0;
            $cutiSakit = 0;
            $cutiTahunan = 0;
            $cutiMelahirkan = 0;
            $dinasLuar = 0;
            $alpha = 0;
            $cutiBersama = 0;
            $cutiHaji = 0;
            $tugasBelajar = 0;
            $cap = 0;
            $prajab = 0;
            // dd($user->nama_pegawai, $user->profile->presensi);

            if(isset($user->profile->presensi)){
                foreach($user->profile->presensi as $p => $presensi){
    
                    if ($presensi->kehadiran !== null && $presensi->kehadiran !== '00:00:00') {
                        $kehadiran++;
                    }
                    
                    switch ($presensi->jenis_perizinan) {
                        case 'I':
                            $ijin++;
                            break;
                        case 'S':
                            $sakit++;
                            break;
                        case 'CS':
                            $cutiSakit++;
                            break;
                        case 'CT':
                            $cutiTahunan++;
                            break;
                        case 'CM':
                            $cutiMelahirkan++;
                            break;
                        case 'DL':
                            $dinasLuar++;
                            break;
                        case 'A':
                            $alpha++;
                            break;
                        case 'CB':
                            $cutiBersama++;
                            break;
                        case 'CH':
                            $cutiHaji++;
                            break;
                        case 'TB':
                            $tugasBelajar++;
                            break;
                        case 'CAP':
                            $cap++;
                            break;
                        case 'Prajab':
                            $prajab++;
                            break;
                        default:
                            // Handle any other case not covered above, if necessary.
                            break;
                    }
    
                    if (isset($presensi->terlambat)) {
                        if ($presensi->kehadiran) {
                            $time = explode(':', $presensi->terlambat);
                            if ($time[0] > 0) {
                                $terlambat++;
                            } elseif ($time[1] > 0) {
                                $terlambat++;
                            } elseif ($time[2] > 0) {
                                $terlambat++;
                            }
                        }
                    }
                }

                $presensis[] = [
                    'user' => $user->nama_pegawai,
                    'kehadiran' => $kehadiran,
                    'terlambat' => $terlambat,
                    'ijin' => $ijin,
                    'sakit' => $sakit,
                    'cutiSakit' => $cutiSakit,
                    'cutiTahunan' => $cutiTahunan,
                    'cutiMelahirkan' => $cutiMelahirkan,
                    'dinasLuar' => $dinasLuar,
                    'alpha' => $alpha,
                    'cutiBersama' => $cutiBersama,
                    'cutiHaji' => $cutiHaji,
                    'tugasBelajar' => $tugasBelajar,
                    'cap' => $cap,
                    'prajab' => $prajab,
                ];
            }
        }

        $presensis['start_date'] = $start_date;
        $presensis['end_date'] = $end_date;

        return Excel::download(new PresensiExportFilter($presensis), 'presensi.xlsx');
    }

    public function filterAdmin(Request $request)
    {
        $defaultStartDate =  date('Y').'-01-01';
        $defaultEndDate = date('Y-m-d');

        $start_date = $request->input('start_date', $defaultStartDate);
        $end_date = $request->input('end_date', $defaultEndDate);

        $users = User::where('is_deleted', '0')
        ->whereNotIn('id_users', [1,2,3,4,5])
        ->with([
            'profile', 
            'profile.presensi' => function($query) use ($start_date, $end_date) {
                $query->whereBetween('tanggal', [ Carbon::parse($start_date)->format('Y-m-d'), Carbon::parse($end_date)->format('Y-m-d')]);
            }
        ])->get();

        $presensis = [];
    
        foreach($users as $key => $user)
        {
            $kehadiran = 0;
            $terlambat = 0;
            $totalWaktuTerlambat = 0;
            $ijin = 0;
            $sakit = 0;
            $cutiSakit = 0;
            $cutiTahunan = 0;
            $cutiMelahirkan = 0;
            $dinasLuar = 0;
            $alpha = 0;
            $cutiBersama = 0;
            $cutiHaji = 0;
            $tugasBelajar = 0;
            $cap = 0;
            $prajab = 0;
            $array_waktu_terlambat = [];
            // dd($user->nama_pegawai, $user->profile->presensi);

            if(isset($user->profile->presensi)){
                foreach($user->profile->presensi as $p => $presensi){
    
                    if ($presensi->kehadiran !== null && $presensi->kehadiran !== '00:00:00') {
                        $kehadiran++;
                    }
                    
                    switch ($presensi->jenis_perizinan) {
                        case 'I':
                            $ijin++;
                            break;
                        case 'S':
                            $sakit++;
                            break;
                        case 'CS':
                            $cutiSakit++;
                            break;
                        case 'CT':
                            $cutiTahunan++;
                            break;
                        case 'CM':
                            $cutiMelahirkan++;
                            break;
                        case 'DL':
                            $dinasLuar++;
                            break;
                        case 'A':
                            $alpha++;
                            break;
                        case 'CB':
                            $cutiBersama++;
                            break;
                        case 'CH':
                            $cutiHaji++;
                            break;
                        case 'TB':
                            $tugasBelajar++;
                            break;
                        case 'CAP':
                            $cap++;
                            break;
                        case 'Prajab':
                            $prajab++;
                            break;
                        default:
                            // Handle any other case not covered above, if necessary.
                            break;
                    }
    
                    if (isset($presensi->terlambat)) {
                        if ($presensi->kehadiran) {
                            if($presensi->terlambat){
                                array_push($array_waktu_terlambat, $presensi->terlambat);
                            }

                            $time = explode(':', $presensi->terlambat);
                            if ($time[0] > 0) {
                                $terlambat++;
                            } elseif ($time[1] > 0) {
                                $terlambat++;
                            } elseif ($time[2] > 0) {
                                $terlambat++;
                            }
                        }
                    }
                }

                $presensis[] = [
                    'user' => $user->nama_pegawai,
                    'kehadiran' => $kehadiran,
                    'total_waktu_terlambat' => $this->CalculateTime($array_waktu_terlambat),
                    'terlambat' => $terlambat,
                    'ijin' => $ijin,
                    'sakit' => $sakit,
                    'cutiSakit' => $cutiSakit,
                    'cutiTahunan' => $cutiTahunan,
                    'cutiMelahirkan' => $cutiMelahirkan,
                    'dinasLuar' => $dinasLuar,
                    'alpha' => $alpha,
                    'cutiBersama' => $cutiBersama,
                    'cutiHaji' => $cutiHaji,
                    'tugasBelajar' => $tugasBelajar,
                    'cap' => $cap,
                    'prajab' => $prajab,
                ];
            }
        }

        return view('presensi.filter', [
            'presensis' => $presensis,
        ]);

    }

    function CalculateTime($times){    
        $hh = 0;
        $mm = 0;
        $ss = 0;
        foreach($times as $time){
            [$hours, $minutes, $seconds] = explode(':', $time);
            $hh += $hours;
            $mm += $minutes;
            $ss += $seconds;
        }
        $mm += floor($ss / 60); $ss = $ss % 60;
        $hh += floor($mm / 60); $mm = $mm % 60;
        return sprintf('%02d:%02d:%02d', $hh, $mm, $ss);
    }

    public function import(Request $request)
    {
        
        Excel::import(new PresensiImport, $request->file('file')->store('presensi'));

        return redirect()->back()->with([
            'success_message' => 'Data telah Tersimpan',
        ]);
    }

}