<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Agustin',
            'last_name' => 'Hernandez',
            'second_last_name' => 'Montero',
            'email' => 'agustin@hotmail.com',
            'password' => bcrypt('123456'),
            'role_id' => 1
        ]);
    }
}
