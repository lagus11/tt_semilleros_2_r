<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Writer;


class WritersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Writer::create([
            'name' => 'William Faulkner',
        ]);
        Writer::create([
            'name' => 'Franz Kafka',
        ]);
        Writer::create([
            'name' => 'Gabriel García Márquez',
        ]);
        Writer::create([
            'name' => 'Julio Verne',
        ]);
    }
}
