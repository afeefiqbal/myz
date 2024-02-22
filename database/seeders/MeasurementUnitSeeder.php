<?php

namespace Database\Seeders;

use App\Models\MeasurementUnit;
use Illuminate\Database\Seeder;

class MeasurementUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MeasurementUnit::insert([
            [
                'id' => 1,
                'title' => 'Normal',
                'symbol' => '',
                'created_at' => now(),
                'updated_at' => now(),
            ], [
                'id' => 2,
                'title' => 'Kilogram',
                'symbol' => 'kg',
                'created_at' => now(),
                'updated_at' => now(),
            ], [
                'id' => 3,
                'title' => 'gram',
                'symbol' => 'g',
                'created_at' => now(),
                'updated_at' => now(),
            ], [
                'id' => 4,
                'title' => 'Litre',
                'symbol' => 'L',
                'created_at' => now(),
                'updated_at' => now(),
            ], [
                'id' => 5,
                'title' => 'milli-litre',
                'symbol' => 'ml',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
