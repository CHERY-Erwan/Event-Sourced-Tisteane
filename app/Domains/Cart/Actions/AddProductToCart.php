<?php

declare(strict_types=1);

namespace App\Domains\Cart\Actions;

use App\Domains\Cart\CartAggregateRoot;
use App\Domains\Cart\Projections\Cart;
use App\Domains\Shared\ValueObjects\ProductQuantity;
use App\Models\ProductVariant;

final class AddProductToCart
{
    public function __invoke(Cart $cart, ProductVariant $productVariant, ProductQuantity $quantity): Cart
    {
        CartAggregateRoot::retrieve(uuid: $cart->uuid)
            ->addProduct(
                productVariantUuid: $productVariant->uuid,
                quantity: $quantity,
                price: $productVariant->price,
            )
            ->persist();

        return $cart->refresh();
    }
}
