<?php

use App\User;
use Webpatser\Uuid\Uuid;
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
        User::create([
            'name' => 'Alexius',
            'email' => 'alexiuslim1994@gmail.com',
            'password' => Hash::make('123456789'),
        ]);
    }
}
