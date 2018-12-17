<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $church = App\Church::create([
            'uuid' => (string) Uuid::generate(4),
            'name' => 'Calvary Family Church',
            'denomination' => 'Charismatic',
            'country' => 'Malaysia'
        ]);

        User::create([
            'name' => 'Alexius',
            'email' => 'alexiuslim1994@gmail.com',
            'level_id' => 1,
            'church_id' => $church->id,
            'password' => Hash::make('123456789')
        ]);
    }
}
