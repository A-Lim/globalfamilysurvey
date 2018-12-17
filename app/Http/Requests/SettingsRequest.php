<?php

namespace App\Http\Requests;

use App\Setting;
use Illuminate\Foundation\Http\FormRequest;

class SettingsRequest extends FormRequest {
    private $settings;

    public function __construct() {
        $this->settings = Setting::all();
    }

    public function authorize() {
        return true;
    }

    public function rules() {
        $rules = [];
        foreach ($this->settings as $setting) {
            $rules[$setting->key] = $setting->validation;
        }
        return $rules;
    }

    public function save() {
        foreach ($this->settings as $setting) {
            $setting->update(['value' => request($setting->key)]);
        }
    }
}
