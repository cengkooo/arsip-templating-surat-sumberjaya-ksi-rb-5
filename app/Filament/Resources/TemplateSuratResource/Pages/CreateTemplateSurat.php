<?php

namespace App\Filament\Resources\TemplateSuratResource\Pages;

use App\Filament\Resources\TemplateSuratResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTemplateSurat extends CreateRecord
{
    protected static string $resource = TemplateSuratResource::class;
    
    protected function getRedirectUrl(): string
    {
        // Redirect ke halaman view template setelah create
        return $this->getResource()::getUrl('view', ['record' => $this->record]);
    }
    
    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Template berhasil dibuat! Klik "Gunakan Template" untuk membuat surat.';
    }
}
