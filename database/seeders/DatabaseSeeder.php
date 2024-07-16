<?php

namespace Database\Seeders;

use App\Models\Feature;
use App\Models\Package;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Sagar Suryawanshi',
            'email' => 'sagarsuryawanshi.datagrid@gmail.com',
            'password' => bcrypt('12345678'),
        ]);

        Feature::create([
            'image' => 'https://static-00.iconduck.com/assets.00/plus-icon-512x512-hnjyaquo.png',
            'route_name' => 'feature1.index',
            'name' => 'Calculate Sum',
            'description' => 'Calculate Sum of the Two Numbers',
            'required_credits' => 1,
            'active' => true,
        ]);

        Feature::create([
            'image' => 'https://cdn-icons-png.flaticon.com/512/2569/2569198.png',
            'route_name' => 'feature2.index',
            'name' => 'Calculate Minus',
            'description' => 'Calculate Minus of the Two Numbers',
            'required_credits' => 3,
            'active' => true,
        ]);

        Feature::create([
            'image' => 'https://static.vecteezy.com/system/resources/previews/009/266/842/original/multiplication-sign-icon-free-png.png',
            'route_name' => 'feature3.index',
            'name' => 'Calculate Multiplication',
            'description' => 'Calculate Multiplication of the Two Numbers',
            'required_credits' => 2,
            'active' => true,
        ]);

        Feature::create([
            'image' => 'https://cdn-icons-png.flaticon.com/512/6399/6399505.png',
            'route_name' => 'feature4.index',
            'name' => 'Calculate Division',
            'description' => 'Calculate Division of the Two Numbers',
            'required_credits' => 4,
            'active' => true,
        ]);

        Package::create([
            'name' => 'Basic',
            'price' => 5,
            'credits' => 20,
        ]);
        Package::create([
            'name' => 'Silver',
            'price' => 20,
            'credits' => 100,
        ]);
        Package::create([
            'name' => 'Gold',
            'price' => 50,
            'credits' => 500,
        ]);
    }
}
