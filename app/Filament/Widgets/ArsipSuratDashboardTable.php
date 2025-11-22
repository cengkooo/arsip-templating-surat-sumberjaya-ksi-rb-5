<?php

namespace App\Filament\Widgets;

use App\Models\ArsipSurat;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class ArsipSuratDashboardTable extends BaseWidget
{
    protected static ?string $heading = 'Arsip Surat';
    protected static ?int $sort = 5;
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                ArsipSurat::query()
                    ->latest('tanggal_surat')
            )
            ->columns([
                Tables\Columns\TextColumn::make('nomor_surat')
                    ->label('Nomor Surat')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('perihal')
                    ->label('Perihal')
                    ->limit(30)
                    ->searchable(),

                Tables\Columns\TextColumn::make('tanggal_surat')
                    ->label('Tanggal')
                    ->date('d/m/Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('kategori.nama')
                    ->label('Kategori')
                    ->badge(),

                Tables\Columns\TextColumn::make('jenis')
                    ->label('Jenis')
                    ->badge()
                    ->color(fn (string $state) => $state === 'masuk' ? 'info' : 'warning')
                    ->formatStateUsing(fn (string $state) => ucfirst($state)),

                Tables\Columns\SelectColumn::make('status')
                    ->label('Status')
                    ->options([
                        'draft' => 'Draft',
                        'belum_lengkap' => 'Belum Lengkap',
                        'menunggu_ttd' => 'Menunggu Tanda Tangan',
                        'siap_dicetak' => 'Siap Dicetak',
                    ])
                    ->selectablePlaceholder(false)
                    ->rules(['required']),

                Tables\Columns\IconColumn::make('file_path')
                    ->label('File')
                    ->boolean()
                    ->trueIcon('heroicon-m-arrow-down-tray')
                    ->falseIcon('heroicon-m-document-x-mark')
                    ->tooltip(fn ($record) => $record->file_path ? 'Download' : 'Belum ada file')
                    ->url(fn (ArsipSurat $record) => $record->file_url, shouldOpenInNewTab: true),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label('Lihat')
                    ->icon('heroicon-m-eye')
                    ->url(fn (ArsipSurat $record) => route('filament.admin.resources.arsip-surats.view', $record)),
                Tables\Actions\Action::make('edit')
                    ->label('Edit')
                    ->icon('heroicon-m-pencil-square')
                    ->color('warning')
                    ->url(fn (ArsipSurat $record) => route('filament.admin.resources.arsip-surats.edit', $record)),
            ])
            ->defaultPaginationPageOption(10);
    }
}
