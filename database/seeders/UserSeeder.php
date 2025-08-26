<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('users')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        User::create([
            'name' => 'stefen jowo',
            'whatsapp' => '6285848250548',
            'email' => 'stefen.jowo@gmail.com',
            'otp' => Hash::make(123456),
            'otp_expires_at' => Carbon::now()->addMonth(1),
        ]);
    }
}
