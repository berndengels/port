<?php

namespace App\Traits\Models\Filter;

trait HasYearMonthOptions
{
    public static function monthOptions(string $groupKeyBy = 'month', $prepend = 'Monat wählen')
    {
        $options = (static::class)::selectRaw("MONTH(`from`) AS `$groupKeyBy`, MONTHNAME(`from`) AS monthname")
            ->groupByRaw($groupKeyBy)
            ->get()
            ->keyBy($groupKeyBy)
            ->map
            ->monthname
        ;

        if($prepend) {
            $options->prepend($prepend, '');
        }

        return $options;
    }

    public static function yearOptions(string $groupKeyBy = 'year', $prepend = 'Jahr wählen')
    {
        $options = (static::class)::selectRaw("YEAR(`from`) AS `$groupKeyBy`")
            ->groupByRaw($groupKeyBy)
            ->get()
            ->keyBy($groupKeyBy)
            ->map
            ->year
        ;

        if($prepend) {
            $options->prepend($prepend, '');
        }

        return $options;
    }
}
