<?php
namespace App\Traits\Models\Filter;

use Illuminate\Database\Eloquent\Builder;

trait YearMonthFilter
{
    public function scopeFromYearMonth(Builder $builder, string $year = null, string $month = null) : Builder
    {
        if($year) {
            $builder->whereYear('from', $year);
            if($month) {
                $builder->whereMonth('from', $month);
            }
        }
        return $builder;
    }

    /**
     * Scope a query to get.
     *
     * @param  Builder $query
     * @return array
     */
    public function scopeGetMonthsByYears(Builder $query, $from = null, $until = null)
    {
        $query->selectRaw("DISTINCT MONTH(`from`) month, DATE_FORMAT(`from`, '%M', 'de_DE') monthname, YEAR(`from`) year");

        if($from) {
            $query->whereDate('from', '>=', $from);
        }
        if($until) {
            $query->whereDate('until', '<=', $until);
        }
        $data = $query
            ->orderBy('year')
            ->orderBy('month')
            ->get();
        $result = [];
        foreach($data as $date) {
            $result[$date->year][] = [
                'month'     => $date->month,
                'monthname' => $date->monthname,
            ];
        }
        return $result;
    }
}
