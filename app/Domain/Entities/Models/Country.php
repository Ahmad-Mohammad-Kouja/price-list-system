<?php

namespace App\Domain\Entities\Models;

use Cache;
use Database\Factories\Entities\CountryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $table = 'countries';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'name',
    ];

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory<static>
     */
    protected static function newFactory()
    {
        return CountryFactory::new();
    }

    public function findByCode(string $code): ?self
    {
        return Cache::rememberForever(
            "countries.{$code}",
            fn() => self::query()->where('code', $code)->first(),
        );
    }
}
