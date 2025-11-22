<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArsipSuratResource\Pages;
use App\Models\ArsipSurat;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;

class ArsipSuratResource extends Resource
{
    protected static ?string $model = ArsipSurat::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';
    protected static ?string $navigationGroup = 'Surat';
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationLabel = 'Arsip Surat';

    public static function getModelLabel(): string
    {
        return 'Arsip Surat';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Arsip Surat';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Surat')
                    ->schema([
                        Forms\Components\Select::make('kategori_id')
                            ->relationship('kategori', 'nama')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->label('Kategori'),
                        
                        Forms\Components\Select::make('jenis')
                            ->options([
                                'masuk' => 'Surat Masuk',
                                'keluar' => 'Surat Keluar',
                            ])
                            ->required()
                            ->native(false)
                            ->live(), // Real-time update
                        
                        Forms\Components\TextInput::make('nomor_surat')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(100)
                            ->label('Nomor Surat')
                            ->placeholder('Contoh: 001/SM/2024'),
                        
                        Forms\Components\DatePicker::make('tanggal_surat')
                            ->required()
                            ->native(false)
                            ->displayFormat('d/m/Y')
                            ->label('Tanggal Surat'),
                        
                        Forms\Components\DatePicker::make('tanggal_terima')
                            ->native(false)
                            ->displayFormat('d/m/Y')
                            ->label('Tanggal Terima')
                            ->visible(fn ($get) => $get('jenis') === 'masuk'),
                        
                        Forms\Components\TextInput::make('perihal')
                            ->required()
                            ->maxLength(255)
                            ->label('Perihal/Judul')
                            ->placeholder('Contoh: Undangan Rapat Desa'),
                    ])
                    ->columns(2),
                
                Forms\Components\Section::make('Detail Surat')
                    ->schema([
                        Forms\Components\TextInput::make('pengirim')
                            ->maxLength(255)
                            ->label('Pengirim')
                            ->visible(fn ($get) => $get('jenis') === 'masuk'),
                        
                        Forms\Components\TextInput::make('penerima')
                            ->maxLength(255)
                            ->label('Penerima')
                            ->visible(fn ($get) => $get('jenis') === 'keluar'),
                        
                        Forms\Components\Textarea::make('isi_ringkas')
                            ->rows(3)
                            ->label('Ringkasan Isi Surat')
                            ->columnSpanFull(),
                        
                        Forms\Components\Select::make('status')
                            ->options([
                                'draft' => 'Draft',
                                'terkirim' => 'Terkirim',
                                'diarsipkan' => 'Diarsipkan',
                                'selesai' => 'Selesai',
                            ])
                            ->required()
                            ->native(false)
                            ->default('draft'),
                        
                        Forms\Components\Textarea::make('catatan')
                            ->rows(2)
                            ->label('Catatan'),
                    ])
                    ->columns(2),
                
                Forms\Components\Section::make('Upload File')
                    ->schema([
                        Forms\Components\FileUpload::make('file_path')
                            ->label('File Surat')
                            ->disk('public')
                            ->directory('arsip-surat')
                            ->acceptedFileTypes(['application/pdf', 'image/*', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
                            ->maxSize(5120) // 5MB
                            ->downloadable()
                            ->previewable()
                            ->helperText('Format: PDF, DOC, DOCX, atau Gambar. Maksimal 5MB'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nomor_surat')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->label('No. Surat'),
                
                Tables\Columns\TextColumn::make('tanggal_surat')
                    ->date('d/m/Y')
                    ->sortable()
                    ->label('Tanggal'),
                
                Tables\Columns\TextColumn::make('perihal')
                    ->searchable()
                    ->limit(40)
                    ->tooltip(function ($record) {
                        return $record->perihal;
                    }),
                
                Tables\Columns\TextColumn::make('kategori.nama')
                    ->badge()
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('jenis')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'masuk' => 'info',
                        'keluar' => 'warning',
                    })
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),
                
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'draft' => 'gray',
                        'terkirim' => 'success',
                        'diarsipkan' => 'info',
                        'selesai' => 'success',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),
                
                Tables\Columns\TextColumn::make('pengirim')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                
                Tables\Columns\IconColumn::make('file_path')
                    ->boolean()
                    ->label('File')
                    ->trueIcon('heroicon-o-document-check')
                    ->falseIcon('heroicon-o-document-minus'),
            ])
            ->filters([
                SelectFilter::make('kategori')
                    ->relationship('kategori', 'nama')
                    ->searchable()
                    ->preload(),
                
                SelectFilter::make('jenis')
                    ->options([
                        'masuk' => 'Surat Masuk',
                        'keluar' => 'Surat Keluar',
                    ]),
                
                SelectFilter::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'terkirim' => 'Terkirim',
                        'diarsipkan' => 'Diarsipkan',
                        'selesai' => 'Selesai',
                    ]),
                
                Tables\Filters\Filter::make('tanggal_surat')
                    ->form([
                        Forms\Components\DatePicker::make('dari'),
                        Forms\Components\DatePicker::make('sampai'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['dari'], fn ($q, $date) => $q->whereDate('tanggal_surat', '>=', $date))
                            ->when($data['sampai'], fn ($q, $date) => $q->whereDate('tanggal_surat', '<=', $date));
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('download')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('success')
                    ->url(fn ($record) => $record->file_url)
                    ->openUrlInNewTab()
                    ->visible(fn ($record) => $record->file_path !== null),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('tanggal_surat', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListArsipSurats::route('/'),
            'create' => Pages\CreateArsipSurat::route('/create'),
            'create-from-template' => Pages\CreateFromTemplate::route('/create-from-template'),
            'edit' => Pages\EditArsipSurat::route('/{record}/edit'),
            'view' => Pages\ViewArsipSurat::route('/{record}'),
        ];
    }
}
