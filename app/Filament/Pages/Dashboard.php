<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    public function getWidgets(): array
    {
        return [
            \App\Filament\Widgets\StatsOverview::class,
            \App\Filament\Widgets\SuratPerBulanChart::class,
            \App\Filament\Widgets\TemplateUsageChart::class,
            \App\Filament\Widgets\RecentSuratTable::class,
            \App\Filament\Widgets\QuickActions::class,
        ];
    }
    
    public function getColumns(): int | string | array
    {
        return 2;
    }
}
