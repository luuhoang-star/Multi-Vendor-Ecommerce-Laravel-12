<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingService
{
    // Lấy settings từ cache. Nếu chưa có thì lấy database rồi lưu vào cache vĩnh viễn.
    function getSettings()
    {
        return Cache::rememberForever('settings', function () {
            return Setting::pluck('value', 'key')->toArray();
        });
    }

    function setSettings()
    {
        $settings = $this->getSettings();
        config()->set('settings', $settings);
    }

    //Lần truy cập sau Laravel sẽ lấy database lại.
    function clearCashedSettings()
    {
        Cache::forget('settings');
    }
}
