<?php

namespace App\Rules;

use App\Models\Caravan;
use App\Models\CaravanDates;
use Illuminate\Contracts\Validation\Rule;

class DatesIntervalUnique implements Rule
{
    private $caravan;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(Caravan $caravan)
    {
        $this->caravan = $caravan;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $from   = request('from');
        $exist  = CaravanDates::whereCaravanId($this->caravan->id)
            ->whereBetween('from', [$from, $value])
            ->orWhereBetween('until', [$from, $value])
            ->count()
        ;
        if($exist > 0) {
            return false;
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Es existiert schon ein Eintrag, der in diesen Zeitraum fällt.';
    }
}
