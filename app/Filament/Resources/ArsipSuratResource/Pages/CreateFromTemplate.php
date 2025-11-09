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
                        
                        $fields = [];
                        foreach ($template->variables as $variable) {
                            // Special handling untuk jenis_kelamin
                            if ($variable === 'jenis_kelamin') {
                                $fields[] = Forms\Components\Select::make("variables.{$variable}")
                                    ->label('Jenis Kelamin')
                                    ->options([
                                        'Pria' => 'Pria',
                                        'Wanita' => 'Wanita',
                                    ])
                                    ->native(false)
                                    ->required()
                                    ->helperText("Akan mengganti {{" . $variable . "}} di template");
                            } else {
                                $fields[] = Forms\Components\TextInput::make("variables.{$variable}")
                                    ->label(ucfirst(str_replace('_', ' ', $variable)))
                                    ->placeholder("Isi {$variable}")
                                    ->helperText("Akan mengganti {{" . $variable . "}} di template");
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
    
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Set user_id
        $data['user_id'] = Auth::id();
        
        // Set jenis surat (keluar karena dari template desa)
        $data['jenis'] = 'keluar';
        
        // Set status default
        $data['status'] = 'draft';
        
        // Ambil variables dari form
        $dataVariables = $data['variables'] ?? [];
        unset($data['variables']);
        
        $data['data_variables'] = $dataVariables;
        
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
