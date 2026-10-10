@extends('layouts.main')

@section('content')
<div class="max-w-2xl mx-auto bg-white shadow-lg rounded-2xl p-6 mt-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-700 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-[#45C4EB]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Ajouter une nouvelle étude
        </h1>
        <a href="{{ route('etudes.index') }}" class="text-sm text-gray-500 hover:text-[#F7881B] transition">
            ← Retour à la liste
        </a>
    </div>

    {{-- Message de succès --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-800 border border-green-300 p-3 rounded-lg mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- Messages d’erreurs --}}
    @if($errors->any())
        <div class="bg-red-100 text-red-800 border border-red-300 p-3 rounded-lg mb-4">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Formulaire --}}
    <form action="{{ route('etudes.store') }}" method="POST" class="space-y-5">
        @csrf

        <div>
            <label for="code_ensee" class="block font-semibold text-gray-700 mb-1">Code Ensee</label>
            <input type="text" name="code_ensee" id="code_ensee"
                value="{{ old('code_ensee') }}"
                class="border border-gray-300 rounded-lg p-2 w-full focus:outline-none focus:ring-2 focus:ring-[#45C4EB]">
        </div>

        <div>
            <label for="commune" class="block font-semibold text-gray-700 mb-1">Commune</label>
            <input type="text" name="commune" id="commune"
                value="{{ old('commune') }}"
                class="border border-gray-300 rounded-lg p-2 w-full focus:outline-none focus:ring-2 focus:ring-[#45C4EB]">
        </div>

        <div>
            <label for="clients_id" class="block font-semibold text-gray-700 mb-1">Client</label>
            <select name="clients_id" id="clients_id"
                class="border border-gray-300 rounded-lg p-2 w-full bg-white focus:outline-none focus:ring-2 focus:ring-[#45C4EB]">
                <option value="">-- Sélectionner un client --</option>
                @foreach($clients as $client)
                    <option value="{{ $client->id }}" {{ old('clients_id') == $client->id ? 'selected' : '' }}>
                        {{ $client->nom }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="numero_etude" class="block font-semibold text-gray-700 mb-1">Numéro d'étude</label>
            <input type="text" name="numero_etude" id="numero_etude"
                value="{{ old('numero_etude') }}"
                class="border border-gray-300 rounded-lg p-2 w-full focus:outline-none focus:ring-2 focus:ring-[#45C4EB]">
        </div>

        <div class="flex justify-end pt-3">
            <button type="submit"
                class="bg-[#45C4EB] hover:bg-[#F7881B] text-white font-semibold px-5 py-2 rounded-lg transition transform hover:scale-105 shadow-md">
                Enregistrer
            </button>
        </div>
    </form>
</div>
@endsection
