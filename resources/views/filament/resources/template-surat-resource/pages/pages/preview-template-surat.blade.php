<x-filament-panels::page>
    <div class="space-y-6">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h2 class="text-xl font-bold mb-4">{{ $record->nama_template }}</h2>
            
            <div class="prose max-w-none dark:prose-invert">
                {!! $record->konten_template !!}
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-3">Variabel Template:</h3>
            @if($record->variabel_template)
                <ul class="list-disc list-inside space-y-1">
                    @foreach($record->variabel_template as $var)
                        <li><code>{{ '{{' . $var['nama'] . '}}' }}</code> - {{ $var['label'] }}</li>
                    @endforeach
                </ul>
            @else
                <p class="text-gray-500">Tidak ada variabel</p>
            @endif
        </div>
    </div>
</x-filament-panels::page>