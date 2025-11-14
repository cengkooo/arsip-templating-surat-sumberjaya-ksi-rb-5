<?php

namespace App\Filament\Widgets;

use App\Models\TemplateSurat;
use Filament\Widgets\ChartWidget;

class TemplateUsageChart extends ChartWidget
{
    protected static ?string $heading = 'Penggunaan Template';
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = 'full';

    protected function getData(): array
    {
        $templates = TemplateSurat::where('is_active', true)
            ->orderBy('usage_count', 'desc')
            ->take(10)
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Penggunaan',
                    'data' => $templates->pluck('usage_count')->toArray(),
                    'backgroundColor' => [
                        'rgba(255, 99, 132, 0.6)',
                        'rgba(54, 162, 235, 0.6)',
                        'rgba(255, 206, 86, 0.6)',
                        'rgba(75, 192, 192, 0.6)',
                        'rgba(153, 102, 255, 0.6)',
                        'rgba(255, 159, 64, 0.6)',
                        'rgba(199, 199, 199, 0.6)',
                        'rgba(83, 102, 255, 0.6)',
                        'rgba(255, 99, 255, 0.6)',
                        'rgba(99, 255, 132, 0.6)',
                    ],
                ],
            ],
            'labels' => $templates->pluck('nama_template')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
