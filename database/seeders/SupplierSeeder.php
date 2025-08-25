<?php

namespace Database\Seeders;

use Config\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    public $tableName = 'suppliers';
    public $version = 1;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Admin::SeedMigration($this->tableName, $this->version)) {
            $faker = \Faker\Factory::create();
            for ($i = 0; $i < 10; $i++) {
                DB::table('suppliers')->insert([
                    'thumbnail'    => $faker->imageUrl(200, 200, 'business', true, 'Faker'),
                    'company_name' => $faker->company,
                    'owner_name'   => $faker->name,
                    'email'        => $faker->unique()->safeEmail,
                    'phone'        => $faker->phoneNumber,
                    'website'      => $faker->url,
                    'facebook'     => 'https://facebook.com/' . $faker->userName,
                    'instagram'    => 'https://instagram.com/' . $faker->userName,
                    'address'      => $faker->address,
                    'city'         => $faker->city,
                    'country'      => $faker->country,
                    'created_at'   => now(),
                    'updated_at'   => now(),
                ]);
            }
        }
    }
}
