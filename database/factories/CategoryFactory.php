<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->randomElement([
            'Laptops',
            'Desktop PCs',
            'Graphics Cards',
            'Processors',
            'Motherboards',
            'RAM & Memory',
            'Storage Devices',
            'Monitors',
            'Keyboards & Mice',
            'Headphones & Audio',
            'Gaming Accessories',
            'Networking',
            'Power Supplies',
            'PC Cases',
            'Cooling Solutions'
        ]);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => fake()->sentence(15),
            'is_active' => true,
            'sort_order' => fake()->numberBetween(0, 100),
        ];
    }
}
