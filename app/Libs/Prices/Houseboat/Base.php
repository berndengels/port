<?php
namespace App\Libs\Prices\Houseboat;

use App\Models\ConfigSaisonRentDates;
use App\Models\HouseboatModel;
use DatePeriod;
use Carbon\Carbon;
use App\Models\Houseboat;
use App\Libs\Prices\Price;
use App\Libs\Prices\IDailyPrice;
use Spatie\Period\Period;

class Base extends Main implements IDailyPrice
{
    public static $dailyPrices;

    public function __construct(
        protected Carbon|null $from = null,
        protected Carbon|null $until = null,
        protected Houseboat $houseboat,
    ) {
        $this->initConfig();
    }

    public function addPrice(?DatePeriod $days = null): Price
    {
        /**
         * @var HouseboatModel $model
         */
        $model = $this->houseboat->model;
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
            foreach ($configSaisonRentDates as $d) {
                if($d->period->contains(Carbon::make($day))) {
                    $fDay = Carbon::make($day)
                        ->locale($locale)
                        ->translatedFormat('D d.m.Y')
                    ;
                    $saison = $d->saison;
                    if('peak' === $saison->key) {
                        static::$dailyPrices[$day] = [
                            'date'      => $fDay,
                            'saison'    => $saison->name,
                            'holiday'   => $d->holiday ?? '',
                            'price'     => $model->peak_season_price,
                        ];
                        continue 2;
                    }
                    elseif('mid' === $saison->key) {
                        static::$dailyPrices[$day] = [
                            'date'      => $fDay,
                            'saison'    => $saison->name,
                            'holiday'   => $d->holiday,
                            'price'     => $model->mid_season_price,
                        ];
                        continue 2;
                    }
                    elseif('low' === $saison->key) {
                        static::$dailyPrices[$day] = [
                            'date'      => $fDay,
                            'saison'    => $saison->name,
                            'holiday'   => $d->holiday,
                            'price'     => $model->low_season_price,
                        ];
                        continue 2;
                    } else {
                        static::$dailyPrices[$day] = [
                            'date'      => $fDay,
                            'saison'    => $saison->name,
                            'holiday'   => $d->holiday,
                            'price'     => 0,
                        ];
                        continue 2;
                    }
                }
            }
        }

        return new Price(collect(static::$dailyPrices)->sum('price'));
    }
}
