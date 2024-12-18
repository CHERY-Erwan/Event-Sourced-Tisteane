<?php

namespace App\Domains\Cart\Actions;

use App\Domains\Cart\CartAggregateRoot;
use App\Domains\Cart\Projections\Cart;
use Illuminate\Support\Str;

class InitializeCart
{
    public function __invoke(?string $customerUuid, ?string $sessionId): Cart
    {
        $existingCart = Cart::query()
            ->when($customerUuid, fn($query) => $query->where('customer_uuid', $customerUuid))
            ->when($sessionId, fn($query) => $query->where('session_id', $sessionId))
            ->first();

        if ($existingCart) {
            return $existingCart;
        }

        $cartUuid = Str::uuid();

        CartAggregateRoot::retrieve($cartUuid)
            ->initializeCart($customerUuid, $sessionId)
            ->persist();

        return Cart::find($cartUuid);
    }
}
