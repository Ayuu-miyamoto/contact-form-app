<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //管理ユーザー2を作成
        User::create([
            'name' => 'Test User2',
            'email' => 'test2@example.com',
            'password' => Hash::make('password2'),
            'is_admin' => true,
        ]);
    }
}
