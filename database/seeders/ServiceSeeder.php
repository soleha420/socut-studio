<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        Service::create([
            'name' => 'Haircut',
            'description' => 'Professional haircut service',
            'price' => 50000,
            'duration' => 60,
        ]);

        Service::create([
            'name' => 'Hair Coloring',
            'description' => 'Premium hair coloring',
            'price' => 150000,
            'duration' => 120,
        ]);

        Service::create([
            'name' => 'Hair Spa',
            'description' => 'Relaxing hair spa treatment',
            'price' => 100000,
            'duration' => 90,
        ]);
    }
}