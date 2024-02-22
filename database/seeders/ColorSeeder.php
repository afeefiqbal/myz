<?php

namespace Database\Seeders;

use App\Models\Color;
use Illuminate\Database\Seeder;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Color::insert([
            [
                'title' => 'Red',
                'code' => '#ff0000',
                'created_at' => now(),
                'updated_at' => now(),
            ], [
                'title' => 'Black',
                'code' => '#000000',
                'created_at' => now(),
                'updated_at' => now(),
            ], [
                'title' => 'Green',
                'code' => '#00ff00',
                'created_at' => now(),
                'updated_at' => now(),
            ], [
                'title' => 'Blue',
                'code' => '#0000ff',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
