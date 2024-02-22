<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Brand::insert([
            [
                'id' => 1,
                'title' => 'Vegan Food',
                'short_url' => 'vegan-food',
                'image' => '/uploads/brand/VeganFood.png',
                'desktop_banner' => '/uploads/brand/banner/VeganFood.png',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
