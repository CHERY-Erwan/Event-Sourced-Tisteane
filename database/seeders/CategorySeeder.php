<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'uuid' => Str::uuid(),
                'label' => ['en' => 'Solar lamps', 'fr' => 'Lampes solaires'],
                'slug' => 'solar-lamps',
            ],
            [
                'uuid' => Str::uuid(),
                'label' => ['en' => 'Solar lids', 'fr' => 'Couvercles solaires'],
                'slug' => 'solar-lids',
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
