<x-filament-widgets::widget>
    <x-filament::section>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Buat Surat Baru -->
            <a href="{{ route('filament.admin.resources.arsip-surats.create-from-template') }}" 
               class="flex flex-col items-center justify-center p-6 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition-all shadow-lg hover:shadow-xl">
                <svg class="w-12 h-12 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span class="text-lg font-semibold">Buat Surat Baru</span>
                <span class="text-sm text-primary-100 mt-1">Dari Template</span>
            </a>

            <!-- Tambah Template -->
            <a href="{{ route('filament.admin.resources.template-surats.create') }}" 
               class="flex flex-col items-center justify-center p-6 bg-warning-500 text-white rounded-lg hover:bg-warning-600 transition-all shadow-lg hover:shadow-xl">
                <svg class="w-12 h-12 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <span class="text-lg font-semibold">Tambah Template</span>
                <span class="text-sm text-warning-100 mt-1">Template Surat Baru</span>
            </a>

            <!-- Upload Arsip -->
            <a href="{{ route('filament.admin.resources.arsip-surats.create') }}" 
               class="flex flex-col items-center justify-center p-6 bg-success-500 text-white rounded-lg hover:bg-success-600 transition-all shadow-lg hover:shadow-xl">
                <svg class="w-12 h-12 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                </svg>
                <span class="text-lg font-semibold">Upload Arsip</span>
                <span class="text-sm text-success-100 mt-1">Arsip Manual</span>
            </a>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
