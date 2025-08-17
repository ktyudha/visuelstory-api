<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Package\Package;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $package = Package::whereHas('packageCategory', function ($query) {
            $query->where('name', 'Wedding');
        })->first();

        $events = [
            ['note' => 'Akad', 'date' => now(), 'location' => 'KUA Surabaya'],
            ['note' => 'Resepsi', 'date' => now(), 'location' => 'Lynn Hotel Mojokerto'],
        ];

        foreach ($events as $event) {
            Event::create([
                'package_id' => $package['id'],
                'note' => $event['note'],
                'date' => $event['date'],
                'location' => $event['location'],
            ]);
        }
    }
}
