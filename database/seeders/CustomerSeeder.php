<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Customer::insert([
            [
                'user_id' => 2,
                'first_name' => 'Customer',
                'last_name' => '123',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
