<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Item;
use RuntimeException;

class ItemSeeder extends Seeder
{
    public function run(): void
    {
        $categoryIds = Category::pluck('id', 'slug');
        $items = [
            [
                'name' => 'Basic Keyboard',
                'category_slug' => 'peripherals',
                'description' => 'A simple USB keyboard.',
                'price' => 19.99,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Wireless Mouse',
                'category_slug' => 'peripherals',
                'description' => 'Ergonomic wireless mouse.',
                'price' => 29.50,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '1080p Monitor',
                'category_slug' => 'displays',
                'description' => 'Full HD LED display.',
                'price' => 129.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'USB-C Hub',
                'category_slug' => 'accessories',
                'description' => 'Multi-port hub with HDMI.',
                'price' => 45.25,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Laptop Stand',
                'category_slug' => 'accessories',
                'description' => 'Adjustable aluminum stand.',
                'price' => 32.75,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mechanical Keyboard',
                'category_slug' => 'peripherals',
                'description' => 'RGB mechanical keyboard with blue switches.',
                'price' => 89.99,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Gaming Mouse Pad',
                'category_slug' => 'accessories',
                'description' => 'Large surface mouse pad.',
                'price' => 14.99,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '27-inch Monitor',
                'category_slug' => 'displays',
                'description' => '1440p IPS display.',
                'price' => 279.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'External SSD 1TB',
                'category_slug' => 'storage-devices',
                'description' => 'High-speed USB-C external SSD.',
                'price' => 119.99,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Webcam',
                'category_slug' => 'peripherals',
                'description' => '1080p USB webcam with microphone.',
                'price' => 54.90,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Noise Cancelling Headphones',
                'category_slug' => 'headphones-speakers',
                'description' => 'Over-ear Bluetooth headphones.',
                'price' => 199.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Desk Lamp',
                'category_slug' => 'accessories',
                'description' => 'LED desk lamp with brightness control.',
                'price' => 24.99,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Portable Charger',
                'category_slug' => 'cables-chargers',
                'description' => '10000mAh power bank.',
                'price' => 21.50,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Ethernet Adapter',
                'category_slug' => 'cables-chargers',
                'description' => 'USB to Ethernet adapter.',
                'price' => 16.75,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Bluetooth Speaker',
                'category_slug' => 'headphones-speakers',
                'description' => 'Compact wireless speaker.',
                'price' => 39.99,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Smartphone Stand',
                'category_slug' => 'accessories',
                'description' => 'Adjustable desk phone stand.',
                'price' => 12.99,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'HDMI Cable',
                'category_slug' => 'cables-chargers',
                'description' => '2-meter high-speed HDMI cable.',
                'price' => 9.99,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'USB Flash Drive 64GB',
                'category_slug' => 'storage-devices',
                'description' => 'USB 3.0 flash drive.',
                'price' => 11.50,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Wireless Charger',
                'category_slug' => 'cables-chargers',
                'description' => 'Qi-compatible fast charger.',
                'price' => 18.75,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Laptop Backpack',
                'category_slug' => 'accessories',
                'description' => 'Water-resistant laptop backpack.',
                'price' => 49.99,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Monitor Arm',
                'category_slug' => 'accessories',
                'description' => 'Adjustable desk-mounted monitor arm.',
                'price' => 69.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Surge Protector',
                'category_slug' => 'cables-chargers',
                'description' => '6-outlet surge protector.',
                'price' => 22.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'USB Desk Fan',
                'category_slug' => 'accessories',
                'description' => 'Quiet USB-powered desk fan.',
                'price' => 15.99,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Graphics Tablet',
                'category_slug' => 'peripherals',
                'description' => 'Drawing tablet for digital art.',
                'price' => 79.50,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Microphone',
                'category_slug' => 'peripherals',
                'description' => 'USB condenser microphone.',
                'price' => 64.99,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Desk Organizer',
                'category_slug' => 'accessories',
                'description' => 'Cable and accessory organizer.',
                'price' => 17.25,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'VR Headset',
                'category_slug' => 'devices',
                'description' => 'Entry-level virtual reality headset.',
                'price' => 299.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Wi-Fi Router',
                'category_slug' => 'devices',
                'description' => 'Dual-band wireless router.',
                'price' => 89.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'NAS Storage',
                'category_slug' => 'storage-devices',
                'description' => '2-bay network attached storage.',
                'price' => 249.99,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Cable Management Box',
                'category_slug' => 'accessories',
                'description' => 'Heat-resistant cable organizer box.',
                'price' => 19.75,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        $payload = [];
        foreach ($items as $item) {
            $slug = $item['category_slug'];
            if (! $categoryIds->has($slug)) {
                throw new RuntimeException("Missing category slug: {$slug}");
            }

            $item['category_id'] = $categoryIds[$slug];
            unset($item['category_slug']);
            $payload[] = $item;
        }

        Item::insert($payload);
    }
}
