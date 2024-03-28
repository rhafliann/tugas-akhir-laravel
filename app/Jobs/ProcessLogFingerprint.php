<?php

namespace App\Jobs;

use App\Models\Presensi;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessLogFingerprint implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Presensi $presensi,
    )
    {
        //
        
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
        $presensi = $this->presensi->where();
    }
}
