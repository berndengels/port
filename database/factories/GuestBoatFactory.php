<?php
namespace Database\Factories;

use Database\Factories\Ext\MainFactory;

class GuestBoatFactory extends MainFactory
{

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $names = file(database_path('data/bootsnamen.csv'));
        $name = $names[rand(0, count($names) - 1)];
        return [
            'name'      => $name,
            'length'    => mt_rand(6, 14),
            'home_port' => $this->faker->city,
        ];
    }
}
