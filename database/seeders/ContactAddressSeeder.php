<?php

namespace Database\Seeders;

use App\Models\ContactAddress;
use Illuminate\Database\Seeder;

class ContactAddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ContactAddress::insert([
            [
                'id' => 1,
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
