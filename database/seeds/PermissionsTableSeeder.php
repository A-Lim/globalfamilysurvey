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
            ['name' => 'create_users', 'label' => 'Create Users', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'update_users', 'label' => 'Update Users', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'delete_users', 'label' => 'Delete Users', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'view_churches', 'label' => 'View Churches', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'create_churches', 'label' => 'Create Churches', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'update_churches', 'label' => 'Update Churches', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'delete_churchs', 'label' => 'Delete Churches', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'view_surveys', 'label' => 'View Surveys', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'retrieve_surveys', 'label' => 'Retrieve Surveys', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'delete_surveys', 'label' => 'Delete Surveys', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'view_questions', 'label' => 'View Questions', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'delete_questions', 'label' => 'Delete Questions', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'view_roles', 'label' => 'View Roles', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'create_roles', 'label' => 'Create Roles', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'update_roles', 'label' => 'Update Roles', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'delete_roles', 'label' => 'Delete Roles', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'view_reports', 'label' => 'View Reports', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'create_reports', 'label' => 'Create Reports', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'update_reports', 'label' => 'Update Reports', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'delete_reports', 'label' => 'Delete Reports', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'view_settings', 'label' => 'View Settings', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'update_settings', 'label' => 'Update Settings', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'view_webhooks', 'label' => 'View Webhooks', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'create_webhooks', 'label' => 'Create Webhooks', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'update_webhooks', 'label' => 'Update Webhooks', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'delete_webhooks', 'label' => 'Delete Webhooks', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'view_audits', 'label' => 'View Audits', 'created_at' => $now, 'updated_at' => $now],
        ];

        Permission::insert($permissions);
    }
}
