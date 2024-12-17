<?php

namespace Database\Seeders;

use App\Models\rols;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 
        rols::create(
            ['rol' => 'Alcalde']
        );
        rols::create(
            ['rol' => 'Sindico']
        );
        rols::create(
            ['rol' => 'Regidor']
        );
        rols::create(
            ['rol' => 'Secretario de ayuntamiento']
        );
        rols::create(
            ['rol' => 'Secretario técnico']
        );
        rols::create(
            ['rol' => 'Administrador']
        );
        rols::create(
            ['rol' => 'Visualizador']
        );
    }
}
