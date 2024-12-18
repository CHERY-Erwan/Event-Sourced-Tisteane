<?php

namespace Tests\Unit\Domains\Cart;

use App\Domains\Cart\CartAggregateRoot;
use App\Domains\Cart\Events\CartInitialized;
use LogicException;
use Symfony\Component\Routing\Exception\InvalidParameterException;
use Tests\TestCase;

class CartAggregateRootTest extends TestCase
{
    public const CART_UUID = 'fake-cart-uuid';
    public const FAKE_SESSION_ID = 'fake-session-id';

    public function test_cart_can_be_initialized(): void
    {
        CartAggregateRoot::fake(self::CART_UUID)
            ->given([])
            ->when(fn(CartAggregateRoot $aggregate) => $aggregate->initializeCart(null, self::FAKE_SESSION_ID))
            ->assertRecorded([
                new CartInitialized(null, self::FAKE_SESSION_ID),
            ]);
    }

    public function test_cart_cannot_be_initialized_without_customer_or_session_id(): void
    {
        $this->expectException(InvalidParameterException::class);
        $this->expectExceptionMessage('Customer UUID or Session ID is required');

        CartAggregateRoot::fake(self::CART_UUID)
            ->given([])
            ->when(fn(CartAggregateRoot $aggregate) => $aggregate->initializeCart(null, null));
    }
}
