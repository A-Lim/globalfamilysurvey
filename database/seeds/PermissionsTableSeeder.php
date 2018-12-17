<?php

use App\Permission;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $now = Carbon::now()->toDateTimeString();
        $permissions = [
            ['name' => 'view_users', 'label' => 'View Users', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'create_user', 'label' => 'Create User', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'update_user', 'label' => 'Update User', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'delete_user', 'label' => 'Delete User', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'view_churches', 'label' => 'View Churches', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'create_church', 'label' => 'Create Church', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'update_church', 'label' => 'Update Users', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'delete_church', 'label' => 'Delete Church', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'view_surveys', 'label' => 'View Surveys', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'delete_survey', 'label' => 'Delete Survey', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'view_questions', 'label' => 'View Questions', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'delete_question', 'label' => 'Delete Question', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'view_roles', 'label' => 'View Roles', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'create_role', 'label' => 'Create Role', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'update_role', 'label' => 'Update Role', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'delete_role', 'label' => 'Delete Role', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'view_reports', 'label' => 'View Reports', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'create_report', 'label' => 'Create Report', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'update_report', 'label' => 'Update Report', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'delete_report', 'label' => 'Delete Report', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'view_settings', 'label' => 'View Settings', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'update_settings', 'label' => 'Update Settings', 'created_at' => $now, 'updated_at' => $now],
        ];

        Permission::insert($permissions);
    }
}
