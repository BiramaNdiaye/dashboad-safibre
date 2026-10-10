@extends('layouts.main')

@section('content')

    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6 mb-8">
            <div class="flex-1">
                <div class="flex items-center space-x-3 mb-2">
                    <div class="p-2 bg-gradient-to-r from-[#45C4EB] to-blue-500 rounded-xl shadow-lg">
                        <i class="fas fa-project-diagram text-white text-lg"></i>
                    </div>
                    <h1 class="text-2xl md:text-3xl font-bold text-[#45C4EB] ">
                        Liste des Etudes de Faisabilité
                    </h1>
                </div>
               
            </div>
            
            <a href="{{ route('nexloop.etudes.create') }}" 
               class="group inline-flex items-center space-x-2 bg-[#45C4EB] text-white hover:bg-[#F7881B]  font-semibold px-6 py-3 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                <i class="fas fa-plus-circle group-hover:rotate-90 transition-transform duration-300"></i>
                <span>Nouveau Etude</span>
            </a>
        </div>
 @if(session('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-400 p-4 rounded">
            <!-- Même structure que ci-dessus -->
            <div class="flex">
                <!-- ... -->
                <p class="text-sm font-medium text-green-800">
                    {{ session('success') }}
                </p>
                <!-- ... -->
            </div>
        </div>
    @endif

     <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6 mb-6">
        <form method="GET" action="{{ route('nexloop.etudes.index') }}" class="space-y-4">
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 mb-2">
                    Rechercher une étude
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input type="text" 
                           name="search" 
                           id="search" 
                           value="{{ $search ?? '' }}"
                           placeholder="Rechercher par code ENSEI, commune, numéro d'étude ou code postal..."
                           class="block w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] focus:border-[#45C4EB] transition duration-200">
                </div>
                <p class="mt-2 text-sm text-gray-500">
                    Vous pouvez rechercher par : Code ENSEI, Commune, Numéro d'étude ou Code postal
                </p>
            </div>
            
            <div class="flex justify-end space-x-3 pt-2">
                <!-- Bouton Réinitialiser -->
                <a href="{{ route('nexloop.etudes.index') }}" 
                   class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg font-medium transition duration-200">
                    Réinitialiser
                </a>
                
                <!-- Bouton Rechercher -->
                <button type="submit"
                        class="bg-[#45C4EB] hover:bg-[#F7881B] text-white px-6 py-2 rounded-lg font-medium transition duration-200 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Rechercher
                </button>
            </div>
        </form>
    </div>

    <!-- Statistiques 
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow p-4">
            <h3 class="text-lg font-semibold text-gray-800">Total études</h3>
            <p class="text-3xl font-bold text-[#45C4EB]">{{ $etudesfais->total() }}</p>
        </div>
        <div class="bg-white rounded-xl shadow p-4">
            <h3 class="text-lg font-semibold text-gray-800">Résultats</h3>
            <p class="text-3xl font-bold text-green-600">
                {{ $etudesfais->count() }}
            </p>
        </div>
        <div class="bg-white rounded-xl shadow p-4">
            <h3 class="text-lg font-semibold text-gray-800">Communes uniques</h3>
            <p class="text-3xl font-bold text-purple-600">
                {{ \App\Models\EtudeFaisa::distinct('commune')->count() }}
            </p>
        </div>
        <div class="bg-white rounded-xl shadow p-4">
            <h3 class="text-lg font-semibold text-gray-800">Codes ENSEI uniques</h3>
            <p class="text-3xl font-bold text-blue-600">
                {{ \App\Models\EtudeFaisa::distinct('code_ensei')->count() }}
            </p>
        </div>
    </div>-->
<div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-[#45C4EB] text-white">
                <tr>
                    <th class="px-4 py-4 text-left text-sm font-semibold uppercase tracking-wider">
                        Commune
                    </th>
                    <th class="px-4 py-4 text-left text-sm font-semibold uppercase tracking-wider">
                        Code postal
                    </th>
                    <th class="px-4 py-4 text-left text-sm font-semibold uppercase tracking-wider">
                        Code ENSEI
                    </th>
                    <th class="px-4 py-4 text-left text-sm font-semibold uppercase tracking-wider">
                        Numéro d’étude
                    </th>
                    <th class="px-4 py-4 text-left text-sm font-semibold uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200 bg-white">
                @forelse($etudesfais as $etude)
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="px-4 py-4 text-sm font-medium text-gray-900">
                            {{ $etude->commune }}
                        </td>
                        <td class="px-4 py-4 text-sm text-gray-700">
                            {{ $etude->code_postal }}
                        </td>
                        <td class="px-4 py-4 text-sm text-gray-700">
                            {{ $etude->code_ensei }}
                        </td>
                        <td class="px-4 py-4 text-sm text-gray-700">
                            {{ $etude->numero_etude ?? '-' }}
                        </td>
                        <td class="px-4 py-4 text-sm font-medium">
                            <div class="flex space-x-2">
                                <!-- Bouton Voir le FCI 
                                <a href="{{ route('nexloop.fci.show', $etude->id) }}" 
                                   class="bg-[#45C4EB] hover:bg-[#F7881B] text-white px-3 py-1 rounded-lg text-sm font-medium transition duration-200 flex items-center"
                                   title="Voir les détails">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Détails
                                </a>-->
                                <a href="{{ route('nexloop.etudes.edit', $etude->id) }}" 
                                class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-lg text-sm font-medium transition duration-200 flex items-center">
                                    Modifier
                                </a>
                                <form action="{{ route('nexloop.etudes.destroy', $etude->id) }}" method="POST" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit" 
                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg text-sm font-medium transition duration-200 flex items-center"
                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce FCI ?')">
                Supprimer
            </button>
        </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-6 text-center text-gray-500">
                            Aucune étude trouvée
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection