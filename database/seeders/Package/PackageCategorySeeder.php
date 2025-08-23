<?php

namespace Database\Seeders\Package;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class PackageCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Mini Wedding',
                'description' => 'Ngunduh mantu, intimate wedding',
            ],
            [
                'name' => 'Couple Session',
                'description' => 'Couple session, prewedding',
            ],
            [
                'name' => 'Before Wedding',
                'description' => 'Engagement, akad, siraman, etc.',
            ],
            [
                'name' => 'Wedding',
                'description' => 'Include akad & reception',
            ],
        ];

        foreach ($categories as $category) {
            DB::table('package_categories')->insert([
                'id' => (string) Str::uuid(),
                'name' => $category['name'],
                'description' => $category['description'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
