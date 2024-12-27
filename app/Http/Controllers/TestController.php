<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Domains\Cart\Actions\AddProduct;
use App\Domains\Cart\Actions\InitializeCart;
use App\Domains\Cart\Actions\RemoveProduct;
use App\Domains\Cart\Actions\UpdateProductQuantity;
use App\Domains\Cart\Projections\CartItem;
use App\Domains\Shared\ValueObjects\CartIdentifiers;
use App\Domains\Shared\ValueObjects\ProductQuantity;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

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
        $variant = $product?->variants()->where('sku', 'LEO-S-BLUE')->first();

        /** @var ProductAttribute $attribute */
        $attribute = $variant?->attributes()?->first();

        $cart = (new InitializeCart)(
            CartIdentifiers::with(
                customerUuid: null,
                sessionId: session()->getId()
            )
        );

        $cart = (new AddProduct)(
            cart: $cart,
            productVariant: $variant,
            quantity: ProductQuantity::from(2)
        );

        dd($cart);
    }

    public function addBundle()
    {
        dd('addBundle');
    }

    public function updateItemQuantity(Request $request)
    {
        $item = CartItem::query()->where('product_variant_uuid', $request->item_uuid)->first();

        $cart = (new UpdateProductQuantity)(
            cart: $item->cart,
            productVariant: $item->productVariant,
            quantity: ProductQuantity::from((int) $request->quantity)
        );

        return redirect()->route('test');
    }

    public function removeItem(Request $request)
    {
        $item = CartItem::query()->where('product_variant_uuid', $request->item_uuid)->first();

        $cart = (new RemoveProduct)(
            cart: $item->cart,
            productVariant: $item->productVariant,
        );

        return redirect()->route('test');
    }
}
