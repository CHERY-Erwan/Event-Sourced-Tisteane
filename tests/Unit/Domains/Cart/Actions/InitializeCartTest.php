<?php

namespace Tests\Unit\Domains\Cart\Actions;

use App\Domains\Cart\Actions\InitializeCart;
use App\Domains\Cart\Events\CartInitialized;
use App\Domains\Cart\Projections\Cart;
use Database\Factories\CartFactory;
use Tests\TestCase;

class InitializeCartTest extends TestCase
{
    public const CUSTOMER_UUID = 'fake-customer-uuid';
    public const SESSION_ID = 'fake-session-id';

    public function test_it_returns_existing_cart(): void
    {
        $existingCart = CartFactory::new()->create([
            'customer_uuid' => null,
            'session_id' => self::SESSION_ID,
        ]);

        $event = new CartInitialized(customerUuid: null, sessionId: self::SESSION_ID);

        $this->assertTrue($existingCart->is($event->getCart()));
    }

    // public function test_it_creates_new_cart_with_session_id(): void
    // {
    //     $this->assertDatabaseCount('carts', 0);

    //     $action = new InitializeCart();
    //     $result = $action(null, self::SESSION_ID);

    //     $this->assertNotNull($result);
    //     $this->assertDatabaseHas('carts', [
    //         'uuid' => $result->uuid,
    //         'customer_uuid' => null,
    //         'session_id' => self::SESSION_ID,
    //     ]);
    //     $this->assertDatabaseCount('carts', 1);
    // }

    // public function test_it_creates_new_cart_with_customer_uuid(): void
    // {
    //     $this->assertDatabaseCount('carts', 0);

    //     $action = new InitializeCart();
    //     $result = $action(self::CUSTOMER_UUID, null);

    //     $this->assertNotNull($result);
    //     $this->assertDatabaseHas('carts', [
    //         'uuid' => $result->uuid,
    //         'customer_uuid' => self::CUSTOMER_UUID,
    //         'session_id' => null,
    //     ]);
    //     $this->assertDatabaseCount('carts', 1);
    // }
}
