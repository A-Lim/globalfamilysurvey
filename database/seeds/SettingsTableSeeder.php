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
            ['name' => 'Survey Base URL', 'key' => 'survey_base_url', 'value' => 'https://betterfamily.typeform.com/to/', 'validation' => 'url']
        ];
        Setting::insert($settings);
    }
}
