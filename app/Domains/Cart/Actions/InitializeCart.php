<?php

namespace App\Domains\Cart\Actions;

use App\Domains\Cart\CartAggregateRoot;
use App\Domains\Cart\Projections\Cart;
use App\Domains\Shared\ValueObjects\CartIdentifiers;
use Illuminate\Support\Str;
use LogicException;

final class InitializeCart
{
    public function __invoke(CartIdentifiers $cartIdentifiers): Cart
    {
        $existingCart = Cart::query()
            ->when($cartIdentifiers->isRegisteredUser(), fn($query) => $query->where('customer_uuid', $cartIdentifiers->customerUuid))
            ->when($cartIdentifiers->isGuest(), fn($query) => $query->where('session_id', $cartIdentifiers->sessionId))
            ->first();

        if ($existingCart) {
            return $existingCart;
        }

        $cartUuid = Str::uuid()->toString();

        CartAggregateRoot::retrieve(uuid: $cartUuid)
            ->initializeCart(cartIdentifiers: $cartIdentifiers)
            ->persist();

        $cart = Cart::findOrFail($cartUuid);

        if (!$cart) {
            throw new LogicException('Cart not initialized.');
        }

        return $cart;
    }
}
