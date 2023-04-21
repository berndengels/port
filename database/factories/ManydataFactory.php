<?php

namespace Database\Factories;

use App\Models\Manydata;

use Illuminate\Database\Eloquent\Factories\Factory;

class ManydataFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Manydata::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'      => $this->faker->name(),
            'test_id'   => $this->faker->numberBetween(1)
        ];
    }
}
