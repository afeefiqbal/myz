<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 50; $i++) {
            Product::insert([
                [
                    'id' => $i,
                    'title' => 'Test Pro' . $i,
                    'short_url' => 'test-pro' . $i,
                    'sku' => '2345676',
                    'category_id' => rand(1, 2),
                    'color_id' => rand(1, 4),
                    'price' => rand(1500, 10000),
                    'description' => 'test',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            ]);
        }
    }
}
