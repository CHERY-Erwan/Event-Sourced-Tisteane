<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductVariant;
use App\Models\ProductAttribute;

class ProductAttributeSeeder extends Seeder
{
    public function run()
    {
        $attributes = [
            [
                'product_variant_uuid' => ProductVariant::where('sku', 'LEO-S-RED')->first()->uuid,
                'key' => 'Battery Life',
                'value' => '10 hours',
            ],
            [
                'product_variant_uuid' => ProductVariant::where('sku', 'LEO-S-RED')->first()->uuid,
                'key' => 'Material',
                'value' => 'Bamboo',
            ],
            [
                'product_variant_uuid' => ProductVariant::where('sku', 'LEO-S-BLUE')->first()->uuid,
                'key' => 'Material',
                'value' => 'Recycled Plastic',
            ],
            [
                'product_variant_uuid' => ProductVariant::where('sku', 'LEO-M-RED')->first()->uuid,
                'key' => 'Wood Type',
                'value' => 'Oak',
            ],
        ];

        foreach ($attributes as $attribute) {
            ProductAttribute::create($attribute);
        }
    }
}
