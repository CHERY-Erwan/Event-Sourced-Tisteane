<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasUuids;

    protected $fillable = ['cart_uuid', 'product_variant_uuid', 'bundle_uuid', 'quantity'];

    public function cart()
    {
        return $this->belongsTo(Cart::class, 'cart_uuid', 'uuid');
    }

    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_uuid');
    }

    public function bundle()
    {
        return $this->belongsTo(Bundle::class, 'bundle_uuid', 'uuid');
    }
}
