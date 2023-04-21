<?php
namespace Database\Factories;

use App\Models\Boat;
use Database\Factories\Ext\MainFactory;
use Database\Data\BoatData;

class BoatFactory extends MainFactory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Boat::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $names = file(database_path('data/bootsnamen.csv'));
        $name = $names[rand(0, count($names) - 1)];
        $data = BoatData::$data;
        return array_merge($data[rand(0, count($data) - 1)], ['name' => $name]);
    }
}
