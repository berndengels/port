<?php

namespace App\Repositories;

use Acaronlex\LaravelCalendar\Calendar;
use App\Models\Houseboat;
use App\Models\HouseboatDates;
use Illuminate\Database\Eloquent\Collection;

class CalendarRepository
{
    private $calendar;
    private $calendarDates;
    private $options = [
        'selectable'        => true,
        'selectOverlap'     => true,
        'locale'            => 'de',
        'firstDay'          => 1,
        'displayEventTime'  => false,
        'initialView'       => 'dayGridMonth',
        'headerToolbar'     => [
            'left' => 'prev,next today',
            'center' => 'title',
            'right' => null,
        ],
    ];

    public function __construct(private string $type, private ?Collection $dates = null)
    {
        $this->calendar = new Calendar();
        $this->calendar->setOptions($this->options);

        if($this->dates && $this->dates->count() > 0) {
            $this->calendarDates = $this->parseDates();
            $this->calendar->addEvents($this->calendarDates);
        }
    }

    private function parseDates() {
        switch ($this->type) {
            case 'houseboat':
                return $this->dates->map(function(HouseboatDates $date) {
                    if($date->houseboat && $date->houseboat instanceof Houseboat) {
                        return Calendar::event(
                            title: $date->houseboat->name .' - '.$date->customer->name,
                            isAllDay: false,
                            start: $date->from,
                            end: $date->until,
                            id: $date->id,
                        );
                    }
                    return null;
                });
            default:
                return null;
        }
    }

    /**
     * @return Calendar
     */
    public function getCalendar(): Calendar
    {
        return $this->calendar;
    }

    /**
     * @return null
     */
    public function getCalendarDates()
    {
        return $this->calendarDates;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @param array $options
     * @return CalendarRepository
     */
    public function setOptions(array $options): CalendarRepository
    {
        $this->options += $options;
        return $this;
    }
}
