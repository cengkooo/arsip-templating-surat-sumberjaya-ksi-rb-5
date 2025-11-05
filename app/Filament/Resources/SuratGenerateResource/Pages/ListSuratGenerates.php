<?php

namespace App\Filament\Resources\SuratGenerateResource\Pages;

use App\Filament\Resources\SuratGenerateResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSuratGenerates extends ListRecords
{
    protected static string $resource = SuratGenerateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
