<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TemplateSuratResource\Pages;
use App\Models\TemplateSurat;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TemplateSuratResource extends Resource
{
    protected static ?string $model = TemplateSurat::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Surat';
    protected static ?int $navigationSort = 3;
    protected static ?string $navigationLabel = 'Template Surat';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Template')
                    ->schema([
                        Forms\Components\Select::make('kategori_id')
                            ->relationship('kategori', 'nama')
                            ->required()
                            ->searchable()
                            ->preload(),
                        
                        Forms\Components\TextInput::make('nama_template')
                            ->required()
                            ->maxLength(255)
                            ->label('Nama Template')
                            ->placeholder('Contoh: Template Surat Keterangan'),
                        
                        Forms\Components\TextInput::make('kode_template')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(50)
                            ->label('Kode Template')
                            ->placeholder('Contoh: SK-001')
                            ->helperText('Kode unik untuk template ini'),
                        
                        Forms\Components\Textarea::make('keterangan')
                            ->rows(2)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
                
                Forms\Components\Section::make('Pengaturan Halaman')
                    ->schema([
                        Forms\Components\Select::make('orientasi')
                            ->options([
                                'portrait' => 'Portrait (Tegak)',
                                'landscape' => 'Landscape (Mendatar)',
                            ])
                            ->required()
                            ->native(false)
                            ->default('portrait'),
                        
                        Forms\Components\Select::make('ukuran_kertas')
                            ->options([
                                'A4' => 'A4 (21 x 29.7 cm)',
                                'F4' => 'F4 (21.5 x 33 cm)',
                                'Letter' => 'Letter (21.6 x 27.9 cm)',
                            ])
                            ->required()
                            ->native(false)
                            ->default('A4'),
                        
                        Forms\Components\Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true),
                    ])
                    ->columns(3),
                
                Forms\Components\Section::make('Konten Template')
                    ->schema([
                        Forms\Components\RichEditor::make('content_header')
                            ->label('Header (Kop Surat)')
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'underline',
                                'bulletList',
                                'orderedList',
                                'h2',
                                'h3',
                            ])
                            ->columnSpanFull()
                            ->helperText('Logo, nama instansi, alamat, dll'),
                        
                        Forms\Components\RichEditor::make('content_body')
                            ->required()
                            ->label('Isi Surat')
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'underline',
                                'bulletList',
                                'orderedList',
                                'h2',
                                'h3',
                                'blockquote',
                            ])
                            ->columnSpanFull()
                            ->helperText('Gunakan {{variable}} untuk placeholder. Contoh: {{nama}}, {{nip}}, {{alamat}}'),
                        
                        Forms\Components\RichEditor::make('content_footer')
                            ->label('Footer (TTD)')
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'underline',
                            ])
                            ->columnSpanFull()
                            ->helperText('Tanda tangan, nama pejabat, dll'),
                    ]),
                
                Forms\Components\Section::make('Variable')
                    ->schema([
                        Forms\Components\TagsInput::make('variables')
                            ->label('Daftar Variable')
                            ->placeholder('Ketik variable lalu Enter')
                            ->helperText('Contoh: nama, nip, jabatan, alamat, tanggal_lahir, dll')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kode_template')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->badge()
                    ->color('info'),
                
                Tables\Columns\TextColumn::make('nama_template')
                    ->searchable()
                    ->sortable()
                    ->limit(40),
                
                Tables\Columns\TextColumn::make('kategori.nama')
                    ->badge()
                    ->searchable(),
                
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->label('Status'),
                
                Tables\Columns\TextColumn::make('usage_count')
                    ->label('Digunakan')
                    ->badge()
                    ->color('success')
                    ->suffix(' x'),
                
                Tables\Columns\TextColumn::make('ukuran_kertas')
                    ->badge()
                    ->color('gray'),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('kategori')
                    ->relationship('kategori', 'nama'),
                
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status')
                    ->boolean()
                    ->trueLabel('Aktif')
                    ->falseLabel('Nonaktif'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('preview')
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->url(fn ($record) => route('filament.admin.resources.template-surats.preview', $record))
                    ->openUrlInNewTab(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTemplateSurats::route('/'),
            'create' => Pages\CreateTemplateSurat::route('/create'),
            'edit' => Pages\EditTemplateSurat::route('/{record}/edit'),
            'view' => Pages\ViewTemplateSurat::route('/{record}'),
        ];
    }
}