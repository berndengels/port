<?php
namespace App\Console\Commands;

use App\Libs\Sanitizers\GuestBoatSanitizer;
use App\Models\GuestBoat;
use App\Models\GuestBoatDates;
use Spatie\Emoji\Emoji;

class RepairGuestBoatPriceData extends RepairPriceData
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'repair:guest-boat-prices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Repair price data for guest-boats';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->sanitizer = new GuestBoatSanitizer();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if ($this->confirm('Do you wish to continue?', true)) {
            $this->data = GuestBoatDates::all();
            if($this->data && $this->data->count() > 0) {
                $this->withProgressBar(
                    $this->data, function ($item) {
                        $this->sanitizer->sanitize($item);
                    }
                );
                echo Emoji::okHand();
                return 0;
            } else {
                $this->info(Emoji::CHARACTER_ALARM_CLOCK . ' no guest boat data to sanitize');
                return 1;
            }
        }
        return 0;
    }
}
