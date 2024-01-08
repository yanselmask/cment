<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('localization.localization_availables_languages', ['en', 'es']);
        $this->migrator->add('localization.localization_default_language', 'en');
        $this->migrator->add('localization.localization_date_format', 'd M, Y');
        $this->migrator->add('localization.localization_time_format', '');
        $this->migrator->add('localization.localization_timezone', 'UTC');
        $this->migrator->add('localization.localization_week_start', 'sunday');
    }
};
