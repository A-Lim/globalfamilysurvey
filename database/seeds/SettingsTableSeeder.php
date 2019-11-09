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
        $request_intervals = [
            (object) ['label' => 'Every 30 minutes', 'value' => '*/30 * * * *'],
            (object) ['label' => 'Hourly', 'value' => '0 */1 * * *'],
            (object) ['label' => 'Every 2 hours', 'value' => '0 */2 * * *'],
            (object) ['label' => 'Every 4 hours', 'value' => '0 */4 * * *'],
            (object) ['label' => 'Every 12 hours', 'value' => '0 */12 * * *'],
            (object) ['label' => 'Daily at 12 AM', 'value' => '0 0 * * *'],
        ];

        $settings = [
            ['name' => 'Survey Base URL', 'type' => 'text', 'key' => 'survey_base_url', 'value' => '', 'options' => null, 'help_text' => 'Links end with "/" eg. https://google.com/', 'validation' => 'nullable|url'],
            ['name' => 'Survey Monkey API Key', 'type' => 'textarea', 'key' => 'api_key', 'value' => '', 'options' => null, 'help_text' => null, 'validation' => 'nullable|string'],
            ['name' => 'Survey Monkey Token', 'type' => 'textarea', 'key' => 'token', 'value' => '', 'options' => null, 'help_text' => null, 'validation' => 'nullable|string'],
            ['name' => 'Open Registration', 'type' => 'checkbox', 'key' => 'open_registration', 'value' => '0', 'options' => null, 'help_text' => null, 'validation' => 'boolean'],
            ['name' => 'Request Interval', 'type' => 'select', 'key' => 'request_interval', 'value' => '', 'options' => json_encode($request_intervals), 'help_text' => 'The interval for request to be made to survey monkey to retrieve submissions.', 'validation' => 'nullable|string']
        ];
        Setting::insert($settings);
    }
}
