<?php

namespace Database\Seeders;

use App\Models\Standing;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StandingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Standing::create(
            ['standings_name' => 'Pendiente']
        );
        Standing::create(
            ['standings_name' => 'Revisión interna']
        );
        Standing::create(
            ['standings_name' => 'Aprobado por ']
        );
        Standing::create(
            ['standings_name' => 'No aprobado por ']
        );
        
    }
}
