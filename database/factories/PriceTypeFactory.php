<?php

namespace Database\Factories;

use App\Models\PriceType;
use Database\Factories\Ext\MainFactory;

class PriceTypeFactory extends MainFactory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PriceType::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
        ];
    }


}
