<?php

namespace Tests\Unit\Domains\Cart\Actions;

use App\Domains\Cart\Actions\InitializeCart;
use App\Domains\Shared\ValueObjects\CartIdentifiers;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\Routing\Exception\InvalidParameterException;
use Tests\Unit\Domains\Cart\Factories\CartFactory;

use function Pest\Laravel\assertDatabaseCount;
use function PHPUnit\Framework\assertEquals;

uses(RefreshDatabase::class);

it('returns a new cart for a guest', function () {
    $cart = (new InitializeCart)(new CartIdentifiers(
        customerUuid: null,
        sessionId: session()->getId()
    ));

    assertEquals($cart->customer_uuid, null);
    assertEquals($cart->session_id, session()->getId());
});

it('cannot initialize a cart without a session id or a customer uuid', function () {
    (new InitializeCart)(new CartIdentifiers(
        customerUuid: null,
        sessionId: null
    ));
})->throws(InvalidParameterException::class);

it('does not create a cart if one already exists', function () {
    $customerUuid = Str::uuid()->toString();

    $existingCart = CartFactory::new()
        ->withCustomerUuid($customerUuid)
        ->create();

    assertDatabaseCount('carts', 1);

    $cart = (new InitializeCart)(new CartIdentifiers(
        customerUuid: $customerUuid,
        sessionId: null
    ));

    assertDatabaseCount('carts', 1);
    expect($cart->uuid)->toBe($existingCart->uuid);
});

it('returns an existing cart for a registered customer', function () {
    $customerUuid = Str::uuid()->toString();

    $existingCart = CartFactory::new()
        ->withCustomerUuid($customerUuid)
        ->create();

    $cart = (new InitializeCart)(new CartIdentifiers(
        customerUuid: $customerUuid,
        sessionId: null
    ));

    expect($cart->uuid)->toBe($existingCart->uuid);
});
