<?php

namespace Database\Seeders;

use App\Models\parties;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PartiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        parties::create(
            ['party_name' => 'morena', 
            'party_acronim' => 'morena',
            'party_colour' => '#9E3451',
            'party_icon' => '07-03-2023_Morena_partido_logo.png',
            'party_iconPath' => '/storage/icons/07-03-2023_Morena_partido_logo.png',
            ]
        );
        parties::create(
            ['party_name' => 'partido acción nacional', 
            'party_acronim' => 'pan',
            'party_colour' => '#042F83',
            'party_icon' => '07-03-2023_PAN-LOGO.jpg',
            'party_iconPath' => '/storage/icons/07-03-2023_PAN-LOGO.jpg',
            ]
        );
        parties::create(
            ['party_name' => 'movimiento ciudadano', 
            'party_acronim' => 'mc',
            'party_colour' => '#FF8300',
            'party_icon' => '07-03-2023_movimiento ciudadano.png',
            'party_iconPath' => '/storage/icons/07-03-2023_movimiento ciudadano.png',
            ]
        );
        parties::create(
            ['party_name' => 'partido del trabajo', 
            'party_acronim' => 'pt',
            'party_colour' => '#ff0000',
            'party_icon' => '07-03-2023_pt.jpg',
            'party_iconPath' => '/storage/icons/07-03-2023_pt.jpg',
            ]
        );
        parties::create(
            ['party_name' => 'partido revolucionario institucional', 
            'party_acronim' => 'pri',
            'party_colour' => '#01923F',
            'party_icon' => '07-03-2023_LOGO-Portal-PRI1.jpg',
            'party_iconPath' => '/storage/icons/07-03-2023_LOGO-Portal-PRI1.jpg',
            ]
        );
    }
}
