<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         \App\Models\User::create([
            'name' => 'Aleksis Š.',
            'email' => 'competitor1@skill17.com',
            'password' => Hash::make('demopass1'),
         ]);

        \App\Models\User::create([
            'name' => 'Roberts F.',
            'email' => 'competitor2@skill17.com',
            'password' => Hash::make('demopass2'),
        ]);
    }
}
