<?php

declare(strict_types=1);

namespace App\Domains\Cart\Projectors;

use App\Domains\Cart\CartAggregateRoot;
use App\Domains\Cart\Projections\Cart;
use App\Domains\Cart\Events\CartInitialized;
use App\Domains\Cart\Events\ProductAdded;
use App\Domains\Cart\Events\ProductQuantityUpdated;
use App\Domains\Cart\Events\ProductRemoved;
use App\Domains\Cart\Projections\CartItem;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class CartProjector extends Projector
{
    /**
     * @param CartInitialized $event
     * @return void
     */
    public function onCartInitialized(CartInitialized $event): void
    {
        Cart::new()
            ->writeable()
            ->create([
                'uuid' => $event->aggregateRootUuid(),
                'customer_uuid' => $event->customerUuid,
                'session_id' => $event->sessionId,
            ]);
    }

    /**
     * @param ProductAdded $event
     * @return void
     */
    public function onProductAdded(ProductAdded $event): void
    {
        CartItem::new()
            ->writeable()
            ->create([
                'cart_uuid' => $event->aggregateRootUuid(),
                'product_variant_uuid' => $event->productVariantUuid,
                'bundle_uuid' => null,
                'quantity' => $event->quantity,
            ]);
    }

    /**
     * @param ProductQuantityUpdated $event
     * @return void
     */
    public function onProductQuantityUpdated(ProductQuantityUpdated $event): void
    {
        CartItem::query()
            ->where('product_variant_uuid', $event->productVariantUuid)
            ->tap(function ($cartItem) use ($event) {
                match ($event->type) {
                    CartAggregateRoot::PRODUCT_QUANTITY_UPDATED_TYPE_ADD => $cartItem->increment('quantity', $event->quantity),
                    CartAggregateRoot::PRODUCT_QUANTITY_UPDATED_TYPE_REMOVE => $cartItem->decrement('quantity', $event->quantity),
                    CartAggregateRoot::PRODUCT_QUANTITY_UPDATED_TYPE_UPDATE => $cartItem->update(['quantity' => $event->quantity]),
                };
            })
            ->tap(function ($cartItem) {
                if ($cartItem->value('quantity') <= 0) {
                    $cartItem->delete();
                }
            });
    }

    /**
     * @param ProductRemoved $event
     * @return void
     */
    public function onProductRemoved(ProductRemoved $event): void
    {
        CartItem::query()
            ->where('product_variant_uuid', $event->productVariantUuid)
            ->delete();
    }
}
