<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Domains\Cart\Actions\AddProductToCart;
use App\Domains\Cart\Actions\InitializeCart;
use App\Domains\Shared\ValueObjects\CartIdentifiers;
use App\Domains\Shared\ValueObjects\ProductQuantity;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductVariant;

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

        return view('test', compact('cart'));
    }

    public function addItem()
    {
        /** @var Product $product */
        $product = Product::where('sku', 'LEO-001')->first();

        /** @var ProductVariant $variant */
        $variant = $product?->variants()?->first();

        /** @var ProductAttribute $attribute */
        $attribute = $variant?->attributes()?->first();

        $cart = (new InitializeCart)(
            CartIdentifiers::with(
                customerUuid: null,
                sessionId: session()->getId()
            )
        );

        $cart = (new AddProductToCart)(
            cart: $cart,
            productVariant: $variant,
            quantity: ProductQuantity::from(12)
        );

        dd($cart);
    }

    public function addBundle()
    {
        dd('addBundle');
    }
}
