<?php

namespace App\Domain\Entities\Models;

use Database\Factories\Entities\CurrencyFactory;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class Currency extends Model
{
    use HasFactory;

    protected $table = 'currencies';

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
        return CurrencyFactory::new();
    }

    public function findByCode(string $code): ?self
    {
        try {
            return Cache::rememberForever(
                "currencies.{$code}",
                fn() => self::query()->where('code', $code)->first(),
            );
        } catch (Exception $exception) {
            Log::warning("error on get currency: $code from cache, exception: {$exception->getMessage()}");
        }

        return null;
    }
}
