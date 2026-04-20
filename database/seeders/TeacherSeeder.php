<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TeacherSeeder extends Seeder
{
    public function run(): void
    {
        // Sample Teacher 1
        User::create([
            'name'     => 'Maria Santos',
            'email'    => 'santos.teacher@gmail.com',
            'password' => Hash::make('password123'),
            'role'     => 'teacher',
            'status'   => 'Active', // Para maging "badge-good" sa dashboard mo
        ]);

        // Sample Teacher 2
        User::create([
            'name'     => 'Juan Dela Cruz',
            'email'    => 'delacruz.teacher@gmail.com',
            'password' => Hash::make('password123'),
            'role'     => 'teacher',
            'status'   => 'Pending', // Para ma-test mo ang "Approve" button
        ]);
    }
}