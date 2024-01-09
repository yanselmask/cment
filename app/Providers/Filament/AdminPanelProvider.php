<?php

namespace App\Providers\Filament;

use Filament\Facades\Filament;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors([
                'primary' => Color::Amber,
                'info' => Color::Cyan
            ])
            ->navigationGroups([
                //ENGLISH
                __('Users'),
                __('Posts'),
                __('Settings'),
                //SPANISH
                __('Usuarios'),
                __('Publicaciones'),
                __('Configuraciones'),
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->plugin(
                \Althinect\FilamentSpatieRolesPermissions\FilamentSpatieRolesPermissionsPlugin::make()
            )
            ->plugin(
                \Hasnayeen\Themes\ThemesPlugin::make()
            )
            ->plugin(
                \DutchCodingCompany\FilamentSocialite\FilamentSocialitePlugin::make()
                    // (required) Add providers corresponding with providers in `config/services.php`.
                    ->setProviders([
                        // 'github' => [
                        //     'label' => 'GitHub',
                        //     // Custom icon requires an additional package, see below.
                        //     'icon' => 'fab-github',
                        // ],
                    ])
                    // (optional) Enable or disable registration from OAuth.
                    ->setRegistrationEnabled(true)
                    // (optional) Change the associated model class.
                    ->setUserModelClass(\App\Models\User::class)
            )
            ->plugin(
                \ShuvroRoy\FilamentSpatieLaravelBackup\FilamentSpatieLaravelBackupPlugin::make()
                    ->usingPage(\App\Filament\Pages\Backups::class)
            )
            ->plugin(
                \RyanChandler\FilamentNavigation\FilamentNavigation::make()
                    ->withExtraFields([
                        \Filament\Forms\Components\TextInput::make('id'),
                        \Filament\Forms\Components\TextInput::make('classes'),
                        \Filament\Forms\Components\TextInput::make('icon'),
                    ])
                    ->itemType('Post', [
                        \Filament\Forms\Components\Select::make('post_id')
                            ->label(__('Post'))
                            ->options(installed() ? \App\Models\Post::all()->map(function ($post) {
                                return [
                                    'id' => $post->title
                                ];
                            })->flatten() : [])
                    ])
                    ->itemType('Page', [
                        \Filament\Forms\Components\Select::make('page_id')
                            ->label(__('Page'))
                            ->options(installed() ? \App\Models\Page::all()->map(function ($page) {
                                return [
                                    'id' => $page->title
                                ];
                            })->flatten() : [])
                    ])

            )
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                \App\Filament\Widgets\StatsOverview::class,
                \App\Filament\Widgets\UserLastMonth::class,
            ])
            ->middleware([
                \Illuminate\Cookie\Middleware\EncryptCookies::class,
                \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
                \Illuminate\Session\Middleware\StartSession::class,
                \Illuminate\Session\Middleware\AuthenticateSession::class,
                \Illuminate\View\Middleware\ShareErrorsFromSession::class,
                \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class,
                \Illuminate\Routing\Middleware\SubstituteBindings::class,
                \Filament\Http\Middleware\DisableBladeIconComponents::class,
                \Filament\Http\Middleware\DispatchServingFilamentEvent::class,
                \Hasnayeen\Themes\Http\Middleware\SetTheme::class,
                \Shipu\WebInstaller\Middleware\RedirectIfNotInstalled::class,
            ])
            ->tenantMiddleware([
                \Hasnayeen\Themes\Http\Middleware\SetTheme::class
            ])
            ->authMiddleware([
                \Filament\Http\Middleware\Authenticate::class,
            ]);
    }

    public function boot(): void
    {

        if (installed()) {
            /** LANGUAGE */
            config(['language.allowed' => setting('localization_availables_languages')]);
            config(['app.locale' => setting('localization_default_language')]);
            config(['app.timezone' => setting('localization_timezone')]);
            /** MAIL */
            config(['mail.default' => setting('mail_mailer')]);
            config(['mail.mailers.smtp.host' => setting('mail_host')]);
            config(['mail.mailers.smtp.port' => setting('mail_port')]);
            config(['mail.mailers.smtp.username' => setting('mail_username')]);
            config(['mail.mailers.smtp.password' => setting('mail_password')]);
            config(['mail.mailers.smtp.encryption' => setting('mail_encryption')]);
            config(['mail.from.address' => setting('mail_from_address')]);
            config(['mail.from.name' => setting('mail_from_name')]);
        }

        /** MENU BUILDER */
        //NavigationResource
        \RyanChandler\FilamentNavigation\Filament\Resources\NavigationResource::NavigationLabel(__('Menu Builder'));
        //LanguageSwitch
        \BezhanSalleh\FilamentLanguageSwitch\LanguageSwitch::configureUsing(function (\BezhanSalleh\FilamentLanguageSwitch\LanguageSwitch $switch) {
            $switch
                ->locales(config('language.allowed')); // also accepts a closure
        });
        Filament::serving(function () {
            Filament::registerNavigationItems([
                NavigationItem::make(__('Translations'))
                    ->url(route('languages.index'), shouldOpenInNewTab: true)
                    ->icon('heroicon-o-language')
                    ->group(__('Settings'))
                    ->sort(2),
                NavigationItem::make(__('Site Health'))
                    ->url(route('pulse'), shouldOpenInNewTab: true)
                    ->icon('heroicon-o-cpu-chip')
                    ->group(__('Settings'))
                    ->sort(1),
            ]);
        });
    }
}
