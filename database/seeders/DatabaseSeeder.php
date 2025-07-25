<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Seeders\Package\PackageCategorySeeder;
use Database\Seeders\Package\PackageSeeder;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            UserSeeder::class,

            // Package
            PackageCategorySeeder::class,
            PackageSeeder::class
        ]);
    }
}
