<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Editorial;


class EditorialsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Editorial::create([
            'name' => 'Cvltura',
        ]);
        Editorial::create([
            'name' => 'Botas',
        ]);
        Editorial::create([
            'name' => 'Patria',
        ]);
        Editorial::create([
            'name' => 'Fondo de Cultura Económica',
        ]);
    }
}
