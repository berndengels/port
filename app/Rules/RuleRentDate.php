<?php

namespace App\Rules;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Validation\Rule;

abstract class RuleRentDate implements Rule
{
    protected $existing;
    protected $routeName;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(
        protected Model $model,
        protected $relation
    ) {
        $this->routeName = 'admin.'.strtolower(class_basename($this->model)).'Rentals.edit';
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
                $url    = route($this->routeName, $item);
                return "<a href='$url'>$name $from bis $until</a>";
            }
        )->toArray();
        $msg = implode('<br>', $msg);
        return "Es existieren schon Einträge für diesen Zeitraum: <br><ul>$msg</ul>";
    }
}
