<?php

namespace App\Repositories;

use App\Models\Houseboat;
use App\Models\HouseboatDates;
use Illuminate\Support\Collection;
use Acaronlex\LaravelCalendar\Calendar;

/**
 * class CalendarRepository
 */
class CalendarRepository
{
    /**
     * @param string $type
     * @param Collection|null $dates
     */
    public function __construct(
        private string $type,
        private ?Collection $dates
    ) {}

    /**
     * @param Collection $dates
     * @return Collection|null
     */
    public function getDates(): Collection|null
    {
        if($this->dates && $this->dates->count() > 0) {
            switch ($this->type) {
                case 'houseboat':
                    return $this->dates->map(function(HouseboatDates $date) {
                        if( $date->houseboat ) {
                            return [
                                'id'                => $date->id,
                                'title'             => $date->houseboat->name .' - '.$date->customer->name,
                                'allDay'            => false,
                                'start'             => $date->from->addHours(12),
                                'end'               => $date->until->addHours(12),
                                'backgroundColor'   => $date->houseboat->calendar_color ?? '#3788d8',
                                'url'               => route('admin.houseboatDates.show', $date),
                            ];
                        }
                        return null;
                    });
                default:
                    return null;
            }
        }
        return null;
    }

    public function getJsonDates()
    {
        return $this->getDates()->toJson();
    }
}
