<?php

namespace App\Rules;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Validation\Rule;

class DatesIntervalUnique implements Rule
{
    protected $model;
    protected $classDates;
    protected $relation;
    protected $foreignKey;
    protected $routeKey;
    protected $existing;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(Model $model)
    {
        $this->model        = $model;
        $this->classDates   = get_class($this->model). 'Dates';
        $this->relation     = strtolower(class_basename($this->model));
        $this->foreignKey   = $this->relation . '_id';
        $this->routeKey     = $this->relation . 'Dates';
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $this->existing = $this->classDates::with([$this->relation])
            ->whereRaw(
                $this->foreignKey . ' = ? AND (DATE(?) BETWEEN `from` AND `until` OR DATE(?) BETWEEN `from` AND `until`)', [
                $this->model->id,
                request('from'),
                $value
            ])
            ->get();
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
                $url    = route('admin.'.$this->routeKey.'.edit', $item);
                return "<a href='$url'>$name $from bis $until</a>";
            }
        )->toArray();
        $msg = implode('', $msg);
        return "Es existieren schon Einträge für diesen Zeitraum: <br><ul>$msg</ul>";
    }
}
