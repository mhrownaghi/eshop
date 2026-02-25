<?php

namespace Database\Factories;

use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'height' => $this->faker->randomFloat(2),
            'diagonal' => $this->faker->randomFloat(2),
            'volume' => $this->faker->randomFloat(2),
            'weight' => $this->faker->randomFloat(2),
            'box' => $this->faker->randomNumber(2),
            'price' => $this->faker->randomFloat(2),
            'old_price' => $this->faker->randomFloat(2),
            'additional_price' => $this->faker->randomFloat(2),
            'can_increase_price' => $this->faker->boolean(),
            'is_stock' => $this->faker->boolean(),
            'stock' => $this->faker->randomNumber(2),
            'sku' => $this->faker->randomNumber(2),
            'type' => $this->faker->randomElement(['lid', 'box', 'other']),
            'has_selectable_lid' => $this->faker->boolean(),
            'has_selectable_box' => $this->faker->boolean(),
            'offline_shopping' => $this->faker->boolean(),
            'description' => $this->faker->text(),
            'short_description' => $this->faker->text(),
            'meta_description' =>  $this->faker->text(),
            'category_id' => ProductCategory::factory()->create()->id,
        ];
    }
}
