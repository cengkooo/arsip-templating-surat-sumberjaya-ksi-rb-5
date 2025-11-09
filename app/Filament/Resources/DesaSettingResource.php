<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DesaSettingResource\Pages;
use App\Filament\Resources\DesaSettingResource\RelationManagers;
use App\Models\DesaSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DesaSettingResource extends Resource
{
    protected static ?string $model = DesaSetting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationLabel = 'Pengaturan Desa';
    protected static ?string $modelLabel = 'Pengaturan Desa';
    protected static ?string $navigationGroup = 'Master Data';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Pengaturan Desa')
                    ->tabs([
                        // TAB 1: DESA
                        Forms\Components\Tabs\Tab::make('DESA')
                            ->icon('heroicon-o-building-office-2')
                            ->schema([
                                Forms\Components\Section::make('Logo Desa')
                                    ->description('Upload logo desa/kabupaten untuk kop surat')
                                    ->schema([
                                        Forms\Components\FileUpload::make('logo_path')
                                            ->label('Logo Desa/Kabupaten')
                                            ->image()
                                            ->disk('public')
                                            ->directory('logo-desa')
                                            ->imageEditor()
                                            ->imageEditorAspectRatios(['1:1'])
                                            ->maxSize(2048)
                                            ->helperText('Format: PNG/JPG. Maksimal 2MB. Rasio 1:1 (persegi)')
                                            ->columnSpanFull(),
                                    ])
                                    ->collapsible(),
                                
                                Forms\Components\Section::make('Identitas Desa')
                                    ->description('Data lengkap identitas desa seperti di OpenSID')
                                    ->schema([
                                        Forms\Components\Grid::make(2)
                                            ->schema([
                                                Forms\Components\TextInput::make('nama_desa')
                                                    ->required()
                                                    ->maxLength(100)
                                                    ->label('Nama Desa')
                                                    ->placeholder('Batang Hari Ogan'),
                                                
                                                Forms\Components\TextInput::make('kode_desa')
                                                    ->maxLength(20)
                                                    ->label('Kode Desa')
                                                    ->placeholder('18.09.03.2003')
                                                    ->helperText('Kode unik identitas desa'),
                                                
                                                Forms\Components\TextInput::make('kode_pos_desa')
                                                    ->maxLength(10)
                                                    ->label('Kode Pos')
                                                    ->placeholder('35142'),
                                            ]),
                                    ])
                                    ->collapsible(),
                            ]),
                        
                        // TAB 2: KECAMATAN
                        Forms\Components\Tabs\Tab::make('KECAMATAN')
                            ->icon('heroicon-o-building-office')
                            ->schema([
                                Forms\Components\Section::make('Identitas Kecamatan')
                                    ->schema([
                                        Forms\Components\TextInput::make('nama_kecamatan')
                                            ->required()
                                            ->maxLength(100)
                                            ->label('Nama Kecamatan')
                                            ->placeholder('Tegineneng'),
                                        
                                        Forms\Components\TextInput::make('kode_kecamatan')
                                            ->maxLength(10)
                                            ->label('Kode Kecamatan')
                                            ->placeholder('18.09.03'),
                                        
                                        Forms\Components\TextInput::make('nama_kepala_camat')
                                            ->maxLength(100)
                                            ->label('Nama Kepala Camat')
                                            ->placeholder('Aep Alamsyah, S STP.M.M')
                                            ->helperText('Akan muncul di template jika diperlukan'),
                                        
                                        Forms\Components\TextInput::make('nip_kepala_camat')
                                            ->maxLength(30)
                                            ->label('NIP Camat')
                                            ->placeholder('19870101 201001 1 001'),
                                    ])
                                    ->columns(2)
                                    ->collapsible(),
                            ]),
                        
                        // TAB 3: KABUPATEN
                        Forms\Components\Tabs\Tab::make('KABUPATEN')
                            ->icon('heroicon-o-map')
                            ->schema([
                                Forms\Components\Section::make('Identitas Kabupaten/Kota')
                                    ->schema([
                                        Forms\Components\TextInput::make('nama_kabupaten')
                                            ->required()
                                            ->maxLength(100)
                                            ->label('Nama Kabupaten')
                                            ->placeholder('Pesawaran'),
                                        
                                        Forms\Components\TextInput::make('kode_kabupaten')
                                            ->maxLength(10)
                                            ->label('Kode Kabupaten')
                                            ->placeholder('18.09'),
                                        
                                        Forms\Components\TextInput::make('nama_kepala_kabupaten')
                                            ->maxLength(100)
                                            ->label('Nama Bupati/Walikota')
                                            ->placeholder('Dr. H. Ahmad Chandra, M.Si')
                                            ->helperText('Akan muncul di template jika diperlukan'),
                                        
                                        Forms\Components\TextInput::make('nip_kepala_kabupaten')
                                            ->maxLength(30)
                                            ->label('NIP Bupati/Walikota')
                                            ->placeholder('19750101 199901 1 001'),
                                    ])
                                    ->columns(2)
                                    ->collapsible(),
                            ]),
                        
                        // TAB 4: PROVINSI
                        Forms\Components\Tabs\Tab::make('PROVINSI')
                            ->icon('heroicon-o-globe-alt')
                            ->schema([
                                Forms\Components\Section::make('Identitas Provinsi')
                                    ->schema([
                                        Forms\Components\TextInput::make('nama_provinsi')
                                            ->required()
                                            ->maxLength(100)
                                            ->label('Nama Provinsi')
                                            ->default('Lampung')
                                            ->placeholder('Lampung'),
                                        
                                        Forms\Components\TextInput::make('kode_provinsi')
                                            ->maxLength(10)
                                            ->label('Kode Provinsi')
                                            ->placeholder('18'),
                                    ])
                                    ->columns(2)
                                    ->collapsible(),
                            ]),
                        
                        // TAB 5: ALAMAT & KONTAK
                        Forms\Components\Tabs\Tab::make('Alamat & Kontak')
                            ->icon('heroicon-o-map-pin')
                            ->schema([
                                Forms\Components\Section::make('Alamat Kantor Desa')
                                    ->schema([
                                        Forms\Components\Textarea::make('alamat_lengkap')
                                            ->label('Alamat Kantor Desa')
                                            ->rows(3)
                                            ->placeholder('Batang Hari Ogan, Kec. Tegineneng, Kabupaten Pesawaran, Lampung 35363')
                                            ->columnSpanFull()
                                            ->helperText('Alamat lengkap kantor desa untuk kop surat'),
                                        
                                        Forms\Components\TextInput::make('kode_pos')
                                            ->label('Kode Pos Kantor')
                                            ->maxLength(10)
                                            ->placeholder('35142'),
                                        
                                        Forms\Components\TextInput::make('no_telepon')
                                            ->label('Nomor Telepon Kantor')
                                            ->tel()
                                            ->maxLength(20)
                                            ->placeholder('0812-3456-7890'),
                                        
                                        Forms\Components\TextInput::make('email')
                                            ->label('E-Mail Desa')
                                            ->email()
                                            ->maxLength(100)
                                            ->placeholder('emonievbho@gmail.com'),
                                        
                                        Forms\Components\TextInput::make('website')
                                            ->label('Website Desa')
                                            ->url()
                                            ->maxLength(100)
                                            ->placeholder('https://batanghariogan.com/'),
                                    ])
                                    ->columns(2)
                                    ->collapsible(),
                                
                                Forms\Components\Section::make('Koordinat Kantor Desa')
                                    ->description('Koordinat GPS lokasi kantor desa')
                                    ->schema([
                                        Forms\Components\TextInput::make('latitude')
                                            ->label('Latitude')
                                            ->numeric()
                                            ->placeholder('-5.123456')
                                            ->helperText('Contoh: -5.123456'),
                                        
                                        Forms\Components\TextInput::make('longitude')
                                            ->label('Longitude')
                                            ->numeric()
                                            ->placeholder('105.123456')
                                            ->helperText('Contoh: 105.123456'),
                                    ])
                                    ->columns(2)
                                    ->collapsible()
                                    ->collapsed(),
                            ]),
                        
                        // TAB 6: PEJABAT
                        Forms\Components\Tabs\Tab::make('Pejabat')
                            ->icon('heroicon-o-user-circle')
                            ->schema([
                                Forms\Components\Section::make('Kepala Desa')
                                    ->description('Data kepala desa untuk referensi')
                                    ->schema([
                                        Forms\Components\TextInput::make('nama_kepala_desa')
                                            ->label('Nama Kepala Desa')
                                            ->maxLength(100)
                                            ->placeholder('INDRA GUNAWAN, S.H'),
                                        
                                        Forms\Components\TextInput::make('nip_kepala_desa')
                                            ->label('NIP Kepala Desa')
                                            ->maxLength(30)
                                            ->placeholder('19800101 200801 1 001'),
                                    ])
                                    ->columns(2)
                                    ->collapsible(),
                                
                                Forms\Components\Section::make('Pamong TTD Default')
                                    ->description('Pamong yang akan TTD surat secara default (bisa diganti per surat)')
                                    ->schema([
                                        Forms\Components\TextInput::make('nama_pamong_ttd')
                                            ->label('Nama Pamong')
                                            ->maxLength(100)
                                            ->placeholder('INDRA GUNAWAN, S.H')
                                            ->helperText('Akan otomatis terisi saat generate surat'),
                                        
                                        Forms\Components\TextInput::make('jabatan_pamong_ttd')
                                            ->label('Jabatan')
                                            ->maxLength(100)
                                            ->placeholder('Kepala Desa')
                                            ->helperText('Misal: Kepala Desa, Sekretaris Desa'),
                                        
                                        Forms\Components\TextInput::make('nip_pamong_ttd')
                                            ->label('NIP Pamong')
                                            ->maxLength(30)
                                            ->placeholder('19800101 200801 1 001'),
                                    ])
                                    ->columns(3)
                                    ->collapsible(),
                            ]),
                    ])
                    ->columnSpanFull()
                    ->persistTabInQueryString(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageDesaSettings::route('/'),
            'edit' => Pages\EditDesaSetting::route('/{record}/edit'),
        ];
    }
    
    /**
     * Disable table - langsung redirect ke edit
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([])
            ->actions([])
            ->bulkActions([]);
    }
    
    /**
     * Disable navigation badge count
     */
    public static function getNavigationBadge(): ?string
    {
        return null;
    }
}
