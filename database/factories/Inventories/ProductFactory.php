<?php

namespace Database\Factories\Inventories;

use App\Domain\Inventories\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Domain\Inventory\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => 'Product ' . $this->faker->word(),
            'base_price' => $this->faker->randomFloat(2, 10, 1000),
        ];
    }
}
