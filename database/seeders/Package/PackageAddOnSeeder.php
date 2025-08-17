<?php

namespace Database\Seeders\Package;

use App\Models\Package\PackageAddOn;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PackageAddOnSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $addOns = [
            ['name' => 'Photographer', 'price' => '800000'],
            ['name' => 'Videographer', 'price' => '1000000'],
            ['name' => 'Extra hour', 'price' => '150000'],
            ['name' => 'Different days', 'price' => '300000'],
            ['name' => 'Print 12rs + frame', 'price' => '150000'],
            ['name' => 'Print 16rs + frame', 'price' => '250000'],
            ['name' => 'Album magnetic + 40 Photos (4R)', 'price' => '250000'],
        ];


        foreach ($addOns as $item) {
            PackageAddOn::create([
                'id' => (string) Str::uuid(),
                'name' => $item['name'],
                'price' => $item['price'],
            ]);
        }
    }
}
