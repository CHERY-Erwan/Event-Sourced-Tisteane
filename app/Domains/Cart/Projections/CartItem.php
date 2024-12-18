<?php

namespace App\Domains\Cart\Projections;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\EventSourcing\Projections\Projection;

/**
 * @property string $uuid
 * @property string $cart_uuid
 * @property string $product_variant_uuid
 * @property string $bundle_uuid
 * @property int $quantity
 * @property-read Cart $cart
 */
class CartItem extends Projection
{
    use HasUuids;

    protected $fillable = ['uuid', 'cart_uuid', 'product_variant_uuid', 'bundle_uuid', 'quantity'];

    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class, 'cart_uuid', 'uuid');
    }
}
