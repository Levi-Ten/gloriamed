<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        // Admin principal
        User::create([
            'name' => 'admin',
            'password' => 'admin1234', // se hash-uiește automat bd admin123admin123@A
            'role' => 'principal',
        ]);

        // Admin secundar
        User::create([
            'name' => 'secundar1',
            'password' => 'secundar123',
            'role' => 'secundar',
        ]);

        // Vizualizare doar
        User::create([
            'name' => 'vizualizare1',
            'password' => 'vizualizare123',
            'role' => 'vizualizare',
        ]);
    }
}
