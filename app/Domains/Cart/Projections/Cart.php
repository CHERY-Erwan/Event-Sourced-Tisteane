<?php

declare(strict_types=1);

namespace App\Domains\Cart\Projections;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\EventSourcing\Projections\Projection;

/**
 * @property string $uuid
 * @property string $customer_uuid
 * @property string $session_id
 * @property-read Collection<CartItem> $items
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
}
