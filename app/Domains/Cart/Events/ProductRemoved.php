<?php

declare(strict_types=1);

namespace App\Domains\Cart\Events;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class ProductRemoved extends ShouldBeStored
{
    public function __construct(
        public string $productVariantUuid,
    ) {}
}
