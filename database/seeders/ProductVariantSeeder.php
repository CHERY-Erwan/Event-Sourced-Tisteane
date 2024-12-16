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
                'id' => Str::uuid(),
                'product_id' => Product::where('slug', 'leonardo-solar-lamp')->first()->id,
                'sku' => 'LEO-S-RED',
                'slug' => 'leonardo-solar-lamp-red-small',
                'size' => ['en' => 'Small', 'fr' => 'Petit'],
                'color' => ['en' => 'Red', 'fr' => 'Rouge'],
                'price' => 1999,
                'is_active' => true,
            ],
            [
                'id' => Str::uuid(),
                'product_id' => Product::where('slug', 'leonardo-solar-lamp')->first()->id,
                'sku' => 'LEO-S-BLUE',
                'slug' => 'leonardo-solar-lamp-blue-small',
                'size' => ['en' => 'Small', 'fr' => 'Petit'],
                'color' => ['en' => 'Blue', 'fr' => 'Bleu'],
                'price' => 1499,
                'is_active' => true,
            ],
            [
                'id' => Str::uuid(),
                'product_id' => Product::where('slug', 'leonardo-solar-lamp')->first()->id,
                'sku' => 'LEO-M-RED',
                'slug' => 'leonardo-solar-lamp-red-medium',
                'size' => ['en' => 'Medium', 'fr' => 'Moyen'],
                'color' => ['en' => 'Red', 'fr' => 'Rouge'],
                'price' => 2499,
                'is_active' => true,
            ],
        ];

        foreach ($variants as $variant) {
            ProductVariant::create($variant);
        }
    }
}
