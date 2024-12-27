<?php

declare(strict_types=1);

namespace App\Domains\Cart\Projections;

use App\Models\Bundle;
use App\Models\ProductVariant;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\EventSourcing\Projections\Projection;

/**
 * @property string $cart_uuid
 * @property string $product_variant_uuid
 * @property string $bundle_uuid
 * @property int $quantity
 * @property-read Cart $cart
 * @property-read ProductVariant $productVariant
 * @property-read Bundle $bundle
 */
class CartItem extends Projection
{
    protected $fillable = ['cart_uuid', 'product_variant_uuid', 'bundle_uuid', 'quantity'];

    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class, 'cart_uuid', 'uuid');
    }

    public function productVariant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_uuid', 'uuid');
    }

    public function bundle(): BelongsTo
    {
        return $this->belongsTo(Bundle::class, 'bundle_uuid', 'uuid');
    }
}
