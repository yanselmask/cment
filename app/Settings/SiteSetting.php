<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class SiteSetting extends Settings
{

    public ?String $site_logo_light;
    public ?String $site_logo_dark;
    public String $site_name;
    public String $site_url;
    public String $site_description;
    public String $site_admin_email;
    public String $site_privacy_url;
    public String $site_terms_url;
    public String $site_cookies_url;
    public ?String $site_theme_active;
    public ?String $site_front_css;
    public ?String $site_front_js;
    public String $site_post_editor;
    public String $site_page_editor;
    public bool $site_maintenance_status;
    public String $site_maintenance_message;
    public array $site_social_media_links;

    public static function group(): string
    {
        return 'site';
    }
}
