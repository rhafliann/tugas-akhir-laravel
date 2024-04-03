<?php

namespace App\Console\Commands;

use App\Models\LogFingerprint;
use App\Models\Presensi;
// use App\Models\Profile;
// use App\Models\User;
use Illuminate\Console\Command;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

use Carbon\Carbon;

class ProcessFingerprint extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:process-fingerprint';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $hari_ini = Carbon::now()->format('Y-m-d');
        // $hari_ini = "2024-03-20";
        // $jam10pagi = Carbon::now()->hour(10)->minute(1);
        $jam10pagi = Carbon::parse($hari_ini)->hour(10)->minute(1);

        $cloud_id = "C2630450C3051F24";
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer NOLQ4U14G2EWG5W3'
        ])
        ->post('https://developer.fingerspot.io/api/get_attlog', [
            'trans_id' => 1, 
            'cloud_id' => $cloud_id,
            "start_date" => $hari_ini,
            "end_date" => $hari_ini
        ]);

        $log_fingerprints = [];
        
        if ($response->failed()) {
            echo "Failed \n";
            Log::error('request failed with' . json_encode($response->json(), JSON_PRETTY_PRINT));
        } else {
            echo "Success \n";  
            $json = (object) $response->json();
            // Log::info('request success with' . json_encode($json, JSON_PRETTY_PRINT));

            if(isset($json->data)){ // mengecek apakah data dapat diakses
                foreach($json->data as $item){

                    $log_fingerprint = [
                        "cloud_id"   => $cloud_id,
                        "nik"        => $item['pin'],
                        "type"       => $item['verify'],
                        "scan_time"  => $item['scan_date'],
                        "original_data" => json_encode($item)
                    ];

                    // melakukan try catch untuk menghandle ketika data yang dimasukan merupakan duplikat
                    try {
                        $inserted = LogFingerprint::create($log_fingerprint);
                        // mengecek apakah data berhasil di masukan
                        if($inserted) { 
                            // data yang berhasil di masukan akan di gunakan kembali
                            array_push($log_fingerprints, (object) $log_fingerprint); 
                        }
                    } catch (\Throwable $e) {
                        // ketika data merupakan duplikat laravel akan melempar sebuah error
                        // namun akan di abaikan dan program akan terus berlanjut
                        continue; 
                    }
                }
            }
        }

        Log::info('log_fingerprints ' . json_encode($log_fingerprints, JSON_PRETTY_PRINT));

        foreach ($log_fingerprints as $item) {
            $payload = [];
            $where   = ['nik' => $item->nik, 'tanggal'=> $hari_ini];

            if ($item->scan_time <= $jam10pagi) {
                $payload['scan_masuk'] = $item->scan_time;
            } else {
                $payload['scan_pulang'] = $item->scan_time;
            }

            Presensi::where($where)->update($payload);
        }
    }
}
