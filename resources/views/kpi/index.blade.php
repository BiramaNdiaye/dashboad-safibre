@extends('layouts.main')

@section('content')

{{-- KPIs --}}
<div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">

    <div class="relative bg-green-50 border border-green-200 rounded-xl p-5 text-center overflow-hidden">
        <div class="w-11 h-11 rounded-full bg-green-200 flex items-center justify-content-center mx-auto mb-3">
            <svg class="w-5 h-5 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
        </div>
        <p class="text-xs font-medium uppercase tracking-widest text-green-700 mb-1">Total ROP</p>
        <p class="text-3xl font-medium text-green-900">{{ $stats->sum('total') }}</p>
        <div class="absolute bottom-0 left-0 right-0 h-1 bg-green-500 rounded-b-xl"></div>
    </div>

    <div class="relative bg-amber-50 border border-amber-200 rounded-xl p-5 text-center overflow-hidden">
        <div class="w-11 h-11 rounded-full bg-amber-200 flex items-center justify-content-center mx-auto mb-3">
            <svg class="w-5 h-5 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2h5M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8z"/>
            </svg>
        </div>
        <p class="text-xs font-medium uppercase tracking-widest text-amber-700 mb-1">Opérateurs</p>
        <p class="text-3xl font-medium text-amber-900">{{ $stats->pluck('utilisateur')->unique()->count() }}</p>
        <div class="absolute bottom-0 left-0 right-0 h-1 bg-amber-500 rounded-b-xl"></div>
    </div>

</div>

{{-- FILTRES --}}
<div class="bg-white border border-gray-200 rounded-xl overflow-hidden mb-6">
    <div class="flex items-center gap-2 px-4 py-3" style="background:#45C4EB;">
        <svg class="w-4 h-4 text-[#044053]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h18M7 8h10M11 12h2M9 16h6"/>
        </svg>
        <h5 class="text-sm font-medium text-[#044053]">Filtres de recherche</h5>
    </div>
    <div class="p-5">
        <form method="GET">

            {{-- Ligne 1 : Opérateur + Date début + Date fin --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Opérateur</label>
                    <select name="user_id"
                            class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 focus:border-[#45C4EB] focus:ring-2 focus:ring-[#45C4EB]/20 outline-none">
                        <option value="">Tous les opérateurs</option>
                        @foreach($operateurs as $operateur)
                            <option value="{{ $operateur->id }}"
                                {{ request('user_id') == $operateur->id ? 'selected' : '' }}>
                                {{ $operateur->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Date début</label>
                    <input type="date" name="date_debut" value="{{ request('date_debut') }}"
                           class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 focus:border-[#45C4EB] focus:ring-2 focus:ring-[#45C4EB]/20 outline-none">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Date fin</label>
                    <input type="date" name="date_fin" value="{{ request('date_fin') }}"
                           class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 focus:border-[#45C4EB] focus:ring-2 focus:ring-[#45C4EB]/20 outline-none">
                </div>

            </div>

            {{-- Ligne 2 : Boutons alignés à droite --}}
            <div class="flex flex-wrap justify-end items-center gap-2 mt-4">

                <a href="{{ route('rapports.rop-operateurs') }}"
                   class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4l16 16M20 4L4 20"/>
                    </svg>
                    Réinitialiser
                </a>

                <button type="submit"
                        class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-medium text-white rounded-lg hover:opacity-90 transition-opacity"
                        style="background:#F7881B;">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h18M7 8h10M11 12h2M9 16h6"/>
                    </svg>
                    Filtrer
                </button>
                
                <a href="{{ route('kpi.rop.export', array_filter([
                        'user_id'    => request('user_id'),
                        'date_debut' => request('date_debut'),
                        'date_fin'   => request('date_fin'),
                    ])) }}"
                   class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-medium text-white rounded-lg hover:opacity-90 transition-colors"
                   style="background:#1D6F42;">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5 5-5M12 15V3"/>
                    </svg>
                    Exporter Excel
                </a>

            </div>

        </form>
    </div>
</div>
{{-- TABLEAU --}}
<div class="bg-white mb-10 border border-gray-200 rounded-xl overflow-hidden">
    <div class="flex items-center gap-2 px-4 py-3" style="background:#45C4EB;">
        <svg class="w-4 h-4 text-[#044053]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 6h18M3 14h18M3 18h18"/>
        </svg>
        <h5 class="text-sm font-medium text-[#044053]">Production ROP par opérateur</h5>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-200">
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Opérateur</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date livraison</th>
                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre ROP</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($stats as $stat)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-3 flex items-center gap-3">
                            <span class="w-8 h-8 rounded-full bg-blue-100 text-blue-700 text-xs font-medium flex items-center justify-center flex-shrink-0">
                                {{ strtoupper(substr($stat->utilisateur, 0, 2)) }}
                            </span>
                            <span class="font-medium text-gray-900">{{ $stat->utilisateur }}</span>
                        </td>
                        <td class="px-4 py-3 text-gray-500">
                            {{ \Carbon\Carbon::parse($stat->jour)->format('d/m/Y') }}
                        </td>
                        <td class="px-4 py-3 text-center">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                {{ $stat->total }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-4 py-10 text-center text-gray-400">
                            <svg class="w-8 h-8 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Aucun résultat trouvé
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-4 py-3 border-t border-gray-100">
        {{ $stats->links('vendor.pagination.tailwind') }}
    </div>
</div>
{{-- HISTOGRAMME --}}
<div class="bg-white mb-10 border border-gray-200 rounded-xl overflow-hidden mb-6">
    <div class="flex items-center gap-2 px-4 py-3" style="background:#45C4EB;">
        <svg class="w-4 h-4 text-[#044053]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M3 3v18h18M7 18V10m4 8V6m4 12V4"/>
        </svg>
        <h5 class="text-sm font-medium text-[#044053]">Production ROP par opérateur</h5>
    </div>
    <div class="p-5">
        <div class="relative w-full" style="height: 280px;">
            <canvas id="ropHisto"
                    role="img"
                    aria-label="Histogramme de la production ROP par opérateur">
                Production ROP par opérateur.
            </canvas>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const histoLabels = @json($histogramData->pluck('utilisateur'));
    const histoTotals = @json($histogramData->pluck('total'));

    const maxVal    = Math.max(...histoTotals);
    const barColors = histoTotals.map(v => v === maxVal ? '#F7881B' : '#378ADD');

    new Chart(document.getElementById('ropHisto'), {
        type: 'bar',
        data: {
            labels: histoLabels,
            datasets: [{
                label: 'Total ROP',
                data: histoTotals,
                backgroundColor: barColors,
                borderRadius: 6,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#ffffff',
                    borderColor: 'rgba(0,0,0,0.1)',
                    borderWidth: 1,
                    titleColor: '#111827',
                    bodyColor: '#374151',
                    padding: 10,
                    callbacks: {
                        label: ctx => ' ' + ctx.parsed.y + ' ROP livrés'
                    }
                },
                datalabels: false
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: {
                        color: '#6B7280',
                        font: { size: 12 },
                        maxRotation: 25,
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(0,0,0,0.05)' },
                    ticks: {
                        color: '#6B7280',
                        font: { size: 11 },
                        stepSize: 1,
                        callback: v => Math.round(v)
                    }
                }
            }
        }
    });
</script>
@endpush
@endsection