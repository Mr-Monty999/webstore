<?php

namespace Database\Factories;

use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "name" => $this->faker->name,
            "price" => $this->faker->numberBetween(0, 100000),
            "discount" => $this->faker->numberBetween(0, 100),
            "photo" => $this->faker->image,
            "item_id" => $this->faker->unique()->randomElement(Item::pluck("id")->toArray())

        ];
    }
}
