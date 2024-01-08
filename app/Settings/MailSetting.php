<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class MailSetting extends Settings
{

    public String $mail_mailer;
    public String $mail_host;
    public String $mail_port;
    public ?String $mail_username;
    public ?String $mail_password;
    public ?String $mail_encryption;
    public String $mail_from_address;
    public String $mail_from_name;

    public static function group(): string
    {
        return 'mail';
    }
}
