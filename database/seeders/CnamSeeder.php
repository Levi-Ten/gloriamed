<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cnam;

class CnamSeeder extends Seeder
{
    public function run(): void
    {
        Cnam::create([
            'numele' => 'Popescu',
            'prenumele' => 'Ion',
            'data_nasterii' => '1990-05-12',
            'idnp' => '1234567890123',
            'localitatea' => 'Chișinău',
            'sectorul' => 'Centru',
            'strada' => 'Ștefan cel Mare',
            'casa' => '10',
            'blocul' => 'A',
            'apartamentul' => '15',
        ]);

        Cnam::create([
            'numele' => 'Ionescu',
            'prenumele' => 'Maria',
            'data_nasterii' => '1985-11-20',
            'idnp' => '9876543210987',
            'localitatea' => 'Bălți',
            'sectorul' => null,
            'strada' => 'Independenței',
            'casa' => '22',
            'blocul' => null,
            'apartamentul' => '5',
        ]);
    }
}
