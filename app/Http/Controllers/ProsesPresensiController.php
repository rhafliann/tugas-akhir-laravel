<?php

namespace App\Http\Controllers;

use App\Jobs\ProsesPresensi;
use App\Models\LogFingerprint;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ProsesPresensiController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $hari_ini =  Carbon::now()->format('Y-m-d');
        $start_date = $request->input('start_date') ?? $hari_ini;
    
        $cloud_id = "C2630450C3051F24";
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer NOLQ4U14G2EWG5W3'
        ])
        ->post('https://developer.fingerspot.io/api/get_attlog', [
            'trans_id' => 1,
            'cloud_id' => $cloud_id,
            "start_date" => $start_date,
            "end_date" => $start_date
        ]);

        // $log_fingerprints = [];
    
        if ($response->failed()) {
            echo "Failed \n";
            Log::error('request failed with' . json_encode($response->json(), JSON_PRETTY_PRINT));
        } else {
    
            $json = (object) $response->json();

            if($json->success == false){
                return response()->json($json, 400);
            }

            Log::info('request success with' . json_encode($json, JSON_PRETTY_PRINT));
        
            if (isset($json->data)) { // mengecek apakah data dapat diakses
                foreach ($json->data as $item) {
                    try {
    
                        $log_fingerprint = [
                            "cloud_id" => $cloud_id,
                            "nik" => $item['pin'],
                            "type" => $item['verify'],
                            "scan_time" => $item['scan_date'],
                            "original_data" => json_encode($item)
                        ];
                        // $inserted = LogFingerprint::create($log_fingerprint);
                        LogFingerprint::create($log_fingerprint);
                        // mengecek apakah data berhasil di masukan
                        // if ($inserted) {
                        //     // data yang berhasil di masukan akan di gunakan kembali
                        //     // array_push($log_fingerprints, (object) $log_fingerprint);
                        // }

                    } catch (\Throwable $th) {
                        //throw $th;
                        continue;
                    }
                }
            }
        }

        $log_fingerprints = LogFingerprint::whereDate('scan_time', $start_date)->get();

        foreach ($log_fingerprints as $key => $value) {
            dispatch(new ProsesPresensi($value->nik, Carbon::parse($value->scan_time)->format('Y-m-d')));
        }

        return response()->json([
            'message' => 'Processing Presensi',
            'data' => [
                'process_count' => count($log_fingerprints) 
            ]
        ]);
            
    }
}
