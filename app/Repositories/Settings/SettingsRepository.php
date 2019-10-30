<?php
namespace App\Repositories;

use DB;
use App\Setting;

use Illuminate\Http\Request;

class SettingsRepository implements SettingsRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function all() {
        return \Cache::rememberForEver(Setting::CACHE_KEY, function() {
            return Setting::all();
        });
    }

    /**
     * {@inheritdoc}
     */
    public function get($key) {
        return \Cache::rememberForEver(Setting::CACHE_KEY.':'.$key, function() use ($key) {
            return Setting::where('key', $key)->first();
        });
    }

    /**
     * {@inheritdoc}
     */
    public function registration_is_opened() {
        return \Cache::rememberForEver(Setting::CACHE_KEY.':open_registration', function() {
            return $this->get('open_registration')->value == "1";
        });
    }

    /**
     * {@inheritdoc}
     */
    public function update_all(Request $request) {
        DB::beginTransaction();
        $settings = $this->all();
        foreach ($settings as $setting) {
            $setting->update(['value' => $request->{$setting->key}]);
            // clear individual cache
            \Cache::forget(Setting::CACHE_KEY.':'.$setting->key);
        }
        DB::commit();

        \Cache::forget(Setting::CACHE_KEY);
    }
}
