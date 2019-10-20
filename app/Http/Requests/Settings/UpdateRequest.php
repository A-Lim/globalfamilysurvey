<?php

namespace App\Http\Requests\Settings;

use App\Setting;
use App\Repositories\SettingsRepositoryInterface;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest {
    private $settings;
    private $settingsRepository;

    public function __construct(SettingsRepositoryInterface $settingsRepositoryInterface) {
        $this->settingsRepository = $settingsRepositoryInterface;
        $this->settings = $this->settingsRepository->all();
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
}
