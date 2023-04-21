<?php

namespace App\Repositories\Ext;

use App\Helper\ModelHelper;
use App\Models\ConfigOffer;
use App\Models\Rentable;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Spatie\Period\Period;

trait Stats
{
    protected static $ttl = 0;
    public static function getVisitsByDate(string $modelClass, $dateField = 'from', $dateFormat = 'd.m.Y'): Collection|null
    {
        $cacheKey = 'stats-' . Str::slug(class_basename($modelClass));
        return Cache::remember($cacheKey, self::$ttl, function() use ($modelClass, $dateField, $dateFormat) {
            $query = ($modelClass)::groupBy(['from'])
                ->selectRaw('`'.$dateField.'`, COUNT(*) AS count')
                ->orderBy('from')
            ;
            $data = $query->get();

            if(!$data->count()) {
                return null;
            }

            return $data->map(fn($item) => [
                    $dateField  => $item->{$dateField}->format($dateFormat),
                    'count' => $item->count
                ]);
        });
    }

    public static function getSalesVolumByMonth(string $modelClass, $dateFormat = 'M y'): Collection|null
    {
        $cacheKey = 'stats-sales-volume-' . Str::slug(class_basename($modelClass));
        return Cache::remember($cacheKey, self::$ttl, function() use ($modelClass, $dateFormat) {
            /**
             * @var $model Model
             */
            $model = ($modelClass);
            $query = $model::getQuery();
            $query->selectRaw(
                'MONTH(`until`) `month`,
                    YEAR(`until`) `year`, 
                    SUM(`price`) `sum`'
                )
                ->groupByRaw('month')
                ->orderBy('year')
                ->orderBy('month')
            ;

            $data = $query->get();

            if(!$data->count()) {
                return null;
            }

            return $data->map(function(Model $item) use ($dateFormat) {
                $data = [
                    'year'  => $item->year,
                    'month' => Carbon::createFromDate($item->year, $item->month)->format($dateFormat),
                    'sum'   => $item->sum,
                ];
                return $data;
            });
        });
    }

    public static function getRentalSalesVolumByMonth(string $modelClass, $dateFormat = 'M y'): Collection|null
    {
        $cacheKey = 'stats-sales-volume-' . Str::slug(class_basename($modelClass));
        return Cache::remember($cacheKey, self::$ttl, function() use ($modelClass, $dateFormat) {
            /**
             * @var $model Model
             */
            $model = ($modelClass);
            $relations = ModelHelper::allRentableModels()
                ->filter(fn($m) => ConfigOffer::whereModel($m)->first()->enabled)
                ->values()
                ->toArray();

            $query = $model::whereHasMorph('rentable', $relations)
                ->select()
                ->selectRaw(
                    "CONCAT(DATE_FORMAT(`until`,'%b'),' ',DATE_FORMAT(`until`,'%Y')) `date`"
                )
                ->orderBy('from')
            ;
            $data = $query->get();

            if(!$data->count()) {
                return null;
            }

            /**
             * @var $firstDate Carbon
             * @var $lastDate Carbon
             */
            $firstDate = $data->first()->until;
            $lastDate = $data->last()->until;

            $dates = [];
            do {
                $date = $firstDate->addMonth();
                $dates[] = $date->clone()->format('M Y');
            } while ($date <= $lastDate);
            $dates = collect($dates);

            $data = $data
                ->mapToGroups(fn(Rentable $i) => [class_basename($i->rentable) => $i])
                ->map(fn($i) => $i->mapToGroups(fn($i) => [$i->date => $i->price]))
                ->map(fn($i) => $i->map->sum())
            ;
            $models = $data->keys();
            $results = [];

            $dates->each(function($date) use ($data, $models, &$results) {
                foreach ($models as $model) {
                    $results[$model][$date] = 0;
                }

                foreach ($data as $model => $months) {
                    foreach ($months as $month => $sum) {
                        if($month === $date) {
                            $results[$model][$date] = $sum;
                        }
                    }
                }
            });

            return collect($results);
        });
    }
}
