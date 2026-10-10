@extends('layouts.main')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Bouton retour -->
    <div class="mb-6">
        <a href="{{ route('nexloop.fci.index') }}" 
           class="inline-flex items-center text-[#45C4EB] hover:text-[#F7881B] font-medium">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Retour à la liste
        </a>
    </div>

    <!-- Carte principale du FCI -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6 mb-6">
        <div class="flex justify-between items-start mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 mb-2">Détails du FCI</h1>
                <p class="text-gray-600">Informations détaillées du FCI et ses études associées</p>
            </div>
            
        </div>

        <!-- Informations du FCI -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <!-- Site -->
            <div class="bg-gray-50 rounded-xl p-4">
                <h3 class="text-sm font-medium text-gray-500 mb-1">Site</h3>
                <p class="text-lg font-semibold text-gray-800">{{ $fci->site }}</p>
            </div>
            
            <!-- Type -->
            <div class="bg-gray-50 rounded-xl p-4">
                <h3 class="text-sm font-medium text-gray-500 mb-1">Type</h3>
                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full 
                    {{ $fci->type === 'Simple' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                    {{ $fci->type }}
                </span>
            </div>
            
            <!-- Code ENSEI (FCI) -->
            <div class="bg-gray-50 rounded-xl p-4">
                <h3 class="text-sm font-medium text-gray-500 mb-1">Code ENSEI (FCI)</h3>
                <p class="text-lg font-semibold text-gray-800">{{ $fci->code_ensei ?? 'Non spécifié' }}</p>
            </div>
            
            <!-- Numéro FCI -->
            <div class="bg-gray-50 rounded-xl p-4">
                <h3 class="text-sm font-medium text-gray-500 mb-1">Numéro FCI</h3>
                <p class="text-lg font-semibold text-gray-800">{{ $fci->numero_fci }}</p>
            </div>
            
            <!-- Date de création -->
            <div class="bg-gray-50 rounded-xl p-4">
                <h3 class="text-sm font-medium text-gray-500 mb-1">Date de création</h3>
                <p class="text-lg font-semibold text-gray-800">{{ $fci->created_at->format('d/m/Y H:i') }}</p>
            </div>
            
            <!-- Nombre d'études -->
            <div class="bg-gray-50 rounded-xl p-4">
                <h3 class="text-sm font-medium text-gray-500 mb-1">Études associées</h3>
                <p class="text-lg font-semibold text-gray-800">{{ $fci->etudes->count() }}</p>
            </div>
        </div>

        <!-- Section des études associées -->
        <div class="mt-8">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Études associées</h2>
            
            @if($fci->etudes->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-[#45C4EB] text-white">
                            <tr>
                                <th class="px-4 py-3 text-left text-sm font-semibold uppercase tracking-wider">
                                    Code ENSEI
                                </th>
                                <th class="px-4 py-3 text-left text-sm font-semibold uppercase tracking-wider">
                                    Numéro d'étude
                                </th>
                                <th class="px-4 py-3 text-left text-sm font-semibold uppercase tracking-wider">
                                    Commune
                                </th>
                                <th class="px-4 py-3 text-left text-sm font-semibold uppercase tracking-wider">
                                    Code postal
                                </th>
                                <th class="px-4 py-3 text-left text-sm font-semibold uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @foreach($fci->etudes as $etude)
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <td class="px-4 py-3 text-sm font-medium text-gray-900">
                                        {{ $etude->code_ensei }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-700">
                                        {{ $etude->numero_etude }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-700">
                                        {{ $etude->commune }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-700">
                                        {{ $etude->code_postal }}
                                    </td>
                                    <td class="px-4 py-3 text-sm font-medium">
                                        <a href="#" 
                                           class="text-[#45C4EB] hover:text-[#F7881B] font-medium">
                                            Voir l'étude
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-yellow-400 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.998-.833-2.732 0L4.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                    </svg>
                    <h3 class="text-lg font-medium text-yellow-800 mb-1">Aucune étude associée</h3>
                    <p class="text-yellow-600">Ce FCI n'a pas encore d'études associées.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection