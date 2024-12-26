<?php

namespace App\Domains\Cart;

use App\Domains\Cart\Events\CartInitialized;
use App\Domains\Shared\ValueObjects\CartIdentifiers;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

class CartAggregateRoot extends AggregateRoot
{
    protected CartIdentifiers $cartIdentifiers;

    /**
     * Initialise un panier pour un client ou une session.
     *
     * @param CartIdentifiers $cartIdentifiers
     * @return self
     */
    public function initializeCart(CartIdentifiers $cartIdentifiers): self
    {
        $this->recordThat(new CartInitialized(
            cartIdentifiers: $cartIdentifiers,
        ));

        return $this;
    }

    /**
     * Applique les effets de l'événement `CartInitialized`.
     *
     * @param CartInitialized $event
     */
    protected function applyCartInitialized(CartInitialized $event): void
    {
        $this->cartIdentifiers = $event->cartIdentifiers;
    }
}
