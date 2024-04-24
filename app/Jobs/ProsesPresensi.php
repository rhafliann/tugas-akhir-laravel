<?php

namespace App\Jobs;

use App\Models\LogFingerprint;
use App\Models\Presensi;
use App\Models\WaktuKerja;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProsesPresensi implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    protected $nik;
    /**
     * Create a new job instance.
     */
    public function __construct($nik)
    {
        //
        $this->nik = $nik;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
        $hari_ini = date('Y-m-d');
        $jam10pagi = Carbon::parse($hari_ini)->hour(10)->minute(1);

        $waktuKerja = WaktuKerja::where(['nama_waktu' => 'waktu-normal'])->first();
        
        $presensiPayload = [
            'jam_masuk' => $waktuKerja->jam_masuk,
            'jam_pulang' => $waktuKerja->jam_pulang,
            'tanggal' => $hari_ini,
            'nik' => $this->nik
        ];

        $presensi = Presensi::where($presensiPayload)->first();

        if(!$presensi) {
            $presensi = Presensi::create($presensiPayload);
        }

        $logFingerPrint = LogFingerprint::where('nik', $this->nik)
        ->whereDate('scan_time', $hari_ini)
        ->orderBy('scan_time', 'desc')
        ->first();

        $payload = [];

        $scanTime = Carbon::parse($logFingerPrint->scan_time);
        $jamMasuk = Carbon::now()->setTimeFromTimeString($waktuKerja->jam_masuk);
        $jamPulang = Carbon::now()->setTimeFromTimeString($waktuKerja->jam_pulang);

        if($scanTime->greaterThan($jam10pagi))
        {
            $payload['scan_pulang'] = $scanTime->toTimeString();
            $payload['kehadiran'] =  Carbon::parse($presensi->scan_masuk)->diff($scanTime)->format('%H:%I:%S');

            if($scanTime->lessThan($jamPulang)){
                $payload['pulang_cepat'] = $jamPulang->diff($scanTime)->format('%H:%I:%S');
            }
        } else {
            $payload['scan_masuk'] = $scanTime->toTimeString();

            if($scanTime->greaterThan($jamMasuk)){
                $payload['terlambat'] = $scanTime->diff($jamMasuk)->format('%H:%I:%S');
            }
        }

        $presensi->update($payload);
    }
}
