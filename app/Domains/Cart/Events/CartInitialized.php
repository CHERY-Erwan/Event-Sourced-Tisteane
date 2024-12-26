<?php

namespace App\Domains\Cart\Events;

use App\Domains\Shared\ValueObjects\CartIdentifiers;
use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class CartInitialized extends ShouldBeStored
{
    public function __construct(
        public CartIdentifiers $cartIdentifiers,
    ) {}
}
