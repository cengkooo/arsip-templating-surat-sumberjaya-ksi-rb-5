<?php

namespace App\Filament\Resources\ArsipSuratResource\Pages;

use App\Filament\Resources\ArsipSuratResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components;
use Illuminate\Support\Str;

class ViewArsipSurat extends ViewRecord
{
    protected static string $resource = ArsipSuratResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->icon('heroicon-o-pencil')
                ->color('warning'),
            
            Actions\DeleteAction::make()
                ->icon('heroicon-o-trash')
                ->requiresConfirmation(),
            
            Actions\Action::make('download')
                ->label('Download File')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success')
                ->url(fn ($record) => $record->file_url)
                ->openUrlInNewTab()
                ->visible(fn ($record) => $record->file_path !== null),
            
            Actions\Action::make('print')
                ->label('Cetak')
                ->icon('heroicon-o-printer')
                ->color('info')
                ->url(fn ($record) => $record->file_url)
                ->openUrlInNewTab()
                ->visible(fn ($record) => $record->file_path !== null),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Components\Section::make('Informasi Surat')
                    ->schema([
                        Components\TextEntry::make('nomor_surat')
                            ->label('Nomor Surat')
                            ->size('lg')
                            ->weight('bold')
                            ->copyable()
                            ->icon('heroicon-o-document-text'),
                        
                        Components\TextEntry::make('kategori.nama')
                            ->label('Kategori')
                            ->badge()
                            ->color('info'),
                        
                        Components\TextEntry::make('jenis')
                            ->label('Jenis Surat')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'masuk' => 'success',
                                'keluar' => 'warning',
                            })
                            ->formatStateUsing(fn (string $state): string => strtoupper($state)),
                        
                        Components\TextEntry::make('status')
                            ->label('Status')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'draft' => 'gray',
                                'terkirim' => 'success',
                                'diarsipkan' => 'info',
                            })
                            ->formatStateUsing(fn (string $state): string => ucfirst($state)),
                    ])
                    ->columns(2),
                
                Components\Section::make('Perihal & Isi')
                    ->schema([
                        Components\TextEntry::make('perihal')
                            ->label('Perihal/Judul')
                            ->size('lg')
                            ->columnSpanFull(),
                        
                        Components\TextEntry::make('isi_ringkas')
                            ->label('Ringkasan Isi Surat')
                            ->markdown()
                            ->columnSpanFull()
                            ->placeholder('Tidak ada ringkasan'),
                    ]),
                
                Components\Section::make('Tanggal & Pihak Terkait')
                    ->schema([
                        Components\TextEntry::make('tanggal_surat')
                            ->label('Tanggal Surat')
                            ->date('d F Y')
                            ->icon('heroicon-o-calendar'),
                        
                        Components\TextEntry::make('tanggal_terima')
                            ->label('Tanggal Diterima')
                            ->date('d F Y')
                            ->icon('heroicon-o-calendar-days')
                            ->placeholder('Belum diterima')
                            ->visible(fn ($record) => $record->jenis === 'masuk'),
                        
                        Components\TextEntry::make('pengirim')
                            ->label('Pengirim')
                            ->icon('heroicon-o-user')
                            ->placeholder('Tidak ada data')
                            ->visible(fn ($record) => $record->jenis === 'masuk'),
                        
                        Components\TextEntry::make('penerima')
                            ->label('Penerima')
                            ->icon('heroicon-o-user')
                            ->placeholder('Tidak ada data')
                            ->visible(fn ($record) => $record->jenis === 'keluar'),
                    ])
                    ->columns(2),
                
                Components\Section::make('File Lampiran')
                    ->schema([
                        Components\ImageEntry::make('file_path')
                            ->label('Preview File')
                            ->disk('public')
                            ->visibility('public')
                            ->columnSpanFull()
                            ->visible(function ($record) {
                                if (!$record->file_path) return false;
                                
                                $extension = strtolower(pathinfo($record->file_path, PATHINFO_EXTENSION));
                                return in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg']);
                            }),
                        
                        Components\TextEntry::make('file_path')
                            ->label('File Surat')
                            ->formatStateUsing(fn ($state) => $state ? basename($state) : 'Tidak ada file')
                            ->icon('heroicon-o-document')
                            ->color(fn ($state) => $state ? 'success' : 'gray')
                            ->url(fn ($record) => $record->file_url)
                            ->openUrlInNewTab()
                            ->columnSpanFull(),
                    ])
                    ->visible(fn ($record) => $record->file_path !== null)
                    ->collapsible(),
                
                Components\Section::make('Catatan')
                    ->schema([
                        Components\TextEntry::make('catatan')
                            ->label('')
                            ->markdown()
                            ->columnSpanFull()
                            ->placeholder('Tidak ada catatan'),
                    ])
                    ->collapsible()
                    ->collapsed(),
                
                Components\Section::make('Informasi Sistem')
                    ->schema([
                        Components\TextEntry::make('created_at')
                            ->label('Dibuat Pada')
                            ->dateTime('d F Y, H:i')
                            ->icon('heroicon-o-clock'),
                        
                        Components\TextEntry::make('updated_at')
                            ->label('Terakhir Diupdate')
                            ->dateTime('d F Y, H:i')
                            ->since()
                            ->icon('heroicon-o-arrow-path'),
                        
                        Components\TextEntry::make('deleted_at')
                            ->label('Dihapus Pada')
                            ->dateTime('d F Y, H:i')
                            ->placeholder('Arsip aktif')
                            ->icon('heroicon-o-trash')
                            ->color('danger')
                            ->visible(fn ($record) => $record->deleted_at !== null),
                    ])
                    ->columns(2)
                    ->collapsible()
                    ->collapsed(),
            ]);
    }
}