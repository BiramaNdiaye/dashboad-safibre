@extends('layouts.main')

@section('content')
<div class="container mx-auto px-4 py-8">

    @if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-transition 
         class="flex items-center justify-between bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded-lg shadow-md mb-6">
        <!-- Icône -->
        <div class="flex items-center space-x-2">
            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m0 5.8V19a2 2 0 01-2 2H7a2 2 0 01-2-2V7a2 2 0 012-2h4"></path>
            </svg>
            <span class="text-sm font-medium">{{ session('success') }}</span>
        </div>

        <!-- Bouton de fermeture -->
        <button @click="show = false" class="text-green-700 hover:text-green-900 focus:outline-none">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>
@endif
    <div class="flex justify-between items-center mb-8">
        <!-- Titre du projet -->
        <h2 class="text-4xl font-extrabold text-center text-gray-800 mb-6 relative w-full">
            <span class="bg-[#45C4EB]  text-transparent bg-clip-text ">
                Details des taches
            </span>
            <span class="block w-16 h-1 bg-[#F7881B] mx-auto mt-2 rounded-full"></span>
        </h2>
    
        <!-- Conteneur des boutons -->
        <div class="flex space-x-6 justify-center w-full p-4">
    <!-- Icône Retour -->
   @php
    $routeProjet = url()->previous();
@endphp
    
    <a href="{{ $routeProjet }}" 
       class="p-3 bg-[#45C4EB] hover:bg-[#F7881B] text-white rounded-full shadow-md transition-all duration-300 hover:scale-110 group"
       title="Retour aux projets">
        <svg class="w-6 h-6 group-hover:animate-bounce-left" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
    </a>

    <!-- Icône Ajouter -->
    @if(auth()->user()->id === $projet->chefProjet->id || auth()->user()->hasRole('admin'))
        <a href="{{ route('taches.create', ['projet' => $projet->id]) }}" 
           class="p-3 bg-[#45C4EB] hover:bg-[#F7881B] text-white rounded-full shadow-md transition-all duration-300 hover:scale-110 group"
           title="Ajouter une tâche">
            <svg class="w-6 h-6 group-hover:animate-pulse" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
        </a>
    @else
        <span class="p-3 bg-[#45C4EB] text-white rounded-full shadow-md opacity-50 cursor-not-allowed"
              title="Ajouter une tâche (non autorisé)">
            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
        </span>
    @endif
</div>
    </div>
    
    <hr class="border-b-2 border-[#F7881B] border-dashed mb-10">
    <div class="flex justify-between items-center mb-8">
    <h1 class="text-sm font-bold text-gray-800 uppercase">
        Référence projet :
        <span class="text-[#F78718] uppercase">{{ $projet->reference }}</span>
    </h1>

    <h1 class="text-sm font-bold text-gray-800 uppercase">
        Client :
        <span class="text-[#F78718] uppercase">{{ $projet->client?->nom }}</span>
    </h1>

    <h1 class="text-sm font-bold text-gray-800 uppercase">
        Chef de projet :
        <span class="text-[#F78718] uppercase">{{ $projet->chefProjet->name }}</span>
    </h1>
</div>

    @if($taches->isEmpty())
        <div class="bg-white p-6 rounded-lg shadow-md text-center">
            <p class="text-gray-600">Aucune tâche associée à ce projet.</p>
        </div>
    @else
        <div class="space-y-6">
            @foreach($taches as $tache)
                <div class="bg-white rounded-lg shadow-xl overflow-hidden transform ">
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-xl font-semibold text-[#F78718]">{{ $tache->typeTache->nom ?? 'Inconnu' }}</h2>
                            <span class="text-sm text-gray-500">{{ $tache->created_at->format('d M Y') }}</span>
                        </div>

                        <!-- Tableau des informations -->
                        <div class="mt-4">
                            
                            @if(is_array($tache->informations))
                            <table class="min-w-full bg-gray-50 rounded-lg overflow-hidden">
                                <tbody>
                                    @switch($tache->typeTache->nom)
                                        @case('ROP')
                                            <thead class="bg-blue-50">
                                                <tr>
                                                    <th class="py-3 px-4 text-left text-[#45C4EB] text-xs">Type ROP</th>
                                                    <th class="py-3 px-4 text-left text-[#45C4EB] text-xs">VERSION ROP</th>
                                                    <th class="py-3 px-4 text-left text-[#45C4EB] text-xs">Nombre de BPE</th>
                                                    <th class="py-3 px-4 text-left text-[#45C4EB] text-xs">Liste de BPE</th>
                                                    <th class="py-3 px-4 text-left text-[#45C4EB] text-xs">Statut ROP</th>
                                                    <th class="py-3 px-4 text-left text-[#45C4EB] text-xs">Statut ROP Netgeo</th>
                                                    <th class="py-3 px-4 text-left text-[#45C4EB] text-xs">Date de livraison</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="hover:bg-gray-100 transition">
                                                    <td class="py-3 px-4 border-b">{{ $tache->informations['type_rop'] ?? 'Simple' }}</td>
                                                    <td class="py-3 px-4 border-b">{{ $tache->informations['version_rop'] ?? 'V1' }}</td>
                                                    <td class="py-3 px-4 border-b">{{ $tache->informations['nbre_bpe'] ?? '0' }}</td>
                                                    <td class="py-3 px-4 border-b">{{ $tache->informations['liste_bpe'] ?? '' }}</td>
                                                    <td class="py-3 px-4 border-b">{{ $tache->informations['statut_rop'] ?? 'En cours' }}</td>
                                                    <td class="py-3 px-4 border-b">{{ $tache->informations['statut_rop_netgeo'] ?? '' }}</td>
                                                    <td class="py-3 px-4 border-b">{{ $tache->informations['date_livraison_rop'] ?? '' }}</td>
                                                   
                                                </tr>
                                            </tbody>
                                            @break
                        
                                        @case('BLO')
                                            <thead class="bg-blue-50">
                                                <tr>
                                                    <th class="py-3 px-4 text-left text-[#45C4EB]">Type BLO</th>
                                                    <th class="py-3 px-4 text-left text-[#45C4EB]">Numéro FCI</th>
                                                    <th class="py-3 px-4 text-left text-[#45C4EB]">Date de livraison</th>
                                                    <th class="py-3 px-4 text-left text-[#45C4EB]">Statut BLO</th>
                                                    <th class="py-3 px-4 text-left text-[#45C4EB]">Version ROP</th>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="hover:bg-gray-100 transition">
                                                    <td class="py-3 px-4 border-b">{{ $tache->informations['type_blo'] ?? 'Non spécifié' }}</td>
                                                    <td class="py-3 px-4 border-b">{{ $tache->informations['num_fci'] ?? 'Non spécifié' }}</td>
                                                    <td class="py-3 px-4 border-b">{{ $tache->informations['date_livraison_blo'] ?? 'Non spécifié' }}</td>
                                                    <td class="py-3 px-4 border-b">{{ $tache->informations['statut_blo'] ?? 'Non spécifié' }}</td>
                                                    <td class="py-3 px-4 border-b">{{ $tache->informations['version_rop'] ?? 'Non spécifié' }}</td>
                                                   
                                                </tr>
                                            </tbody>
                                            @break
                        
                                        @case('DOE OPTIQUE')
                                        <thead class="bg-blue-50">
                                            <tr>
                                                <th class="py-3 px-4 text-left text-[#45C4EB]">Date demande DOE</th>
                                                <th class="py-3 px-4 text-left text-[#45C4EB]">Support Hotline</th>
                                                <th class="py-3 px-4 text-left text-[#45C4EB]">Date d'intégration DOE</th>
                                                <th class="py-3 px-4 text-left text-[#45C4EB]">Statut DOE</th>
                                                <th class="py-3 px-4 text-left text-[#45C4EB]">Rectification </th>
                                                <th class="py-3 px-4 text-left text-[#45C4EB]">Nbre BPE </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="hover:bg-gray-100 transition">
                                                <td class="py-3 px-4 border-b">{{ $tache->informations['date_demande_doe'] ?? 'Non spécifié' }}</td>
                                                <td class="py-3 px-4 border-b">{{ $tache->informations['support'] ?? 'Non spécifié' }}</td>
                                                <td class="py-3 px-4 border-b">{{ $tache->informations['date_integration'] ?? 'Non spécifié' }}</td>
                                                <td class="py-3 px-4 border-b">{{ $tache->informations['statut_doe'] ?? 'Non spécifié' }}</td>
                                                <td class="py-3 px-4 border-b">{{ $tache->informations['rectification'] ?? 'Non spécifié' }}</td>
                                                <td class="py-3 px-4 border-b">{{ $tache->informations['doe_bpe'] ?? 'Non spécifié' }}</td>
                                                
                                            </tr>
                                        </tbody>
                                            @break
                                            @case('Accompagnement')
                                            <thead class="bg-blue-50">
                                                <tr>
                                                    <th class="py-3 px-4 text-left text-[#45C4EB]">Type d'Accompagnement</th>
                                                    <th class="py-3 px-4 text-left text-[#45C4EB]">Date dépot</th>
                                                    <th class="py-3 px-4 text-left text-[#45C4EB]">Numéro ticket</th>
                                                    <th class="py-3 px-4 text-left text-[#45C4EB]">Commentaires</th>
                                                 
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="hover:bg-gray-100 transition">
                                                    <td class="py-3 px-4 border-b">{{ $tache->informations['type_projet_acc'] ?? 'Non spécifié' }}</td>
                                                    <td class="py-3 px-4 border-b">{{ $tache->informations['date_depot'] ?? 'Non spécifié' }}</td>
                                                    <td class="py-3 px-4 border-b">{{ $tache->informations['num_ticket'] ?? 'Non spécifié' }}</td>
                                                    <td class="py-3 px-4 border-b">{{ $tache->informations['acc_com'] ?? 'Non spécifié' }}</td>
                                    
                                                </tr>
                                            </tbody>
                                                @break


                                                @case('APD GC/DOE GC')
                                                <thead class="bg-blue-50">
                                                    <tr>
                                                        <th class="py-3 px-4 text-left text-[#45C4EB]">Type de projet</th>
                                                        <th class="py-3 px-4 text-left text-[#45C4EB]">Date de demande</th>
                                                        <th class="py-3 px-4 text-left text-[#45C4EB]">date de livraison</th>
                                                        <th class="py-3 px-4 text-left text-[#45C4EB]">lineaire projet</th>
                                                        <th class="py-3 px-4 text-left text-[#45C4EB]">adresse</th>
                                                        <th class="py-3 px-4 text-left text-[#45C4EB]">code postal</th>
                                                        <th class="py-3 px-4 text-left text-[#45C4EB]">ville</th>
                                                     
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="hover:bg-gray-100 transition">
                                                        <td class="py-3 px-4 border-b">{{ $tache->informations['type_prod'] ?? 'Non spécifié' }}</td>
                                                        <td class="py-3 px-4 border-b">{{ $tache->informations['date_demande_prod'] ?? 'Non spécifié' }}</td>
                                                        <td class="py-3 px-4 border-b">{{ $tache->informations['date_livraison_prod'] ?? 'Non spécifié' }}</td>
                                                        <td class="py-3 px-4 border-b">{{ $tache->informations['lineaire'] ?? 'Non spécifié' }}</td>
                                                        <td class="py-3 px-4 border-b">{{ $tache->informations['adresse'] ?? 'Non spécifié' }}</td>
                                                        <td class="py-3 px-4 border-b">{{ $tache->informations['code_postal'] ?? 'Non spécifié' }}</td>
                                                        <td class="py-3 px-4 border-b">{{ $tache->informations['ville'] ?? 'Non spécifié' }}</td>
                                        
                                                    </tr>
                                                </tbody>
                                                    @break
                                        @default
                                            <tr class="hover:bg-gray-100 transition">
                                                <td class="py-3 px-4" colspan="2">Aucune information disponible pour ce type de tâche.</td>
                                            </tr>
                                    @endswitch
                                </tbody>
                            </table>
                        @else
                            <p class="text-gray-600">Aucune information disponible pour le moment.</p>
                        @endif
                        </div>
                    </div>
                    
                    <!-- Bouton de modification -->
                    <div class="p-4 bg-[#07677A] text-right rounded-lg shadow-md">
                        <div class="inline-flex space-x-6 items-center">
                            {{-- Bouton Modifier --}}
                            @if(auth()->user()->id === $tache->projet->chefProjet->id || auth()->user()->hasRole('admin'))
                                <a href="{{ route('taches.edit', $tache->id) }}"
                                   class="p-2 bg-white/10 rounded-full hover:bg-white/20 transition-all duration-300 group"
                                   title="Modifier">
                                    <svg class="w-6 h-6 text-white group-hover:text-[#F78719]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/>
                                    </svg>
                                </a>
                            @else
                                <span class="p-2 bg-white/10 rounded-full opacity-50 cursor-not-allowed" title="Modifier (non autorisé)">
                                    <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/>
                                    </svg>
                                </span>
                            @endif
                    
                            {{-- Bouton Supprimer --}}
                            @if(auth()->user()->id === $tache->projet->chefProjet->id || auth()->user()->hasRole('admin'))
                                <form action="{{ route('taches.destroy', $tache->id) }}" method="POST" class="inline-block delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="p-2 bg-white/10 rounded-full hover:bg-white/20 transition-all duration-300 group"
                                            title="Supprimer">
                                        <svg class="w-6 h-6 text-white group-hover:text-red-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                                        </svg>
                                    </button>
                                </form>
                            @else
                                <span class="p-2 bg-white/10 rounded-full opacity-50 cursor-not-allowed" title="Supprimer (non autorisé)">
                                    <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                                    </svg>
                                </span>
                            @endrole
                        </div>
                    </div>
                    
                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            const deleteForms = document.querySelectorAll('.delete-form');
                            
                            deleteForms.forEach(form => {
                                form.addEventListener('submit', function (e) {
                                    e.preventDefault();
                                    
                                    Swal.fire({
                                        title: 'Êtes-vous sûr ?',
                                        text: "Cette action est irréversible !",
                                        icon: 'warning',
                                        showCancelButton: true,
                                        confirmButtonColor: '#d33',
                                        cancelButtonColor: '#07677A',
                                        confirmButtonText: 'Oui, supprimer !',
                                        cancelButtonText: 'Annuler',
                                        backdrop: `
                                            rgba(7, 103, 122, 0.4)
                                            url("/images/trash-icon.gif")
                                            left top
                                            no-repeat
                                        `
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            form.submit();
                                        }
                                    });
                                });
                            });
                        });
                    </script>
                    
                </div>
            @endforeach
        </div>
    @endif
</div>


@endsection