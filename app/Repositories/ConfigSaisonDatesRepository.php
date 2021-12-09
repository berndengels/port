<?php
namespace App\Repositories;

use App\Entities\SaisonDatesEntity;
use App\Libs\AppCache;
use App\Models\BoatDates;
use App\Models\CaravanDates;
use App\Models\ConfigDailyPrice;
use App\Models\ConfigSaisonDates;
use App\Repositories\Ext\SelectOptions;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Spatie\Period\Period;
use Spatie\Period\PeriodCollection;
use Spatie\Period\Visualizer;
use Illuminate\Database\Eloquent\Builder;

class ConfigSaisonDatesRepository extends Repository
{
    use SelectOptions;

    protected static $model = ConfigSaisonDates::class;
    protected static $cacheKeyOptions = AppCache::KEY_OPTIONS_SAISON_DATES;
    protected static $cacheKeyOptionsData = AppCache::KEY_OPTIONS_DATA_SAISON_DATES;
    protected static $counter = 0;

    public function getSaisons(Carbon $from, Carbon $until, $byRelation) {
        $data = ConfigSaisonDates::with($byRelation)
            ->whereKey('guest')
            ->get()
            ->map(function (ConfigSaisonDates $saison) use ($from, $until) {
//                $untilYear = ($saison->from_month > $saison->until_month) ? $until->year + 1 : $until->year;
                $fromYear = ($saison->from_month > $saison->until_month) ? $until->year - 1 : $until->year;
                $from   = Carbon::create($fromYear . '-' . $saison->from_month . '-' . $saison->from_day);
                $until  = Carbon::create($until->format('Y') . '-' . $saison->until_month . '-' . $saison->until_day);

                return new SaisonDatesEntity(saison: $saison, from: $from, until: $until);
            })
        ;
        return $data;
    }

    public function getTouchedSaisons(Carbon $from, Carbon $until, $model, $search): Collection|null {
        return $this->getSaisons($from, $until, 'dailyPrice')
            ->filter(function (SaisonDatesEntity $entiy) use ($from, $until, $model, $search) {
                $itemPeriod     = Period::make($from, $until, format: 'md');
                $saisonPeriod   = Period::make($entiy->getFrom(), $entiy->getUntil(), format: 'md');
                $overlap        = $itemPeriod->overlap($saisonPeriod);

                if($overlap) {
//                    dump(static::$counter++ ,$itemPeriod->asString(), $saisonPeriod->asString());

                    $entiy->setPeriod($overlap);
                    $dailyPrice = $entiy->dailyPrice()->whereModel($model)
                        ->where(function (Builder $query) use ($search) {
                            return $query
                                ->where('from_unit','>=', $search)
                                ->where('until_unit','<=', $search)
                                ->orWhereNull('from_unit')
                                ->where('until_unit','<=', $search)
                                ->orWhereNull('until_unit')
                                ->where('from_unit','>=', $search)
                                ->orWhereNull('from_unit')
                                ->whereNull('until_unit')
                            ;
                        })
                        ->first()
                    ;

                    if(!$dailyPrice) {
                        return null;
                    }

                    switch($dailyPrice->price_type_id) {
                        // length
                        case 1:
                            $sumPrice = ($dailyPrice->from_unit && $dailyPrice->until_unit)
                                ? $dailyPrice->price * $overlap->length()
                                : $dailyPrice->price * $search * $overlap->length();
                            $dayPrice = ($dailyPrice->from_unit && $dailyPrice->until_unit)
                                ? $dailyPrice->price
                                : $dailyPrice->price * $search;
                            break;
                        // absolute
                        case 6:
                        default:
                            $sumPrice = $dailyPrice->price * $overlap->length();
                            $dayPrice = $dailyPrice->price;
                    }

                    $entiy->setPrice($sumPrice);

                    foreach($overlap as $index => $date) {
                        if($index > 0) {
                            $entiy->addDailyPrices($date, $dayPrice);
                        }
                    }

                    return $entiy;
                }
                return null;
            });
    }
}
