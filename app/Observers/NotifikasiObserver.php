<?php

namespace App\Observers;

use App\Mail\NotifikasiMail;
use App\Models\Notifikasi;
use App\Models\User;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class NotifikasiObserver
{
    /**
     * Handle the Notifikasi "created" event.
     */
    public function created(Notifikasi $notifikasi): void
    {
        if ($notifikasi->send_email == 'yes') {
            $count = 0;
            try {
                Mail::to($notifikasi->user)->send(new NotifikasiMail($notifikasi));
            } catch (\Throwable $th) {
                Log::error($th);
                $notifikasiAdmin = User::where('level', 'admin')->get();
                $count = $count + 1;
                
                if ($count <= 3) {
                    foreach($notifikasiAdmin as $na){
                        DB::table('notifikasi')->insert([
                            'judul' => 'Error Mengirim Email',
                            'pesan' => 'Terjadi Error ketika mengirim email. '.$count.' '. $th->getMessage(), // Sesuaikan pesan notifikasi sesuai kebutuhan Anda.
                            'is_dibaca' => 'tidak_dibaca',
                            'label' => 'error',
                            'link' => '/email-configuration',
                            'id_users' => $na->id_users,
                            'created_at' => Date::now(),
                            'updated_at' => Date::now()
                        ]);
                    }
                }
            }
        }
    }

    /**
     * Handle the Notifikasi "updated" event.
     */
    public function updated(Notifikasi $notifikasi): void
    {
        //
    }

    /**
     * Handle the Notifikasi "deleted" event.
     */
    public function deleted(Notifikasi $notifikasi): void
    {
        //
    }

    /**
     * Handle the Notifikasi "restored" event.
     */
    public function restored(Notifikasi $notifikasi): void
    {
        //
    }

    /**
     * Handle the Notifikasi "force deleted" event.
     */
    public function forceDeleted(Notifikasi $notifikasi): void
    {
        //
    }
}
