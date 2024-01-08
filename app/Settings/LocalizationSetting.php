<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class LocalizationSetting extends Settings
{

    public array $localization_availables_languages;
    public string $localization_default_language;
    public string $localization_date_format;
    public ?string $localization_time_format;
    public string $localization_timezone;
    public string $localization_week_start;

    public static function group(): string
    {
        return 'localization';
    }
}
