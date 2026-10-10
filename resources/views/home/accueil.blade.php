@extends('layouts.main')

@section('content')
<div class="p-6 bg-gradient-to-br from-gray-50 to-blue-50 min-h-screen">
    <!-- En-tête avec animation -->
    <div class="mb-8 animate-fade-in">
        <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">Tableau de bord ROP</h1>
        <div class="w-20 h-1 bg-gradient-to-r from-blue-400 to-cyan-300 rounded-full"></div>
    </div>

    <!-- Grille de statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Carte Total Projets -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-1 border-l-4 border-blue-500">
            <div class="p-5">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-500 font-medium">Total Projets</p>
                        <h3 class="text-3xl font-bold text-gray-800 mt-2">{{ $stats['total'] }}</h3>
                    </div>
                    <div class="bg-blue-100 p-3 rounded-full">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="text-green-500 text-sm font-semibold">+5.2% vs mois dernier</span>
                </div>
            </div>
        </div>

        <!-- Carte En Attente Info -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-1 border-l-4 border-amber-500">
            <div class="p-5">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-500 font-medium">En Attente Info</p>
                        <h3 class="text-3xl font-bold text-gray-800 mt-2">{{ $stats['attente_info_sup'] }}</h3>
                    </div>
                    <div class="bg-amber-100 p-3 rounded-full">
                        <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="text-red-500 text-sm font-semibold animate-pulse">Nécessite action</span>
                </div>
            </div>
        </div>

        <!-- Carte En Cours -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-1 border-l-4 border-indigo-500">
            <div class="p-5">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-500 font-medium">En Cours</p>
                        <h3 class="text-3xl font-bold text-gray-800 mt-2">{{ $stats['Attente Validation Syno'] }}</h3>
                    </div>
                    <div class="bg-indigo-100 p-3 rounded-full">
                        <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="text-blue-500 text-sm font-semibold">En traitement</span>
                </div>
            </div>
        </div>

        <!-- Carte ROP Livrés -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-1 border-l-4 border-green-500">
            <div class="p-5">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-500 font-medium">ROP Livrés</p>
                        <h3 class="text-3xl font-bold text-gray-800 mt-2">{{ $stats['Livré'] }}</h3>
                    </div>
                    <div class="bg-green-100 p-3 rounded-full">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="text-green-500 text-sm font-semibold">+12% ce mois</span>
                </div>
            </div>
        </div>
    </div>

   
</div>

<!-- Animation CSS -->
<style>
    .animate-fade-in {
        animation: fadeIn 0.8s ease-out;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection
