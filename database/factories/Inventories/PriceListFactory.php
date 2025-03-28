<?php

namespace Database\Factories\Inventories;

use App\Domain\Inventories\Models\PriceList;
use App\Domain\Inventories\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Domain\Inventories\Models\PriceList>
 */
class PriceListFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PriceList::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'country_code' => fake()->boolean(70) ? fake()->countryISOAlpha3() : null,
            'currency_code' => fake()->boolean(70) ? fake()->countryCode() : null,
            'price' => fake()->randomFloat(2, 5, 500),
            'start_date' => fake()->boolean(70) ? fake()->dateTimeThisYear() : null,
            'end_date' => fake()->boolean(50) ? fake()->dateTimeThisYear('+6 months') : null,
            'priority' => fake()->numberBetween(1, 100),
        ];
    }
}
