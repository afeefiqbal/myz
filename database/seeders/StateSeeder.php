<?php

namespace Database\Seeders;

use App\Models\State;
use Illuminate\Database\Seeder;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        State::insert([
            [
                'id' => 1,
                'country_id' => 1,
                'title' => 'Kerala',
                'created_at' => now(),
                'updated_at' => now(),
            ], [
                'id' => 2,
                'country_id' => 1,
                'title' => 'Tamil Nadu',
                'created_at' => now(),
                'updated_at' => now(),
            ], [
                'id' => 3,
                'country_id' => 2,
                'title' => 'Dubai',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
