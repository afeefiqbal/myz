<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::insert([
            [
                'user_id' => 1,
                'name' => 'Pentacodes',
                'more_info' => '<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and ' .
                    'typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the ' .
                    '1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen ' .
                    'book.</p>',
                'role' => 'Super Admin',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
