<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $today;

    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
    //        RepairCaravanPriceData::class,
    //        RepairGuestBoatPriceData::class,
    //        ExportTableData::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('snapshot:create')->hourly();
        $schedule->command('snapshot:cleanup --keep=24')->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');
        include base_path('routes/console.php');
    }
}
