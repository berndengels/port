<?php

namespace Database\Factories;

use Carbon\Carbon;
use App\Models\ServiceRequest;
use Database\Factories\Ext\MainFactory;

class ServiceRequestFactory extends MainFactory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ServiceRequest::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'description'   => $this->faker->text(50),
            'done_until'    => Carbon::today()->addMonths(rand(1,10))->format('Y-m-d'),
            'is_paid'   => false,
        ];
    }
}
