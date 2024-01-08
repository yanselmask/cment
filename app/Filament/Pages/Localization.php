<?php

namespace App\Filament\Pages;

use App\Settings\LocalizationSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\SettingsPage;
use Filament\Forms\Get;

class Localization extends SettingsPage
{
    protected static ?string $navigationIcon = 'heroicon-o-language';

    protected static string $settings = LocalizationSetting::class;

    public function form(Form $form): Form
    {

        $collected = collect(config('language.all'))->mapWithKeys(function ($lang) {
            return [$lang['short'] => $lang['english']];
        });

        return $form
            ->schema([
                Forms\Components\Select::make('localization_availables_languages')
                    ->label(__('Site Availables Languages'))
                    ->helperText(view('filament.components.helper_text_setting', ['value' => 'localization_availables_languages']))
                    ->multiple()
                    ->options($collected),
                Forms\Components\Select::make('localization_default_language')
                    ->label(__('Site Default Language'))
                    ->helperText(view('filament.components.helper_text_setting', ['value' => 'localization_default_language']))
                    ->options(language()->allowed()),
                Forms\Components\TextInput::make('localization_date_format')
                    ->label(__('Site Data Format'))
                    ->hint(__('Example: F j, Y | Y-m-d| m/d/Y| d/m/Y| d M, Y| human'))
                    ->helperText(view('filament.components.helper_text_setting', ['value' => 'localization_date_format'])),
                Forms\Components\TextInput::make('localization_time_format')
                    ->label(__('Site Hour Format'))
                    ->hint(__('Example: g:i a | g:i A | H:i'))
                    ->helperText(view('filament.components.helper_text_setting', ['value' => 'localization_time_format'])),
                Forms\Components\Select::make('localization_timezone')
                    ->label(__('Site Timezone'))
                    ->helperText(view('filament.components.helper_text_setting', ['value' => 'localization_timezone']))
                    ->options(collect(timezone_identifiers_list())->mapWithKeys(function ($time) {
                        return [$time => $time];
                    })),
                Forms\Components\Select::make('localization_week_start')
                    ->label(__('Site Week Start'))
                    ->helperText(view('filament.components.helper_text_setting', ['value' => 'localization_week_start']))
                    ->options([
                        'monday' => 'Monday',
                        'tuesday' => 'Tuesday',
                        'wednesday' => 'Wednesday',
                        'thursday' => 'Thursday',
                        'friday' => 'Friday',
                        'saturday' => 'Saturday',
                        'sunday' => 'Sunday'
                    ])->default('monday'),
            ]);
    }

    public static function getnavigationGroup(): string
    {
        return __('Settings');
    }

    public static function getnavigationLabel(): string
    {
        return __('Localization Settings');
    }

    public function getTitle(): string
    {
        return __('Localization Settings');
    }
}
