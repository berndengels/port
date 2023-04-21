<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class RandomCustomerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Customer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'type' => ['permanent','guest'][mt_rand(0,1)],
            'name' => $this->faker->firstName.' '.$this->faker->lastName,
            'email' => $this->faker->email,
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'fon'       => $this->faker->phoneNumber,
            'state'     => $this->faker->city,
            'street'    => $this->faker->streetAddress,
            'postcode'  => $this->faker->postcode,
            'city'      => $this->faker->city,
        ];
    }
}
