<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->randomElement([
            'Samsung Galaxy Buds 3 FE',
            'Corsair 3500X RS-R ARGB Mid-Tower PC Case',
            'Apple iPhone Air 256GB',
            'ASUS ROG Strix RTX 4090',
            'Intel Core i9-14900K',
            'AMD Ryzen 9 7950X',
            'Corsair Vengeance RGB DDR5 32GB',
            'Samsung 990 PRO 2TB NVMe SSD',
            'LG UltraGear 27" 4K Gaming Monitor',
            'Logitech G Pro X Superlight Wireless Mouse',
            'Razer BlackWidow V4 Pro Mechanical Keyboard',
            'Sony WH-1000XM5 Wireless Headphones',
            'NZXT Kraken Z73 RGB AIO Cooler',
            'Corsair RM1000x 1000W PSU',
            'MSI MAG B760 Tomahawk WiFi Motherboard',
            'WD Black SN850X 4TB NVMe SSD',
            'Dell XPS 15 Laptop',
            'HP Omen 16 Gaming Laptop',
            'Acer Predator Helios 300',
            'Lenovo Legion 5 Pro'
        ]) . ' - ' . fake()->colorName();

        $price = fake()->randomFloat(2, 5000, 500000);
        $hasDiscount = fake()->boolean(40);
        $oldPrice = $hasDiscount ? $price * fake()->randomFloat(2, 1.1, 1.5) : null;

        return [
            'category_id' => fake()->numberBetween(1, 7), // Will be 1-7 after CategorySeeder runs
            'name' => $name,
            'slug' => Str::slug($name) . '-' . fake()->unique()->numberBetween(1000, 9999),
            'sku' => 'SKU-' . strtoupper(fake()->unique()->bothify('???-####')),
            'description' => fake()->paragraph(3),
            'specifications' => json_encode([
                'Brand' => fake()->company(),
                'Model' => fake()->bothify('??-####'),
                'Warranty' => fake()->randomElement(['1 Year', '2 Years', '3 Years']),
                'Color' => fake()->colorName(),
            ]),
            'price' => $price,
            'old_price' => $oldPrice,
            'stock' => fake()->numberBetween(0, 100),
            'is_active' => true,
            'is_featured' => fake()->boolean(30),
            'is_new' => fake()->boolean(20),
            'is_flash_deal' => fake()->boolean(15),
            'views' => fake()->numberBetween(0, 1000),
            'rating' => fake()->randomFloat(2, 3.5, 5.0),
            'reviews_count' => fake()->numberBetween(0, 500),
        ];
    }
}
