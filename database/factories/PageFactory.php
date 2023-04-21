<?php
namespace Database\Factories;

use Database\Factories\Ext\MainFactory;

class PageFactory extends MainFactory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title'     => $this->faker->text(20),
            'content'   => $this->faker->text(5000),
        ];
    }
}
