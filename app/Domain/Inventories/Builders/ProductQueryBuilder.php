<?php

namespace App\Domain\Inventories\Builders;

use App\Domain\Inventories\Dtos\PriceListFilterDTO;
use App\Domain\Inventories\Models\PriceList;
use DB;
use Illuminate\Database\Eloquent\Builder;

class ProductQueryBuilder extends Builder
{
    public function addApplicablePrice(PriceListFilterDTO $priceListFilterDTO): self
    {
        $priceListSubQuery = PriceList::query()
            ->select([
                'price_lists.product_id',
                'price_lists.price',
                DB::raw('ROW_NUMBER() OVER (PARTITION BY product_id ORDER BY priority ASC) AS row_num')
            ])
            ->when(
                $priceListFilterDTO->hasCountryId(),
                fn($query) => $query->where(function ($query) use ($priceListFilterDTO) {
                    $query->where('price_lists.country_id', $priceListFilterDTO->getCountryId())
                        ->orWhereNull('price_lists.country_id');
                }),
                fn($query) => $query->whereNull('price_lists.country_id')
            )
            ->when(
                $priceListFilterDTO->hasCurrencyId(),
                fn($query) => $query->where(function ($query) use ($priceListFilterDTO) {
                    $query->where('price_lists.currency_id', $priceListFilterDTO->getCurrencyId())
                        ->orWhereNull('price_lists.currency_id');
                }),
                fn($query) => $query->whereNull('price_lists.currency_id')
            )
            ->when(
                $priceListFilterDTO->hasDate(),
                fn($query) => $query->where(function ($query) use ($priceListFilterDTO) {
                    $query->where(function ($query) use ($priceListFilterDTO) {
                        $query->where('price_lists.start_date', '<=', $priceListFilterDTO->getDate()->format('Y-m-d'))
                            ->where('price_lists.end_date', '>=', $priceListFilterDTO->getDate()->format('Y-m-d'));
                    })
                        ->orWhereNull('price_lists.start_date');
                }),
                fn($query) => $query->whereNull('price_lists.start_date')
            );

        return $this
            ->addSelect([
                DB::raw('COALESCE(price_lists.price, products.base_price) as applicable_price'),
            ])
            ->leftJoinSub(
                $priceListSubQuery,
                'price_lists',
                function ($query) {
                    $query->on('price_lists.product_id', '=', 'products.id')
                        ->where('price_lists.row_num', 1);
                }
            )
            ->when(
                $priceListFilterDTO->hasPriceListSorting(),
                fn($query) => $query->orderBy(
                    'applicable_price',
                    $priceListFilterDTO->getPriceListSorting()->getSorting()
                )
            );
    }
}
