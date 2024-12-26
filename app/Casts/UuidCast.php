<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Ramsey\Uuid\Uuid;
use InvalidArgumentException;

class UuidCast implements CastsAttributes
{
    /**
     * Cast the given value to a UUID string.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return string|null
     */
    public function get($model, $key, $value, $attributes): ?string
    {
        return $value ? (string) Uuid::fromString($value) : null;
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return string|null
     */
    public function set($model, $key, $value, $attributes): ?string
    {
        if (is_null($value)) {
            return null;
        }

        if (!Uuid::isValid($value)) {
            throw new InvalidArgumentException("The value for {$key} must be a valid UUID.");
        }

        return (string) $value;
    }
}
