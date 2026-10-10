@extends('layouts.main')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50/30">
    <div class="container mx-auto p-4">
        <!-- Header avec stats -->
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6 mb-8">
            <div class="flex-1">
                <div class="flex items-center space-x-3 mb-2">
                    <div class="p-2 bg-gradient-to-r from-[#45C4EB] to-blue-500 rounded-xl shadow-lg">
                        <i class="fas fa-project-diagram text-white text-lg"></i>
                    </div>
                    <h1 class="text-2xl md:text-3xl font-bold text-[#45C4EB] ">
                        Liste des Patatoïdes
                    </h1>
                </div>
                <p class="text-gray-600 text-fontbold">Gestion et suivi des projets patatoïdes</p>
            </div>
            
            <a href="{{ route('patatoides.create') }}" 
               class="group inline-flex items-center space-x-2 bg-gradient-to-r from-[#45C4EB] to-blue-500 hover:from-[#F7881B] hover:to-orange-500 text-[#45C4EB] font-semibold px-6 py-3 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                <i class="fas fa-plus-circle group-hover:rotate-90 transition-transform duration-300"></i>
                <span>Nouveau Patatoïde</span>
            </a>
        </div>

        <!-- Cartes de statistiques -->
       <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total des patatoïdes -->
    <div class="bg-gradient-to-br from-blue-50 to-indigo-100 rounded-2xl shadow-lg border border-blue-200 p-6 transform hover:scale-105 transition-all duration-300 group">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-600 text-sm font-medium">Total des projets</p>
                <p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalPatatoides ?? 0 }}</p>
            </div>
            <div class="p-3 bg-white/80 rounded-xl shadow-sm group-hover:scale-110 transition-transform duration-300">
                <i class="fas fa-layer-group text-blue-500 text-xl"></i>
            </div>
        </div>
        <div class="mt-4 pt-3 border-t border-blue-200/50">
            <span class="text-blue-700 text-sm font-medium flex items-center">
                <i class="fas fa-chart-line mr-2"></i>
                Tous les projets confondus
            </span>
        </div>
    </div>

    <!-- Patatoïdes livrés -->
    <div class="bg-gradient-to-br from-green-50 to-emerald-100 rounded-2xl shadow-lg border border-green-200 p-6 transform hover:scale-105 transition-all duration-300 group">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-green-600 text-sm font-medium">Livrés</p>
                <p class="text-3xl font-bold text-gray-800 mt-1">{{ $livresCount ?? 0 }}</p>
            </div>
            <div class="p-3 bg-white/80 rounded-xl shadow-sm group-hover:scale-110 transition-transform duration-300">
                <i class="fas fa-check-circle text-green-500 text-xl"></i>
            </div>
        </div>
        <div class="mt-4 pt-3 border-t border-green-200/50">
            <span class="text-green-700 text-sm font-medium flex items-center">
                @php
                    $livresPercentage = $totalPatatoides > 0 ? round(($livresCount / $totalPatatoides) * 100) : 0;
                @endphp
                <i class="fas fa-chart-pie mr-2"></i>
                {{ $livresPercentage }}% du total
            </span>
        </div>
    </div>

    <!-- En cours -->
    <div class="bg-gradient-to-br from-amber-50 to-orange-100 rounded-2xl shadow-lg border border-amber-200 p-6 transform hover:scale-105 transition-all duration-300 group">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-amber-600 text-sm font-medium">En cours</p>
                <p class="text-3xl font-bold text-gray-800 mt-1">{{ $enCoursCount ?? 0 }}</p>
            </div>
            <div class="p-3 bg-white/80 rounded-xl shadow-sm group-hover:scale-110 transition-transform duration-300">
                <i class="fas fa-sync-alt text-amber-500 text-xl"></i>
            </div>
        </div>
        <div class="mt-4 pt-3 border-t border-amber-200/50">
            <span class="text-amber-700 text-sm font-medium flex items-center">
                @php
                    $enCoursPercentage = $totalPatatoides > 0 ? round(($enCoursCount / $totalPatatoides) * 100) : 0;
                @endphp
                <i class="fas fa-tasks mr-2"></i>
                {{ $enCoursPercentage }}% du total
            </span>
        </div>
    </div>

    <!-- En attente -->
    <div class="bg-gradient-to-br from-purple-50 to-violet-100 rounded-2xl shadow-lg border border-purple-200 p-6 transform hover:scale-105 transition-all duration-300 group">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-purple-600 text-sm font-medium">En attente</p>
                <p class="text-3xl font-bold text-gray-800 mt-1">{{ $attenteCount ?? 0 }}</p>
            </div>
            <div class="p-3 bg-white/80 rounded-xl shadow-sm group-hover:scale-110 transition-transform duration-300">
                <i class="fas fa-clock text-purple-500 text-xl"></i>
            </div>
        </div>
        <div class="mt-4 pt-3 border-t border-purple-200/50">
            <span class="text-purple-700 text-sm font-medium flex items-center">
                @php
                    $attentePercentage = $totalPatatoides > 0 ? round(($attenteCount / $totalPatatoides) * 100) : 0;
                @endphp
                <i class="fas fa-hourglass-half mr-2"></i>
                {{ $attentePercentage }}% du total
            </span>
        </div>
    </div>
</div>
        <!-- Filtres -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 mb-6">
            <form action="{{ route('patatoides.index') }}" method="GET" class="space-y-6">
                <!-- Dates Réception & Livraison -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    <!-- Date Réception -->
    <div class="p-6 border border-[#45C4EB]/30 rounded-xl shadow-sm bg-gradient-to-r from-blue-50 to-blue-50/50">
        <label class="text-lg font-semibold text-gray-700 block mb-3">
            <i class="fas fa-calendar-alt text-[#45C4EB] mr-2"></i>
            Date Réception
        </label>

        <div class="space-y-3">
            <input type="date" name="date_reception_from"
                   class="border-2 border-[#45C4EB]/30 rounded-xl p-3 w-full shadow-sm focus:ring-2 focus:ring-[#45C4EB] focus:border-transparent transition-all duration-200"
                   value="{{ request('date_reception_from') }}">

            <input type="date" name="date_reception_to"
                   class="border-2 border-[#45C4EB]/30 rounded-xl p-3 w-full shadow-sm focus:ring-2 focus:ring-[#45C4EB] focus:border-transparent transition-all duration-200"
                   value="{{ request('date_reception_to') }}">
        </div>
    </div>

    <!-- Date Livraison -->
    <div class="p-6 border border-[#F7881B]/30 rounded-xl shadow-sm bg-gradient-to-r from-orange-50 to-orange-50/50">
        <label class="text-lg font-semibold text-gray-700 block mb-3">
            <i class="fas fa-calendar-alt text-[#F7881B] mr-2"></i>
            Date Livraison
        </label>

        <div class="space-y-3">
            <input type="date" name="date_liv_from"
                   class="border-2 border-[#F7881B]/30 rounded-xl p-3 w-full shadow-sm focus:ring-2 focus:ring-[#F7881B] focus:border-transparent transition-all duration-200"
                   value="{{ request('date_liv_from') }}">

            <input type="date" name="date_liv_to"
                   class="border-2 border-[#F7881B]/30 rounded-xl p-3 w-full shadow-sm focus:ring-2 focus:ring-[#F7881B] focus:border-transparent transition-all duration-200"
                   value="{{ request('date_liv_to') }}">
        </div>
    </div>

    <!-- Statut Patatoide & Validation -->
    <div class="p-6 border border-[#F7881B]/30 rounded-xl shadow-sm bg-gradient-to-r from-gray-50 to-gray-100">

        <label class="text-sm font-semibold text-gray-700 block mb-3">
            Statut Patatoide & Validation Covage
        </label>

        <!-- Statut Patatoide -->
        <div class="mb-4">
            <select name="statut_patatoide"
                    class="border-2 border-[#F7881B]/30 rounded-xl p-3 w-full shadow-sm focus:ring-2 focus:ring-[#F7881B] focus:border-transparent transition-all duration-200">
                <option value="">Tous les statuts</option>
                <option value="EN COURS" {{ request('statut_patatoide')=='EN COURS'?'selected':'' }}>EN COURS</option>
                <option value="LIVRÉ" {{ request('statut_patatoide')=='LIVRÉ'?'selected':'' }}>LIVRÉ</option>
                <option value="ATTENTE INFO SUPP" {{ request('statut_patatoide')=='ATTENTE INFO SUPP'?'selected':'' }}>ATTENTE INFO SUPP</option>
                <option value="DEPOT KMZ" {{ request('statut_patatoide')=='DEPOT KMZ'?'selected':'' }}>DEPOT KMZ</option>
                <option value="TRAITÉ" {{ request('statut_patatoide')=='TRAITÉ'?'selected':'' }}>TRAITÉ</option>
                <option value="ANNULÉ" {{ request('statut_patatoide')=='ANNULÉ'?'selected':'' }}>ANNULÉ</option>
                <option value="REPRISE" {{ request('statut_patatoide')=='REPRISE'?'selected':'' }}>REPRISE</option>
            </select>
        </div>

        <!-- Validation Covage -->
        <div class="flex flex-col">
           
            <select name="validation_covage"
                    class="border-2 border-[#F7881B]/30 rounded-xl p-3 w-full shadow-sm focus:ring-2 focus:ring-[#F7881B] focus:border-transparent transition-all duration-200">
                <option value="">Tous les états</option>
                <option value="Oui" {{ request('validation_covage')=='Oui'?'selected':'' }}>Oui</option>
                <option value="Non" {{ request('validation_covage')=='Non'?'selected':'' }}>Non</option>
                <option value="En cours" {{ request('validation_covage')=='En cours'?'selected':'' }}>En cours</option>
            </select>
        </div>

    </div>

</div>

           
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Référence Projet -->
                        <div class="flex flex-col">
                            <label class="text-sm font-medium text-gray-700 mb-2">Référence Projet</label>
                            <input type="text" name="ref_projet" value="{{ request('ref_projet') }}"
                                placeholder="Rechercher par référence..." 
                                class="border border-gray-300 p-2.5 rounded-lg w-full focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                        </div>

                    </div>

                <!-- Boutons -->
                <div class="flex flex-wrap gap-3 justify-start pt-4">
                    <button type="submit" 
                            class="bg-[#45C4EB] hover:bg-[#F7881B] text-white font-semibold px-6 py-2 rounded-lg shadow-md transition duration-300 flex items-center gap-2">
                        
                        <span>Filtrer</span>
                    </button>

                    <a href="{{ route('patatoides.index') }}" 
                       class="bg-white text-gray-700 px-6 py-3 rounded-xl hover:bg-gray-50 focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-all duration-200 font-medium flex items-center space-x-2 border-2 border-gray-200 shadow-sm hover:shadow-md">
                        <i class="fas fa-redo"></i>
                        <span>Réinitialiser</span>
                    </a>
                      <a href="{{ route('patatoides.export', request()->query()) }}" 
   class="bg-[#F7881B] hover:bg-[#45C4EB] text-white font-semibold px-6 py-3 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 flex items-center space-x-2">
    <i class="fas fa-file-excel mr-2"></i>
    Exporter Excel
</a>
                </div>
            </form>
        </div>

        <!-- Message succès -->
        @if(session('success'))
            <div class="bg-gradient-to-r from-green-500 to-emerald-500 text-white p-4 mb-6 rounded-2xl shadow-lg flex items-center space-x-3">
                <i class="fas fa-check-circle text-xl"></i>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Tableau -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-[#45C4EB] text-white">
                        <tr>
                            <th class="px-4 py-4 text-left text-sm font-semibold uppercase tracking-wider">
                                Type
                            </th>
                            <th class="px-4 py-4 text-left text-sm font-semibold uppercase tracking-wider">
                                Référence
                            </th>
                            <th class="px-4 py-4 text-left text-sm font-semibold uppercase tracking-wider">
                                Site
                            </th>
                            <th class="px-4 py-4 text-left text-sm font-semibold uppercase tracking-wider">
                               Date Réception
                            </th>                   
                            <th class="px-4 py-4 text-left text-sm font-semibold uppercase tracking-wider">
                                Statut
                            </th>
                            <th class="px-4 py-4 text-left text-sm font-semibold uppercase tracking-wider">
                                Date Livraison
                            </th>
                            <th class="px-4 py-4 text-left text-sm font-semibold uppercase tracking-wider">
                               Validation
                            </th>                 
                            <th class="px-4 py-4 text-left text-sm font-semibold uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @forelse($patatoides as $patatoide)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-4 py-4 text-sm font-medium text-gray-900">
                                {{ $patatoide->type_projet }}
                            </td>
                            <td class="px-4 py-4 text-sm  ">
                                {{ $patatoide->ref_projet }}
                            </td>
                            <td class="px-4 py-4 text-sm text-gray-700">
                                {{ Str::limit($patatoide->site, 30) }}
                            </td>
                            <td class="px-4 py-4 text-sm text-gray-700">
                                {{ optional($patatoide->date_reception)->format('d/m/Y') }}
                            </td>
                            <td class="px-4 py-4">
                                @php
                                    $statusColors = [
                                        'LIVRÉ' => 'bg-green-100 text-green-800',
                                        'EN COURS' => 'bg-blue-100 text-blue-800',
                                        'ATTENTE INFO SUPP' => 'bg-yellow-100 text-yellow-800',
                                        'DEPOT KMZ' => 'bg-purple-100 text-purple-800',
                                        'TRAITE' => 'bg-indigo-100 text-indigo-800',
                                        'ANNULE' => 'bg-red-100 text-red-800',
                                        'REPRISE' => 'bg-orange-100 text-orange-800',
                                    ];
                                    $statusColor = $statusColors[$patatoide->statut_patatoide] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $statusColor }}">
                                    <i class="fas fa-circle text-xs mr-1 animate-pulse"></i>
                                    {{ $patatoide->statut_patatoide }}
                                </span>
                            </td>
                            <td class="px-4 py-4 text-sm text-gray-700">
                                {{ optional($patatoide->date_liv_patatoide)->format('d/m/Y') }}
                            </td>
                            <td class="px-4 py-4">
                                
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        {{ $patatoide->validation_covage }}
                                    </span>
                               
                            </td>
                            
                            <td class="px-4 py-4">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('patatoides.show', $patatoide) }}" 
                                       class="inline-flex items-center bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded-lg text-xs font-medium transition-all duration-200 transform hover:scale-105 shadow-sm">
                                        <i class="fas fa-eye mr-1"></i>
                                        
                                    </a>
                                    <a href="{{ route('patatoides.edit', $patatoide) }}" 
                                       class="inline-flex items-center bg-[#45C4EB] hover:bg-blue-500 text-white px-3 py-2 rounded-lg text-xs font-medium transition-all duration-200 transform hover:scale-105 shadow-sm">
                                        <i class="fas fa-edit mr-1"></i>
                                        
                                    </a>
                                    <button type="button" 
                                            class="btn-delete inline-flex items-center bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-lg text-xs font-medium transition-all duration-200 transform hover:scale-105 shadow-sm"
                                            data-id="{{ $patatoide->id }}">
                                        <i class="fas fa-trash mr-1"></i>
                                        
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-4 py-8 text-center text-gray-500">
                                <div class="flex flex-col items-center space-y-3">
                                    <i class="fas fa-inbox text-4xl text-gray-300"></i>
                                    <p class="text-lg font-medium text-gray-500">Aucun Patatoïde trouvé</p>
                                    <p class="text-sm text-gray-400">Essayez de modifier vos critères de recherche</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($patatoides->hasPages())
            <div class="border-t border-gray-200 px-6 py-4 bg-gray-50">
                {{ $patatoides->links('vendor.pagination.tailwind') }}
            </div>
            @endif
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const deleteButtons = document.querySelectorAll('.btn-delete');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            const projetId = this.getAttribute('data-id');
            Swal.fire({
                title: 'Êtes-vous sûr ?',
                text: "Cette action est irréversible.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Oui, supprimer',
                cancelButtonText: 'Annuler',
                background: '#fff',
                backdrop: 'rgba(0,0,0,0.4)'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/patatoides/${projetId}`;
                    form.innerHTML = `
                        @csrf
                        @method('DELETE')
                    `;
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });
    });
});
</script>
@endsection