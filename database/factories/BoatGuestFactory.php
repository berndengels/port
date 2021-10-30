<?php
namespace Database\Factories;

use App\Models\BoatGuest;
use Database\Factories\Ext\MainFactory;

class BoatGuestFactory extends MainFactory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BoatGuest::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'      => $this->faker->name(['female']),
            'length'    => mt_rand(5, 20),
            'home_port' => $this->faker->city,
        ];
    }
}
