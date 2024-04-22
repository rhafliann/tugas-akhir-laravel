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

        $jamMasuk = WaktuKerja::where(['nama_waktu' => 'waktu-normal'])->first();
        
        $presensiPayload = [
            'jam_masuk' => $jamMasuk->jam_masuk,
            'jam_pulang' => $jamMasuk->jam_pulang,
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

        if(Carbon::createFromTimestamp($logFingerPrint->scan_time) >= $jam10pagi)
        {
            $payload['scan_pulang'] = $logFingerPrint->scan_time;
        } else {
            $payload['scan_masuk'] = $logFingerPrint->scan_time;
        }

        $presensi->update($payload);
    }
}
