@php
    $usageLabels = $templateUsageLabels ?? [];
    $usageCounts = $templateUsageCounts ?? [];
    $desaData = $desa ?? null;
@endphp

<div class="flex flex-row gap-4 mt-0 mb-4 justify-end items-center w-full" style="position: absolute; top: 0; right: 2rem; z-index: 10;">
    <a href="{{ route('filament.admin.resources.arsip-surats.create') }}"
       class="inline-flex items-center px-6 py-3 bg-orange-500 hover:bg-orange-600 text-white text-base font-semibold rounded-lg shadow transition">
        <x-heroicon-o-archive-box class="h-5 w-5 mr-2" />
        Tambah Arsip
    </a>
    <a href="{{ route('filament.admin.resources.arsip-surats.create-from-template') }}"
       class="inline-flex items-center px-6 py-3 bg-orange-500 hover:bg-orange-600 text-white text-base font-semibold rounded-lg shadow transition">
        <x-heroicon-o-document-plus class="h-5 w-5 mr-2" />
        Surat Baru
    </a>
</div>

@once
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.6/dist/chart.umd.min.js" integrity="sha256-uKiaQJeAHRdXijN8D7MLT0JwADjyZWekjyLNu3kCgN4=" crossorigin="anonymous"></script>
    @endpush
@endonce

@push('scripts')
    <script>
        const initTemplateUsageChart = () => {
            const ctx = document.getElementById('templateUsageChart');
            if (!ctx || typeof Chart === 'undefined') {
                return;
            }

            if (ctx.chartInstance) {
                ctx.chartInstance.destroy();
            }

            const labels = @json($usageLabels);
            const counts = @json($usageCounts);

            if (!labels.length) {
                return;
            }

            ctx.chartInstance = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels,
                    datasets: [
                        {
                            label: 'Total Penggunaan',
                            data: counts,
                            backgroundColor: '#2563eb',
                            borderRadius: 8,
                        },
                    ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            ticks: {
                                precision: 0,
                            },
                            beginAtZero: true,
                            grid: {
                                color: '#f1f5f9',
                            },
                        },
                        x: {
                            grid: {
                                display: false,
                            },
                        },
                    },
                    plugins: {
                        legend: {
                            display: false,
                        },
                    },
                },
            });
        };

        document.addEventListener('livewire:load', initTemplateUsageChart);
        document.addEventListener('livewire:navigated', initTemplateUsageChart);
    </script>
@endpush
