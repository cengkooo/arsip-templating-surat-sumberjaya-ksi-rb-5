<?php

namespace App\Filament\Resources\TemplateSuratResource\Pages;

use App\Filament\Resources\TemplateSuratResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components;

class ViewTemplateSurat extends ViewRecord
{
    protected static string $resource = TemplateSuratResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->icon('heroicon-o-pencil')
                ->color('warning'),
            
            Actions\DeleteAction::make()
                ->icon('heroicon-o-trash')
                ->requiresConfirmation(),
            
            Actions\Action::make('use_template')
                ->label('Gunakan Template')
                ->icon('heroicon-o-document-plus')
                ->color('success')
                ->url(fn ($record) => route('filament.admin.resources.arsip-surats.create-from-template', ['template' => $record->id]))
                ->visible(fn ($record) => $record->is_active)
                ->tooltip('Buat surat baru menggunakan template ini'),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Components\Section::make('Informasi Template')
                    ->schema([
                        Components\TextEntry::make('kode_template')
                            ->label('Kode Template')
                            ->badge()
                            ->color('info')
                            ->copyable(),
                        
                        Components\TextEntry::make('nama_template')
                            ->label('Nama Template')
                            ->size('lg')
                            ->weight('bold'),
                        
                        Components\TextEntry::make('kategori.nama')
                            ->label('Kategori')
                            ->badge()
                            ->color('success'),
                        
                        Components\IconEntry::make('is_active')
                            ->label('Status')
                            ->boolean()
                            ->trueIcon('heroicon-o-check-circle')
                            ->falseIcon('heroicon-o-x-circle')
                            ->trueColor('success')
                            ->falseColor('danger'),
                        
                        Components\TextEntry::make('keterangan')
                            ->label('Keterangan')
                            ->columnSpanFull()
                            ->placeholder('Tidak ada keterangan'),
                    ])
                    ->columns(2),
                
                Components\Section::make('Pengaturan Halaman')
                    ->schema([
                        Components\TextEntry::make('ukuran_kertas')
                            ->label('Ukuran Kertas')
                            ->badge()
                            ->color('gray'),
                        
                        Components\TextEntry::make('orientasi')
                            ->label('Orientasi')
                            ->badge()
                            ->color('gray')
                            ->formatStateUsing(fn (string $state): string => ucfirst($state)),
                        
                        Components\TextEntry::make('usage_count')
                            ->label('Jumlah Penggunaan')
                            ->badge()
                            ->color('success')
                            ->suffix(' kali digunakan'),
                    ])
                    ->columns(3),
                
                Components\Section::make('Variable Template')
                    ->schema([
                        Components\TextEntry::make('variables')
                            ->label('Daftar Variable')
                            ->badge()
                            ->separator(',')
                            ->placeholder('Tidak ada variable')
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),
                
                Components\Section::make('Preview Template')
                    ->schema([
                        Components\ViewEntry::make('content_preview')
                            ->label('')
                            ->view('filament.infolists.template-preview')
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),
                
                Components\Section::make('Detail Sistem')
                    ->schema([
                        Components\TextEntry::make('created_at')
                            ->label('Dibuat Pada')
                            ->dateTime('d F Y, H:i'),
                        
                        Components\TextEntry::make('updated_at')
                            ->label('Terakhir Diupdate')
                            ->dateTime('d F Y, H:i')
                            ->since(),
                    ])
                    ->columns(2)
                    ->collapsible()
                    ->collapsed(),
            ]);
    }
}