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
            ['name' => 'Survey Base URL', 'type' => 'text', 'key' => 'survey_base_url', 'value' => '', 'validation' => 'url'],
            ['name' => 'Survey Monkey API Key', 'type' => 'textarea', 'key' => 'api_key', 'value' => '', 'validation' => 'string'],
            ['name' => 'Survey Monkey Token', 'type' => 'textarea', 'key' => 'token', 'value' => '', 'validation' => 'string']
        ];
        Setting::insert($settings);
    }
}
