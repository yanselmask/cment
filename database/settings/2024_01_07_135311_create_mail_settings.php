<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('mail.mail_mailer', config('mail.default', 'smtp'));
        $this->migrator->add('mail.mail_host', config('mail.mailers.smtp.host', '127.0.0.1'));
        $this->migrator->add('mail.mail_port', config('mail.mailers.smtp.port', '1025'));
        $this->migrator->add('mail.mail_username', config('mail.mailers.smtp.username', ''));
        $this->migrator->add('mail.mail_password', config('mail.mailers.smtp.password', ''));
        $this->migrator->add('mail.mail_encryption', config('mail.mailers.smtp.encryption', 'tls'));
        $this->migrator->add('mail.mail_from_address', config('mail.from.address', ''));
        $this->migrator->add('mail.mail_from_name', config('mail.from.name', config('app.name')));
    }
};
