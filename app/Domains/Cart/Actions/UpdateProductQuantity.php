<?php

declare(strict_types=1);

namespace App\Domains\Cart\Actions;

use App\Domains\Cart\CartAggregateRoot;
use App\Domains\Cart\Projections\Cart;
use App\Domains\Shared\ValueObjects\ProductQuantity;
use App\Models\ProductVariant;

final class UpdateProductQuantity
{
    public function __invoke(Cart $cart, ProductVariant $productVariant, ProductQuantity $quantity): Cart
    {
        CartAggregateRoot::retrieve(uuid: $cart->uuid)
            ->updateProductQuantity(
                productVariantUuid: $productVariant->uuid,
                quantity: $quantity,
            )
            ->persist();

        return $cart->refresh();
    }
}
