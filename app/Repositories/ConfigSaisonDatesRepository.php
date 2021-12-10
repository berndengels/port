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
    protected $fromMonthDay;
    protected $untilMonthDay;

    public function __construct(
        protected ?Carbon $from = null,
        protected ?Carbon $until = null
    ) {
        $this->fromMonthDay     = $from->format('m').$from->format('d');
        $this->untilMonthDay    = $until->format('m').$until->format('d');
    }


    public function getGuestSaisons(string $byRelation): Collection|null
    {
        $data = ConfigSaisonDates::with($byRelation)
            ->where('key','=','guest')
            ->get()
            ->map(function (ConfigSaisonDates $saison) {
                if($saison->from_month > $saison->until_month) {
                    // p.e: 10 => 05
                    if($this->from->month <= $saison->until_month ) {
                        // p.e: 02 => 05
                        $fromYear = ($this->from->copy()->year - 1);
                        $from   = Carbon::create($fromYear . '-' . $saison->from_month . '-' . $saison->from_day);
                        $until  = Carbon::create($this->until->year . '-' . $saison->until_month . '-' . $saison->until_day);
                    }
                    else {
                        // p.e: 11 => 10
                        $untilYear = $this->until->copy()->year + 1;
                        $from   = Carbon::create($this->from->year . '-' . $saison->from_month . '-' . $saison->from_day);
                        $until  = Carbon::create($untilYear . '-' . $saison->until_month . '-' . $saison->until_day);
                    }
                } else {
                    // p.e: 06 => 09
                    $from   = Carbon::create($this->from->year . '-' . $saison->from_month . '-' . $saison->from_day);
                    $until  = Carbon::create($this->until->year . '-' . $saison->until_month . '-' . $saison->until_day);
                }

                return new SaisonDatesEntity(saison: $saison, from: $from, until: $until);
            })
        ;
        return $data;
    }

    public function getTouchedGuestSaisons(string $model, string $search): Collection|null
    {
        return $this->getGuestSaisons('dailyPrice')
            ->filter(function (SaisonDatesEntity $entiy) use ($model, $search) {

                $from = $this->from;
                $until = $this->until;

                $itemPeriod     = Period::make($from, $until);
                $saisonPeriod   = Period::make($entiy->getFrom(), $entiy->getUntil());
                $overlap        = $itemPeriod->overlap($saisonPeriod);

                if(!$overlap) {
//                    dd($itemPeriod->asString(), $saisonPeriod->asString());
                }
                else {
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
