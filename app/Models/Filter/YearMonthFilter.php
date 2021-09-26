<?php
namespace App\Models\Filter;

use Illuminate\Database\Eloquent\Builder;

trait YearMonthFilter
{
    public function scopeFromYearMonth(Builder $builder, string $year = null, string $month = null) : Builder
    {
        if($year) {
            $builder->whereYear('from', $year);
            if($month) {
                $builder->whereMonth('from', $month);
//                dd($year, $month);
            }
        }
        return $builder;
    }
}
