<?php
namespace Database\Factories;

use Database\Factories\Ext\MainFactory;

class WidgetFactory extends MainFactory
{
    public static $number = 1;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title'     => $this->faker->text(20),
            'content'   => $this->faker->text(500),
            'position'  => static::$number++,
        ];
    }
}
