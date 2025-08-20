<?php

namespace Database\Seeders;

use Config\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    public $tableName = 'blogs';
    public $version = 1;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Admin::SeedMigration($this->tableName, $this->version)) {
            $faker = Faker::create('vi_VN'); // dùng locale tiếng Việt
            $thumbnails = [
                'https://picsum.photos/seed/1/400/300',
                'https://picsum.photos/seed/2/400/300',
                'https://picsum.photos/seed/3/400/300',
                'https://picsum.photos/seed/4/400/300',
                'https://picsum.photos/seed/5/400/300',
                'https://picsum.photos/seed/6/400/300',
                'https://picsum.photos/seed/7/400/300',
                'https://picsum.photos/seed/8/400/300',
                'https://picsum.photos/seed/9/400/300',
                'https://picsum.photos/seed/10/400/300',
            ];

            $posts = [];
            for ($i = 1; $i <= 500; $i++) { // seed 500 bài cho nhẹ
                $title = $faker->sentence(rand(4, 8)); // tiêu đề ngẫu nhiên 4–8 từ
                $posts[] = [
                    'thumbnail'        => $faker->randomElement($thumbnails),
                    'title'            => $title,
                    'slug'             => Str::slug($title) . "-$i",
                    'content'          => $faker->paragraphs(rand(5, 10), true),
                    'status'           => $faker->randomElement(['published', 'draft']),
                    'meta_title'       => $faker->sentence(6),
                    'meta_description' => $faker->text(160),
                    'meta_keywords'    => implode(',', $faker->words(5)),
                    'category_id'      => $faker->numberBetween(1, 5),
                    'is_comment'       => $faker->boolean(),
                    'created_at'       => $faker->dateTimeBetween('-1 years', 'now'),
                    'updated_at'       => now(),
                ];
            }

            DB::table($this->tableName)->insert($posts);
        }
    }
}
