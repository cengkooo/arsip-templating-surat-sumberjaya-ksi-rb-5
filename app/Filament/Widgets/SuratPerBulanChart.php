<?php

namespace App\Filament\Widgets;

use App\Models\ArsipSurat;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class SuratPerBulanChart extends ChartWidget
{
    protected static ?string $heading = 'Surat per Bulan';
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 6; // Set to 6 for side by side display

    protected function getData(): array
    {
        $data = Trend::model(ArsipSurat::class)
            ->between(
                start: now()->subMonths(11),
                end: now(),
            )
            ->perMonth()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Surat',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'borderColor' => 'rgb(59, 130, 246)',
                    'fill' => true,
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => date('M Y', strtotime($value->date))),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
