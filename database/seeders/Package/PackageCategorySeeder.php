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
            'Engagement',
            'Birthday',
            'Couple Session',
            'Akad',
            'Wedding',
        ];

        foreach ($categories as $category) {
            DB::table('package_categories')->insert([
                'id' => (string) Str::uuid(),
                'name' => $category,
                'description' => $category . ' package category',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
