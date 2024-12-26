<?php

namespace App\Models;

use App\Domains\Shared\Casts\PriceCast;
use App\Domains\Shared\ValueObjects\Price;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Collection;

/**
 * @property string $uuid
 * @property string $product_uuid
 * @property string $sku
 * @property string $slug
 * @property string $size
 * @property string $color
 * @property Price $price
 * @property bool $is_active
 * @property-read Product $product
 * @property-read Collection<ProductAttribute> $attributes
 */
class ProductVariant extends Model
{
    use HasFactory;
    use HasUuids;
    use HasTranslations;

    protected $primaryKey = 'uuid';

    protected $fillable = ['uuid', 'product_uuid', 'sku', 'slug', 'size', 'color', 'price', 'is_active'];

    public $translatable = ['size', 'color'];

    protected $casts = [
        'price' => PriceCast::class,
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_uuid', 'uuid');
    }

    public function attributes()
    {
        return $this->hasMany(ProductAttribute::class, 'product_variant_uuid');
    }
}
