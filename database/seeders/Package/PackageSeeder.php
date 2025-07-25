<?php

namespace Database\Seeders\Package;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Package\PackageCategory;
use App\Models\Package\Package;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categoryIds = PackageCategory::pluck('id'); // Ambil semua ID kategori yang ada

        $packages = [
            [
                'name' => 'Sweet',
                'description' => "- 1 Photographer\n- Fullday coverage (max 20.00)\n- Edited photos\n- All file original photos\n- Album magnetic + 100 Photos (4R)\n- Free flashdisk",
                'price' => 1300000,
                'discount' => 10,
            ],
            [
                'name' => 'Joyful',
                'description' => "- 1 Photographer\n- 1 Videographer\n- Fullday coverage (max 20.00)\n- Edited photos\n- All file original photos\n- Album magnetic + 100 Photos (4R)\n- Print 12rs + frame\n- 2-3 min cinematic clip\n- Free flashdisk",
                'price' => 2500000,
                'discount' => 0,
            ],
            [
                'name' => 'Lovely',
                'description' => "- 1 Photographer\n- 1 Videographer\n- Fullday coverage (max 20.00)\n- Edited photos\n- All file original photos\n- Album magnetic + 100 Photos (4R)\n- Print 12rs + frame\n- Print 10rs + frame\n- 2-3 min cinematic clip\n- 30 sec teaser portrait\n- Free flashdisk",
                'price' => 3000000,
                'discount' => 0,
            ],
        ];

        foreach ($packages as $package) {
            Package::create([
                'package_category_id' => $categoryIds->random(),
                'name' => $package['name'],
                'description' => $package['description'],
                'price' => $package['price'],
                'discount' => $package['discount'],
            ]);
        }
    }
}
