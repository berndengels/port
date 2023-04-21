<?php
namespace App\Console\Commands;

use App\Models\BoatDates;
use Spatie\Emoji\Emoji;
use App\Libs\Sanitizers\BoatSanitizer;

class RepairBoatPriceData extends RepairPriceData
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'repair:boat-prices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Repair price data for boats';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->sanitizer = new BoatSanitizer();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if ($this->confirm('Do you wish to continue?', true)) {
            $this->data = BoatDates::all();
            if($this->data && $this->data->count() > 0) {
                $this->withProgressBar(
                    $this->data, function ($item) {
                        $this->sanitizer->sanitize($item);
                    }
                );
                echo Emoji::okHand();
                return 0;
            } else {
                $this->info(Emoji::CHARACTER_ALARM_CLOCK . ' no boat data to sanitize');
                return 1;
            }
        }
        return 0;
    }
}
