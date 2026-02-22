<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Processor',
            'VGA',
            'Motherboard',
            'RAM',
            'SSD',
            'PSU',
            'PC CASE',
            'FAN COOLER',
            'FAN CASE',
            'Peripheral',
        ];

        foreach ($categories as $cat) {
            // Pakai updateOrCreate supaya kalau datanya sudah ada, dia cuma update
            // Ini solusi biar gak kena "Duplicate Entry" lagi
            Category::updateOrCreate(
                ['slug' => Str::slug($cat)], // Cek kolom slug
                [
                    'name' => $cat,
                    'type' => 'component'
                ]
            );
        }
    }
}