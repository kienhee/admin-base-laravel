<?php

namespace Database\Seeders;

use Config\Admin;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public $tableName = 'products';
    public $version = 3;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Admin::SeedMigration($this->tableName, $this->version, false)) {
            $faker = Factory::create();
            $supplierIds = DB::table('suppliers')->pluck('id')->toArray();
            $categoryIds = DB::table('categories')->pluck('id')->toArray();
            $collectionIds = DB::table('collections')->pluck('id')->toArray();
            $statusArr = ['draft', 'scheduled', 'published'];

            for ($i = 0; $i < 10; $i++) {
                $variants = [];
                $variantCount = $faker->numberBetween(1, 4);
                for ($j = 0; $j < $variantCount; $j++) {
                    $option = $faker->randomElement(['size', 'color', 'weight', 'smell']);
                    $value = $faker->word;
                    $variants[] = [
                        'option' => $option,
                        'value' => $value,
                    ];
                }

                DB::table('products')->insert([
                    'title' => $faker->unique()->sentence(3),
                    'slug' => $faker->unique()->slug,
                    'sku' => $faker->optional()->ean8,
                    'barcode' => $faker->optional()->ean13,
                    'description' => $faker->paragraph,
                    'images' => implode(',', [
                        $faker->imageUrl(640, 480, 'business', true, 'Business'),
                        $faker->imageUrl(640, 480, 'nature', true, 'Nature'),
                        $faker->imageUrl(640, 480, 'food', true, 'Food'),
                    ]),
                    'variants' => json_encode($variants),
                    'base_price' => $faker->numberBetween(100000, 20000000),
                    'sale_price' => $faker->optional()->numberBetween(50000, 19000000),
                    'is_tax' => $faker->boolean,
                    'is_in_stock' => $faker->boolean,
                    'supplier_id' => $faker->randomElement($supplierIds),
                    'category_id' => $faker->randomElement($categoryIds),
                    'collection_id' => $faker->randomElement($collectionIds),
                    'status' => $faker->randomElement($statusArr),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
