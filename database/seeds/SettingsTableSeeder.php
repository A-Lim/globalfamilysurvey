<?php

use App\Setting;
use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings = [
            ['name' => 'Survey Base URL', 'type' => 'text', 'key' => 'survey_base_url', 'value' => '', 'validation' => 'nullable|url'],
            ['name' => 'Survey Monkey API Key', 'type' => 'textarea', 'key' => 'api_key', 'value' => '', 'validation' => 'nullable|string'],
            ['name' => 'Survey Monkey Token', 'type' => 'textarea', 'key' => 'token', 'value' => '', 'validation' => 'nullable|string'],
            ['name' => 'Open Registration', 'type' => 'checkbox', 'key' => 'open_registration', 'value' => '0', 'validation' => 'boolean']
        ];
        Setting::insert($settings);
    }
}
