<x-filament-panels::page>
    <div class="space-y-6">
        <!-- Info Template -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-gray-200 dark:border-gray-700">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Informasi Template
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="space-y-1">
                    <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Nama Template</h3>
                    <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $record->nama_template }}</p>
                </div>
                <div class="space-y-1">
                    <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Kode Template</h3>
                    <p class="text-lg font-bold text-blue-600 dark:text-blue-400">{{ $record->kode_template }}</p>
                </div>
                <div class="space-y-1">
                    <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Kategori</h3>
                    <p class="text-base font-semibold text-gray-900 dark:text-white">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                            {{ $record->kategori->nama }}
                        </span>
                    </p>
                </div>
            </div>
            
            @if($record->keterangan)
            <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Keterangan</h3>
                <p class="text-sm text-gray-700 dark:text-gray-300">{{ $record->keterangan }}</p>
            </div>
            @endif
        </div>

        <!-- Pengaturan Halaman -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-gray-200 dark:border-gray-700">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                </svg>
                Pengaturan Halaman
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-gray-50 dark:bg-gray-900 p-4 rounded-lg border border-gray-200 dark:border-gray-700">
                    <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-2">Ukuran Kertas</h3>
                    <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $record->ukuran_kertas }}</p>
                </div>
                <div class="bg-gray-50 dark:bg-gray-900 p-4 rounded-lg border border-gray-200 dark:border-gray-700">
                    <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-2">Orientasi</h3>
                    <p class="text-lg font-bold text-gray-900 dark:text-white">{{ ucfirst($record->orientasi) }}</p>
                </div>
                <div class="bg-gray-50 dark:bg-gray-900 p-4 rounded-lg border border-gray-200 dark:border-gray-700">
                    <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-2">Status</h3>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold {{ $record->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                        {{ $record->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </div>
                <div class="bg-gray-50 dark:bg-gray-900 p-4 rounded-lg border border-gray-200 dark:border-gray-700">
                    <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-2">Layanan Mandiri</h3>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold {{ $record->sediakan_layanan_mandiri ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200' }}">
                        {{ $record->sediakan_layanan_mandiri ? 'Ya' : 'Tidak' }}
                    </span>
                </div>
            </div>
            
            <!-- Margin -->
            <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                <h3 class="text-sm font-bold text-gray-700 dark:text-gray-300 mb-4 uppercase tracking-wide">Margin Kertas</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="text-center p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                        <p class="text-xs text-gray-600 dark:text-gray-400 mb-1">Kiri</p>
                        <p class="text-xl font-bold text-blue-600 dark:text-blue-400">{{ $record->margin_kiri }} cm</p>
                    </div>
                    <div class="text-center p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                        <p class="text-xs text-gray-600 dark:text-gray-400 mb-1">Kanan</p>
                        <p class="text-xl font-bold text-blue-600 dark:text-blue-400">{{ $record->margin_kanan }} cm</p>
                    </div>
                    <div class="text-center p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                        <p class="text-xs text-gray-600 dark:text-gray-400 mb-1">Atas</p>
                        <p class="text-xl font-bold text-blue-600 dark:text-blue-400">{{ $record->margin_atas }} cm</p>
                    </div>
                    <div class="text-center p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                        <p class="text-xs text-gray-600 dark:text-gray-400 mb-1">Bawah</p>
                        <p class="text-xl font-bold text-blue-600 dark:text-blue-400">{{ $record->margin_bawah }} cm</p>
                    </div>
                </div>
            </div>
            
            <!-- Pengaturan Tampilan -->
            <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                <h3 class="text-sm font-bold text-gray-700 dark:text-gray-300 mb-4 uppercase tracking-wide">Pengaturan Tampilan</h3>
                <div class="flex flex-wrap gap-3">
                    <div class="flex items-center gap-2 px-4 py-2 {{ $record->tampilkan_header ? 'bg-green-50 text-green-700 border-green-200 dark:bg-green-900/20 dark:text-green-300 dark:border-green-800' : 'bg-gray-50 text-gray-700 border-gray-200 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700' }} border rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $record->tampilkan_header ? 'M5 13l4 4L19 7' : 'M6 18L18 6M6 6l12 12' }}"></path>
                        </svg>
                        <span class="font-medium">Header ({{ $record->header_type }})</span>
                    </div>
                    <div class="flex items-center gap-2 px-4 py-2 {{ $record->tampilkan_footer ? 'bg-green-50 text-green-700 border-green-200 dark:bg-green-900/20 dark:text-green-300 dark:border-green-800' : 'bg-gray-50 text-gray-700 border-gray-200 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700' }} border rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $record->tampilkan_footer ? 'M5 13l4 4L19 7' : 'M6 18L18 6M6 6l12 12' }}"></path>
                        </svg>
                        <span class="font-medium">Footer</span>
                    </div>
                    <div class="flex items-center gap-2 px-4 py-2 {{ $record->tampilkan_logo ? 'bg-green-50 text-green-700 border-green-200 dark:bg-green-900/20 dark:text-green-300 dark:border-green-800' : 'bg-gray-50 text-gray-700 border-gray-200 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700' }} border rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $record->tampilkan_logo ? 'M5 13l4 4L19 7' : 'M6 18L18 6M6 6l12 12' }}"></path>
                        </svg>
                        <span class="font-medium">Logo Garuda</span>
                    </div>
                    <div class="flex items-center gap-2 px-4 py-2 {{ $record->tampilkan_qrcode ? 'bg-green-50 text-green-700 border-green-200 dark:bg-green-900/20 dark:text-green-300 dark:border-green-800' : 'bg-gray-50 text-gray-700 border-gray-200 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700' }} border rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $record->tampilkan_qrcode ? 'M5 13l4 4L19 7' : 'M6 18L18 6M6 6l12 12' }}"></path>
                        </svg>
                        <span class="font-medium">QR Code</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Preview Content -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
            <div class="border-b border-gray-200 dark:border-gray-700 px-6 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-gray-900 dark:to-gray-800">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    Preview Template Surat
                </h2>
            </div>
            
            <div class="p-8 space-y-8" style="background: linear-gradient(to bottom, #f9fafb 0%, #ffffff 100%);">
                <!-- Header -->
                @if($record->content_header && $record->tampilkan_header)
                <div class="border-b-2 border-gray-300 dark:border-gray-600 pb-6">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-2 h-6 bg-blue-600 rounded"></div>
                        <h3 class="text-sm font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wide">Header (Kop Surat)</h3>
                    </div>
                    <div class="prose prose-sm max-w-none dark:prose-invert bg-white dark:bg-gray-900 p-6 rounded-lg border-2 border-gray-200 dark:border-gray-700 shadow-sm">
                        {!! $record->content_header !!}
                    </div>
                </div>
                @endif

                <!-- Body -->
                <div class="pb-6">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-2 h-6 bg-green-600 rounded"></div>
                        <h3 class="text-sm font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wide">Isi Surat</h3>
                    </div>
                    <div class="prose prose-sm max-w-none dark:prose-invert bg-white dark:bg-gray-900 p-6 rounded-lg border-2 border-gray-200 dark:border-gray-700 shadow-sm min-h-[200px]">
                        {!! $record->content_body !!}
                    </div>
                </div>

                <!-- Footer -->
                @if($record->content_footer && $record->tampilkan_footer)
                <div class="border-t-2 border-gray-300 dark:border-gray-600 pt-6">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-2 h-6 bg-purple-600 rounded"></div>
                        <h3 class="text-sm font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wide">Footer (Tanda Tangan)</h3>
                    </div>
                    <div class="prose prose-sm max-w-none dark:prose-invert bg-white dark:bg-gray-900 p-6 rounded-lg border-2 border-gray-200 dark:border-gray-700 shadow-sm">
                        {!! $record->content_footer !!}
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Variables -->
        @if($record->variables && count($record->variables) > 0)
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center gap-2 mb-4">
                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                </svg>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white">Variable yang Tersedia</h3>
            </div>
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Gunakan variable berikut dalam template untuk data dinamis. Total: <strong>{{ count($record->variables) }} variable</strong></p>
            <div class="flex flex-wrap gap-3">
                @foreach($record->variables as $variable)
                    <span class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-blue-100 to-indigo-100 text-blue-900 dark:from-blue-900 dark:to-indigo-900 dark:text-blue-100 rounded-lg text-sm font-mono font-bold shadow-sm border-2 border-blue-200 dark:border-blue-800 hover:scale-105 transition-transform">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                        </svg>
                        {{ '{{' }} {{ $variable }} {{ '}}' }}
                    </span>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Format Nomor -->
        @if($record->format_nomor)
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center gap-2 mb-4">
                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                </svg>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white">Format Penomoran Surat</h3>
            </div>
            <div class="bg-orange-50 dark:bg-orange-900/20 p-4 rounded-lg border-2 border-orange-200 dark:border-orange-800">
                <p class="text-lg font-mono font-bold text-orange-900 dark:text-orange-100">{{ $record->format_nomor }}</p>
            </div>
        </div>
        @endif
    </div>
</x-filament-panels::page>
