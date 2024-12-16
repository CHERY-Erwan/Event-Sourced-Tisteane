<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $solarLampsCategoryId = Category::where('slug', 'solar-lamps')->value('id');
        $solarLidsCategoryId = Category::where('slug', 'solar-lids')->value('id');


        $products = [
            [
                'id' => Str::uuid(),
                'category_id' => $solarLampsCategoryId,
                'sku' => 'LEO-001',
                'slug' => 'leonardo-solar-lamp',
                'label' => ['en' => 'Leonardo Solar Lamp', 'fr' => 'Lampe Solaire Leonardo'],
                'description' => ['en' => 'A stylish and energy-efficient solar lamp.', 'fr' => 'Une lampe solaire élégante et économe en énergie.'],
                'stock' => 10,
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'id' => Str::uuid(),
                'category_id' => $solarLampsCategoryId,
                'sku' => 'PDL-002',
                'slug' => 'pot-de-lait-solar-lamp',
                'label' => ['en' => 'Pot de lait Solar Lamp', 'fr' => 'Lampe Solaire Pot de lait'],
                'description' => ['en' => 'A concentrated light source meant to illuminate your spaces.', 'fr' => 'Un concentré de lumière pour illuminer vos espaces.'],
                'stock' => 25,
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'id' => Str::uuid(),
                'category_id' => $solarLidsCategoryId,
                'sku' => 'CST-003',
                'slug' => 'solar-lid-t082',
                'label' => ['en' => 'Solar Lid T082', 'fr' => 'Couvercle Solaire T082'],
                'description' => ['en' => 'A solar lid that fits your T082 jars.', 'fr' => 'Un couvercle solaire qui s\'adapte à vos bocaux T082.'],
                'stock' => 55,
                'is_active' => true,
                'is_featured' => true,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
