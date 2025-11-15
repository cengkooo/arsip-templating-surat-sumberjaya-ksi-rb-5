<div class="flex flex-col md:flex-row items-center gap-4 mb-6">
    <div class="flex flex-row gap-4 w-full md:w-auto">
        <div class="bg-blue-600 rounded-xl shadow-2xl p-4 min-w-[160px] flex flex-col items-start border-4 border-blue-800 hover:scale-105 transition-transform">
            <div class="text-xs text-white mb-1 font-extrabold uppercase tracking-wide">Total Arsip Surat</div>
            <div class="text-4xl font-extrabold text-white drop-shadow-lg">{{ number_format($totalArsip) }}</div>
        </div>
        <div class="bg-green-600 rounded-xl shadow-2xl p-4 min-w-[160px] flex flex-col items-start border-4 border-green-800 hover:scale-105 transition-transform">
            <div class="text-xs text-white mb-1 font-extrabold uppercase tracking-wide">Total Template</div>
            <div class="text-4xl font-extrabold text-white drop-shadow-lg">{{ number_format($totalTemplate) }}</div>
        </div>
    </div>
    <div class="flex flex-row gap-3 mt-4">
        <a href="{{ route('filament.admin.resources.arsip-surats.create-from-template') }}"
           class="inline-flex items-center px-5 py-2.5 bg-orange-500 hover:bg-orange-600 text-white text-base font-semibold rounded-lg shadow transition">
            <x-heroicon-o-document-plus class="h-5 w-5 mr-2" />
            Buat Surat Cepat
        </a>
        <a href="{{ route('filament.admin.resources.arsip-surats.create') }}"
           class="inline-flex items-center px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-base font-semibold rounded-lg shadow transition">
            <x-heroicon-o-archive-box class="h-5 w-5 mr-2" />
            Tambah Arsip Cepat
        </a>
    </div>
</div>