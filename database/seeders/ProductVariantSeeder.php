<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\ProductVariant;

class ProductVariantSeeder extends Seeder
{
    public function run()
    {
        $variants = [
            [
                'uuid' => Str::uuid(),
                'product_uuid' => Product::where('slug', 'leonardo-solar-lamp')->first()->uuid,
                'sku' => 'LEO-S-RED',
                'slug' => 'leonardo-solar-lamp-red-small',
                'size' => ['en' => 'Small', 'fr' => 'Petit'],
                'color' => ['en' => 'Purple Red', 'fr' => 'Rouge pourpre'],
                'price' => 1999,
                'is_active' => true,
            ],
            [
                'uuid' => Str::uuid(),
                'product_uuid' => Product::where('slug', 'leonardo-solar-lamp')->first()->uuid,
                'sku' => 'LEO-S-BLUE',
                'slug' => 'leonardo-solar-lamp-blue-small',
                'size' => ['en' => 'Small', 'fr' => 'Petit'],
                'color' => ['en' => 'Azure Blue', 'fr' => 'Bleu azure'],
                'price' => 1499,
                'is_active' => true,
            ],
            [
                'uuid' => Str::uuid(),
                'product_uuid' => Product::where('slug', 'leonardo-solar-lamp')->first()->uuid,
                'sku' => 'LEO-M-RED',
                'slug' => 'leonardo-solar-lamp-red-medium',
                'size' => ['en' => 'Medium', 'fr' => 'Moyen'],
                'color' => ['en' => 'Purple Red', 'fr' => 'Rouge pourpre'],
                'price' => 2499,
                'is_active' => true,
            ],
        ];

        foreach ($variants as $variant) {
            ProductVariant::create($variant);
        }
    }
}
