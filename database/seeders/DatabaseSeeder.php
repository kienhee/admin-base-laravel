<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // UserSeeder::class,
            // HashTagSeeder::class,
            // CategorySeeder::class,
            // BlogSeeder::class,
            // SupplierSeeder::class,
            // CollectionSeeder::class,
            ProductSeeder::class
        ]);
    }
}
