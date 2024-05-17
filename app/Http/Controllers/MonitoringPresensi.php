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
            }
        ])
        ->whereNotIn('id_users', [1,2,3,4,5]);

        return response()->json([
            'data' => $presensi_pegawai->get()
        ]);
    }
}
