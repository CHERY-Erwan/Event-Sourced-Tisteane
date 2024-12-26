<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Collection;

/**
 * @property string $uuid
 * @property string $category_uuid
 * @property string $sku
 * @property string $slug
 * @property string $label
 * @property string $description
 * @property int $stock
 * @property bool $is_active
 * @property bool $is_featured
 * @property-read Collection<ProductVariant> $variants
 * @property-read Collection<ProductAttribute> $attributes
 */
class Product extends Model
{
    use HasFactory;
    use HasUuids;
    use HasTranslations;
    use SoftDeletes;

    protected $primaryKey = 'uuid';

    protected $fillable = ['uuid', 'category_uuid', 'sku', 'slug', 'label', 'description', 'stock', 'is_active', 'is_featured'];

    public $translatable = ['label', 'description'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_uuid', 'uuid');
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class, 'product_uuid', 'uuid');
    }
}
