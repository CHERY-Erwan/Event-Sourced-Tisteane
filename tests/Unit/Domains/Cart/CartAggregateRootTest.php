<?php

namespace Tests\Unit\Domains\Cart;

use App\Domains\Cart\CartAggregateRoot;
use App\Domains\Cart\Events\CartInitialized;
use App\Domains\Cart\Events\ProductAdded;
use App\Domains\Cart\Events\ProductQuantityUpdated;
use App\Domains\Cart\Events\ProductRemoved;
use App\Domains\Shared\ValueObjects\CartIdentifiers;
use App\Domains\Shared\ValueObjects\Price;
use App\Domains\Shared\ValueObjects\ProductQuantity;

const FAKE_SESSION_ID = 'A1bC2dE3fG4hI5jK6L7mN8oP9qR0sT1uV';
const CART_UUID = 'fake-cart-uuid-must-be-valid';
const FAKE_PRODUCT_VARIANT_UUID = 'fake-product-variant-uuid';
const FAKE_PRODUCT_VARIANT_UUID_2 = 'fake-product-variant-uuid-2';

it('can initialize a cart', function () {
    CartAggregateRoot::fake(CART_UUID)
        ->given([])
        ->when(fn(CartAggregateRoot $aggregate) => $aggregate->initializeCart(CartIdentifiers::with(null, FAKE_SESSION_ID)))
        ->assertRecorded([
            new CartInitialized(null, FAKE_SESSION_ID),
        ]);
});

it('can add a product to the cart', function () {
    CartAggregateRoot::fake(CART_UUID)
        ->given([])
        ->when(fn(CartAggregateRoot $aggregate) => $aggregate->addProduct(productVariantUuid: FAKE_PRODUCT_VARIANT_UUID, quantity: ProductQuantity::from(1), price: Price::from(100)))
        ->assertRecorded([
            new ProductAdded(productVariantUuid: FAKE_PRODUCT_VARIANT_UUID, quantity: 1, price: 100),
        ]);
});

it('can update the quantity of a product in the cart', function () {
    CartAggregateRoot::fake(CART_UUID)
        ->given([
            new ProductAdded(productVariantUuid: FAKE_PRODUCT_VARIANT_UUID, quantity: 1, price: 100),
        ])
        ->when(fn(CartAggregateRoot $aggregate) => $aggregate->updateProductQuantity(productVariantUuid: FAKE_PRODUCT_VARIANT_UUID, quantity: ProductQuantity::from(1)))
        ->assertRecorded([
            new ProductQuantityUpdated(productVariantUuid: FAKE_PRODUCT_VARIANT_UUID, quantity: 1),
        ])
        ->assertNotRecorded(ProductAdded::class);
});

it('removes a product from the cart when the quantity is set to 0', function () {
    CartAggregateRoot::fake(CART_UUID)
        ->given([
            new ProductAdded(productVariantUuid: FAKE_PRODUCT_VARIANT_UUID, quantity: 1, price: 100),
        ])
        ->when(fn(CartAggregateRoot $aggregate) => $aggregate->updateProductQuantity(productVariantUuid: FAKE_PRODUCT_VARIANT_UUID, quantity: ProductQuantity::from(0)))
        ->assertRecorded([
            new ProductRemoved(productVariantUuid: FAKE_PRODUCT_VARIANT_UUID),
        ])
        ->assertNotRecorded(ProductQuantityUpdated::class);
});


it('can remove a product from the cart', function () {
    CartAggregateRoot::fake(CART_UUID)
        ->given([
            new ProductAdded(productVariantUuid: FAKE_PRODUCT_VARIANT_UUID, quantity: 1, price: 100),
        ])
        ->when(fn(CartAggregateRoot $aggregate) => $aggregate->removeProduct(productVariantUuid: FAKE_PRODUCT_VARIANT_UUID))
        ->assertRecorded([
            new ProductRemoved(productVariantUuid: FAKE_PRODUCT_VARIANT_UUID),
        ]);
});

it('updates the quantity of a product in the cart when adding the same product variant', function () {
    CartAggregateRoot::fake(CART_UUID)
        ->given([
            new ProductAdded(productVariantUuid: FAKE_PRODUCT_VARIANT_UUID, quantity: 1, price: 100),
        ])
        ->when(fn(CartAggregateRoot $aggregate) => $aggregate->addProduct(productVariantUuid: FAKE_PRODUCT_VARIANT_UUID, quantity: ProductQuantity::from(1), price: Price::from(100)))
        ->assertRecorded([
            new ProductQuantityUpdated(productVariantUuid: FAKE_PRODUCT_VARIANT_UUID, quantity: 1),
        ])
        ->assertNotRecorded(ProductAdded::class);
});
