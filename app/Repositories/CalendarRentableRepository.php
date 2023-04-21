<?php

namespace App\Repositories;

use App\Models\Rentable;
use Illuminate\Support\Collection;

/**
 * class CalendarRepository
 */
class CalendarRentableRepository
{
    /**
     * @param string $type
     * @param Collection|null $dates
     */
    public function __construct(
        private ?Collection $dates
    ) {}

    /**
     * @param Collection $dates
     * @return Collection|null
     */
    public function getDates($withUrl = true): Collection|null
    {
        if($this->dates && $this->dates->count() > 0) {
            return $this->dates->map(function(Rentable $rent) use($withUrl) {
                $relation = class_basename($rent->rentable);
                $routeName = 'admin.'.strtolower($relation).'Rentals.show';
                $data = [
                    'id'                => $rent->id,
                    'title'             => __($relation) .' '. $rent->rentable->name .' - '.$rent->customer->name,
                    'allDay'            => false,
                    'start'             => $rent->from->addHours(12),
                    'end'               => $rent->until->addHours(12),
                    'backgroundColor'   => $rent->rentable->calendar_color ?? '#3788d8',
                    'relation'          => $relation,
                ];
                if($withUrl) {
                    $data += ['url' => route($routeName, $rent),];
                }
                return $data;
            });
        }
        return null;
    }

    public function getReservationDates($withUrl = true)
    {
        if($this->dates && $this->dates->count() > 0) {
            return $this->dates->map(function(Rentable $rent) use ($withUrl) {
                $relation = class_basename($rent->rentable);
                $data = [
                    'id'                => $rent->id,
                    'title'             => __($relation) .' '. $rent->rentable->name .' belegt',
                    'allDay'            => false,
                    'start'             => $rent->from->addHours(12),
                    'end'               => $rent->until->addHours(12),
                    'backgroundColor'   => '#dd0000',
                    'relation'          => $relation,
                ];
                if($withUrl) {
                    $data += ['url' => route('admin.rentals.show', $rent),];
                }
                return $data;
            });
        }
    }

    public function getJsonDates()
    {
        if($this->getDates()) {
            return $this->getDates()->toJson();
        }
        return null;
    }
}
