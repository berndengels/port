<?php

namespace Database\Factories;

use App\Models\MaterialCategory;
use Database\Factories\Ext\MainFactory;

class MaterialCategoryFactory extends MainFactory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MaterialCategory::class;
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
