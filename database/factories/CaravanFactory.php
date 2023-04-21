<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CaravanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'country_id'    => 55,
            'carnumber'     => $this->generateCarnumber(),
            'carlength'     => rand(6, 12),
            'email'         => $this->faker->unique()->safeEmail(),
        ];
    }

    private function generateCarnumber() {
        $str = '';
        $letters = [];
        for($i = 'A'; $i < 'Z'; $i++){ $letters[] = $i; }
        $letters[] = 'Z';
        $max = count($letters) - 1;
        $str .= $letters[rand(0, $max)];
        $str .= '-';
        $str .= $letters[rand(0, $max)];
        $str .= $letters[rand(0, $max)];
        $str .= ' ';
        $str .= rand(1000, 9999);

        return $str;
    }
}
