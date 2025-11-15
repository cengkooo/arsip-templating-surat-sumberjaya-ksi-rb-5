<?php

namespace App\Filament\Widgets;

use App\Models\DesaSetting;
use App\Models\TemplateSurat;
use Filament\Widgets\Widget;
use Illuminate\Support\Str;

class QuickActions extends Widget
{
    protected static ?int $sort = 5;
    protected static string $view = 'filament.widgets.quick-actions';
    protected int | string | array $columnSpan = 'full';

    protected function getViewData(): array
    {
        $templateUsage = TemplateSurat::query()
            ->select(['nama_template', 'usage_count'])
            ->orderByDesc('usage_count')
            ->limit(7)
            ->get();

        return [
            'templateUsageLabels' => $templateUsage
                ->pluck('nama_template')
                ->map(fn (string $name) => Str::limit($name, 24))
                ->all(),
            'templateUsageCounts' => $templateUsage->pluck('usage_count')->all(),
            'desa' => DesaSetting::getActive(),
            'totalUsageCount' => (int) $templateUsage->sum('usage_count'),
        ];
    }
}
