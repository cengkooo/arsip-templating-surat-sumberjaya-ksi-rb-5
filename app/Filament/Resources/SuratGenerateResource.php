<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SuratGenerateResource\Pages;
use App\Models\SuratGenerate;
use App\Models\TemplateSurat;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class SuratGenerateResource extends Resource
{
    protected static ?string $model = SuratGenerate::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-plus';
    protected static ?string $navigationGroup = 'Surat';
    protected static ?int $navigationSort = 4;
    protected static ?string $navigationLabel = 'Generate Surat';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Pilih Template')
                    ->schema([
                        Forms\Components\Select::make('template_surat_id')
                            ->label('Template Surat')
                            ->options(TemplateSurat::where('is_active', true)->pluck('nama_template', 'id'))
                            ->required()
                            ->searchable()
                            ->preload()
                            ->live()
                            ->afterStateUpdated(function ($state, Forms\Set $set) {
                                if ($state) {
                                    $template = TemplateSurat::find($state);
                                    if ($template && $template->variables) {
                                        $set('template_variables', $template->variables);
                                    }
                                }
                            })
                            ->helperText('Pilih template yang akan digunakan'),
                        
                        Forms\Components\Placeholder::make('template_info')
                            ->label('Info Template')
                            ->content(function ($get) {
                                if ($get('template_surat_id')) {
                                    $template = TemplateSurat::find($get('template_surat_id'));
                                    if ($template) {
                                        return "Template: {$template->nama_template} | Kertas: {$template->ukuran_kertas} | Orientasi: {$template->orientasi}";
                                    }
                                }
                                return 'Pilih template terlebih dahulu';
                            }),
                    ]),
                
                Forms\Components\Section::make('Informasi Surat')
                    ->schema([
                        Forms\Components\TextInput::make('nomor_surat')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(100)
                            ->label('Nomor Surat')
                            ->placeholder('Contoh: 001/SK/2024'),
                        
                        Forms\Components\DatePicker::make('tanggal_surat')
                            ->required()
                            ->native(false)
                            ->displayFormat('d/m/Y')
                            ->default(now())
                            ->label('Tanggal Surat'),
                        
                        Forms\Components\Select::make('status')
                            ->options([
                                'draft' => 'Draft',
                                'final' => 'Final',
                                'terkirim' => 'Terkirim',
                            ])
                            ->required()
                            ->native(false)
                            ->default('draft'),
                        
                        Forms\Components\Textarea::make('catatan')
                            ->rows(2)
                            ->columnSpanFull(),
                    ])
                    ->columns(3),
                
                Forms\Components\Section::make('Isi Data Variable')
                    ->schema([
                        Forms\Components\KeyValue::make('data_variables')
                            ->label('Data Variable')
                            ->keyLabel('Nama Variable')
                            ->valueLabel('Isi Data')
                            ->addButtonLabel('Tambah Variable')
                            ->required()
                            ->helperText('Isi data untuk setiap variable di template')
                            ->columnSpanFull(),
                    ]),
                
                Forms\Components\Hidden::make('user_id')
                    ->default(Auth::id()),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nomor_surat')
                    ->searchable()
                    ->sortable()
                    ->copyable(),
                
                Tables\Columns\TextColumn::make('tanggal_surat')
                    ->date('d/m/Y')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('templateSurat.nama_template')
                    ->label('Template')
                    ->searchable()
                    ->limit(30),
                
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Dibuat Oleh')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'draft' => 'gray',
                        'final' => 'success',
                        'terkirim' => 'info',
                    }),
                
                Tables\Columns\IconColumn::make('file_pdf_path')
                    ->boolean()
                    ->label('PDF')
                    ->trueIcon('heroicon-o-document-check')
                    ->falseIcon('heroicon-o-document-minus'),
                
                Tables\Columns\TextColumn::make('generated_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Waktu Generate')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('template_surat_id')
                    ->label('Template')
                    ->relationship('templateSurat', 'nama_template'),
                
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'final' => 'Final',
                        'terkirim' => 'Terkirim',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                
                Tables\Actions\Action::make('generate_pdf')
                    ->icon('heroicon-o-document-arrow-down')
                    ->color('success')
                    ->label('Generate PDF')
                    ->action(function ($record) {
                        // Logic generate PDF ada di sini (akan dibuat di Step 3)
                        app(\App\Services\PdfGeneratorService::class)->generate($record);
                    })
                    ->requiresConfirmation()
                    ->successNotificationTitle('PDF berhasil digenerate!'),
                
                Tables\Actions\Action::make('download')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('info')
                    ->url(fn ($record) => $record->pdf_url)
                    ->openUrlInNewTab()
                    ->visible(fn ($record) => $record->file_pdf_path !== null),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSuratGenerates::route('/'),
            'create' => Pages\CreateSuratGenerate::route('/create'),
            'edit' => Pages\EditSuratGenerate::route('/{record}/edit'),
            'view' => Pages\ViewSuratGenerate::route('/{record}'),
        ];
    }
}