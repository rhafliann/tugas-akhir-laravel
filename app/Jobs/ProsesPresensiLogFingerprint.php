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

class ProsesPresensiLogFingerprint implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    protected $nik;
    protected $hari_ini;
    protected $logFingerPrint;
    /**
     * Create a new job instance.
     */
    public function __construct($nik, $tanggal, $logFingerPrint)
    {
        //
        $this->nik = $nik;
        if($tanggal){
            $this->hari_ini = $tanggal;
        } else {
            $this->hari_ini = date('Y-m-d');
        }

        if($logFingerPrint){
            $this->logFingerPrint = $logFingerPrint;
        }
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
        // $hari_ini = date('Y-m-d');
        $hari_ini = $this->hari_ini;

        $jam10pagi = Carbon::parse($hari_ini)->hour(10)->minute(1)->setTimezone('Asia/Jakarta');

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

        $logFingerPrint = $this->logFingerPrint;

        $payload = [];

        if($logFingerPrint){

            $scanTime = Carbon::parse($logFingerPrint->scan_time)->setTimezone('Asia/Jakarta');
            $jamMasuk = Carbon::parse($hari_ini)->setTimeFromTimeString($waktuKerja->jam_masuk)->setTimezone('Asia/Jakarta');
            $jamPulang = Carbon::parse($hari_ini)->setTimeFromTimeString($waktuKerja->jam_pulang)->setTimezone('Asia/Jakarta');

            if($scanTime->greaterThan($jam10pagi))
            {
                $payload['scan_pulang'] = $scanTime->toTimeString();

                if($presensi->scan_masuk){
                    $kehadiran = Carbon::parse($hari_ini)
                        ->setTimeFromTimeString($presensi->scan_masuk)
                        ->diff($scanTime)->format('%H:%I:%S');
                        
                    $payload['kehadiran'] = $kehadiran;
                }
    
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
}
