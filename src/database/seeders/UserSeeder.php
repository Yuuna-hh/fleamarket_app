<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'テスト1',
            'email' => '1@example.com',
            'password' => Hash::make('12345678'),
        ]);

        User::create([
            'name' => 'テスト2',
            'email' => '2@example.com',
            'password' => Hash::make('12345678'),
        ]);
    }
}