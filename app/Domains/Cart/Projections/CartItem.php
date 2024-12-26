<?php

declare(strict_types=1);

namespace App\Domains\Cart\Projections;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\EventSourcing\Projections\Projection;

/**
 * @property string $cart_uuid
 * @property string $product_variant_uuid
 * @property string $bundle_uuid
 * @property int $quantity
 * @property-read Cart $cart
 */
class CartItem extends Projection
{
    protected $fillable = ['cart_uuid', 'product_variant_uuid', 'bundle_uuid', 'quantity'];

    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class, 'cart_uuid', 'uuid');
    }
}
