<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Country::insert([
            [
                'id' => 1,
                'title' => 'India',
                'created_at' => now(),
                'updated_at' => now(),
            ], [
                'id' => 2,
                'title' => 'UAE',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
