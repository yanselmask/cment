<?php

use App\Settings\LocalizationSetting;
use App\Settings\MailSetting;
use App\Settings\SiteSetting;


if (!function_exists('installed')) {
    function installed()
    {
        return file_exists(storage_path('installed'));
    }
}

if (!function_exists('setting')) {
    function setting($value = null)
    {
        if (!installed()) {
            return [];
        }

        $settings = new SiteSetting();
        $localization = new LocalizationSetting();
        $mail = new MailSetting();

        $merged = array_merge(
            $settings->toArray(),
            $localization->toArray(),
            $mail->toArray()
        );

        if ($value) {
            return $merged[$value];
        }

        return $merged;
    }
}
