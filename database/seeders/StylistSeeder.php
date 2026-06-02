<?php

namespace Database\Seeders;

use App\Models\Stylist;
use Illuminate\Database\Seeder;

class StylistSeeder extends Seeder
{
    public function run(): void
    {
        Stylist::create([
            'name' => 'Alex',
            'specialist' => 'Haircut',
            'gender' => 'Male',
        ]);

        Stylist::create([
            'name' => 'Sofia',
            'specialist' => 'Hair Coloring',
            'gender' => 'Female',
        ]);
    }
}