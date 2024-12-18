<?php

namespace App\Domains\Cart\Events;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class CartInitialized extends ShouldBeStored
{
    public function __construct(
        public ?string $customerUuid,
        public ?string $sessionId,
    ) {}
}
