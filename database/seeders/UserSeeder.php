<?php

namespace Database\Seeders;

use Config\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public $tableName = 'users';
    public $version = 1;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Admin::SeedMigration($this->tableName, $this->version)) {

            DB::table($this->tableName)->insert([
                'avatar' => null,
                'full_name' => 'Kien Tran',
                'email' => 'kienhee.it@gmail.com',
                'email_verified_at' => null,
                'password' => Hash::make('123456'),
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
