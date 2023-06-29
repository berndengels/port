<?php
namespace App\Libs\Prices\Rentals;

use DatePeriod;
use Carbon\Carbon;
use App\Libs\Prices\Price;
use App\Libs\Prices\IDailyPrice;
use App\Models\ConfigSaisonRentDates;
use Illuminate\Database\Eloquent\Model;

class Base extends Main implements IDailyPrice
{
    public static $dailyPrices;

    public function __construct(
        protected Carbon|null $from = null,
        protected Carbon|null $until = null,
	    protected Model $rentable
    ) {
        $this->model = get_class($this->rentable);
        parent::__construct();
        $this->initConfg();
    }

    public function addPrice(?DatePeriod $days = null): Price
    {
        /**
         * @var rentable model $model
         */
        $model = $this->rentable->model;
        $days = collect($days)->map(fn($d) => $d->format('Y-m-d'))->toArray();
        sort($days);

        $configSaisonRentDates = ConfigSaisonRentDates::with('saison')->get();
        static::$dailyPrices = [];
        $locale = app()->getLocale();
        Carbon::setLocale($locale);

        /**
         * @var ConfigSaisonRentDates $d
         */
        foreach ($days as $day) {
            $fDay = Carbon::make($day)
                ->locale($locale)
                ->translatedFormat('D d.m.Y')
            ;
            foreach ($configSaisonRentDates as $d) {
                $contains = $d->period->contains(Carbon::make($day));
                if($contains) {
                    $saison = $d->saison;
                    static::$dailyPrices[$day] = [
                        'date'      => $fDay,
                        'saison'    => $saison->name,
                        'holiday'   => $d->holiday,
                    ];
                    switch ($saison->key) {
                        case 'peak':
                            static::$dailyPrices[$day] += [
                                'price' => $model->peak_season_price,
                            ];
                            break;
                        case 'mid':
                            static::$dailyPrices[$day] += [
                                'price' => $model->mid_season_price,
                            ];
                            break;
                        case 'low':
                            static::$dailyPrices[$day] += [
                                'price' => $model->low_season_price,
                            ];
                            break;
                    }
                    continue 1;
                }
            }
        }

        return new Price(collect(static::$dailyPrices)->sum('price'));
    }
}
