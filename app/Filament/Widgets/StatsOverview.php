<?php

namespace App\Filament\Widgets;

use App\Models\ArsipSurat;
use App\Models\TemplateSurat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $totalSurat = ArsipSurat::count();
        $totalArsip = ArsipSurat::where('status', 'selesai')->count();
        $totalTemplate = TemplateSurat::where('is_active', true)->count();
        $suratPending = ArsipSurat::where('status', 'draft')->count();

        return [
            Stat::make('Total Surat', $totalSurat)
                ->description('Semua surat yang dibuat')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('success')
                ->chart([7, 3, 4, 5, 6, 3, 5, 3]),
            
            Stat::make('Total Arsip', $totalArsip)
                ->description('Surat yang sudah selesai')
                ->descriptionIcon('heroicon-m-archive-box')
                ->color('primary')
                ->chart([3, 5, 6, 7, 8, 5, 6, 4]),
            
            Stat::make('Total Template', $totalTemplate)
                ->description('Template surat aktif')
                ->descriptionIcon('heroicon-m-document-duplicate')
                ->color('warning')
                ->chart([2, 3, 4, 3, 5, 4, 6, 5]),
            
            Stat::make('Surat Pending', $suratPending)
                ->description('Menunggu finalisasi')
                ->descriptionIcon('heroicon-m-clock')
                ->color('danger')
                ->chart([1, 2, 1, 3, 2, 1, 2, 1]),
        ];
    }
}
