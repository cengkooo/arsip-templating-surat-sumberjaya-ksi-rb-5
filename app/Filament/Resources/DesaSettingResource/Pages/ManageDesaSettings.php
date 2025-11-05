<?php

namespace App\Filament\Resources\DesaSettingResource\Pages;

use App\Filament\Resources\DesaSettingResource;
use App\Models\DesaSetting;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use Filament\Notifications\Notification;

class ManageDesaSettings extends ManageRecords
{
    protected static string $resource = DesaSettingResource::class;

    protected function getHeaderActions(): array
    {
        // Jika sudah ada data, hanya tampilkan tombol edit
        if (DesaSetting::exists()) {
            return [];
        }
        
        return [
            Actions\CreateAction::make()
                ->label('Buat Pengaturan Desa')
                ->after(function () {
                    Notification::make()
                        ->title('Pengaturan Desa berhasil dibuat!')
                        ->success()
                        ->send();
                }),
        ];
    }
    
    public function mount(): void
    {
        // Auto-redirect ke edit jika sudah ada data
        $setting = DesaSetting::getActive();
        
        if ($setting) {
            redirect()->to(DesaSettingResource::getUrl('index') . '/' . $setting->id . '/edit');
        }
    }
}
