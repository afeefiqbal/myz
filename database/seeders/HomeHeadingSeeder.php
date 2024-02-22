<?php

namespace Database\Seeders;

use App\Models\HomeHeading;
use Illuminate\Database\Seeder;

class HomeHeadingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        HomeHeading::insert([
            [
                'id' => 1,
                'type' => 'brand',
                'title' => 'BRANDS',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
