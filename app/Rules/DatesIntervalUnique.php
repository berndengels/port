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
    private $existing;

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
//        $this->existing = DB::select(DB::raw($sql), [$this->caravan->id, request('from'), $value]);
        $this->existing = CaravanDates::with(['caravan'])
            ->whereRaw('caravan_id = ? AND (DATE(?) BETWEEN `from` AND `until` OR DATE(?) BETWEEN `from` AND `until`)', [
                $this->caravan->id,
                request('from'),
                $value
            ])
            ->get()
        ;
        if($this->existing->count() > 0) {
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
        $msg = $this->existing->map(function($item){
            $carnumber  = $item->caravan->carnumber;
            $from       = $item->from->format('d.m.Y');
            $until      = $item->until->format('d.m.Y');
            return "<li>$carnumber: $from bis $until</li>";
        })->toArray();
        $msg = implode('', $msg);
        return "Es existieren schon ein Einträge für diesen Zeitraum: <br><ul>$msg</ul>";
    }
}
