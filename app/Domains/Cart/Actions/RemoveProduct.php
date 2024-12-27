<?php

declare(strict_types=1);

namespace App\Domains\Cart\Actions;

use App\Domains\Cart\CartAggregateRoot;
use App\Domains\Cart\Projections\Cart;
use App\Models\ProductVariant;

final class RemoveProduct
{
    public function __invoke(Cart $cart, ProductVariant $productVariant): Cart
    {
        CartAggregateRoot::retrieve(uuid: $cart->uuid)
            ->removeProduct(
                productVariantUuid: $productVariant->uuid,
            )
            ->persist();

        return $cart->refresh();
    }
}
