<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Domains\Cart\Actions\InitializeCart;
use App\Domains\Shared\ValueObjects\CartIdentifiers;

class TestController extends Controller
{
    public function index()
    {
        $cart = (new InitializeCart)(
            CartIdentifiers::with(
                customerUuid: null,
                sessionId: session()->getId()
            )
        );

        dd($cart);
    }
}
