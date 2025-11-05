<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TemplateSuratResource\Pages;
use App\Models\TemplateSurat;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use AmidEsfahani\FilamentTinyEditor\TinyEditor;

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
                Forms\Components\Tabs::make('Template Surat')
                    ->tabs([
                        // Tab 1: Umum
                        Forms\Components\Tabs\Tab::make('Umum')
                            ->icon('heroicon-o-information-circle')
                            ->schema([
                                Forms\Components\Section::make('Informasi Template')
                                    ->schema([
                                        Forms\Components\Select::make('kategori_id')
                                            ->relationship('kategori', 'nama')
                                            ->required()
                                            ->searchable()
                                            ->preload()
                                            ->createOptionForm([
                                                Forms\Components\TextInput::make('nama')
                                                    ->required()
                                                    ->maxLength(100),
                                                Forms\Components\Textarea::make('keterangan')
                                                    ->rows(2),
                                            ]),
                                        
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
                                            ->default('F4'),
                                        
                                        Forms\Components\Toggle::make('is_active')
                                            ->label('Aktif')
                                            ->default(true),
                                        
                                        Forms\Components\Toggle::make('sediakan_layanan_mandiri')
                                            ->label('Sediakan di Layanan Mandiri')
                                            ->helperText('Izinkan warga mengajukan surat ini secara online')
                                            ->default(false),
                                    ])
                                    ->columns(4),
                                
                                Forms\Components\Section::make('Margin Kertas (cm)')
                                    ->schema([
                                        Forms\Components\TextInput::make('margin_kiri')
                                            ->numeric()
                                            ->suffix('cm')
                                            ->default(1.78)
                                            ->step(0.01)
                                            ->minValue(0)
                                            ->maxValue(10)
                                            ->label('Kiri'),
                                        
                                        Forms\Components\TextInput::make('margin_kanan')
                                            ->numeric()
                                            ->suffix('cm')
                                            ->default(1.78)
                                            ->step(0.01)
                                            ->minValue(0)
                                            ->maxValue(10)
                                            ->label('Kanan'),
                                        
                                        Forms\Components\TextInput::make('margin_atas')
                                            ->numeric()
                                            ->suffix('cm')
                                            ->default(0.63)
                                            ->step(0.01)
                                            ->minValue(0)
                                            ->maxValue(10)
                                            ->label('Atas'),
                                        
                                        Forms\Components\TextInput::make('margin_bawah')
                                            ->numeric()
                                            ->suffix('cm')
                                            ->default(1.37)
                                            ->step(0.01)
                                            ->minValue(0)
                                            ->maxValue(10)
                                            ->label('Bawah'),
                                    ])
                                    ->columns(4)
                                    ->collapsible(),
                                
                                Forms\Components\Section::make('Pengaturan Tampilan')
                                    ->schema([
                                        Forms\Components\Toggle::make('tampilkan_header')
                                            ->label('Tampilkan Header')
                                            ->default(true)
                                            ->live(),
                                        
                                        Forms\Components\Select::make('header_type')
                                            ->label('Jenis Header')
                                            ->options([
                                                'semua_halaman' => 'Semua Halaman',
                                                'hanya_halaman_awal' => 'Hanya Halaman Awal',
                                                'tidak' => 'Tidak Tampilkan',
                                            ])
                                            ->native(false)
                                            ->default('semua_halaman')
                                            ->visible(fn ($get) => $get('tampilkan_header')),
                                        
                                        Forms\Components\Toggle::make('tampilkan_logo')
                                            ->label('Tampilkan Logo Garuda')
                                            ->default(false),
                                        
                                        Forms\Components\Toggle::make('tampilkan_footer')
                                            ->label('Tampilkan Footer')
                                            ->default(false),
                                        
                                        Forms\Components\Toggle::make('tampilkan_qrcode')
                                            ->label('Tampilkan QR Code')
                                            ->helperText('QR Code untuk verifikasi surat')
                                            ->default(false),
                                    ])
                                    ->columns(3)
                                    ->collapsible(),
                            ]),
                        
                        // Tab 2: Template/Editor
                        Forms\Components\Tabs\Tab::make('Template')
                            ->icon('heroicon-o-document')
                            ->schema([
                                Forms\Components\Section::make('Header (Kop Surat)')
                                    ->description('Bagian atas surat: logo, nama instansi, alamat, dll')
                                    ->schema([
                                        TinyEditor::make('content_header')
                                            ->label('')
                                            ->profile('full')
                                            ->columnSpanFull()
                                            ->minHeight(300)
                                            ->toolbarSticky(true)
                                            ->showMenuBar(),
                                    ])
                                    ->collapsible(),
                                
                                Forms\Components\Section::make('Isi Surat')
                                    ->description('Konten utama surat. Gunakan {{variable}} untuk placeholder dinamis')
                                    ->schema([
                                        TinyEditor::make('content_body')
                                            ->label('')
                                            ->required()
                                            ->profile('full')
                                            ->columnSpanFull()
                                            ->minHeight(500)
                                            ->toolbarSticky(true)
                                            ->showMenuBar()
                                            ->helperText('Contoh variable: {{nama}}, {{nip}}, {{alamat}}, {{tanggal_lahir}}, dll'),
                                    ])
                                    ->collapsible(),
                                
                                Forms\Components\Section::make('Footer (Tanda Tangan)')
                                    ->description('Bagian bawah surat: tanda tangan, nama pejabat, cap, dll')
                                    ->schema([
                                        TinyEditor::make('content_footer')
                                            ->label('')
                                            ->profile('full')
                                            ->columnSpanFull()
                                            ->minHeight(300)
                                            ->toolbarSticky(true)
                                            ->showMenuBar(),
                                    ])
                                    ->collapsible(),
                            ]),
                        
                        // Tab 3: Form Isian
                        Forms\Components\Tabs\Tab::make('Form Isian')
                            ->icon('heroicon-o-clipboard-document-list')
                            ->schema([
                                Forms\Components\Section::make('Variable Template')
                                    ->description('Daftar variable yang bisa digunakan dalam template')
                                    ->schema([
                                        Forms\Components\TagsInput::make('variables')
                                            ->label('Daftar Variable')
                                            ->placeholder('Ketik variable lalu Enter')
                                            ->helperText('Contoh: nama, nip, jabatan, alamat, tanggal_lahir, tempat_lahir, no_kk, nik, dll')
                                            ->columnSpanFull()
                                            ->suggestions([
                                                'nama',
                                                'nik',
                                                'no_kk',
                                                'tempat_lahir',
                                                'tanggal_lahir',
                                                'jenis_kelamin',
                                                'alamat',
                                                'rt',
                                                'rw',
                                                'dusun',
                                                'kelurahan',
                                                'kecamatan',
                                                'kabupaten',
                                                'provinsi',
                                                'agama',
                                                'status_perkawinan',
                                                'pekerjaan',
                                                'kewarganegaraan',
                                                'berlaku_hingga',
                                                'keperluan',
                                                'keterangan',
                                            ]),
                                        
                                        Forms\Components\Placeholder::make('variable_info')
                                            ->label('Cara Penggunaan')
                                            ->content('Gunakan variable dalam template dengan format: {{nama_variable}}. Contoh: {{nama}}, {{nik}}, {{alamat}}')
                                            ->columnSpanFull(),
                                    ]),
                                
                                Forms\Components\Section::make('Penomoran Surat')
                                    ->description('Format penomoran otomatis untuk surat')
                                    ->schema([
                                        Forms\Components\Textarea::make('format_nomor')
                                            ->label('Format Nomor Surat')
                                            ->placeholder('[nomor]/[kode]/[bulan]/[tahun]')
                                            ->helperText('Contoh: [nomor]/SK/[bulan]/[tahun] akan menghasilkan: 001/SK/XI/2025')
                                            ->rows(2)
                                            ->columnSpanFull(),
                                    ])
                                    ->collapsible(),
                            ]),
                    ])
                    ->columnSpanFull()
                    ->persistTabInQueryString(),
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
            'preview' => Pages\PreviewTemplateSurat::route('/{record}/preview'),
        ];
    }
}