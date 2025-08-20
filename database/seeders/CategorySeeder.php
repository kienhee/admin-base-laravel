<?php

namespace Database\Seeders;

use Config\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public $tableName = 'categories';
    public $version = 1;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Admin::SeedMigration($this->tableName, $this->version)) {
            DB::table('categories')->insert([
                [
                    'name' => 'Trí tuệ nhân tạo',
                    'thumbnail' => null,
                    'slug' => 'tri-tue-nhan-tao',
                    'description' => 'Công nghệ trí tuệ nhân tạo',
                    'type' => 'blog',
                    'parent_id' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Blockchain',
                    'thumbnail' => null,
                    'slug' => 'blockchain',
                    'description' => 'Công nghệ chuỗi khối',
                    'type' => 'blog',
                    'parent_id' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Điện toán đám mây',
                    'thumbnail' => null,
                    'slug' => 'dien-toan-dam-may',
                    'description' => 'Công nghệ điện toán đám mây',
                    'type' => 'blog',
                    'parent_id' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Internet vạn vật',
                    'thumbnail' => null,
                    'slug' => 'internet-van-vat',
                    'description' => 'Công nghệ IoT',
                    'type' => 'blog',
                    'parent_id' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'An ninh mạng',
                    'thumbnail' => null,
                    'slug' => 'an-ninh-mang',
                    'description' => 'Công nghệ bảo mật và an ninh mạng',
                    'type' => 'blog',
                    'parent_id' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Phần mềm',
                    'thumbnail' => null,
                    'slug' => 'phan-mem',
                    'description' => 'Công nghệ phần mềm',
                    'type' => 'blog',
                    'parent_id' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Phần cứng',
                    'thumbnail' => null,
                    'slug' => 'phan-cung',
                    'description' => 'Công nghệ phần cứng',
                    'type' => 'blog',
                    'parent_id' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Thực tế ảo',
                    'thumbnail' => null,
                    'slug' => 'thuc-te-ao',
                    'description' => 'Công nghệ thực tế ảo',
                    'type' => 'blog',
                    'parent_id' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Phân tích dữ liệu',
                    'thumbnail' => null,
                    'slug' => 'phan-tich-du-lieu',
                    'description' => 'Công nghệ phân tích dữ liệu',
                    'type' => 'blog',
                    'parent_id' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Mạng 5G',
                    'thumbnail' => null,
                    'slug' => 'mang-5g',
                    'description' => 'Công nghệ mạng 5G',
                    'type' => 'blog',
                    'parent_id' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // Thêm chủ đề cho type = product
                [
                    'name' => 'Laptop',
                    'thumbnail' => null,
                    'slug' => 'laptop',
                    'description' => 'Sản phẩm laptop công nghệ',
                    'type' => 'product',
                    'parent_id' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Điện thoại',
                    'thumbnail' => null,
                    'slug' => 'dien-thoai',
                    'description' => 'Sản phẩm điện thoại công nghệ',
                    'type' => 'product',
                    'parent_id' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Máy tính bảng',
                    'thumbnail' => null,
                    'slug' => 'may-tinh-bang',
                    'description' => 'Sản phẩm máy tính bảng công nghệ',
                    'type' => 'product',
                    'parent_id' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Phụ kiện',
                    'thumbnail' => null,
                    'slug' => 'phu-kien',
                    'description' => 'Phụ kiện công nghệ',
                    'type' => 'product',
                    'parent_id' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }
    }
}
