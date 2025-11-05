<?php

namespace App\Filament\Resources\SuratGenerateResource\Pages;

use App\Filament\Resources\SuratGenerateResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components;

class ViewSuratGenerate extends ViewRecord
{
    protected static string $resource = SuratGenerateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->icon('heroicon-o-pencil')
                ->color('warning')
                ->visible(fn ($record) => $record->status === 'draft'),
            
            Actions\DeleteAction::make()
                ->icon('heroicon-o-trash')
                ->requiresConfirmation(),
            
            Actions\Action::make('generate_pdf')
                ->label('Generate PDF')
                ->icon('heroicon-o-document-arrow-down')
                ->color('success')
                ->action(function ($record) {
                    app(\App\Services\PdfGeneratorService::class)->generate($record);
                })
                ->requiresConfirmation()
                ->successNotificationTitle('PDF berhasil digenerate!')
                ->visible(fn ($record) => $record->file_pdf_path === null),
            
            Actions\Action::make('download')
                ->label('Download PDF')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('info')
                ->url(fn ($record) => $record->pdf_url)
                ->openUrlInNewTab()
                ->visible(fn ($record) => $record->file_pdf_path !== null),
            
            Actions\Action::make('regenerate')
                ->label('Generate Ulang')
                ->icon('heroicon-o-arrow-path')
                ->color('warning')
                ->action(function ($record) {
                    app(\App\Services\PdfGeneratorService::class)->generate($record);
                })
                ->requiresConfirmation()
                ->modalDescription('Generate ulang akan menimpa PDF yang sudah ada. Lanjutkan?')
                ->successNotificationTitle('PDF berhasil digenerate ulang!')
                ->visible(fn ($record) => $record->file_pdf_path !== null),
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
                        
                        Components\TextEntry::make('tanggal_surat')
                            ->label('Tanggal Surat')
                            ->date('d F Y')
                            ->icon('heroicon-o-calendar'),
                        
                        Components\TextEntry::make('status')
                            ->label('Status')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'draft' => 'gray',
                                'final' => 'success',
                                'terkirim' => 'info',
                            })
                            ->formatStateUsing(fn (string $state): string => strtoupper($state)),
                        
                        Components\TextEntry::make('generated_at')
                            ->label('Waktu Generate')
                            ->dateTime('d F Y, H:i')
                            ->icon('heroicon-o-clock')
                            ->placeholder('Belum digenerate')
                            ->badge()
                            ->color(fn ($state) => $state ? 'success' : 'gray'),
                    ])
                    ->columns(2),
                
                Components\Section::make('Template yang Digunakan')
                    ->schema([
                        Components\TextEntry::make('templateSurat.nama_template')
                            ->label('Nama Template')
                            ->size('lg'),
                        
                        Components\TextEntry::make('templateSurat.kode_template')
                            ->label('Kode Template')
                            ->badge()
                            ->color('info'),
                        
                        Components\TextEntry::make('templateSurat.kategori.nama')
                            ->label('Kategori')
                            ->badge(),
                        
                        Components\TextEntry::make('templateSurat.ukuran_kertas')
                            ->label('Ukuran Kertas')
                            ->badge()
                            ->color('gray'),
                    ])
                    ->columns(2),
                
                Components\Section::make('Data Variable')
                    ->schema([
                        Components\KeyValueEntry::make('data_variables')
                            ->label('Data yang Diisi')
                            ->keyLabel('Variable')
                            ->valueLabel('Data')
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),
                
                Components\Section::make('Preview Konten')
                    ->schema([
                        Components\TextEntry::make('content_final')
                            ->label('')
                            ->html()
                            ->columnSpanFull()
                            ->placeholder('Belum digenerate'),
                    ])
                    ->visible(fn ($record) => $record->content_final !== null)
                    ->collapsible()
                    ->collapsed(),
                
                Components\Section::make('File PDF')
                    ->schema([
                        Components\TextEntry::make('file_pdf_path')
                            ->label('File PDF')
                            ->formatStateUsing(fn ($state) => $state ? basename($state) : 'Belum digenerate')
                            ->icon(fn ($state) => $state ? 'heroicon-o-document-check' : 'heroicon-o-document-minus')
                            ->color(fn ($state) => $state ? 'success' : 'gray')
                            ->url(fn ($record) => $record->pdf_url)
                            ->openUrlInNewTab(),
                    ])
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
                
                Components\Section::make('Informasi Pembuat')
                    ->schema([
                        Components\TextEntry::make('user.name')
                            ->label('Dibuat Oleh')
                            ->icon('heroicon-o-user'),
                        
                        Components\TextEntry::make('user.email')
                            ->label('Email')
                            ->icon('heroicon-o-envelope')
                            ->copyable(),
                        
                        Components\TextEntry::make('created_at')
                            ->label('Dibuat Pada')
                            ->dateTime('d F Y, H:i')
                            ->icon('heroicon-o-clock'),
                        
                        Components\TextEntry::make('updated_at')
                            ->label('Terakhir Diupdate')
                            ->dateTime('d F Y, H:i')
                            ->since()
                            ->icon('heroicon-o-arrow-path'),
                    ])
                    ->columns(2)
                    ->collapsible()
                    ->collapsed(),
            ]);
    }
}