<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Variant;
use Faker\Generator as Faker;

class VariantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Variant::class;

    public function definition()
    {
        // $faker = Faker\Factory::create();

        return [
            'name' => $this->faker->word,
            'sku' => $this->faker->unique()->regexify('[A-Z]{3}-[0-9]{3}'),
            'additional_cost' => $this->faker->randomFloat(2, 0, 100),
            'stock_count' => $this->faker->numberBetween(0, 100),
            'product_id' => function () {
                return App\Models\Product::factory()->create()->id;
            },
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
