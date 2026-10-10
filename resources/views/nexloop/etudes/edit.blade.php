@extends('layouts.main')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- En-tête -->
    <div class="mb-8">
      <h2 class="text-3xl font-extrabold text-center text-gray-800 mb-6 relative">
    <span class="bg-[#45C4EB]  text-transparent bg-clip-text uppercase">
        Modifier une Etude de faisabilité
    </span>
    <span class="block w-16 h-1 bg-[#F7881B] mx-auto mt-2 rounded-full"></span>
</h2>
    </div>

    <!-- Carte du formulaire -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6">
        <form action="{{ route('nexloop.etudes.update', $etude->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <!-- Grille 2 colonnes -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Commune -->
                <div>
                    <label for="commune" class="block text-sm font-medium text-gray-700 mb-1">
                        Commune *
                    </label>
                    <input type="text" 
                           name="commune" 
                           id="commune" 
                           value="{{ old('commune', $etude->commune) }}"
                           required
                           class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] focus:border-[#45C4EB] transition duration-200">
                    @error('commune')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Code postal -->
                <div>
                    <label for="code_postal" class="block text-sm font-medium text-gray-700 mb-1">
                        Code postal *
                    </label>
                    <input type="number" 
                           name="code_postal" 
                           id="code_postal" 
                           value="{{ old('code_postal', $etude->code_postal) }}"
                           required
                           min="0"
                           class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] focus:border-[#45C4EB] transition duration-200">
                    @error('code_postal')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Code ENSEI -->
                <div>
                    <label for="code_ensei" class="block text-sm font-medium text-gray-700 mb-1">
                        Code ENSEI *
                    </label>
                    <input type="number" 
                           name="code_ensei" 
                           id="code_ensei" 
                           value="{{ old('code_ensei', $etude->code_ensei) }}"
                           required
                           min="0"
                           class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] focus:border-[#45C4EB] transition duration-200">
                    @error('code_ensei')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Numéro d'étude -->
                <div>
                    <label for="numero_etude" class="block text-sm font-medium text-gray-700 mb-1">
                        Numéro d'étude *
                    </label>
                    <input type="text" 
                           name="numero_etude" 
                           id="numero_etude" 
                           value="{{ old('numero_etude', $etude->numero_etude) }}"
                           required
                           class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] focus:border-[#45C4EB] transition duration-200">
                    @error('numero_etude')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <!-- Boutons d'action -->
            <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200 mt-6">
                <a href="{{ route('nexloop.etudes.index') }}" 
                   class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-2 rounded-lg font-medium transition duration-200">
                    Annuler
                </a>
                
                <button type="submit"
                        class="bg-[#45C4EB] hover:bg-[#F7881B] text-white px-6 py-2 rounded-lg font-medium transition duration-200">
                    Mettre à jour
                </button>
            </div>
        </form>
    </div>
</div>
@endsection