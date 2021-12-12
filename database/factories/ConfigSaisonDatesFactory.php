<?php

namespace Database\Factories;

use App\Models\ConfigSaisonDates;
use Carbon\Carbon;
use Database\Factories\Ext\MainFactory;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConfigSaisonDatesFactory extends MainFactory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ConfigSaisonDates::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        try {
            $start      = Carbon::today()->subDays(rand(1,356));
            $end        = $start->copy()->addDays(rand(7,90));

            $fromDay    = $start->format('d');
            $fromMonth  = $start->format('m');

            $untilDay   = $end->format('d');
            $untilMonth = $end->format('m');

            return [
                'name'          => $this->faker->text(20),
                'key'           => 'guest',
                'mode'           => null,
                'from_day'      => $this->zeroFill($fromDay),
                'from_month'    => $this->zeroFill($fromMonth),
                'until_day'     => $this->zeroFill($untilDay),
                'until_month'   => $this->zeroFill($untilMonth),
                'from_mday'     => null,
                'until_mday'    => null,
            ];
        } catch(Exception $e) {
            die($e->getMessage());
        }
    }
}
