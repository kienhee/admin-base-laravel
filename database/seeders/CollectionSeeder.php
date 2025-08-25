<?php

namespace Database\Seeders;

use Config\Admin;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CollectionSeeder extends Seeder
{
    public $tableName = 'collections';
    public $version = 1;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Admin::SeedMigration($this->tableName, $this->version)) {
            $collections = [
                [
                    'name' => 'Spring Collection',
                    'thumbnail' => 'https://picsum.photos/200?random=1',
                    'description' => 'Bộ sưu tập mùa xuân với các sản phẩm tươi mới.',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Summer Vibes',
                    'thumbnail' => 'https://picsum.photos/200?random=2',
                    'description' => 'Sản phẩm nổi bật cho mùa hè năng động.',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Autumn Elegance',
                    'thumbnail' => 'https://picsum.photos/200?random=3',
                    'description' => 'Phong cách thanh lịch cho mùa thu.',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Winter Warmth',
                    'thumbnail' => 'https://picsum.photos/200?random=4',
                    'description' => 'Giữ ấm với các sản phẩm mùa đông.',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Classic Essentials',
                    'thumbnail' => 'https://picsum.photos/200?random=5',
                    'description' => 'Những sản phẩm cơ bản không thể thiếu.',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ];
            DB::table('collections')->insert($collections);
        }
    }
}
