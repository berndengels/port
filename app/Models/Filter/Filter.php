<?php
namespace App\Models\Filter;

use Illuminate\Database\Eloquent\Builder;

trait Filter
{
    public function scopeFilter(Builder $builder, string $name = null) : Builder
    {
        if(request()->has($name)) {
            $value = request()->input($name);
            $builder->where($name,'like', '%'.$value.'%');
        }
        return $builder;
    }
}
