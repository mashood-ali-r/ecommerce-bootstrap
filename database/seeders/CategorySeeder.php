<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Laptops',
                'description' => 'High-performance laptops for gaming, work, and everyday use',
                'sort_order' => 1,
            ],
            [
                'name' => 'Desktop PCs',
                'description' => 'Custom built and pre-built desktop computers',
                'sort_order' => 2,
            ],
            [
                'name' => 'Graphics Cards',
                'description' => 'Latest NVIDIA and AMD graphics cards for gaming and professional work',
                'sort_order' => 3,
            ],
            [
                'name' => 'Processors',
                'description' => 'Intel and AMD processors for all performance levels',
                'sort_order' => 4,
            ],
            [
                'name' => 'Storage Devices',
                'description' => 'SSDs, HDDs, and NVMe drives for all your storage needs',
                'sort_order' => 5,
            ],
            [
                'name' => 'Monitors',
                'description' => 'Gaming and professional monitors in various sizes and resolutions',
                'sort_order' => 6,
            ],
            [
                'name' => 'Gaming Accessories',
                'description' => 'Keyboards, mice, headsets, and more for gamers',
                'sort_order' => 7,
            ],
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
                'is_active' => true,
                'sort_order' => $category['sort_order'],
            ]);
        }
    }
}
