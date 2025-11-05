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
                Forms\Components\Section::make('Logo Desa')
                    ->description('Upload logo desa/kabupaten untuk kop surat')
                    ->schema([
                        Forms\Components\FileUpload::make('logo_path')
                            ->label('Logo')
                            ->image()
                            ->disk('public')
                            ->directory('logo-desa')
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '1:1',
                            ])
                            ->maxSize(2048)
                            ->helperText('Format: PNG/JPG. Maksimal 2MB. Disarankan ukuran 500x500px')
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),
                
                Forms\Components\Section::make('Identitas Pemerintahan')
                    ->description('Informasi identitas pemerintahan untuk kop surat')
                    ->schema([
                        Forms\Components\TextInput::make('nama_kabupaten')
                            ->required()
                            ->maxLength(100)
                            ->default('KABUPATEN LAMPUNG SELATAN')
                            ->label('Nama Kabupaten/Kota')
                            ->placeholder('KABUPATEN LAMPUNG SELATAN'),
                        
                        Forms\Components\TextInput::make('nama_kecamatan')
                            ->required()
                            ->maxLength(100)
                            ->default('KECAMATAN KALIANDA')
                            ->label('Nama Kecamatan')
                            ->placeholder('KECAMATAN KALIANDA'),
                        
                        Forms\Components\TextInput::make('nama_desa')
                            ->required()
                            ->maxLength(100)
                            ->default('DESA SUMBERJAYA')
                            ->label('Nama Desa/Kelurahan')
                            ->placeholder('DESA SUMBERJAYA'),
                    ])
                    ->columns(3)
                    ->collapsible(),
                
                Forms\Components\Section::make('Alamat & Kontak')
                    ->description('Alamat lengkap dan informasi kontak desa')
                    ->schema([
                        Forms\Components\Textarea::make('alamat_lengkap')
                            ->label('Alamat Lengkap')
                            ->rows(2)
                            ->placeholder('Jl. Way Urang No. 123 Sumberjaya')
                            ->columnSpanFull(),
                        
                        Forms\Components\TextInput::make('kode_pos')
                            ->label('Kode Pos')
                            ->maxLength(10)
                            ->placeholder('35551'),
                        
                        Forms\Components\TextInput::make('no_telepon')
                            ->label('No. Telepon')
                            ->tel()
                            ->maxLength(20)
                            ->placeholder('0727-123456'),
                        
                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->maxLength(100)
                            ->placeholder('desa@example.com'),
                        
                        Forms\Components\TextInput::make('website')
                            ->label('Website')
                            ->url()
                            ->maxLength(100)
                            ->placeholder('www.desa.go.id'),
                    ])
                    ->columns(2)
                    ->collapsible(),
                
                Forms\Components\Section::make('Pejabat (Opsional)')
                    ->description('Data kepala desa untuk referensi (bisa dikosongkan jika penandatangan berbeda-beda)')
                    ->schema([
                        Forms\Components\TextInput::make('nama_kepala_desa')
                            ->label('Nama Kepala Desa')
                            ->maxLength(100)
                            ->placeholder('Budi Santoso, S.STP'),
                        
                        Forms\Components\TextInput::make('nip_kepala_desa')
                            ->label('NIP Kepala Desa')
                            ->maxLength(30)
                            ->placeholder('19800101 200801 1 001'),
                    ])
                    ->columns(2)
                    ->collapsible()
                    ->collapsed(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageDesaSettings::route('/'),
        ];
    }
}
