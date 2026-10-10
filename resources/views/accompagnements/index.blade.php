@extends('layouts.main')

@section('content')
<div class="container mx-auto p-4">
    <h2 class="text-4xl font-extrabold text-center text-gray-800 mb-6 relative">
        <span class="bg-[#45C4EB]  text-transparent bg-clip-text ">
            Récap Demandes d'Accompagnement
        </span>
        <span class="block w-16 h-1 bg-[#F7881B] mx-auto mt-2 rounded-full"></span>
    </h2>
    <form method="GET" action="{{ route('accompagnements.index') }}" >
        <div class="mb-6 flex gap-4 items-center">
            <input type="text" name="search" placeholder=" Rechercher par référence ou site..." 
                   class="px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200 w-1/4" 
                   value="{{ request('search') }}">
            <button type="submit" class="bg-[#45C4EB] hover:bg-[#F7881B] text-white font-semibold px-4 py-2 rounded-lg shadow-md transition duration-300 transform hover:scale-105">
                Rechercher
            </button>
        </div>
    </form>
    
    
    
    <div class="mt-6 mb-10">
       <table class="min-w-full bg-white rounded-lg overflow-hidden">
    <thead class="bg-[#45C4EB] text-white">
        <tr class="uppercase">
            <th class="py-1 px-2 border-b text-left">Référence</th>
            <th class="py-1 px-2 border-b text-left">Type projet</th>
            <th class="py-1 px-2 border-b text-left">Date dépot</th>
            <th class="py-1 px-2 border-b text-left">Numéro ticket</th>
           
        </tr>
    </thead>
    <tbody>
        @foreach ($projets as $projet)
            @php
                $hasAccTask = false;
                $type_projet_acc = 'N/A';
                $date_depot = 'N/A';
                $num_ticket = 'N/A';
                $acc_com = 'N/A';
                
                // Recherche de la tâche d'accompagnement
                foreach ($projet->taches as $tache) {
                    if (isset($tache->typeTache) && $tache->typeTache->nom === 'Accompagnement') {
                        $hasAccTask = true;
                        $type_projet_acc = $tache->informations['type_projet_acc'] ?? 'N/A';
                        $date_depot = $tache->informations['date_depot'] ?? 'N/A';
                        $num_ticket = $tache->informations['num_ticket'] ?? 'N/A';
                        $acc_com = $tache->informations['acc_com'] ?? 'N/A';
                        break;
                    }
                }
            @endphp

            @if ($hasAccTask)
                <tr>
                    <td class="py-1 px-2 border-b-1 border-[#F7881B] border-dashed">{{ $projet->reference }}</td>
                    <td class="py-1 px-2 border-b-1 border-[#F7881B] border-dashed">{{ $type_projet_acc }}</td>
                    <td class="py-1 px-2 border-b-1 border-[#F7881B] border-dashed">{{ $date_depot }}</td>
                    <td class="py-1 px-2 border-b-1 border-[#F7881B] border-dashed">{{ $num_ticket }}</td>
                    
                </tr>
            @endif
        @endforeach
    </tbody>
</table>
<div class="mt-6 flex justify-center mb-10">
            {{ $projets->links('vendor.pagination.tailwind') }}
        </div>

   
    </div>
</div>
@endsection
