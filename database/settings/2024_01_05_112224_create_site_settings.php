<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('site.site_logo_light', '');
        $this->migrator->add('site.site_logo_dark', '');
        $this->migrator->add('site.site_name', config('app.name', 'CMent'));
        $this->migrator->add('site.site_url', config('app.url', ''));
        $this->migrator->add('site.site_description', 'Your Description');
        $this->migrator->add('site.site_admin_email', 'admin@cment.com');
        $this->migrator->add('site.site_privacy_url', '/pages/privacy');
        $this->migrator->add('site.site_terms_url', '/pages/terms');
        $this->migrator->add('site.site_cookies_url', '/pages/cookies');
        $this->migrator->add('site.site_theme_active', 'default');
        $this->migrator->add('site.site_front_css', '');
        $this->migrator->add('site.site_front_js', '');
        $this->migrator->add('site.site_post_editor', 'markdown');
        $this->migrator->add('site.site_page_editor', 'markdown');
        $this->migrator->add('site.site_maintenance_status', false);
        $this->migrator->add('site.site_maintenance_message', 'Maintenance Message');
        $this->migrator->add('site.site_social_media_links', []);
    }
};
