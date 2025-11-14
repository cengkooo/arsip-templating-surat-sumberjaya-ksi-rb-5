<?php

namespace App\Filament\Widgets;

use App\Models\ArsipSurat;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentSuratTable extends BaseWidget
{
    protected static ?string $heading = 'Surat Terbaru';
    protected static ?int $sort = 4;
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                ArsipSurat::query()
                    ->latest()
                    ->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('nomor_surat')
                    ->label('Nomor Surat')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('perihal')
                    ->label('Perihal')
                    ->limit(30)
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('tanggal_surat')
                    ->label('Tanggal')
                    ->date('d/m/Y')
                    ->sortable(),
                
                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'warning' => 'draft',
                        'success' => 'selesai',
                        'danger' => 'dibatalkan',
                    ]),
                
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Dibuat Oleh')
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label('Lihat')
                    ->icon('heroicon-m-eye')
                    ->url(fn (ArsipSurat $record): string => route('filament.admin.resources.arsip-surats.view', $record)),
            ]);
    }
}
