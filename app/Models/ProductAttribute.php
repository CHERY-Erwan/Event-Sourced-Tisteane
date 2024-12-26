<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property string $product_variant_uuid
 * @property string $key
 * @property string $value
 * @property-read ProductVariant $variant
 */
class ProductAttribute extends Model
{
    use HasFactory;

    protected $fillable = ['product_variant_uuid', 'key', 'value'];

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_uuid');
    }
}
