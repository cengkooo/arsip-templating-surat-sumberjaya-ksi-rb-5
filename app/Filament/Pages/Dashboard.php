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
            \App\Filament\Widgets\ArsipSuratDashboardTable::class,
        ];
    }
    
    public function getColumns(): int | string | array
    {
        return 12;
    }

    public function getVisibleWidgets(): array
    {
        return $this->filterVisibleWidgets($this->getWidgets());
    }
}
