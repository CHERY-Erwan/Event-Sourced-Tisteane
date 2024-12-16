<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class ProductVariant extends Model
{
    use HasFactory;
    use HasUuids;
    use HasTranslations;

    protected $fillable = [
        'id', 'product_id', 'sku', 'slug', 'size', 'color', 'price', 'is_active',
    ];

    public $translatable = ['size', 'color'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function attributes()
    {
        return $this->hasMany(ProductAttribute::class, 'product_variant_id');
    }
}
