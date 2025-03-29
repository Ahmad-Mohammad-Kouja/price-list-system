<?php

namespace App\Domain\Inventories\Models;

use App\Domain\Inventories\Builders\ProductQueryBuilder;
use App\Domain\Inventories\Dtos\PriceListFilterDTO;
use Database\Factories\Inventories\ProductFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'base_price',
    ];

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory<static>
     */
    protected static function newFactory()
    {
        return ProductFactory::new();
    }

    /**
     * Create a new Eloquent query builder for the model.
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder<*>
     */
    public function newEloquentBuilder($query): ProductQueryBuilder
    {
        return new ProductQueryBuilder($query);
    }

    public function description(): HasOne
    {
        return $this->hasOne(ProductDescription::class);
    }

    public function priceLists(): HasMany
    {
        return $this->hasMany(PriceList::class);
    }

    public function list(PriceListFilterDTO $priceListFilter)
    {
        return self::query()
            ->select([
                'products.id',
                'products.name',
                'products.base_price',
            ])
            ->addApplicablePrice($priceListFilter)
            ->paginate();
    }

    public function findOrFailById(int $productId, PriceListFilterDTO $priceListFilter): ?self
    {
        return self::query()
            ->select([
                'products.id',
                'products.name',
                'products.base_price',
                'product_descriptions.id as product_description_id',
                'product_descriptions.description',
            ])
            ->leftJoin('product_descriptions', 'product_descriptions.product_id', '=', 'products.id')
            ->addApplicablePrice($priceListFilter)
            ->where('products.id', $productId)
            ->firstOrFail();
    }
}
