<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Package;

class PackageSeeder extends Seeder
{
    public function run(): void
    {
        Package::insert([
            ['name' => 'Gold', 'price' => 3000, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Platinum', 'price' => 5000, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Diamond', 'price' => 8000, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
