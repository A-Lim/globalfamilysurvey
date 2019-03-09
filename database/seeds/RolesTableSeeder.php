<?php

use App\Role;
use App\User;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now()->toDateTimeString();
        $roles = [
            ['name' => 'super_admin', 'label' => 'Super Admin', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'admin', 'label' => 'Admin', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'network_leader', 'label' => 'Network Leader', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'church_pastor', 'label' => 'Church Pastor', 'created_at' => $now, 'updated_at' => $now],
        ];

        Role::insert($roles);

        $user = User::whereEmail('alexiuslim1994@gmail.com')->firstOrFail();
        $user->assignRole('super_admin');
    }
}
