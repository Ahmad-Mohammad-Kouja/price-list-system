<?php

namespace App\Domain\Inventories\Dtos;

use App\Domain\Entities\Models\Country;
use App\Domain\Entities\Models\Currency;
use App\Domain\Entities\Models\User;
use App\Domain\Inventories\Enum\PriceListSortingEnum;
use App\Src\Users\Inventories\Requests\FilterProductRequest;
use Carbon\Carbon;
use Illuminate\Support\Traits\Conditionable;
use Symfony\Component\HttpKernel\Exception\HttpException;

class PriceListFilterDTO
{
    use Conditionable;

    private ?int $countryId = null;

    private ?int $currencyId = null;

    private ?Carbon $date = null;

    private ?PriceListSortingEnum $priceListSorting = null;

    public function __construct()
    {
        $this->date = Carbon::now();
    }

    public static function new(): self
    {
        return new self();
    }

    public function hasCountryId(): bool
    {
        return $this->countryId !== null;
    }

    public function getCountryId(): ?int
    {
        return $this->countryId;
    }

    public function hasCurrencyId(): bool
    {
        return $this->currencyId !== null;
    }

    public function getCurrencyId(): ?int
    {
        return $this->currencyId;
    }

    public function hasDate(): bool
    {
        return $this->date !== null;
    }

    public function getDate(): ?Carbon
    {
        return $this->date;
    }

    public function hasPriceListSorting(): bool
    {
        return $this->priceListSorting !== null;
    }

    public function getPriceListSorting(): ?PriceListSortingEnum
    {
        return $this->priceListSorting;
    }

    public function buildFromUser(User $user): self
    {
        $this->countryId = $user->country_id;
        $this->currencyId = $user->currencyId;

        return $this;
    }

    public function buildFromRequest(FilterProductRequest $request): self
    {
        if ($request->filled('country_code')) {
            $country = (new Country())->findByCode($request->get('country_code'));
            if (empty($country)) {
                throw new HttpException(400, __('user.response_messages.invalid_country_code'));
            }
            $this->countryId = $country->id;
        }

        if ($request->filled('currency_code')) {
            $currency = (new Currency())->findByCode($request->get('currency_code'));
            if (empty($currency)) {
                throw new HttpException(400, __('user.response_messages.invalid_currency_code'));
            }
            $this->currencyId = $currency->id;
        }

        if ($request->filled('date')) {
            $this->date = $request->date('date');
        }

        if ($request->filled('order')) {
            $this->priceListSorting = $request->enum('order', PriceListSortingEnum::class);
        }

        return $this;
    }

    public function fallbackFromUser(User $user): self
    {
        $this->countryId = $this->countryId ?? $user->country_id;
        $this->currencyId = $this->currencyId ?? $user->currency_id;

        return $this;
    }
}
