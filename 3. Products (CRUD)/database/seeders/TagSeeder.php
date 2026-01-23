<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Tag;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            ['id' => 1, 'name' => 'New'],
            ['id' => 2, 'name' => 'Sale'],
            ['id' => 3, 'name' => 'Hot'],
        ];

        Tag::upsert($tags, ['id'], ['name']);
    }
}
