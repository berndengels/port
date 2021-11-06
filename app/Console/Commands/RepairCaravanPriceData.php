<?php
namespace App\Console\Commands;

use App\Libs\Sanitizers\CaravanSanitizer;
use App\Models\CaravanDates;
use Spatie\Emoji\Emoji;

class RepairCaravanPriceData extends RepairPriceData
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'repair:caravan-prices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Repair price data for caravans';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->sanitizer = new CaravanSanitizer();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->data = CaravanDates::all();
        if ($this->confirm('Do you wish to continue?', true)) {
            if($this->data && $this->data->count() > 0) {
                $this->withProgressBar(
                    $this->data, function ($item) {
                        $this->sanitizer->sanitize($item);
                    }
                );
                $this->newLine();
                $this->info(' OK ' . Emoji::okHand());
                return 0;
            } else {
                $this->info(Emoji::CHARACTER_ALARM_CLOCK . ' no caravan data to sanitize');
                return 1;
            }
        }
        return 0;
    }
}
