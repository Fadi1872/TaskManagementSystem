<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Fadi Noumih',
                'email' => 'fadinoumih@gmail.com',
                'password' => Hash::make('#fadi18Admin'),
                'is_Admin' => true
            ],
            [
                'name' => 'Yousha Tarsisi',
                'email' => 'josh@gmail.com',
                'password' => Hash::make('#josh18Admin'),
                'is_Admin' => true
            ],
            [
                'name' => 'John Doe',
                'email' => 'john@gmail.com',
                'password' => Hash::make('john1234'),
                'is_Admin' => false
            ],
            [
                'name' => 'Rissa Mon',
                'email' => 'rissa@gmail.com',
                'password' => Hash::make('rissa123'),
                'is_Admin' => false
            ],
            [
                'name' => 'Maichel Narko',
                'email' => 'mi@gmail.com',
                'password' => Hash::make('mick1234'),
                'is_Admin' => false
            ],
            [
                'name' => 'Dolly Nays',
                'email' => 'doll@gmail.com',
                'password' => Hash::make('doll1234'),
                'is_Admin' => false,
                'is_Activated' => false
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
