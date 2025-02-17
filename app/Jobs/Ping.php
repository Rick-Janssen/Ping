<?php

namespace App\Jobs;

use App\Models\TempData;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class Ping implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    {
    }

    public function handle(): void
    {

        $pythonScriptPath = base_path('_PINGER/PING.py');
        shell_exec("python3 $pythonScriptPath");

        $oldRecords = TempData::all();

        foreach ($oldRecords as $oldRecord) {
            $newRecord = $oldRecord->replicate();
            $newRecord->setTable('pings');
            $newRecord->save();
            $oldRecord->delete();
        }
    }
}
