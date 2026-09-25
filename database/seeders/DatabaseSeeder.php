<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run()
{
    \App\Models\Service::create(['name' => 'Wash & Fold', 'price' => 5.00, 'unit' => 'kg']);
    \App\Models\Service::create(['name' => 'Dry Clean', 'price' => 8.50, 'unit' => 'piece']);
    \App\Models\Service::create(['name' => 'Ironing', 'price' => 3.00, 'unit' => 'kg']);
    \App\Models\Service::create(['name' => 'Bed Sheet', 'price' => 10.00, 'unit' => 'piece']);
}
}
