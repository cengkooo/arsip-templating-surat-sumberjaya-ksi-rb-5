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
                                    ])
                                    ->columns(3),
                                
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
                                        
                                        Forms\Components\Textarea::make('content_header')
                                            ->label('Header Tambahan (Optional)')
                                            ->columnSpanFull()
                                            ->rows(5)
                                            ->placeholder('Kosongkan jika tidak perlu header tambahan. Contoh: Nomor: {{nomor_surat}}\nLampiran: {{lampiran}}\nPerihal: {{perihal}}')
                                            ->helperText('💡 Gunakan HTML untuk format. Contoh: <p style="text-align: center;"><strong>Teks Bold</strong></p>')
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
                                                    <button type="button" onclick="
                                                        const template = `<p style=&quot;text-align: center; margin: 0;&quot;><strong><u>SURAT KETERANGAN TIDAK MAMPU</u></strong></p>
<p style=&quot;text-align: center; margin: 0 0 20px 0;&quot;>Nomor: {{nomor_surat}}</p>

<p style=&quot;text-align: justify; text-indent: 50px;&quot;>Yang bertanda tangan di bawah ini Kepala Desa Sumberjaya Kecamatan Kalianda Kabupaten Lampung Selatan menerangkan bahwa:</p>

<table style=&quot;margin-left: 50px; margin-bottom: 15px; border: none;&quot;>
    <tr><td width=&quot;200&quot;>Nama</td><td>: <strong>{{nama}}</strong></td></tr>
    <tr><td>Tempat Tanggal Lahir</td><td>: {{tempat_lahir}}, {{tanggal_lahir}}</td></tr>
    <tr><td>NIK</td><td>: {{nik}}</td></tr>
    <tr><td>Jenis Kelamin</td><td>: {{jenis_kelamin}}</td></tr>
    <tr><td>Agama</td><td>: {{agama}}</td></tr>
    <tr><td>Pekerjaan</td><td>: {{pekerjaan}}</td></tr>
    <tr><td>Alamat</td><td>: {{alamat}}</td></tr>
</table>

<p style=&quot;text-align: justify; text-indent: 50px;&quot;>Bahwa nama yang tercantum diatas adalah benar-benar berdomisili di Desa Sumberjaya, Kecamatan Kalianda. Sepanjang pengamatan kami dan sesuai data yang ada dalam catatan kependudukan orang tersebut diatas benar tergolong dalam keluarga prasejahtera (Keluarga Berpenghasilan Rendah). Surat Keterangan ini diberikan untuk mendapatkan bantuan berupa rehab/perbaikan rumah tempat tinggal.</p>

<p style=&quot;text-align: justify; text-indent: 50px;&quot;>Demikian surat keterangan ini dibuat dengan sebenarnya dan diberikan kepada yang bersangkutan untuk dapat dipergunakan sebagaimana mestinya.</p>`;
                                                        navigator.clipboard.writeText(template);
                                                        alert(\'✅ Template HTML berhasil di-copy! Paste (Ctrl+V) ke field Isi Surat.\');
                                                    " style="margin-top: 10px; padding: 8px 16px; background: #059669; color: white; border: none; border-radius: 6px; cursor: pointer; font-weight: bold;">
                                                        📋 Copy Template HTML Ini
                                                    </button>
                                                ');
                                            })
                                            ->columnSpanFull(),
                                        
                                        Forms\Components\Textarea::make('content_body')
                                            ->label('Tulis Template Isi Surat (HTML)')
                                            ->required()
                                            ->columnSpanFull()
                                            ->rows(25)
                                            ->placeholder('Tulis HTML template surat di sini...')
                                            ->helperText('💡 Gunakan {{nama_variable}} untuk data dinamis. Lihat tab "Form Isian" untuk daftar variable. Copy template contoh di atas dan edit sesuai kebutuhan.')
                                            ->hint('Klik "Copy Template Contoh" di atas untuk memulai')
                                            ->hintIcon('heroicon-o-clipboard-document-list'),
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
                                                    <button type="button" onclick="
                                                        const template = `<div style=&quot;text-align: right; margin-top: 30px;&quot;>
    <p style=&quot;margin: 0;&quot;>Sumberjaya, {{tanggal_surat}}</p>
    <p style=&quot;margin: 5px 0;&quot;><strong>{{jabatan}}</strong></p>
    <br><br><br>
    <p style=&quot;margin: 0;&quot;><strong><u>{{penandatangan}}</u></strong></p>
    <p style=&quot;margin: 0;&quot;>NIP: {{nip}}</p>
</div>`;
                                                        navigator.clipboard.writeText(template);
                                                        alert(\'✅ Template Footer berhasil di-copy! Paste (Ctrl+V) ke field Footer.\');
                                                    " style="margin-top: 10px; padding: 8px 16px; background: #dc2626; color: white; border: none; border-radius: 6px; cursor: pointer; font-weight: bold;">
                                                        📋 Copy Template Footer Ini
                                                    </button>
                                                ');
                                            })
                                            ->columnSpanFull(),
                                        
                                        Forms\Components\Textarea::make('content_footer')
                                            ->label('Tulis Template Footer (HTML)')
                                            ->columnSpanFull()
                                            ->rows(10)
                                            ->placeholder('Tulis HTML template footer di sini...')
                                            ->helperText('💡 Variable: {{penandatangan}}, {{jabatan}}, {{nip}}, {{tanggal_surat}}. Copy template contoh di atas dan edit.')
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
                                            ->label('Cara Penggunaan Variable')
                                            ->content(function () {
                                                return new \Illuminate\Support\HtmlString('
                                                    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 20px; border-radius: 10px; color: white; margin-bottom: 15px;">
                                                        <h3 style="margin: 0 0 10px 0; font-size: 16px;">📋 Cara Penggunaan Variable</h3>
                                                        <p style="margin: 0; opacity: 0.9;">Gunakan format <strong>{{nama_variable}}</strong> dalam template.</p>
                                                        <p style="margin: 5px 0 0 0; opacity: 0.9;">Contoh: {{nama}}, {{nik}}, {{alamat}}</p>
                                                    </div>
                                                    
                                                    <div style="background: #f0f9ff; padding: 15px; border-radius: 8px; border-left: 4px solid #0ea5e9; margin-bottom: 15px;">
                                                        <h4 style="margin: 0 0 10px 0; color: #0369a1; font-size: 14px;">🏛️ Variable dari Pengaturan Desa (Otomatis Tersedia)</h4>
                                                        <p style="margin: 0 0 8px 0; font-size: 13px; color: #0c4a6e;">Variable berikut OTOMATIS tersedia dari menu <strong>Pengaturan Desa</strong>:</p>
                                                        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 8px; font-family: monospace; font-size: 12px;">
                                                            <span style="background: white; padding: 6px 10px; border-radius: 4px; border: 1px solid #bae6fd;">{{nama_desa}}</span>
                                                            <span style="background: white; padding: 6px 10px; border-radius: 4px; border: 1px solid #bae6fd;">{{kode_desa}}</span>
                                                            <span style="background: white; padding: 6px 10px; border-radius: 4px; border: 1px solid #bae6fd;">{{nama_kecamatan}}</span>
                                                            <span style="background: white; padding: 6px 10px; border-radius: 4px; border: 1px solid #bae6fd;">{{nama_kabupaten}}</span>
                                                            <span style="background: white; padding: 6px 10px; border-radius: 4px; border: 1px solid #bae6fd;">{{nama_provinsi}}</span>
                                                            <span style="background: white; padding: 6px 10px; border-radius: 4px; border: 1px solid #bae6fd;">{{alamat_desa}}</span>
                                                            <span style="background: white; padding: 6px 10px; border-radius: 4px; border: 1px solid #bae6fd;">{{kode_pos}}</span>
                                                            <span style="background: white; padding: 6px 10px; border-radius: 4px; border: 1px solid #bae6fd;">{{telepon_desa}}</span>
                                                            <span style="background: white; padding: 6px 10px; border-radius: 4px; border: 1px solid #bae6fd;">{{email_desa}}</span>
                                                            <span style="background: white; padding: 6px 10px; border-radius: 4px; border: 1px solid #bae6fd;">{{website_desa}}</span>
                                                            <span style="background: white; padding: 6px 10px; border-radius: 4px; border: 1px solid #bae6fd;">{{nama_kepala_desa}}</span>
                                                            <span style="background: white; padding: 6px 10px; border-radius: 4px; border: 1px solid #bae6fd;">{{nip_kepala_desa}}</span>
                                                        </div>
                                                    </div>
                                                    
                                                    <div style="background: #fef3c7; padding: 15px; border-radius: 8px; border-left: 4px solid #f59e0b; margin-bottom: 15px;">
                                                        <h4 style="margin: 0 0 10px 0; color: #92400e; font-size: 14px;">🔢 Variable Sistem (Otomatis)</h4>
                                                        <p style="margin: 0 0 8px 0; font-size: 13px; color: #78350f;">Variable ini otomatis terisi saat generate surat:</p>
                                                        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 8px; font-family: monospace; font-size: 12px;">
                                                            <span style="background: white; padding: 6px 10px; border-radius: 4px; border: 1px solid #fde68a;">{{nomor_surat}}</span>
                                                            <span style="background: white; padding: 6px 10px; border-radius: 4px; border: 1px solid #fde68a;">{{tanggal_surat}}</span>
                                                            <span style="background: white; padding: 6px 10px; border-radius: 4px; border: 1px solid #fde68a;">{{penandatangan}}</span>
                                                            <span style="background: white; padding: 6px 10px; border-radius: 4px; border: 1px solid #fde68a;">{{jabatan}}</span>
                                                            <span style="background: white; padding: 6px 10px; border-radius: 4px; border: 1px solid #fde68a;">{{nip}}</span>
                                                        </div>
                                                    </div>
                                                    
                                                    <div style="background: #dcfce7; padding: 15px; border-radius: 8px; border-left: 4px solid #22c55e;">
                                                        <h4 style="margin: 0 0 10px 0; color: #14532d; font-size: 14px;">✏️ Variable Custom (Didefinisikan di Atas)</h4>
                                                        <p style="margin: 0; font-size: 13px; color: #14532d;">Variable yang Anda buat di field "Daftar Variable" di atas akan muncul sebagai form isian saat Generate Surat.</p>
                                                    </div>
                                                ');
                                            })
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