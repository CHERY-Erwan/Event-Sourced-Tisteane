<?php

declare(strict_types=1);

namespace App\Casts;

use App\Domains\Shared\ValueObjects\Price;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class PriceCast implements CastsAttributes
{
    /**
     * Transforme une valeur brute de la base de données en une instance de Price.
     */
    public function get($model, string $key, $value, array $attributes): Price
    {
        return Price::from((int) $value);
    }

    /**
     * Transforme une instance de Price en une valeur brute pour la base de données.
     */
    public function set($model, string $key, $value, array $attributes): int
    {
        if ($value instanceof Price) {
            return $value->amount();
        }

        throw new \InvalidArgumentException('The given value is not a Price instance.');
    }
}
