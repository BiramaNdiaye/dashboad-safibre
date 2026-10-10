@extends('layouts.main')

@section('content')
<div class="container mx-auto p-6">
    <div class="flex items-center justify-between mb-6">
    <h1 class="text-4xl font-bold text-[#45C4EB]">Liste des études</h1>

    <a href="{{ route('etudes.create') }}" 
       class="flex items-center gap-2 bg-[#45C4EB] hover:bg-[#F7881B] text-white font-medium px-4 py-2 rounded-lg shadow-sm transition duration-300 transform hover:scale-105">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        Ajouter une étude
    </a>
</div>
<form method="GET" action="{{ route('etudes.index') }}" class="mb-4">
    <input type="text" name="search" placeholder="Rechercher code ENSEE ou numéro étude..."
       value="{{ request('search') }}"
       class="w-96 px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm 
              focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200">


    <button class="px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200">
        Rechercher
    </button>
</form>

    @if(session('success'))
        <div class="bg-green-100 border border-green-300 text-green-800 text-sm px-4 py-2 rounded-lg mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <table class="min-w-full text-sm">
            <thead class="bg-[#45C4EB] text-white text-xs uppercase tracking-wider">
                <tr>
                    
                    <th class="py-2 px-3 text-left font-semibold">Code Ensee</th>
                    <th class="py-2 px-3 text-left font-semibold">Commune</th>
                    <th class="py-2 px-3 text-left font-semibold">Client</th>
                    <th class="py-2 px-3 text-left font-semibold">Numéro Étude</th>
                    <th class="py-2 px-3 text-left font-semibold">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($etudes as $etude)
                    <tr class="hover:bg-gray-50 transition">
                        
                        <td class="py-2 px-3 text-gray-700">{{ $etude->code_ensee }}</td>
                        <td class="py-2 px-3 text-gray-700">{{ $etude->commune }}</td>
                        <td class="py-2 px-3 text-gray-700">{{ $etude->client->nom }}</td>
                        <td class="py-2 px-3 text-gray-700">{{ $etude->numero_etude }}</td>
                        <td class="py-2 px-3">
                            <a href="{{ route('etudes.edit', $etude->id) }}" 
                               class="bg-[#45C4EB] hover:bg-[#F7881B] text-white font-medium text-xs px-3 py-1 rounded-lg shadow-sm transition duration-200">
                                Éditer
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
         <div class="mt-6 flex justify-center mb-10">
            {{ $etudes->links('vendor.pagination.tailwind') }}
        </div>
    </div>
</div>
@endsection
