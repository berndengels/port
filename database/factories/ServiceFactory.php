<?php

namespace Database\Factories;

use App\Models\Service;
use Database\Factories\Ext\MainFactory;

class ServiceFactory extends MainFactory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Service::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $quantity = rand(1,3);
        return [
            'service_category_id'   => 1,
            'price_type_id'         => 1,
            'name'      => $this->faker->text(30) . ' x' . $quantity,
            'quantity'  => $quantity,
            'price'     => $this->faker->numberBetween(5, 50) * $quantity,
        ];
    }
}
