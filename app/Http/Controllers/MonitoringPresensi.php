<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MonitoringPresensi extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $presensi_pegawai = User::with([
            'profile:nik,id_users,id_jabatan,photo',            
            'profile.presensi' => function($query){
                $hari_ini = Carbon::now()->format('Y-m-d');
                $query->whereDate('tanggal', $hari_ini);
                // $query->sortBy('scan_time', 'desc');
            }
        ])
        ->whereNotIn('id_users', [1,2,3,4,5]);

        $presensi_pegawai = $presensi_pegawai->get();
        $presensi_pegawai = $presensi_pegawai->map(function($item){
            $item['presensi'] = isset($item->profile->presensi[0]) ? $item->profile->presensi[0] : null;
            unset($item['level']);
            unset($item['is_deleted']);
            unset($item['profile']);
            unset($item['id_jabatan']);
            unset($item['id_users']);
            return $item;
        });

        $presensi_pegawai = $presensi_pegawai->sortBy(function($item){
            if($item->presensi){
                return $item->presensi->scan_masuk;
            }
        })->values();
        // $presensi_pegawai = $presensi_pegawai->sort(function($item, $b){
        //     if( isset($item->presensi) && isset($b->presensi)){
        //         resturn (strtotime($item->presensi->scan_masuk) > strtotime($b->presensi->scan_masuk)) ? 1 : -1;
        //     }
        // });
        return response()->json([   
            'data' => $presensi_pegawai
        ]);
    }
}
