<?php

declare(strict_types=1);

namespace App\Domains\Cart\Projections;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\EventSourcing\Projections\Projection;

/**
 * @property string $uuid
 * @property string $customer_uuid
 * @property string $session_id
 * @property-read Collection<CartItem> $items
 *
 * @method static Builder<static>|Cart whereHasProductVariant(string $productVariantUuid)
 * @method static Builder<static>|Cart whereHasBundle(string $bundleUuid)
 */
class Cart extends Projection
{
    use HasUuids;

    protected $primaryKey = 'uuid';

    protected $fillable = ['uuid', 'customer_uuid', 'session_id'];

    protected $casts = [
        'session_id' => 'string',
    ];

    protected $with = ['items'];

    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class, 'cart_uuid', 'uuid');
    }

    /**
     * @param Builder<Cart> $query
     * @param string $productVariantUuid
     *
     * @return Builder<Cart>
     */
    public function scopeWhereHasProductVariant(Builder $query, string $productVariantUuid): Builder
    {
        return $query->whereHas('items', fn (Builder $query) => $query->where('product_variant_uuid', $productVariantUuid));
    }

    /**
     * @param Builder<Cart> $query
     * @param string $bundleUuid
     *
     * @return Builder<Cart>
     */
    public function scopeWhereHasBundle(Builder $query, string $bundleUuid): Builder
    {
        return $query->whereHas('items', fn (Builder $query) => $query->where('bundle_uuid', $bundleUuid));
    }
}
