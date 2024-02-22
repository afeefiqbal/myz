<?php

namespace Database\Seeders;

use App\Models\SiteInformation;
use Illuminate\Database\Seeder;

class SiteInformationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SiteInformation::insert([
            [
                'id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
