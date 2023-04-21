<?php

namespace App\Rules;

use Carbon\Carbon;
use App\Models\Rentable;
use Spatie\Period\Period;
use Spatie\Period\Boundaries;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Validation\Rule;

class RuleRentDateValidUntil extends RuleRentDate implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $from   = Carbon::make(request('from'));
        $until  = Carbon::make($value);
        $actualPeriod = Period::make($from, $until, boundaries: Boundaries::EXCLUDE_START());

        $this->existing = Rentable::whereHasMorph('rentable', $this->relation)
            ->whereRentableId($this->model->id)
            ->get()
            ->filter(function($item) use ($actualPeriod) {
                $p = Period::make($item->from, $item->until, boundaries: Boundaries::EXCLUDE_START());
                if($actualPeriod->overlapsWith($p)) {
                    return $item;
                }
            });
        if($this->existing->count() > 0) {
            return false;
        }
        return true;
    }
}
