<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
public function run(): void
{
    User::create([
        'name' => 'Admin Project PU',
        'email' => 'admin@projectpu.test',
        'password' => Hash::make('admin123'),
        'role' => 1,
    ]);
}}
