<?php

namespace Database\Seeders;

use App\Models\positions;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PositionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        positions::create(
            ['position' => 'Presidente']
        );
        positions::create(
            ['position' => 'Secretario']
        );
        positions::create(
            ['position' => 'Vocal']
        );
        positions::create(
            ['position' => 'Integrante']
        );
    }
}
