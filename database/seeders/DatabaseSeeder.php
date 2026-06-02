<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | ADMIN
        |--------------------------------------------------------------------------
        */
        User::create([
        'name' => 'Admin',
        'email' => 'admin@gmail.com',
        'password' => 'password',
        'role' => 'admin',
        ]);


        /*
        |--------------------------------------------------------------------------
        | USER
        |--------------------------------------------------------------------------
        */
        User::create([
        'name' => 'Customer',
        'email' => 'user@gmail.com',
        'password' => 'password',
        'role' => 'user',
        ]);

        /*
        |--------------------------------------------------------------------------
        | MASTER DATA
        |--------------------------------------------------------------------------
        */

        $this->call([
            ServiceSeeder::class,
            StylistSeeder::class,
        ]);
    }
}