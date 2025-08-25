<?php

namespace Database\Seeders;

use Config\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HashTagSeeder extends Seeder
{
    public $tableName = 'hash_tags';
    public $version = 2;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Admin::SeedMigration($this->tableName, $this->version)) {
            // Update các hashtag cũ, set type = 'blog'
            DB::table($this->tableName)->whereNull('type')->orWhere('type', '!=', 'product')->update(['type' => 'blog']);

            // Thêm mới các hashtag cũ nếu chưa có type
            DB::table($this->tableName)->insert([
                [
                    'name' => 'Artificial Intelligence',
                    'slug' => 'artificial-intelligence',
                    'isTrending' => true,
                    'type' => 'blog',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Machine Learning',
                    'slug' => 'machine-learning',
                    'isTrending' => true,
                    'type' => 'blog',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Blockchain',
                    'slug' => 'blockchain',
                    'isTrending' => false,
                    'type' => 'blog',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Cloud Computing',
                    'slug' => 'cloud-computing',
                    'isTrending' => true,
                    'type' => 'blog',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Cybersecurity',
                    'slug' => 'cybersecurity',
                    'isTrending' => false,
                    'type' => 'blog',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Internet of Things',
                    'slug' => 'internet-of-things',
                    'isTrending' => false,
                    'type' => 'blog',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Big Data',
                    'slug' => 'big-data',
                    'isTrending' => false,
                    'type' => 'blog',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Virtual Reality',
                    'slug' => 'virtual-reality',
                    'isTrending' => false,
                    'type' => 'blog',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Augmented Reality',
                    'slug' => 'augmented-reality',
                    'isTrending' => false,
                    'type' => 'blog',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'DevOps',
                    'slug' => 'devops',
                    'isTrending' => true,
                    'type' => 'blog',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // 5 hashtag mới cho product
                [
                    'name' => 'Eco Friendly',
                    'slug' => 'eco-friendly',
                    'isTrending' => true,
                    'type' => 'product',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Handmade',
                    'slug' => 'handmade',
                    'isTrending' => false,
                    'type' => 'product',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Limited Edition',
                    'slug' => 'limited-edition',
                    'isTrending' => true,
                    'type' => 'product',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Organic',
                    'slug' => 'organic',
                    'isTrending' => false,
                    'type' => 'product',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Best Seller',
                    'slug' => 'best-seller',
                    'isTrending' => true,
                    'type' => 'product',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }
    }
}
