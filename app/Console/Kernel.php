<?php

namespace App\Console;

use App\Jobs\SynchronizeInstagramPosts;
use App\Models\SocialMediaAccount;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->job(new SynchronizeInstagramPosts(SocialMediaAccount::with('socialMedia')
            ->whereNotNull('profile_id')
            ->whereNotNull('access_token')
            ->where('social_media_id', '=', 1)
            ->get()
        ))->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
