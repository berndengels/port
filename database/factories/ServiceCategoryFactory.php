<?php

namespace Database\Factories;

use App\Models\ServiceCategory;
use Database\Factories\Ext\MainFactory;

class ServiceCategoryFactory extends MainFactory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ServiceCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'  => $this->faker->text(10),
            'modus' => 'underwater',
        ];
    }
}
