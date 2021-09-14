<?php

namespace App\Rules;

use App\Models\Caravan;
use App\Models\CaravanDates;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Boolean;

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
        $sql = <<< SQL
SELECT * FROM `caravan_dates`
WHERE `caravan_id` = ?
AND (DATE(?) BETWEEN `from` AND `until` OR DATE(?) BETWEEN `from` AND `until`)
SQL;
        $found  = DB::select(DB::raw($sql), [$this->caravan->id, request('from'), $value]);

        if(count($found) > 0) {
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
