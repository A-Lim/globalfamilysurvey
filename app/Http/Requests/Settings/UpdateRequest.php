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
            switch ($setting->type) {
                case Setting::TYPE_SELECT:
                    $allowed_options = collect(json_decode($setting->options))->pluck('value')->toArray();
                    $rules[$setting->key] = $setting->validation.'|in:'.implode($allowed_options, ',');
                    break;

                default:
                    $rules[$setting->key] = $setting->validation;
                    break;
            }
        }
        return $rules;
    }
}
