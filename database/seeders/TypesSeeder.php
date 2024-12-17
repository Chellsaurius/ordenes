<?php

namespace Database\Seeders;

use App\Models\types;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        types::create(
            ['type_name' => 'Ordinaria']
        );
        types::create(
            ['type_name' => 'Extraordinaria']
        );
        types::create(
            ['type_name' => 'Solemne']
        );
        types::create(
            ['type_name' => 'Privada']
        );
    }
}
