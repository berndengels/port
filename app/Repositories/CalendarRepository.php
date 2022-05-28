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
     * @var Calendar
     */
    private $calendar;
    /**
     * @var Collection|null
     */
    private $calendarDates;
    /**
     * @var array
     */
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

    /**
     * @param string $type
     * @param Collection|null $dates
     */
    public function __construct(private string $type, private ?Collection $dates = null)
    {
        $this->calendar = new Calendar();
        $this->calendar->setOptions($this->options);

        if($this->dates && $this->dates->count() > 0) {
            $this->calendarDates = $this->parseDates($this->dates);
            $this->calendar->addEvents($this->calendarDates);
        }
    }

    /**
     * @param Collection $dates
     * @return Collection|null
     */
    private function parseDates(Collection $dates): Collection|null
    {
        if($dates && $dates->count() > 0) {
            switch ($this->type) {
                case 'houseboat':
                    return $dates->map(function(HouseboatDates $date) {
                        if( $date->houseboat ) {
                            return Calendar::event(
                                title: ($date->houseboat ? $date->houseboat->name : 'null') .' - '.$date->customer->name,
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
        return null;
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
    public function getCalendarDates(): Collection|null
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
