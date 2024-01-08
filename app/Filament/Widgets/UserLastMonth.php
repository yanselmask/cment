<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Contracts\Support\Htmlable;

class UserLastMonth extends ChartWidget
{

    protected int | string | array $columnSpan = 'full';

    protected function getData(): array
    {
        $data = Trend::model(\App\Models\User::class)
            ->between(
                start: now()->firstOfMonth(),
                end: now()->lastOfMonth(),
            )
            ->perDay()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => __('Registered users'),
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    public function getDescription(): ?string
    {
        return __('Users registered on the website last month');
    }

    public function getHeading(): string|Htmlable|null
    {
        return __('User statistics');
    }
}
