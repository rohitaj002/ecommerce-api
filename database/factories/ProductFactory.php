<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;
use Faker\Generator as Faker;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // $factory = new Factory();


        // $factory->define(Product::class, function (Faker $faker) {
            return [
                'name' => $this->faker->name,
                'description' => $this->faker->paragraph,
                'price' => $this->faker->randomFloat(2, 0, 100),
            ];
        // });
        
    }
}
