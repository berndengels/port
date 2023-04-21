<?php
namespace App\Repositories;

use App\Entities\SaisonDatesEntity;
use App\Libs\AppCache;
use App\Models\ConfigBoatPrice;
use App\Models\ConfigDailyPrice;
use App\Models\ConfigSaisonDates;
use App\Repositories\Ext\SelectOptions;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Spatie\Period\Period;

class ConfigBoatPricesRepository extends Repository
{
    use SelectOptions;

    protected static $model = ConfigBoatPrice::class;
    protected static $cacheKeyOptions = AppCache::KEY_OPTIONS_CONFIG_BOAT_PRICE;
    protected static $cacheKeyOptionsData = AppCache::KEY_OPTIONS_DATA_CONFIG_BOAT_PRICE;

    public function getSaisons(Carbon $from, Carbon $until) {
        $data = ConfigSaisonDates::with('boatPrice')->get()
            ->map(function (ConfigSaisonDates $saison) use ($from, $until) {
                $untilYear = ($saison->from_month > $saison->until_month) ? $until->year + 1 : $until->year;
                $from   = Carbon::create($from->format('Y') . '-' . $saison->from_month . '-' . $saison->from_day);
                $until  = Carbon::create($untilYear . '-' . $saison->until_month . '-' . $saison->until_day);
                return new SaisonDatesEntity(saison: $saison, from: $from, until: $until);
            })
        ;
        dd($data->toArray());
        return $data;
    }

    public function getTouchedSaisons(Carbon $from, Carbon $until, $model, $search): Collection {
        return $this->getSaisons($from, $until)
            ->filter(function (SaisonDatesEntity $entiy) use ($from, $until, $model, $search) {
                $itemPeriod = Period::make($from, $until);
                $saisonPeriod = Period::make($entiy->getFrom(), $entiy->getUntil());
                $overlap = $itemPeriod->overlap($saisonPeriod);
                if($overlap) {
                    $entiy->setPeriod($overlap);
                    $boatPrice = $entiy->boatPrice()->whereSaisonDateId($entiy->getSaisonId())
                        ->first()
                    ;
                    dd($entiy->boatPrice()->get());
                    switch($boatPrice->price_type_id) {
                        // area
                        case 5:
                        default:
                            $sumPrice = $boatPrice->price_factor * $overlap->length();
                            $dayPrice = $boatPrice->price_factor;
                    }

                    $entiy->setPrice($sumPrice);

                    foreach($overlap as $date) {
                        $entiy->addDailyPrices($date, $dayPrice);
                    }

                    return $entiy;
                }
            });
    }
}
