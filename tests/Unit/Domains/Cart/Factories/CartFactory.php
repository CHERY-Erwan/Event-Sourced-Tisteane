<?php

namespace Tests\Unit\Domains\Cart\Factories;

use App\Domains\Cart\Projections\Cart;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CartFactory
{
    protected array $attributes = [];

    public static function new(): self
    {
        return new self();
    }

    public function withCustomerUuid(string $customerUuid): self
    {
        $this->attributes['customer_uuid'] = $customerUuid;
        return $this;
    }

    public function withSessionId(string $sessionId): self
    {
        $this->attributes['session_id'] = $sessionId;
        return $this;
    }

    public function create(): Cart
    {
        return Cart::new()
            ->writeable()
            ->create(array_merge([
                'uuid' => Str::uuid()->toString(),
                'customer_uuid' => null,
                'session_id' => null,
            ], $this->attributes));
    }
}
