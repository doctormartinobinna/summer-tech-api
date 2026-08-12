<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('products')->insert([
            [
                'category_id' => 1,
                'name' => 'Laravel API Training',
                'slug' => 'laravel-api-training',
                'description' => 'A practical backend API development course using Laravel.',
                'price' => 50000,
                'image' => 'laravel-api.jpg',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 1,
                'name' => 'React API Consumption',
                'slug' => 'react-api-consumption',
                'description' => 'Learn how to consume APIs using React.',
                'price' => 45000,
                'image' => 'react-api.jpg',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 2,
                'name' => 'Cyber Security Fundamentals',
                'slug' => 'cyber-security-fundamentals',
                'description' => 'A beginner-friendly course on cybersecurity basics.',
                'price' => 60000,
                'image' => 'cyber-security.jpg',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}