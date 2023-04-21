<?php
namespace App\Repositories;

use Carbon\Carbon;
use Spatie\Period\Period;
use App\Libs\AppCache;
use App\Entities\SaisonDatesEntity;
use App\Models\ConfigSaisonDates;
use App\Repositories\Ext\SelectOptions;
use Illuminate\Support\Collection;
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
        if($this->from) {
            $this->fromMonthDay = $this->from->format('m').$from->format('d');
        }
        if($this->until) {
            $this->untilMonthDay = $this->until->format('m').$until->format('d');
        }
    }


    public function getGuestSaisons(string $byRelation): Collection|null
    {
        $configSaisonDates = ConfigSaisonDates::with($byRelation)
            ->where('key','=','guest')
            ->get();

        if(!$configSaisonDates->count()) {
            return null;
        }

        $data = $configSaisonDates->map(function (ConfigSaisonDates $saison) {
                if($saison->from_month > $saison->until_month) {
                    // jump in next year: p.e: 10 => 05
                    if($this->until->year > $this->from->year) {
                        $from   = Carbon::create($this->from->year . '-' . $saison->from_month . '-' . $saison->from_day);
                        $until  = Carbon::create($this->until->year . '-' . $saison->until_month . '-' . $saison->until_day);
                    }
                    else {
                        if( $this->from->month <= $saison->until_month ) {
                            // p.e: 02 => 05
                            $fromYear = ($this->from->copy()->year - 1);
                            $from   = Carbon::create($fromYear . '-' . $saison->from_month . '-' . $saison->from_day);
                            $until  = Carbon::create($this->until->year . '-' . $saison->until_month . '-' . $saison->until_day);
                        }
                        else if( $this->from->month > $saison->until_month ) {
                            // p.e: 11 => 10
                            $untilYear = $this->until->copy()->year + 1;
                            $from   = Carbon::create($this->from->year . '-' . $saison->from_month . '-' . $saison->from_day);
                            $until  = Carbon::create($untilYear . '-' . $saison->until_month . '-' . $saison->until_day);
                        }

                    }
                } else {
                    // p.e: 06 => 09
                    $untilYear = ($this->until->year > $this->from->year) ? ($this->until->year - 1) : $this->until->year;
                    $from   = Carbon::create($this->from->year . '-' . $saison->from_month . '-' . $saison->from_day);
                    $until  = Carbon::create($untilYear . '-' . $saison->until_month . '-' . $saison->until_day);
                }

                return new SaisonDatesEntity(saison: $saison, from: $from, until: $until);
            })
        ;
        return $data;
    }

    public function getTouchedGuestSaisons(string $model, string $search): Collection|null
    {
        $from = $this->from;
        $until = $this->until->copy()->subDay();
        $itemPeriod = Period::make($from, $until);

        $result = $this->getGuestSaisons('dailyPrice')
            ->filter(function (SaisonDatesEntity $entiy) use ($model, $search, $itemPeriod) {
                $saisonPeriod   = Period::make($entiy->getFrom(), $entiy->getUntil());
                $overlap        = $itemPeriod->overlap($saisonPeriod);

                if(!$overlap) {
//                   dump($itemPeriod->asString(), $saisonPeriod->asString());
                }
                else {
                    $overlapLength = $overlap->length();
//                    dump($overlap->asString());
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
                                ? $dailyPrice->price * $overlapLength
                                : $dailyPrice->price * $search * $overlapLength;
                            $dayPrice = ($dailyPrice->from_unit && $dailyPrice->until_unit)
                                ? $dailyPrice->price
                                : $dailyPrice->price * $search;
                            break;
                        // absolute
                        case 6:
                        default:
                            $sumPrice = $dailyPrice->price * $overlapLength;
                            $dayPrice = $dailyPrice->price;
                    }
//                    dump($overlapLength);
                    $entiy->setPrice($sumPrice);

                    foreach($overlap as $date) {
                        $entiy->addDailyPrices($date, $dayPrice);
                    }

                    return $entiy;
                }
                return null;
            });
        return $result;
    }
}
