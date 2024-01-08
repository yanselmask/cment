<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Users', \App\Models\User::count()),
            Stat::make('Posts', \App\Models\Post::count()),
            Stat::make('Pages', \App\Models\Page::count()),
        ];
    }
}
