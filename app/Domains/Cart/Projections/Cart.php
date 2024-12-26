<?php

namespace App\Domains\Cart\Projections;

use App\Casts\UuidCast;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\EventSourcing\Projections\Projection;
use Ramsey\Uuid\UuidInterface;

/**
 * @property UuidInterface $uuid
 * @property UuidInterface $customer_uuid
 * @property string $session_id
 * @property-read Collection<CartItem> $items
 */
class Cart extends Projection
{
    use HasUuids;

    protected $primaryKey = 'uuid';

    protected $fillable = ['uuid', 'customer_uuid', 'session_id'];

    protected $casts = [
        'uuid' => UuidCast::class,
        'customer_uuid' => UuidCast::class,
        'session_id' => 'string',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class, 'cart_uuid', 'uuid');
    }
}
