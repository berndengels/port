<?php

namespace Database\Factories;

use App\Models\Material;
use Database\Factories\Ext\MainFactory;

class MaterialFactory extends MainFactory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Material::class;

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
