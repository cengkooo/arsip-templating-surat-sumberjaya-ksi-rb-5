<?php

namespace App\Filament\Widgets;

use App\Models\ArsipSurat;
use App\Models\TemplateSurat;
use Filament\Widgets\Widget;

class DashboardStatsActions extends Widget
{
    protected static string $view = 'filament.widgets.dashboard-stats-actions';
    protected int | string | array $columnSpan = 'full';

    public function getViewData(): array
    {
        return [
            'totalSurat' => ArsipSurat::count(),
            'totalArsip' => ArsipSurat::where('status', 'selesai')->count(),
            'totalTemplate' => TemplateSurat::where('is_active', true)->count(),
            'totalBaru' => 0, // Default value for the new card
        ];
    }
}
