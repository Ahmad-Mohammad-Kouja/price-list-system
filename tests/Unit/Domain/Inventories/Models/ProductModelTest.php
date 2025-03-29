<?php

namespace Tests\Unit\Domain\Inventories\Models;

use App\Domain\Entities\Models\Country;
use App\Domain\Entities\Models\Currency;
use App\Domain\Inventories\Dtos\PriceListFilterDTO;
use App\Domain\Inventories\Enum\PriceListSortingEnum;
use App\Domain\Inventories\Models\PriceList;
use App\Domain\Inventories\Models\Product;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Tests\TestCase;

class ProductModelTest extends TestCase
{
    public function test_can_get_the_base_price_if_not_have_any_price_list()
    {
        $expectedProduct = Product::factory()
            ->create(['base_price' => 1200]);

        $realProduct = (new Product())
            ->findOrFailById($expectedProduct->id, PriceListFilterDTO::new());

        $this->assertEquals(1200, $realProduct->applicable_price);
    }

    public function test_can_get_the_base_price_if_have_price_list_but_not_fit_with_filters()
    {
        $this->travelTo('2026-01-01');

        $expectedProduct = Product::factory()
            ->create(['base_price' => 1200]);

        $countries = Country::factory()
            ->count(3)
            ->create();

        $currencies = Currency::factory()
            ->count(3)
            ->create();

        PriceList::factory()
            ->for($expectedProduct)
            ->count(4)
            ->state(new Sequence(
                [
                    'country_id' => $countries[0]->id,
                    'currency_id' => null,
                    'start_date' => null,
                    'end_date' => null,
                    'price' => 100,
                    'priority' => 1,
                ],
                [
                    'country_id' => $countries[1]->id,
                    'currency_id' => null,
                    'start_date' => null,
                    'end_date' => null,
                    'price' => 200,
                    'priority' => 2,
                ],
                [
                    'country_id' => $countries[2]->id,
                    'currency_id' => $currencies[0]->id,
                    'start_date' => null,
                    'end_date' => null,
                    'price' => 300,
                    'priority' => 3,
                ],
                [
                    'country_id' => $countries[2]->id,
                    'currency_id' => null,
                    'start_date' => '2025-12-12',
                    'end_date' => '2025-12-15',
                    'price' => 400,
                    'priority' => 4,
                ],
            ))
            ->create();

        $realProduct = (new Product())
            ->findOrFailById(
                $expectedProduct->id,
                PriceListFilterDTO::new(
                    $countries[2]->id,
                    date: Carbon::today()
                )
            );

        $this->assertEquals(1200, $realProduct->applicable_price);
    }

    public function test_can_get_the_applicable_price_based_on_price_lists_table()
    {
        $this->travelTo('2026-03-25');

        $expectedProduct = Product::factory()
            ->create(['base_price' => 1200]);

        $countries = Country::factory()
            ->count(3)
            ->create();

        PriceList::factory()
            ->for($expectedProduct)
            ->count(4)
            ->state(new Sequence(
                [
                    'country_id' => $countries[0]->id,
                    'currency_id' => null,
                    'start_date' => null,
                    'end_date' => null,
                    'price' => 100,
                    'priority' => 1,
                ],
                [
                    'country_id' => $countries[1]->id,
                    'currency_id' => null,
                    'start_date' => null,
                    'end_date' => null,
                    'price' => 200,
                    'priority' => 2,
                ],
                [
                    'country_id' => $countries[2]->id,
                    'currency_id' => null,
                    'start_date' => '2026-03-23',
                    'end_date' => '2026-03-25',
                    'price' => 800,
                    'priority' => 3,
                ],
                [
                    'country_id' => $countries[2]->id,
                    'currency_id' => null,
                    'start_date' => '2025-12-12',
                    'end_date' => '2025-12-15',
                    'price' => 400,
                    'priority' => 4,
                ],
            ))
            ->create();

        $realProduct = (new Product())
            ->findOrFailById(
                $expectedProduct->id,
                PriceListFilterDTO::new(
                    $countries[2]->id,
                    date: Carbon::today()
                )
            );

        $this->assertEquals(800, $realProduct->applicable_price);
    }

    public function test_can_get_the_applicable_price_based_on_lowest_priority_price_lists_table()
    {
        $this->travelTo('2026-03-25');

        $expectedProduct = Product::factory()
            ->create(['base_price' => 1200]);

        $countries = Country::factory()
            ->count(3)
            ->create();

        $currencies = Currency::factory()
            ->count(3)
            ->create();

        PriceList::factory()
            ->for($expectedProduct)
            ->count(4)
            ->state(new Sequence(
                [
                    'country_id' => $countries[0]->id,
                    'currency_id' => null,
                    'start_date' => null,
                    'end_date' => null,
                    'price' => 100,
                    'priority' => 4,
                ],
                [
                    'country_id' => $countries[2]->id,
                    'currency_id' => null,
                    'start_date' => null,
                    'end_date' => null,
                    'price' => 200,
                    'priority' => 1,
                ],
                [
                    'country_id' => null,
                    'currency_id' => $currencies[2]->id,
                    'start_date' => null,
                    'end_date' => null,
                    'price' => 800,
                    'priority' => 3,
                ],
                [
                    'country_id' => $countries[2]->id,
                    'currency_id' => $currencies[2]->id,
                    'start_date' => '2025-12-12',
                    'end_date' => '2026-03-25',
                    'price' => 400,
                    'priority' => 2,
                ],
            ))
            ->create();

        $realProduct = (new Product())
            ->findOrFailById(
                $expectedProduct->id,
                PriceListFilterDTO::new(
                    $countries[2]->id,
                    $currencies[2]->id,
                    date: Carbon::today()
                )
            );

        $this->assertEquals(200, $realProduct->applicable_price);
    }

    public function test_can_get_the_applicable_price_for_all_items_and_sort_them_based_on_user_input()
    {
        $this->travelTo('2026-03-25');

        $products = Product::factory()
            ->count(3)
            ->state(new Sequence(
                ['base_price' => 1200],
                ['base_price' => 1100],
                ['base_price' => 1000],
            ))
            ->create();

        $countries = Country::factory()
            ->count(3)
            ->create();

        $currencies = Currency::factory()
            ->count(3)
            ->create();

        PriceList::factory()
            ->count(4)
            ->state(new Sequence(
                [
                    'country_id' => $countries[0]->id,
                    'currency_id' => null,
                    'start_date' => null,
                    'end_date' => null,
                    'price' => 100,
                    'priority' => 4,
                    'product_id' => $products[0]->id,
                ],
                [
                    'country_id' => $countries[2]->id,
                    'currency_id' => null,
                    'start_date' => null,
                    'end_date' => null,
                    'price' => 200,
                    'priority' => 1,
                    'product_id' => $products[1]->id,
                ],
                [
                    'country_id' => null,
                    'currency_id' => $currencies[2]->id,
                    'start_date' => null,
                    'end_date' => null,
                    'price' => 800,
                    'priority' => 3,
                    'product_id' => $products[2]->id,
                ],
                [
                    'country_id' => $countries[2]->id,
                    'currency_id' => $currencies[2]->id,
                    'start_date' => '2025-12-12',
                    'end_date' => '2026-03-25',
                    'price' => 400,
                    'priority' => 2,
                    'product_id' => $products[2]->id,
                ],
            ))
            ->create();

        $response = (new Product())
            ->list(
                PriceListFilterDTO::new(
                    $countries[2]->id,
                    $currencies[2]->id,
                    date: Carbon::today(),
                    priceListSorting: PriceListSortingEnum::HIGHEST_TO_LOWEST,
                )
            )
            ->toArray();

        $this->assertEquals($products[0]->id, $response['data'][0]['id']);
        $this->assertEquals($products[2]->id, $response['data'][1]['id']);
        $this->assertEquals($products[1]->id, $response['data'][2]['id']);

        $response = (new Product())
            ->list(
                PriceListFilterDTO::new(
                    $countries[2]->id,
                    $currencies[2]->id,
                    date: Carbon::today(),
                    priceListSorting: PriceListSortingEnum::LOWEST_TO_HIGHEST,
                )
            )
            ->toArray();

            $this->assertEquals($products[1]->id, $response['data'][0]['id']);
            $this->assertEquals($products[2]->id, $response['data'][1]['id']);
            $this->assertEquals($products[0]->id, $response['data'][2]['id']);
    }
}
