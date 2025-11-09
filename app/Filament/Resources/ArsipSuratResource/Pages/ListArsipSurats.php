<?php

namespace App\Filament\Resources\ArsipSuratResource\Pages;

use App\Filament\Resources\ArsipSuratResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListArsipSurats extends ListRecords
{
    protected static string $resource = ArsipSuratResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('create_from_template')
                ->label('Buat Surat dari Template')
                ->icon('heroicon-o-document-plus')
                ->color('success')
                ->url(ArsipSuratResource::getUrl('create-from-template'))
                ->tooltip('Generate surat otomatis dari template, akan langsung jadi PDF'),
            Actions\CreateAction::make()
                ->label('Tambah Surat Manual')
                ->icon('heroicon-o-document-arrow-up')
                ->color('gray')
                ->tooltip('Input surat yang sudah ada (scan/dokumen existing)'),
        ];
    }
}
