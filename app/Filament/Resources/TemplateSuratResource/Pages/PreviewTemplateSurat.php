<?php

namespace App\Filament\Resources\TemplateSuratResource\Pages;

use App\Filament\Resources\TemplateSuratResource;
use Filament\Resources\Pages\Page;
use App\Models\TemplateSurat;

class PreviewTemplateSurat extends Page
{
    protected static string $resource = TemplateSuratResource::class;

    protected static string $view = 'filament.resources.template-surat-resource.pages.preview-template-surat';

    public $record;

    public function mount(int | string $record): void
    {
        // Load record dari database
        $this->record = TemplateSurat::findOrFail($record);
    }
}