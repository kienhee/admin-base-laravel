<?php

namespace Database\Seeders;

use Config\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HashTagSeeder extends Seeder
{
    public $tableName = 'hash_tags';
    public $version = 1;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Admin::SeedMigration($this->tableName, $this->version)) {

            DB::table($this->tableName)->insert([
                [
                    'name' => 'Artificial Intelligence',
                    'slug' => 'artificial-intelligence',
                    'isTrending' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Machine Learning',
                    'slug' => 'machine-learning',
                    'isTrending' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Blockchain',
                    'slug' => 'blockchain',
                    'isTrending' => false,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Cloud Computing',
                    'slug' => 'cloud-computing',
                    'isTrending' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Cybersecurity',
                    'slug' => 'cybersecurity',
                    'isTrending' => false,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Internet of Things',
                    'slug' => 'internet-of-things',
                    'isTrending' => false,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Big Data',
                    'slug' => 'big-data',
                    'isTrending' => false,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Virtual Reality',
                    'slug' => 'virtual-reality',
                    'isTrending' => false,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Augmented Reality',
                    'slug' => 'augmented-reality',
                    'isTrending' => false,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'DevOps',
                    'slug' => 'devops',
                    'isTrending' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }
    }
}
