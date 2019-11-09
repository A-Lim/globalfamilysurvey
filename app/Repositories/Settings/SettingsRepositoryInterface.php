<?php
namespace App\Repositories;

use Illuminate\Http\Request;

interface SettingsRepositoryInterface
{
    /**
     * Retrieve all settings
     *
     * @return [Setting]
     */
    public function all();

    /**
     * Returns settings based on specified key
     *
     * @param string $key
     * @return Setting
     */
    public function get($key);

    /**
     * Returns if registration is opened
     *
     * @return boolean
     */
    public function registration_is_opened();

    /**
     * Update all settings
     *
     * @param Request $request
     * @return null
     */
    public function update_all(Request $request);
}
