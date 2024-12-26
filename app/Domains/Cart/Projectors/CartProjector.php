<?php

declare(strict_types=1);

namespace App\Domains\Cart\Projectors;

use App\Domains\Cart\Projections\Cart;
use App\Domains\Cart\Events\CartInitialized;
use App\Domains\Cart\Events\ProductAddedToCart;
use App\Domains\Cart\Projections\CartItem;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class CartProjector extends Projector
{
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

    public function onProductAddedToCart(ProductAddedToCart $event): void
    {
        $cart = Cart::query()
            ->whereHasProductVariant($event->productVariantUuid)
            ->first();

        dd($cart);

        CartItem::new()
            ->writeable()
            ->create([
                'cart_uuid' => $event->aggregateRootUuid(),
                'product_variant_uuid' => $event->productVariantUuid,
                'bundle_uuid' => null,
                'quantity' => $event->quantity,
            ]);
    }
}
