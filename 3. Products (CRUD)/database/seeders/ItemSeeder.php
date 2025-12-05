<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;

class ItemSeeder extends Seeder
{
    public function run(): void
    {
        Item::insert([
            [
                'name' => 'Basic Keyboard',
                'description' => 'A simple USB keyboard.',
                'price' => 19.99,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Wireless Mouse',
                'description' => 'Ergonomic wireless mouse.',
                'price' => 29.50,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '1080p Monitor',
                'description' => 'Full HD LED display.',
                'price' => 129.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'USB-C Hub',
                'description' => 'Multi-port hub with HDMI.',
                'price' => 45.25,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Laptop Stand',
                'description' => 'Adjustable aluminum stand.',
                'price' => 32.75,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
