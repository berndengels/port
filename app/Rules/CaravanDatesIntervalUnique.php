<?php

namespace App\Rules;

class CaravanDatesIntervalUnique extends DatesIntervalUnique
{
    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        $msg = $this->existing->map(
            function ($item) {
                $name   = $item->model->carnumber;
                $from   = $item->from->format('d.m.Y');
                $until  = $item->until->format('d.m.Y');
                $url    = route($this->routeKey, $item);
                return "<li><a class='btn btn-red mt-3' href='$url'>$name: $from bis $until</a></li>";
            }
        )->toArray();
        $msg = implode('', $msg);
        return "Es existieren schon ein Einträge für diesen Zeitraum: <br><ul>$msg</ul>";
    }
}
