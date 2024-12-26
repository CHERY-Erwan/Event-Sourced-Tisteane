<?php

declare(strict_types=1);

namespace App\Domains\Cart;

use App\Domains\Cart\Events\CartInitialized;
use App\Domains\Cart\Events\ProductAddedToCart;
use App\Domains\Cart\Projections\Cart;
use App\Domains\Shared\ValueObjects\CartIdentifiers;
use App\Domains\Shared\ValueObjects\Price;
use App\Domains\Shared\ValueObjects\ProductQuantity;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

class CartAggregateRoot extends AggregateRoot
{
    protected CartIdentifiers $cartIdentifiers;
    protected Cart $cart;

    /**
     * Initialise un panier pour un client ou une session.
     *
     * @param CartIdentifiers $cartIdentifiers
     * @return self
     */
    public function initializeCart(CartIdentifiers $cartIdentifiers): self
    {
        $this->recordThat(new CartInitialized(
            customerUuid: $cartIdentifiers->customerUuid(),
            sessionId: $cartIdentifiers->sessionId(),
        ));

        return $this;
    }

    /**
     * Ajoute un item au panier.
     *
     * @param string $productUuid
     * @param ProductQuantity $quantity
     * @param Price $price
     * @return self
     */
    public function addProduct(string $productVariantUuid, ProductQuantity $quantity, Price $price): self
    {
        $this->recordThat(new ProductAddedToCart(
            productVariantUuid: $productVariantUuid,
            quantity: $quantity->quantity(),
            price: $price->amount(),
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
        $this->cartIdentifiers = new CartIdentifiers(
            customerUuid: $event->customerUuid,
            sessionId: $event->sessionId,
        );
    }
}
