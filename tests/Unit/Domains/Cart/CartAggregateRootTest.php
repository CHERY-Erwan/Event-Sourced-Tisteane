<?php

namespace Tests\Unit\Domains\Cart;

use App\Domains\Cart\CartAggregateRoot;
use App\Domains\Cart\Events\CartInitialized;
use App\Domains\Shared\ValueObjects\CartIdentifiers;

const FAKE_SESSION_ID = 'A1bC2dE3fG4hI5jK6L7mN8oP9qR0sT1uV';
const CART_UUID = 'fake-cart-uuid-must-be-valid';

it('can initialize a cart', function () {
    CartAggregateRoot::fake(CART_UUID)
        ->given([])
        ->when(fn(CartAggregateRoot $aggregate) => $aggregate->initializeCart(CartIdentifiers::with(null, FAKE_SESSION_ID)))
        ->assertRecorded([
            new CartInitialized(null, FAKE_SESSION_ID),
        ]);
});
