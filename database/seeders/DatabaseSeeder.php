<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'     => 'Rohan Sakhale',
            'email'    => 'rohan@informatia.ai',
            'password' => bcrypt('Secret#1234'),
            'company'  => 'Sai Ashirwad Informatia',
        ]);
    }
}
