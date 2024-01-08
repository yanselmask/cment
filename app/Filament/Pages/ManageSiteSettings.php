<?php

namespace App\Filament\Pages;

use App\Settings\SiteSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\SettingsPage;
use Illuminate\Support\Facades\File;
use Qirolab\Theme\Theme;

class ManageSiteSettings extends SettingsPage
{
    protected static ?string $navigationIcon = 'heroicon-o-wrench-screwdriver';

    protected static string $settings = SiteSetting::class;

    public function form(Form $form): Form
    {
        $themes = $this->themes();
        return $form
            ->schema([
                Forms\Components\Fieldset::make('Logo')
                    ->schema([
                        Forms\Components\FileUpload::make('site_logo_light')
                            ->label(__('Site Logo Light'))
                            ->helperText(view('filament.components.helper_text_setting', ['value' => 'site_logo_light'])),
                        Forms\Components\FileUpload::make('site_logo_dark')
                            ->label(__('Site Logo Dark'))
                            ->helperText(view('filament.components.helper_text_setting', ['value' => 'site_logo_dark'])),

                    ])
                    ->columns(2),
                Forms\Components\Fieldset::make(__('Site Info'))
                    ->schema([
                        Forms\Components\TextInput::make('site_name')
                            ->label(__('Site Name'))
                            ->helperText(view('filament.components.helper_text_setting', ['value' => 'site_name']))
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('site_url')
                            ->label(__('Site Url'))
                            ->helperText(view('filament.components.helper_text_setting', ['value' => 'site_url']))
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('site_description')
                            ->label(__('Site Description'))
                            ->helperText(view('filament.components.helper_text_setting', ['value' => 'site_description']))
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('site_admin_email')
                            ->label(__('Site Admin Email'))
                            ->helperText(view('filament.components.helper_text_setting', ['value' => 'site_admin_email']))
                            ->required()
                            ->maxLength(255),
                    ])
                    ->columns(2),
                Forms\Components\Fieldset::make(__('Terms'))
                    ->schema([
                        Forms\Components\TextInput::make('site_privacy_url')
                            ->label(__('Site Privacy Url'))
                            ->helperText(view('filament.components.helper_text_setting', ['value' => 'site_privacy_url']))
                            ->maxLength(255),
                        Forms\Components\TextInput::make('site_terms_url')
                            ->label(__('Site Terms Url'))
                            ->helperText(view('filament.components.helper_text_setting', ['value' => 'site_terms_url']))
                            ->maxLength(255),
                        Forms\Components\TextInput::make('site_cookies_url')
                            ->label(__('Site Cookies Url'))
                            ->helperText(view('filament.components.helper_text_setting', ['value' => 'site_cookies_url']))
                            ->maxLength(255),

                    ])
                    ->columns(3),
                Forms\Components\Fieldset::make(__('Themes'))
                    ->schema([
                        Forms\Components\Radio::make('site_theme_active')
                            ->label(__('Choose the theme you want to activate'))
                            ->options($themes)
                            ->required()
                            ->columns(3)
                            ->helperText(view('filament.components.helper_text_setting', ['value' => 'site_theme_active'])),
                        \Wiebenieuwenhuis\FilamentCodeEditor\Components\CodeEditor::make('site_front_css')
                            ->label(__('Site Front CSS'))
                            ->helperText(view('filament.components.helper_text_setting', ['value' => 'site_front_css'])),
                        \Wiebenieuwenhuis\FilamentCodeEditor\Components\CodeEditor::make('site_front_js')
                            ->label(__('Site Front JS'))
                            ->helperText(view('filament.components.helper_text_setting', ['value' => 'site_front_js'])),
                    ])
                    ->columns('full'),
                Forms\Components\Fieldset::make(__('Editors'))
                    ->schema([
                        Forms\Components\Select::make('site_post_editor')
                            ->options($this->editors())
                            ->label(__('Site Post Editor'))
                            ->helperText(view('filament.components.helper_text_setting', ['value' => 'site_post_editor'])),
                        Forms\Components\Select::make('site_page_editor')
                            ->options($this->editors('grapejs', 'GrapeJS'))
                            ->label(__('Site Page Editor'))
                            ->helperText(view('filament.components.helper_text_setting', ['value' => 'site_page_editor'])),
                    ])
                    ->columns(2),
                Forms\Components\Fieldset::make(__('Maintenance'))
                    ->schema([
                        Forms\Components\Checkbox::make('site_maintenance_status')
                            ->label(__('Site Maintenance Status'))
                            ->helperText(view('filament.components.helper_text_setting', ['value' => 'site_maintenance_status'])),
                        Forms\Components\Textarea::make('site_maintenance_message')
                            ->label(__('Site Maintenance Message'))
                            ->helperText(view('filament.components.helper_text_setting', ['value' => 'site_maintenance_message']))
                            ->maxLength(255),

                    ])
                    ->columns(2),
                Forms\Components\Fieldset::make(__('Social Media'))
                    ->schema([
                        Forms\Components\KeyValue::make('site_social_media_links')
                            ->reorderable()
                            ->label(__('Social Media Links'))
                            ->helperText(view('filament.components.helper_text_setting', ['value' => 'site_social_media_links']))

                    ])
                    ->columns('full'),
            ]);
    }

    public function editors($key = null, $value = null)
    {
        $default = [
            'markdown' => 'Markdown',
            'ckeditor' => 'CKEditor',
            'froala' => 'Froala',
            'quill' => 'Quill',
            'tiny' => 'Tiny',
            'editorjs' => 'EditorJS'
        ];

        if ($key && $value) {
            $default[$key] = $value;

            return $default;
        }

        return $default;
    }

    public static function getnavigationGroup(): string
    {
        return __('Settings');
    }

    public static function getnavigationLabel(): string
    {
        return __('Site Settings');
    }

    public function getTitle(): string
    {
        return __('Site Settings');
    }

    public function themes()
    {
        $directoryPath = base_path('themes');
        $themes = File::isDirectory($directoryPath) ? collect(File::directories($directoryPath))->mapWithKeys(function ($dir) {
            $path = str_replace(base_path('themes') . '/', '', $dir);
            return [strtolower($path) => $path];
        }) : [];

        return $themes;
    }
}
