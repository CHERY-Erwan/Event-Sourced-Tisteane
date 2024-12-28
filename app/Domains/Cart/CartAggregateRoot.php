<?php

declare(strict_types=1);

namespace App\Domains\Cart;

use App\Domains\Cart\Events\CartInitialized;
use App\Domains\Cart\Events\ProductAdded;
use App\Domains\Cart\Events\ProductQuantityUpdated;
use App\Domains\Cart\Events\ProductRemoved;
use App\Domains\Cart\Projections\CartItem;
use App\Domains\Shared\ValueObjects\CartIdentifiers;
use App\Domains\Shared\ValueObjects\Price;
use App\Domains\Shared\ValueObjects\ProductQuantity;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

class CartAggregateRoot extends AggregateRoot
{
    public CartIdentifiers $cartIdentifiers;

    /** @var array<string, CartItem> */
    public array $cartItems = [];

    public const PRODUCT_QUANTITY_UPDATED_TYPE_ADD = 'add';
    public const PRODUCT_QUANTITY_UPDATED_TYPE_REMOVE = 'remove';
    public const PRODUCT_QUANTITY_UPDATED_TYPE_UPDATE = 'update';

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
        if (isset($this->cartItems[$productVariantUuid])) {
            $this->recordThat(new ProductQuantityUpdated(
                productVariantUuid: $productVariantUuid,
                quantity: $quantity->quantity(),
            ));

            return $this;
        }

        $this->recordThat(new ProductAdded(
            productVariantUuid: $productVariantUuid,
            quantity: $quantity->quantity(),
            price: $price->amount(),
        ));

        return $this;
    }

    /**
     * Met à jour la quantité d'un item du panier.
     *
     * @param string $productVariantUuid
     * @param ProductQuantity $quantity
     * @return self
     */
    public function updateProductQuantity(string $productVariantUuid, ProductQuantity $quantity): self
    {
        if ($quantity->isZero()) {
            $this->recordThat(new ProductRemoved(
                productVariantUuid: $productVariantUuid,
            ));

            return $this;
        }

        $this->recordThat(new ProductQuantityUpdated(
            productVariantUuid: $productVariantUuid,
            quantity: $quantity->quantity(),
        ));

        return $this;
    }

    /**
     * Supprime un item du panier.
     *
     * @param string $productVariantUuid
     * @return self
     */
    public function removeProduct(string $productVariantUuid): self
    {
        $this->recordThat(new ProductRemoved(
            productVariantUuid: $productVariantUuid,
        ));

        return $this;
    }

    /**
     * Applique les effets de l'événement `CartInitialized`.
     *
     * @param CartInitialized $event
     * @return void
     */
    protected function applyCartInitialized(CartInitialized $event): void
    {
        $this->cartIdentifiers = new CartIdentifiers(
            customerUuid: $event->customerUuid,
            sessionId: $event->sessionId,
        );
    }

    /**
     * @param ProductAdded $event
     * @return void
     */
    protected function applyProductAdded(ProductAdded $event): void
    {
        $this->cartItems[$event->productVariantUuid] = [
            'productVariantUuid' => $event->productVariantUuid,
            'quantity' => $event->quantity,
            'price' => $event->price,
        ];
    }

    /**
     * @param ProductQuantityUpdated $event
     * @return void
     */
    protected function applyProductQuantityUpdated(ProductQuantityUpdated $event): void
    {
        if ($event->quantity === 0) {
            unset($this->cartItems[$event->productVariantUuid]);

            return;
        }

        $this->cartItems[$event->productVariantUuid]['quantity'] = $event->quantity;
    }

    /**
     * @param ProductRemoved $event
     * @return void
     */
    protected function applyProductRemoved(ProductRemoved $event): void
    {
        unset($this->cartItems[$event->productVariantUuid]);
    }
}
