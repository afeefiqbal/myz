<?php

namespace Database\Seeders;

use App\Models\ProductType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        ProductType::insert([
            [
               
                'title' => 'Print Only',
                'created_at' => now(),
                'updated_at' => now(),
                'sort_order' => 1
            ]
        ]);
        ProductType::insert([
            [
               
                'title' => 'Canvas',
                'created_at' => now(),
                'updated_at' => now(),
                'sort_order' => 4
            ]
        ]);
        ProductType::insert([
            [
               
                'title' => 'Stretched Canvas',
                'created_at' => now(),
                'updated_at' => now(),
                'sort_order' => 3
            ]
        ]);
        ProductType::insert([
            [
               
                'title' => 'Framed Canvas',
                'created_at' => now(),
                'updated_at' => now(),
                'sort_order' => 2
            ]
        ]);
       
    }
}
