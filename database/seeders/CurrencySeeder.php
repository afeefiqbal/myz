<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Currency::insert([
            [
                'title' => 'Arab Emirates Dirham',
                'code' => 'AED',
                'symbol' => null,
                'is_default' => 1,
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ], [
                'title' => 'Indian Rupee',
                'code' => 'INR',
                'symbol' => '₹',
                'is_default' => 0,
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ], [
                'title' => 'US Dollar',
                'code' => 'USD',
                'symbol' => '$',
                'is_default' => 0,
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
