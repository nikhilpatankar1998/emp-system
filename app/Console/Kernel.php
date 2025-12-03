<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
   /* protected function schedule(Schedule $schedule): void
    {
        Log::info("Scheduler running... Checking user ID");

        $userId = Cache::get('current_logged_in_user');

        if ($userId) {
            Log::info("User ID found in cache: " . $userId);

            /*$schedule->command('screenshot:take', [$userId])
                     ->everyMinute();*/
          /*$schedule->command('screenshot:take', [$userId])->everyMinute();
          Log::info("Running TakeScreenshot command for user: $userId");


        } else {
            Log::warning("No logged-in user found, skipping screenshot scheduling.");
        }
    }*/

    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
