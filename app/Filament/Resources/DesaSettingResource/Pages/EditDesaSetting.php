<?php

namespace App\Filament\Resources\DesaSettingResource\Pages;

use App\Filament\Resources\DesaSettingResource;
use App\Models\DesaSetting;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditDesaSetting extends EditRecord
{
    protected static string $resource = DesaSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('preview')
                ->label('Preview Data')
                ->icon('heroicon-o-eye')
                ->color('info')
                ->action(function () {
                    Notification::make()
                        ->title('Data Pengaturan Desa')
                        ->body('Data berhasil disimpan dan tersedia untuk semua template surat.')
                        ->success()
                        ->send();
                }),
        ];
    }
    
    /**
     * Override mount to handle the record properly
     */
    public function mount(int | string $record): void
    {
        parent::mount($record);
    }
    
    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Ensure is_active is always true for the only record
        $data['is_active'] = true;
        
        return $data;
    }
    
    protected function getSavedNotification(): ?\Filament\Notifications\Notification
    {
        return Notification::make()
            ->success()
            ->title('Pengaturan Desa Berhasil Diperbarui')
            ->body('Data desa telah disimpan dan akan digunakan untuk semua surat.');
    }
}
