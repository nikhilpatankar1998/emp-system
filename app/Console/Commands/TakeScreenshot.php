<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache; // ✅ Add this

class TakeScreenshot extends Command
{
    protected $signature = 'screenshot:take {user_id}';

    protected $description = 'Take a screenshot and save to storage & database';

    public function handle()
    {
        $userId = (int) $this->argument('user_id');

        if (!$userId) {
            $this->error("No user ID provided!");
            Log::error("Screenshot failed: No user ID provided.");
            return;
        }

        $timestamp = date("Ymd_His");
        $scriptPath = base_path('app/scripts/screenshot.sh');
        $logPath = storage_path('logs/screenshot_exec_log.txt');

        $command = "bash \"$scriptPath\" > \"$logPath\" 2>&1";
        exec($command, $output, $resultCode);

        if ($resultCode === 0) {
            $filename = "screenshot_$timestamp.png";

            DB::table('screenshots')->insert([
                'filename' => $filename,
                'user_id' => $userId,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            Log::info("Screenshot taken successfully for user ID: $userId");
            $this->info("Screenshot taken successfully for user ID: $userId");
        } else {
            Log::error("Screenshot script failed with code $resultCode. Check logs in $logPath.");
            $this->error("Screenshot script failed. Check logs in $logPath.");
        }
    }
}
