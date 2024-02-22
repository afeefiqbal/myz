<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::insert([
            [
                'id' => 1,
                'parent_id' => null,
                'title' => 'HOME APPLIANCES',
                'short_url' => 'home-appliances',
                'created_at' => now(),
                'updated_at' => now(),
            ], [
                'id' => 2,
                'parent_id' => null,
                'title' => 'KITCHEN APPLIANCES',
                'short_url' => 'kitchen-appliances',
                'created_at' => now(),
                'updated_at' => now(),
            ], [
                'id' => 3,
                'parent_id' => null,
                'title' => 'Coffee Makers',
                'short_url' => 'coffee-makers',
                'created_at' => now(),
                'updated_at' => now(),
            ], [
                'id' => 4,
                'parent_id' => 3,
                'title' => 'Bean to cup',
                'short_url' => 'bean-to-cup',
                'created_at' => now(),
                'updated_at' => now(),
            ], [
                'id' => 5,
                'parent_id' => 3,
                'title' => 'Pump Espresso',
                'short_url' => 'pump-espresso',
                'created_at' => now(),
                'updated_at' => now(),
            ], [
                'id' => 6,
                'parent_id' => 3,
                'title' => 'Combi',
                'short_url' => 'combi',
                'created_at' => now(),
                'updated_at' => now(),
            ], [
                'id' => 7,
                'parent_id' => 3,
                'title' => 'Drip coffee makers',
                'short_url' => 'drip-coffee-makers',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
