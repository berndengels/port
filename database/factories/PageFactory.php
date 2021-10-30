<?php
namespace Database\Factories;

use App\Models\Page;
use Database\Factories\Ext\MainFactory;

class PageFactory extends MainFactory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Page::class;

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
