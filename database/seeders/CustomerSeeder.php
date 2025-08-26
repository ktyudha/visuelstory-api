<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Customer::create([
            'name' => 'customer baru',
            'email' => 'customer@gmail.com',
            'whatsapp' => '085848250548',
            'otp' => Hash::make(123456),
            'otp_expires_at' => Carbon::now()->addMonth(1),
        ]);
    }
}
