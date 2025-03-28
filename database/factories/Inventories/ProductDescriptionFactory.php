<?php

namespace Database\Factories\Inventories;

use App\Domain\Inventories\Models\Product;
use App\Domain\Inventories\Models\ProductDescription;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Domain\Inventory\Models\ProductDescription>
 */
class ProductDescriptionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductDescription::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'description' => $this->faker->paragraph(),
        ];
    }
}
