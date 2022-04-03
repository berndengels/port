<?php
namespace App\Repositories;

use App\Libs\AppCache;
use Spatie\Period\Period;
use Umulmrum\Holiday\Model\Holiday;
use App\Models\ConfigHoliday;
use App\Repositories\Ext\SelectOptions;
use Carbon\Carbon;
use Umulmrum\Holiday\HolidayCalculator;
use Umulmrum\Holiday\Provider\Germany\Germany;

class ConfigHolidayRepository extends Repository
{
    use SelectOptions;

    protected static $model = ConfigHoliday::class;
    protected $holidays;
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
    ];

    public function __construct(private int $addYears = 1)
    {
        $this->setYears($this->addYears);
        $this->holidays = ConfigHoliday::whereEnabled(true)->get();
    }

    public function getHolidayOptions()
    {
        $calculator = new HolidayCalculator();
        $holidays = $calculator->calculate(Germany::class, $this->years);
        $data = [];

        foreach ($this->holidayList as $groups => $items) {
            $from   = $items[0];
            $until  = $items[1];

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

                elseif ($name === $until) {
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
                $options["$name $year|$val[from]|$val[until]"] = "$year: $name $val[from] - $val[until]";
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
