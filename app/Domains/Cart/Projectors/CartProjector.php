<?php

namespace App\Domains\Cart\Projectors;

use App\Domains\Cart\Projections\Cart;
use App\Domains\Cart\Events\CartInitialized;
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
}
