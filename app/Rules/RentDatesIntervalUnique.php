<?php

namespace App\Rules;

use App\Models\Rentable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Validation\Rule;
use Spatie\Period\Boundaries;
use Spatie\Period\Period;
use Spatie\Period\PeriodCollection;

class RentDatesIntervalUnique implements Rule
{
    protected $existing;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(
        protected Model $model,
        protected $relation
    ) {}

    /**
     * Determine if the validation rule passes.
     *
     * @param  string $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $from = Carbon::make(request('from'));
        $until = Carbon::make($value);
//        $actualPeriod = Period::make($from, $until, boundaries: Boundaries::EXCLUDE_ALL());
        $actualPeriod = Period::make($from, $until, boundaries: Boundaries::EXCLUDE_NONE());

        $this->existing = Rentable::whereHasMorph('rentable', $this->relation)
            ->get()
            ->filter(function($item) use ($actualPeriod) {
                $p = Period::make($item->from, $item->until, boundaries: Boundaries::EXCLUDE_NONE());
                if($actualPeriod->overlapsWith($p)) {
                    return $item;
                }
            });
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
        $msg = $this->existing->map(
            function ($item) {
                $name   = $this->model->name ?? '';
                $from   = $item->from->format('d.m.Y');
                $until  = $item->until->format('d.m.Y');
                $url    = route('admin.rentals.edit', $item);
                return "<a href='$url'>$name $from bis $until</a>";
            }
        )->toArray();
        $msg = implode('', $msg);
        return "Es existieren schon Einträge für diesen Zeitraum: <br><ul>$msg</ul>";
    }
}
