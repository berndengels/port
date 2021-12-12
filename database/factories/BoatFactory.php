<?php
namespace Database\Factories;

use App\Models\Boat;
use Database\Factories\Ext\MainFactory;

class BoatFactory extends MainFactory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Boat::class;
    protected $types = ['motor', 'sail'];
    protected $type;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $this->type = $this->types[rand(0,1)];
        $length = mt_rand(5, 15);
        $arr = [
            'boat_name'         => $this->faker->name(['female']),
            'boat_type'         => $this->type,
            'length'            => $length,
            'width'             => mt_rand(20, 40) / 10,
            'weight'            => mt_rand(1000, 10000),
            'board_height'      => mt_rand(5, 20) / 10,
            'draft'             => mt_rand(3, 10) / 10,
            'length_waterline'  => $length - 1,
            'home_port'         => $this->faker->city(),
            'mast_length'       => 0,
            'mast_weight'       => 0,
            'length_keel'       => 0,
        ];
        if('sail' === $this->type) {
            $arr = array_merge($arr, [
                'mast_length'       => mt_rand(8, 18),
                'mast_weight'       => mt_rand(50, 200),
                'length_keel'       => mt_rand(15, 60) / 10,
                'draft'             => mt_rand(10, 20) / 10,
            ]);
        }

        return $arr;
    }
}
