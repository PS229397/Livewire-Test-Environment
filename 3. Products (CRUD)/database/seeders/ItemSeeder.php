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
            [
                'name' => 'Mechanical Keyboard',
                'description' => 'RGB mechanical keyboard with blue switches.',
                'price' => 89.99,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Gaming Mouse Pad',
                'description' => 'Large surface mouse pad.',
                'price' => 14.99,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '27-inch Monitor',
                'description' => '1440p IPS display.',
                'price' => 279.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'External SSD 1TB',
                'description' => 'High-speed USB-C external SSD.',
                'price' => 119.99,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Webcam',
                'description' => '1080p USB webcam with microphone.',
                'price' => 54.90,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Noise Cancelling Headphones',
                'description' => 'Over-ear Bluetooth headphones.',
                'price' => 199.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Desk Lamp',
                'description' => 'LED desk lamp with brightness control.',
                'price' => 24.99,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Portable Charger',
                'description' => '10000mAh power bank.',
                'price' => 21.50,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Ethernet Adapter',
                'description' => 'USB to Ethernet adapter.',
                'price' => 16.75,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Bluetooth Speaker',
                'description' => 'Compact wireless speaker.',
                'price' => 39.99,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Smartphone Stand',
                'description' => 'Adjustable desk phone stand.',
                'price' => 12.99,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'HDMI Cable',
                'description' => '2-meter high-speed HDMI cable.',
                'price' => 9.99,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'USB Flash Drive 64GB',
                'description' => 'USB 3.0 flash drive.',
                'price' => 11.50,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Wireless Charger',
                'description' => 'Qi-compatible fast charger.',
                'price' => 18.75,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Laptop Backpack',
                'description' => 'Water-resistant laptop backpack.',
                'price' => 49.99,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Monitor Arm',
                'description' => 'Adjustable desk-mounted monitor arm.',
                'price' => 69.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Surge Protector',
                'description' => '6-outlet surge protector.',
                'price' => 22.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'USB Desk Fan',
                'description' => 'Quiet USB-powered desk fan.',
                'price' => 15.99,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Graphics Tablet',
                'description' => 'Drawing tablet for digital art.',
                'price' => 79.50,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Microphone',
                'description' => 'USB condenser microphone.',
                'price' => 64.99,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Desk Organizer',
                'description' => 'Cable and accessory organizer.',
                'price' => 17.25,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'VR Headset',
                'description' => 'Entry-level virtual reality headset.',
                'price' => 299.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Wi-Fi Router',
                'description' => 'Dual-band wireless router.',
                'price' => 89.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'NAS Storage',
                'description' => '2-bay network attached storage.',
                'price' => 249.99,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Cable Management Box',
                'description' => 'Heat-resistant cable organizer box.',
                'price' => 19.75,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
