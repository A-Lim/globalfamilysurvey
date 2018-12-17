<?php

use App\Level;
use Illuminate\Database\Seeder;

class LevelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $levels = [
            ['name' => 'all', 'label' => 'All'],
            ['name' => 'national', 'label' => 'National'],
            ['name' => 'denominational', 'label' => 'Denominational'],
            ['name' => 'church_pastor', 'label' => 'Church Pastor'],
            ['name' => 'none', 'label' => 'None'],
        ];

        Level::insert($levels);
    }
}
