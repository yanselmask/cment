<?php

namespace App\Filament\Pages;

use App\Settings\MailSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\SettingsPage;

class MailSettings extends SettingsPage
{
    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    protected static string $settings = MailSetting::class;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('mail_mailer')
                    ->label(__('Mailer'))
                    ->required()
                    ->helperText(view('filament.components.helper_text_setting', ['value' => 'mail_mailer'])),
                Forms\Components\TextInput::make('mail_host')
                    ->label(__('Host'))
                    ->required()
                    ->helperText(view('filament.components.helper_text_setting', ['value' => 'mail_host'])),
                Forms\Components\TextInput::make('mail_port')
                    ->label(__('Port'))
                    ->required()
                    ->helperText(view('filament.components.helper_text_setting', ['value' => 'mail_port'])),
                Forms\Components\TextInput::make('mail_username')
                    ->label(__('Username'))
                    ->helperText(view('filament.components.helper_text_setting', ['value' => 'mail_username'])),
                Forms\Components\TextInput::make('mail_password')
                    ->label(__('Password'))
                    ->helperText(view('filament.components.helper_text_setting', ['value' => 'mail_password'])),
                Forms\Components\TextInput::make('mail_encryption')
                    ->label(__('Encryption'))
                    ->helperText(view('filament.components.helper_text_setting', ['value' => 'mail_encryption'])),
                Forms\Components\TextInput::make('mail_from_address')
                    ->label(__('From Address'))
                    ->required()
                    ->helperText(view('filament.components.helper_text_setting', ['value' => 'mail_from_address'])),
                Forms\Components\TextInput::make('mail_from_name')
                    ->label(__('From Name'))
                    ->required()
                    ->helperText(view('filament.components.helper_text_setting', ['value' => 'mail_from_name'])),
            ]);
    }

    public static function getnavigationGroup(): string
    {
        return __('Settings');
    }

    public static function getnavigationLabel(): string
    {
        return __('Mail Settings');
    }

    public function getTitle(): string
    {
        return __('Mail Settings');
    }
}
