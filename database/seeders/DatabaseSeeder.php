<?php

namespace Database\Seeders;

use App\Domain\Entities\Models\User;
use App\Domain\Inventories\Models\PriceList;
use App\Domain\Inventories\Models\Product;
use App\Domain\Inventories\Models\ProductDescription;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        Product::factory()
            ->has(ProductDescription::factory(), 'description')
            ->has(PriceList::factory()->count(5))
            ->count(7)
            ->create();
    }
}
