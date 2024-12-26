<?php

namespace Tests\Unit\Domains\Cart\Projectors;

use App\Domains\Cart\CartAggregateRoot;
use App\Domains\Cart\Events\CartInitialized;
use App\Domains\Cart\Projections\Cart;
use App\Domains\Cart\Projectors\CartProjector;
use App\Domains\Shared\ValueObjects\CartIdentifiers;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Spatie\EventSourcing\Facades\Projectionist;
use function Pest\Laravel\assertDatabaseCount;

uses(RefreshDatabase::class);

const FAKE_SESSION_ID = 'A1bC2dE3fG4hI5jK6L7mN8oP9qR0sT1uV';
const CART_UUID = 'fake-cart-uuid-must-be-valid';

it('creates a cart when the CartInitialized event is handled by the projector', function () {
    // assertDatabaseCount('carts', 0);

    // CartAggregateRoot::retrieve(CART_UUID)
    //     ->initializeCart(CartIdentifiers::with(null, FAKE_SESSION_ID))
    //     ->persist();

    // assertDatabaseCount('carts', 1);
});
