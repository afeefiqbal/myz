<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Menu::insert([
            [
                'title' => 'All Products',
                'url' => 'products',
                'menu_type' => 'static',
                'category_id' => null,
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ], [
                'title' => 'HOME APPLIANCES',
                'url' => 'home-appliances',
                'menu_type' => 'category',
                'category_id' => 1,
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ], [
                'title' => 'KITCHEN APPLIANCES',
                'url' => 'kitchen-appliances',
                'menu_type' => 'category',
                'category_id' => 2,
                'sort_order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ], [
                'title' => 'ABOUT US',
                'url' => 'about',
                'menu_type' => 'static',
                'category_id' => null,
                'sort_order' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ], [
                'title' => 'CONTACT US',
                'url' => 'contact',
                'menu_type' => 'static',
                'category_id' => null,
                'sort_order' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
