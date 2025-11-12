<?php

namespace App\Filament\Resources\ArsipSuratResource\Pages;

use App\Filament\Resources\ArsipSuratResource;
use App\Models\ArsipSurat;
use App\Models\TemplateSurat;
use App\Services\PdfGeneratorService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class CreateFromTemplate extends CreateRecord
{
    protected static string $resource = ArsipSuratResource::class;
    
    protected static ?string $title = 'Buat Surat dari Template';
    
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('kategori_id'),
                
                Forms\Components\Section::make('Pilih Template')
                    ->description('Pilih template surat yang akan digunakan')
                    ->schema([
                        Forms\Components\Select::make('template_surat_id')
                            ->label('Template Surat')
                            ->options(TemplateSurat::where('is_active', true)->pluck('nama_template', 'id'))
                            ->required()
                            ->searchable()
                            ->preload()
                            ->live()
                            ->afterStateUpdated(fn ($state, Forms\Set $set) => $this->loadTemplateData($state, $set))
                            ->helperText('Pilih template yang sudah dibuat'),
                    ])
                    ->collapsible(),
                
                Forms\Components\Section::make('Data Surat')
                    ->description('Informasi umum surat')
                    ->schema([
                        Forms\Components\TextInput::make('nomor_surat')
                            ->required()
                            ->unique('arsip_surats', 'nomor_surat')
                            ->maxLength(100)
                            ->label('Nomor Surat')
                            ->placeholder('001/SK/XI/2025')
                            ->helperText('Nomor unik surat')
                            ->columnSpan(1),
                        
                        Forms\Components\DatePicker::make('tanggal_surat')
                            ->required()
                            ->native(false)
                            ->displayFormat('d/m/Y')
                            ->default(now())
                            ->label('Tanggal Surat')
                            ->columnSpan(1),
                        
                        Forms\Components\TextInput::make('lampiran')
                            ->maxLength(100)
                            ->label('Lampiran')
                            ->placeholder('- (jika tidak ada lampiran)')
                            ->helperText('Isi dengan jumlah/jenis lampiran, atau "-" jika tidak ada')
                            ->columnSpan(1),
                        
                        Forms\Components\TextInput::make('perihal')
                            ->required()
                            ->maxLength(255)
                            ->label('Perihal/Judul')
                            ->placeholder('Surat Keterangan Tidak Mampu')
                            ->columnSpan(3),
                    ])
                    ->columns(3)
                    ->collapsible(),
                
                Forms\Components\Section::make('Data Isian')
                    ->description('Isi data sesuai template yang dipilih')
                    ->schema(function (Forms\Get $get) {
                        $templateId = $get('template_surat_id');
                        
                        if (!$templateId) {
                            return [
                                Forms\Components\Placeholder::make('info')
                                    ->label('')
                                    ->content('Pilih template terlebih dahulu untuk melihat form isian'),
                            ];
                        }
                        
                        $template = TemplateSurat::find($templateId);
                        
                        if (!$template || !$template->variables) {
                            return [
                                Forms\Components\Placeholder::make('info')
                                    ->label('')
                                    ->content('Template ini tidak memiliki variable isian'),
                            ];
                        }
                        
                        // Hidden field untuk menyimpan data variables sebagai JSON
                        $fields = [
                            Forms\Components\Hidden::make('form_variables')
                                ->default('{}'),
                        ];
                        
                        // Create visible fields
                        foreach ($template->variables as $variable) {
                            $field = $this->createFieldForVariable($variable);
                            if ($field) {
                                $fields[] = $field;
                            }
                        }
                        
                        return $fields;
                    })
                    ->columns(2)
                    ->collapsible(),
                
                Forms\Components\Section::make('Penandatangan')
                    ->description('Data pejabat yang menandatangani surat')
                    ->schema([
                        Forms\Components\TextInput::make('nama_penandatangan')
                            ->label('Nama Penandatangan')
                            ->maxLength(100)
                            ->placeholder('Budi Santoso, S.STP')
                            ->helperText('Kosongkan untuk menggunakan default dari Pengaturan Desa'),
                        
                        Forms\Components\TextInput::make('jabatan_penandatangan')
                            ->label('Jabatan')
                            ->maxLength(100)
                            ->placeholder('Kepala Desa'),
                        
                        Forms\Components\TextInput::make('nip_penandatangan')
                            ->label('NIP')
                            ->maxLength(30)
                            ->placeholder('19800101 200801 1 001'),
                    ])
                    ->columns(3)
                    ->collapsible(),
                
                Forms\Components\Section::make('Catatan')
                    ->schema([
                        Forms\Components\Textarea::make('catatan')
                            ->rows(2)
                            ->label('Catatan (Opsional)')
                            ->columnSpanFull(),
                    ])
                    ->collapsible()
                    ->collapsed(),
            ]);
    }
    
    protected function loadTemplateData($templateId, $set)
    {
        if (!$templateId) return;
        
        $template = TemplateSurat::find($templateId);
        if (!$template) return;
        
        // Set kategori dari template (hidden field akan diset otomatis)
        $set('kategori_id', $template->kategori_id);
    }
    
    /**
     * Create form field untuk setiap variable
     * Simple mapping dengan minimal configuration
     */
    protected function createFieldForVariable(string $variable)
    {
        $label = ucfirst(str_replace('_', ' ', $variable));
        $helperText = "{{" . $variable . "}}";
        
        return match($variable) {
            'nama' => Forms\Components\TextInput::make($variable)
                ->label('Nama')
                ->maxLength(100)
                ->placeholder('Andryano')
                ->helperText($helperText),
            
            'nik' => Forms\Components\TextInput::make($variable)
                ->label('NIK')
                ->mask('9999999999999999')
                ->placeholder('1234567890123456')
                ->helperText($helperText),
            
            'no_kk' => Forms\Components\TextInput::make($variable)
                ->label('Nomor KK')
                ->mask('9999999999999999')
                ->placeholder('1234567890123456')
                ->helperText($helperText),
            
            'tempat_lahir' => Forms\Components\TextInput::make($variable)
                ->label('Tempat Lahir')
                ->placeholder('Jakarta')
                ->helperText($helperText),
            
            'tanggal_lahir' => Forms\Components\TextInput::make($variable)
                ->label('Tanggal Lahir')
                ->placeholder('20 Juni 1990')
                ->helperText($helperText),
            
            'jenis_kelamin' => Forms\Components\TextInput::make($variable)
                ->label('Jenis Kelamin')
                ->placeholder('Pria / Wanita')
                ->helperText($helperText),
            
            'alamat' => Forms\Components\Textarea::make($variable)
                ->label('Alamat')
                ->rows(2)
                ->placeholder('Jl. Way Urang No. 123')
                ->helperText($helperText)
                ->columnSpanFull(),
            
            'rt' => Forms\Components\TextInput::make($variable)
                ->label('RT')
                ->placeholder('01')
                ->helperText($helperText),
            
            'rw' => Forms\Components\TextInput::make($variable)
                ->label('RW')
                ->placeholder('05')
                ->helperText($helperText),
            
            'dusun' => Forms\Components\TextInput::make($variable)
                ->label('Dusun')
                ->placeholder('Dusun I')
                ->helperText($helperText),
            
            'kelurahan' => Forms\Components\TextInput::make($variable)
                ->label('Kelurahan')
                ->placeholder('Sumberjaya')
                ->helperText($helperText),
            
            'kecamatan' => Forms\Components\TextInput::make($variable)
                ->label('Kecamatan')
                ->placeholder('Kalianda')
                ->helperText($helperText),
            
            'kabupaten' => Forms\Components\TextInput::make($variable)
                ->label('Kabupaten')
                ->placeholder('Lampung Selatan')
                ->helperText($helperText),
            
            'provinsi' => Forms\Components\TextInput::make($variable)
                ->label('Provinsi')
                ->placeholder('Lampung')
                ->helperText($helperText),
            
            'agama' => Forms\Components\TextInput::make($variable)
                ->label('Agama')
                ->placeholder('Islam / Kristen / Katolik / Hindu / Buddha / Konghucu')
                ->helperText($helperText),
            
            'status_perkawinan' => Forms\Components\TextInput::make($variable)
                ->label('Status Perkawinan')
                ->placeholder('Belum Kawin / Kawin / Cerai Hidup / Cerai Mati')
                ->helperText($helperText),
            
            'pekerjaan' => Forms\Components\TextInput::make($variable)
                ->label('Pekerjaan')
                ->placeholder('Mahasiswa')
                ->helperText($helperText),
            
            'kewarganegaraan' => Forms\Components\TextInput::make($variable)
                ->label('Kewarganegaraan')
                ->placeholder('WNI / WNA')
                ->default('WNI')
                ->helperText($helperText),
            
            'berlaku_hingga' => Forms\Components\TextInput::make($variable)
                ->label('Berlaku Hingga')
                ->placeholder('31 Desember 2025')
                ->helperText($helperText),
            
            'keperluan' => Forms\Components\Textarea::make($variable)
                ->label('Keperluan')
                ->rows(2)
                ->placeholder('Mengurus persyaratan...')
                ->helperText($helperText)
                ->columnSpanFull(),
            
            'keterangan' => Forms\Components\Textarea::make($variable)
                ->label('Keterangan')
                ->rows(3)
                ->placeholder('Catatan tambahan')
                ->helperText($helperText)
                ->columnSpanFull(),
            
            default => Forms\Components\TextInput::make($variable)
                ->label($label)
                ->placeholder("Isi {$variable}")
                ->helperText($helperText),
        };
    }
    
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Set user_id
        $data['user_id'] = Auth::id();
        
        // Set jenis surat
        $data['jenis'] = 'keluar';
        
        // Set status default
        $data['status'] = 'draft';
        
        // Get template
        $template = TemplateSurat::find($data['template_surat_id'] ?? null);
        
        if (!$template) {
            return $data;
        }
        
        // Extract variables based on template
        $dataVariables = [];
        
        if ($template->variables) {
            foreach ($template->variables as $variable) {
                // Check if this variable exists in the form data
                if (array_key_exists($variable, $data)) {
                    $value = $data[$variable];
                    
                    // Handle date fields - convert to string for storage
                    if ($value instanceof \Carbon\Carbon) {
                        $value = $value->isoFormat('D MMMM YYYY');
                    }
                    
                    // DEBUG: Log extraction
                    \Log::debug("Extracting variable: {$variable}", [
                        'value' => $value,
                        'type' => gettype($value),
                    ]);
                    
                    $dataVariables[$variable] = $value;
                    
                    // Remove from main data (don't save to arsip_surats table columns)
                    unset($data[$variable]);
                }
            }
        }
        
        // DEBUG: Log final dataVariables
        \Log::debug('mutateFormDataBeforeCreate - dataVariables:', $dataVariables);
        
        // Store as JSON
        $data['data_variables'] = $dataVariables;
        
        // Remove form_variables hidden field if exists
        unset($data['form_variables']);
        
        return $data;
    }
    
    protected function afterCreate(): void
    {
        // Generate PDF setelah create
        $pdfService = app(PdfGeneratorService::class);
        
        try {
            $pdfService->generate($this->record);
            
            Notification::make()
                ->title('Surat Berhasil Dibuat!')
                ->body('PDF surat telah digenerate dan tersimpan di arsip.')
                ->success()
                ->send();
        } catch (\Exception $e) {
            Notification::make()
                ->title('Gagal Generate PDF')
                ->body('Surat tersimpan tapi PDF gagal dibuat: ' . $e->getMessage())
                ->danger()
                ->send();
        }
    }
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->record]);
    }
}
