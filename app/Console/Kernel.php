<?php

namespace App\Console;

use App\Console\Commands\RepairBoatPriceData;
use App\Console\Commands\ExportTableData;
use App\Console\Commands\RepairCaravanPriceData;
use App\Console\Commands\RepairGuestBoatPriceData;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
//use Spatie\TimeWeatherTile\Commands\FetchOpenWeatherMapDataCommand;
//use Spatie\TimeWeatherTile\Commands\FetchBuienradarForecastsCommand;

class Kernel extends ConsoleKernel
{
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
     * @param Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
//        $schedule->command(FetchOpenWeatherMapDataCommand::class)->everyMinute();
//        $schedule->command(FetchBuienradarForecastsCommand::class)->everyMinute();
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
