<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Domain\Entities\Models{
/**
 * 
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @method static \Database\Factories\Entities\CountryFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country whereName($value)
 */
	class Country extends \Eloquent {}
}

namespace App\Domain\Entities\Models{
/**
 * 
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @method static \Database\Factories\Entities\CurrencyFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Currency newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Currency newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Currency query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Currency whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Currency whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Currency whereName($value)
 */
	class Currency extends \Eloquent {}
}

namespace App\Domain\Entities\Models{
/**
 * 
 *
 * @property int $id
 * @property int|null $country_id
 * @property int|null $currency_id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\Entities\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCurrencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

namespace App\Domain\Inventories\Models{
/**
 * 
 *
 * @property int $id
 * @property int $product_id
 * @property int|null $country_id
 * @property int|null $currency_id
 * @property numeric $price
 * @property \Illuminate\Support\Carbon|null $start_date
 * @property \Illuminate\Support\Carbon|null $end_date
 * @property int $priority
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Domain\Entities\Models\Country|null $country
 * @property-read \App\Domain\Entities\Models\Currency|null $currency
 * @property-read \App\Domain\Inventories\Models\Product $product
 * @method static \Database\Factories\Inventories\PriceListFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PriceList newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PriceList newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PriceList query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PriceList whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PriceList whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PriceList whereCurrencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PriceList whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PriceList whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PriceList wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PriceList wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PriceList whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PriceList whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PriceList whereUpdatedAt($value)
 */
	class PriceList extends \Eloquent {}
}

namespace App\Domain\Inventories\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $base_price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Domain\Inventories\Models\ProductDescription|null $description
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Domain\Inventories\Models\PriceList> $priceLists
 * @property-read int|null $price_lists_count
 * @method static \Database\Factories\Inventories\ProductFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereBasePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereUpdatedAt($value)
 */
	class Product extends \Eloquent {}
}

namespace App\Domain\Inventories\Models{
/**
 * 
 *
 * @property int $id
 * @property int $product_id
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Domain\Inventories\Models\Product $product
 * @method static \Database\Factories\Inventories\ProductDescriptionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductDescription newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductDescription newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductDescription query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductDescription whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductDescription whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductDescription whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductDescription whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductDescription whereUpdatedAt($value)
 */
	class ProductDescription extends \Eloquent {}
}

