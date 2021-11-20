<?php

namespace App\Repositories\Ext;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

trait Stats
{
    public static function getVisitsByDate(string $modelClass, $dateField = 'from', $dateFormat = 'd.m.Y'): Collection
    {
        $cacheKey = 'stats-' . Str::slug(class_basename($modelClass));
        return Cache::remember($cacheKey, 3600, function() use ($modelClass, $dateField, $dateFormat) {
            $query = ($modelClass)::groupBy(['from'])
                ->selectRaw('`'.$dateField.'`, COUNT(*) AS count')
                ->orderBy('from')
            ;

            return $query->get()
                ->map(fn($item) => [
                    $dateField  => $item->{$dateField}->format($dateFormat),
                    'count' => $item->count
                ]);
        });
    }
}
