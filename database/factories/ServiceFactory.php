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
        return [
        ];
    }
}
