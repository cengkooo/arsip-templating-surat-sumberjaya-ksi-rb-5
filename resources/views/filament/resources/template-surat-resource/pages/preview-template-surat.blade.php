<x-filament-panels::page>
    <div class="max-w-5xl mx-auto space-y-6">
        {{-- Header --}}
        <div class="bg-white dark:bg-gray-900 shadow-sm border border-gray-200 dark:border-gray-800 rounded-2xl">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-800 flex items-start justify-between gap-4">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">Template Surat</p>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white">{{ $record->nama_template }}</h1>
                    @if($record->keterangan)
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400 leading-relaxed">{{ $record->keterangan }}</p>
                    @endif
                </div>
                <div class="flex flex-col items-end gap-2">
                    <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-sm font-semibold {{ $record->is_active ? 'bg-emerald-50 text-emerald-700 border border-emerald-200 dark:bg-emerald-900/30 dark:text-emerald-200 dark:border-emerald-700' : 'bg-rose-50 text-rose-700 border border-rose-200 dark:bg-rose-900/30 dark:text-rose-200 dark:border-rose-700' }}">
                        <span class="h-2 w-2 rounded-full {{ $record->is_active ? 'bg-emerald-500' : 'bg-rose-500' }}"></span>
                        {{ $record->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                    <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-200 border border-gray-200 dark:border-gray-700">
                        <span class="text-gray-500 dark:text-gray-400">Kode</span>
                        <span class="font-mono">{{ $record->kode_template }}</span>
                    </span>
                    <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-100 dark:bg-blue-900/40 dark:text-blue-200 dark:border-blue-700">
                        {{ $record->kategori->nama ?? 'Tidak ada kategori' }}
                    </span>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 px-6 py-4">
                <div class="space-y-1">
                    <p class="text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400 font-semibold">Nama Template</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $record->nama_template }}</p>
                </div>
                <div class="space-y-1">
                    <p class="text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400 font-semibold">Status</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $record->is_active ? 'Aktif' : 'Nonaktif' }}</p>
                </div>
                <div class="space-y-1">
                    <p class="text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400 font-semibold">Ukuran Kertas</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $record->ukuran_kertas }}</p>
                </div>
                <div class="space-y-1">
                    <p class="text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400 font-semibold">Orientasi</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ ucfirst($record->orientasi) }}</p>
                </div>
            </div>
        </div>

        {{-- Margin & Tampilan --}}
        <div class="bg-white dark:bg-gray-900 shadow-sm border border-gray-200 dark:border-gray-800 rounded-2xl">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-800">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white">Pengaturan Halaman</h2>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 px-6 py-4">
                <div class="rounded-xl border border-gray-200 dark:border-gray-800 p-4 text-center">
                    <p class="text-xs text-gray-500 dark:text-gray-400">Margin Kiri</p>
                    <p class="text-xl font-semibold text-gray-900 dark:text-white">{{ $record->margin_kiri }} cm</p>
                </div>
                <div class="rounded-xl border border-gray-200 dark:border-gray-800 p-4 text-center">
                    <p class="text-xs text-gray-500 dark:text-gray-400">Margin Kanan</p>
                    <p class="text-xl font-semibold text-gray-900 dark:text-white">{{ $record->margin_kanan }} cm</p>
                </div>
                <div class="rounded-xl border border-gray-200 dark:border-gray-800 p-4 text-center">
                    <p class="text-xs text-gray-500 dark:text-gray-400">Margin Atas</p>
                    <p class="text-xl font-semibold text-gray-900 dark:text-white">{{ $record->margin_atas }} cm</p>
                </div>
                <div class="rounded-xl border border-gray-200 dark:border-gray-800 p-4 text-center">
                    <p class="text-xs text-gray-500 dark:text-gray-400">Margin Bawah</p>
                    <p class="text-xl font-semibold text-gray-900 dark:text-white">{{ $record->margin_bawah }} cm</p>
                </div>
            </div>
            <div class="px-6 pb-6 space-y-3">
                <p class="text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400 font-semibold">Pengaturan Tampilan</p>
                <div class="flex flex-wrap gap-2">
                    <span class="inline-flex items-center gap-2 px-3 py-2 rounded-lg border {{ $record->tampilkan_header ? 'border-emerald-200 bg-emerald-50 text-emerald-700 dark:border-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-200' : 'border-gray-200 bg-gray-50 text-gray-700 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200' }}">
                        <span class="h-2 w-2 rounded-full {{ $record->tampilkan_header ? 'bg-emerald-500' : 'bg-gray-300' }}"></span>
                        Header ({{ $record->header_type }})
                    </span>
                    <span class="inline-flex items-center gap-2 px-3 py-2 rounded-lg border {{ $record->tampilkan_footer ? 'border-emerald-200 bg-emerald-50 text-emerald-700 dark:border-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-200' : 'border-gray-200 bg-gray-50 text-gray-700 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200' }}">
                        <span class="h-2 w-2 rounded-full {{ $record->tampilkan_footer ? 'bg-emerald-500' : 'bg-gray-300' }}"></span>
                        Footer
                    </span>
                    <span class="inline-flex items-center gap-2 px-3 py-2 rounded-lg border {{ $record->tampilkan_logo ? 'border-emerald-200 bg-emerald-50 text-emerald-700 dark:border-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-200' : 'border-gray-200 bg-gray-50 text-gray-700 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200' }}">
                        <span class="h-2 w-2 rounded-full {{ $record->tampilkan_logo ? 'bg-emerald-500' : 'bg-gray-300' }}"></span>
                        Logo Garuda
                    </span>
                    <span class="inline-flex items-center gap-2 px-3 py-2 rounded-lg border {{ $record->tampilkan_qrcode ? 'border-emerald-200 bg-emerald-50 text-emerald-700 dark:border-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-200' : 'border-gray-200 bg-gray-50 text-gray-700 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200' }}">
                        <span class="h-2 w-2 rounded-full {{ $record->tampilkan_qrcode ? 'bg-emerald-500' : 'bg-gray-300' }}"></span>
                        QR Code
                    </span>
                </div>
            </div>
        </div>

        {{-- Preview --}}
        <div class="bg-white dark:bg-gray-900 shadow-sm border border-gray-200 dark:border-gray-800 rounded-2xl overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-800 flex items-center justify-between">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white">Preview Template Surat</h2>
                <span class="text-xs px-3 py-1 rounded-full bg-gray-100 text-gray-600 border border-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700">Pratinjau</span>
            </div>
            <div class="p-6 space-y-6">
                @if($record->content_header && $record->tampilkan_header)
                    <div class="space-y-2 border-b border-dashed border-gray-300 dark:border-gray-700 pb-4">
                        <p class="text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400 font-semibold">Header</p>
                        <div class="prose prose-sm max-w-none dark:prose-invert bg-gray-50 dark:bg-gray-800 p-4 rounded-xl border border-gray-200 dark:border-gray-700">
                            {!! $record->content_header !!}
                        </div>
                    </div>
                @endif

                <div class="space-y-2">
                    <p class="text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400 font-semibold">Isi Surat</p>
                    <div class="prose prose-sm max-w-none dark:prose-invert bg-gray-50 dark:bg-gray-800 p-4 rounded-xl border border-gray-200 dark:border-gray-700 min-h-[200px]">
                        {!! $record->content_body !!}
                    </div>
                </div>

                @if($record->content_footer && $record->tampilkan_footer)
                    <div class="space-y-2 border-t border-dashed border-gray-300 dark:border-gray-700 pt-4">
                        <p class="text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400 font-semibold">Footer</p>
                        <div class="prose prose-sm max-w-none dark:prose-invert bg-gray-50 dark:bg-gray-800 p-4 rounded-xl border border-gray-200 dark:border-gray-700">
                            {!! $record->content_footer !!}
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- Variables --}}
        @if($record->variables && count($record->variables) > 0)
            <div class="bg-white dark:bg-gray-900 shadow-sm border border-gray-200 dark:border-gray-800 rounded-2xl p-6 space-y-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Variabel Template</h3>
                    <span class="text-xs font-semibold px-3 py-1 rounded-full bg-blue-50 text-blue-700 border border-blue-100 dark:bg-blue-900/30 dark:text-blue-200 dark:border-blue-700">{{ count($record->variables) }} variabel</span>
                </div>
                <p class="text-sm text-gray-600 dark:text-gray-400">Gunakan variabel ini pada konten template untuk menampilkan data dinamis.</p>
                <div class="flex flex-wrap gap-2">
                    @foreach($record->variables as $variable)
                        <span class="inline-flex items-center gap-2 px-3 py-2 rounded-lg border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-sm font-mono text-gray-800 dark:text-gray-200">
                            {{ '{{' }} {{ $variable }} {{ '}}' }}
                        </span>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Format Nomor --}}
        @if($record->format_nomor)
            <div class="bg-white dark:bg-gray-900 shadow-sm border border-gray-200 dark:border-gray-800 rounded-2xl p-6 space-y-3">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Format Penomoran</h3>
                <div class="rounded-xl border border-amber-200 dark:border-amber-700 bg-amber-50 dark:bg-amber-900/30 px-4 py-3">
                    <p class="text-base font-mono font-semibold text-amber-900 dark:text-amber-100">{{ $record->format_nomor }}</p>
                </div>
            </div>
        @endif
    </div>
</x-filament-panels::page>
