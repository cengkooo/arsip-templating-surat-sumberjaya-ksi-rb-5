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
                                            ->default(2)
                                            ->step(0.1)
                                            ->minValue(0)
                                            ->maxValue(10)
                                            ->label('Kiri'),
                                        
                                        Forms\Components\TextInput::make('margin_kanan')
                                            ->numeric()
                                            ->suffix('cm')
                                            ->default(2)
                                            ->step(0.1)
                                            ->minValue(0)
                                            ->maxValue(10)
                                            ->label('Kanan'),
                                        
                                        Forms\Components\TextInput::make('margin_atas')
                                            ->numeric()
                                            ->suffix('cm')
                                            ->default(1.5)
                                            ->step(0.1)
                                            ->minValue(0)
                                            ->maxValue(10)
                                            ->label('Atas'),
                                        
                                        Forms\Components\TextInput::make('margin_bawah')
                                            ->numeric()
                                            ->suffix('cm')
                                            ->default(1.5)
                                            ->step(0.1)
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
                                    ->description('⚠️ KOSONGKAN! Kop surat otomatis dari Pengaturan Desa (logo + nama instansi + alamat)')
                                    ->schema([
                                        Forms\Components\Placeholder::make('header_info')
                                            ->label('Contoh Tampilan Header Otomatis')
                                            ->content(function () {
                                                return new \Illuminate\Support\HtmlString('
                                                    <div style="border: 1px dashed #666; padding: 15px; background: #f9f9f9; border-radius: 5px;">
                                                        <div style="text-align: center;">
                                                            <strong>[LOGO GARUDA]</strong><br>
                                                            <strong>KABUPATEN LAMPUNG SELATAN</strong><br>
                                                            <strong>KECAMATAN KALIANDA</strong><br>
                                                            <strong>DESA SUMBERJAYA</strong><br>
                                                            <em>Jl. Way Urang No. 123 Sumberjaya Kode Pos 35551</em><br>
                                                            <small>Telp: 0727-123456 | Email: desa.sumberjaya@lampungselatan.go.id</small>
                                                        </div>
                                                        <hr style="border-top: 3px solid #000; margin-top: 10px;">
                                                    </div>
                                                    <p style="margin-top: 10px; color: #666; font-size: 12px;">
                                                        💡 <strong>Tips:</strong> Kosongkan field ini KECUALI jika butuh info tambahan seperti:<br>
                                                        • Nomor: {{nomor_surat}}<br>
                                                        • Lampiran: {{lampiran}}<br>
                                                        • Perihal: {{perihal}}
                                                    </p>
                                                ');
                                            })
                                            ->columnSpanFull(),
                                        
                                        Forms\Components\RichEditor::make('content_header')
                                            ->label('Header Tambahan (Optional)')
                                            ->columnSpanFull()
                                            ->placeholder('Kosongkan jika tidak perlu header tambahan')
                                            ->toolbarButtons([
                                                'bold',
                                                'italic',
                                                'underline',
                                                'strike',
                                                'alignLeft',
                                                'alignCenter',
                                                'alignRight',
                                                'alignJustify',
                                                'bulletList',
                                                'orderedList',
                                                'table',
                                            ])
                                            ->required(false),
                                    ])
                                    ->collapsible()
                                    ->collapsed(false),
                                
                                Forms\Components\Section::make('Isi Surat')
                                    ->description('📝 Konten utama surat dengan data yang akan diganti otomatis')
                                    ->schema([
                                        Forms\Components\Placeholder::make('body_example')
                                            ->label('Contoh Template Isi Surat')
                                            ->content(function () {
                                                return new \Illuminate\Support\HtmlString('
                                                    <div style="border: 1px dashed #059669; padding: 15px; background: #f0fdf4; border-radius: 5px; font-family: \'Times New Roman\';">
                                                        <p style="text-align: center; margin: 0;"><strong><u>SURAT KETERANGAN TIDAK MAMPU</u></strong></p>
                                                        <p style="text-align: center; margin: 0 0 20px 0;">Nomor: {{nomor_surat}}</p>
                                                        
                                                        <p style="text-align: justify; text-indent: 50px;">
                                                            Yang bertanda tangan di bawah ini Kepala Desa Sumberjaya Kecamatan Kalianda 
                                                            Kabupaten Lampung Selatan menerangkan bahwa:
                                                        </p>
                                                        
                                                        <table style="margin-left: 50px; margin-bottom: 15px;">
                                                            <tr><td width="200">Nama</td><td>: <strong>{{nama}}</strong></td></tr>
                                                            <tr><td>Tempat Tanggal Lahir</td><td>: {{tempat_lahir}}, {{tanggal_lahir}}</td></tr>
                                                            <tr><td>NIK</td><td>: {{nik}}</td></tr>
                                                            <tr><td>Jenis Kelamin</td><td>: {{jenis_kelamin}}</td></tr>
                                                            <tr><td>Agama</td><td>: {{agama}}</td></tr>
                                                            <tr><td>Pekerjaan</td><td>: {{pekerjaan}}</td></tr>
                                                            <tr><td>Alamat</td><td>: {{alamat}}</td></tr>
                                                        </table>
                                                        
                                                        <p style="text-align: justify; text-indent: 50px;">
                                                            Bahwa nama yang tercantum diatas adalah benar-benar berdomisili di Desa Sumberjaya, 
                                                            Kecamatan Kalianda. Sepanjang pengamatan kami dan sesuai data yang ada dalam catatan 
                                                            kependudukan orang tersebut diatas benar tergolong dalam keluarga prasejahtera (Keluarga 
                                                            Berpenghasilan Rendah). Surat Keterangan ini diberikan untuk mendapatkan bantuan berupa 
                                                            rehab/perbaikan rumah tempat tinggal.
                                                        </p>
                                                        
                                                        <p style="text-align: justify; text-indent: 50px;">
                                                            Demikian surat keterangan ini dibuat dengan sebenarnya dan diberikan kepada yang 
                                                            bersangkutan untuk dapat dipergunakan sebagaimana mestinya.
                                                        </p>
                                                    </div>
                                                    <p style="margin-top: 10px; color: #059669; font-size: 12px;">
                                                        ✅ <strong>Variable yang digunakan:</strong> nama, tempat_lahir, tanggal_lahir, nik, jenis_kelamin, agama, pekerjaan, alamat, nomor_surat
                                                    </p>
                                                ');
                                            })
                                            ->columnSpanFull(),
                                        
                                        Forms\Components\RichEditor::make('content_body')
                                            ->label('Tulis Template Isi Surat')
                                            ->required()
                                            ->columnSpanFull()
                                            ->placeholder('Klik di sini untuk mulai menulis template surat...')
                                            ->helperText('💡 Gunakan {{nama_variable}} untuk data dinamis. Lihat tab "Form Isian" untuk daftar variable yang tersedia.')
                                            ->toolbarButtons([
                                                'bold',
                                                'italic',
                                                'underline',
                                                'strike',
                                                'alignLeft',
                                                'alignCenter',
                                                'alignRight',
                                                'alignJustify',
                                                'bulletList',
                                                'orderedList',
                                                'h2',
                                                'h3',
                                                'table',
                                                'blockquote',
                                            ]),
                                    ])
                                    ->collapsible()
                                    ->collapsed(false),
                                
                                Forms\Components\Section::make('Footer (Tanda Tangan)')
                                    ->description('✍️ Bagian tanda tangan dan nama pejabat')
                                    ->schema([
                                        Forms\Components\Placeholder::make('footer_example')
                                            ->label('Contoh Template Footer')
                                            ->content(function () {
                                                return new \Illuminate\Support\HtmlString('
                                                    <div style="border: 1px dashed #dc2626; padding: 15px; background: #fef2f2; border-radius: 5px; font-family: \'Times New Roman\';">
                                                        <div style="text-align: right; margin-top: 30px;">
                                                            <p style="margin: 0;">Sumberjaya, {{tanggal_surat}}</p>
                                                            <p style="margin: 5px 0;"><strong>{{jabatan}}</strong></p>
                                                            <br><br><br>
                                                            <p style="margin: 0;"><strong><u>{{penandatangan}}</u></strong></p>
                                                            <p style="margin: 0;">NIP: {{nip}}</p>
                                                        </div>
                                                    </div>
                                                    <p style="margin-top: 10px; color: #dc2626; font-size: 12px;">
                                                        ✅ <strong>Variable khusus footer:</strong><br>
                                                        • <strong>{{penandatangan}}</strong> = Nama pejabat penandatangan<br>
                                                        • <strong>{{jabatan}}</strong> = Jabatan pejabat (contoh: Kepala Desa, Sekretaris Desa)<br>
                                                        • <strong>{{nip}}</strong> = NIP pejabat<br>
                                                        • <strong>{{tanggal_surat}}</strong> = Tanggal surat ditandatangani<br>
                                                        <br>
                                                        💡 Data ini akan diisi saat Generate Surat (bisa berbeda tiap surat)
                                                    </p>
                                                ');
                                            })
                                            ->columnSpanFull(),
                                        
                                        Forms\Components\RichEditor::make('content_footer')
                                            ->label('Tulis Template Footer')
                                            ->columnSpanFull()
                                            ->placeholder('Klik di sini untuk menulis template footer...')
                                            ->helperText('💡 Variable: {{penandatangan}}, {{jabatan}}, {{nip}}, {{tanggal_surat}}')
                                            ->toolbarButtons([
                                                'bold',
                                                'italic',
                                                'underline',
                                                'alignLeft',
                                                'alignCenter',
                                                'alignRight',
                                                'table',
                                            ])
                                            ->required(false),
                                    ])
                                    ->collapsible()
                                    ->collapsed(false),
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