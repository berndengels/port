<?php
namespace App\Repositories;

use Carbon\Carbon;
use App\Models\ConfigHoliday;
use Illuminate\Support\Collection;
use Umulmrum\Holiday\Model\Holiday;
use App\Repositories\Ext\SelectOptions;
use Umulmrum\Holiday\HolidayCalculator;
use Umulmrum\Holiday\Provider\Germany\Germany;

class ConfigHolidayRepository extends Repository
{
    use SelectOptions;

    protected static $model = ConfigHoliday::class;
    /**
     * @var Collection
     */
    protected $exceptHolidays;
    protected $years;
    protected $holidayList = [
        'easter'    => [
            'good_friday',
            'easter_monday',
        ],
        'pentecost'  => [
            'whit_sunday',
            'whit_monday',
        ],
        'chrismas'  => [
            'christmas_eve',
            'second_christmas_day',
        ],
        'yearchange'  => [
            'new_years_eve',
            'new_year',
        ],
        'chrismas-yearchange'  => [
            'christmas_eve',
            'new_year',
        ],
        'german_unity_day',
        'reformation_day',
        'repentance_and_prayer_day',
        'labor_day',
    ];
    public function __construct(private int $addYears = 1)
    {
        $this->setYears($this->addYears);
        $this->exceptHolidays = ConfigHoliday::whereEnabled(false)->get()->map->key;
    }

    public function getHolidayOptions()
    {
        $calculator = new HolidayCalculator();
        $holidays = collect($calculator->calculate(Germany::class, $this->years));
        $data = [];
        foreach ($this->holidayList as $groups => $items) {
            if(is_array($items)) {
                [$from, $until] = $items;
            } else {
                $from = $until = $groups = $items;
            }
            // skip disabled holidays
            if($this->exceptHolidays->contains($from) || $this->exceptHolidays->contains($until) || $this->exceptHolidays->contains($groups)) {
                continue;
            }

            /**
             * @var Holiday $holiday
             */
            foreach ($holidays as $holiday) {
                $name = $holiday->getName();
                $date = Carbon::create($holiday->getDate());
                $year = $date->format('Y');

                if ($name === $from) {
                    $dateFrom = $date->copy()->format('Y-m-d');
                    $data[$year][$groups]['from'] = $dateFrom;
                }
                if ($name === $until) {
                    if($until === 'new_year') {
                        $year = $year++;
                        $date = $date->copy()->addYear();
                    }
                    $dateUntil = $date->copy()->format('Y-m-d');
                    $data[$year][$groups]['until'] = $dateUntil;
                }
            }
        }

        $options = [];
        foreach ($data as $year => $groups) {
            foreach ($groups as $group => $val) {
                $name = __($group, [], 'de');
                $germanFrom = Carbon::create($val['from'])->format('d.m.Y');
                $germanUntil = Carbon::create($val['until'])->format('d.m.Y');
                if($val['from'] === $val['until']) {

                    $options["$name $year|$val[from]|$val[until]"] = "$year: $name $germanFrom";
                } else {
                    $options["$name $year|$val[from]|$val[until]"] = "$year: $name $germanFrom - $germanUntil";
                }
            }
        }
        return $options;
    }

    /**
     * @param mixed $years
     * @return ConfigSaisonRentDatesRepository
     */
    public function setYears($addYears = 1): self
    {
        $today = Carbon::today();
        $currentYear = $today->year;

        for($i = 0; $i <= $addYears; $i++) {
           $this->years[] = $currentYear++;
        }

        return $this;
    }

    public function getYears() {
        return $this->years;
    }
}
