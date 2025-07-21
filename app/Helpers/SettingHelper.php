<?php

use App\Models\Setting;

if (!function_exists('setting')) {
    function setting($settingKey, $defaultSetting = null)
    {
        return Setting::where('key', $settingKey)->value('value') ?? $defaultSetting;
    }
}
