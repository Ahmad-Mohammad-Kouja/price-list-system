<?php

namespace App\Domain\Inventories\Enum;

enum PriceListSortingEnum: string
{
    case HIGHEST_TO_LOWEST = 'highest_to_lowest';
    case LOWEST_TO_HIGHEST = 'lowest_to_highest';

    public function getSorting(): string
    {
        return match ($this->value) {
            self::HIGHEST_TO_LOWEST->value => 'desc',
            self::HIGHEST_TO_LOWEST => 'asc',
            default => 'asc',
        };
    }
}
