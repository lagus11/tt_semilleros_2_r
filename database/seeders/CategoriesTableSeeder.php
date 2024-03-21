<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'name' => 'Recreativos',
        ]);
        Category::create([
            'name' => 'Científicos',
        ]);
        Category::create([
            'name' => 'Biográficos',
        ]);
        Category::create([
            'name' => 'Autoayuda',
        ]);
    }
}
