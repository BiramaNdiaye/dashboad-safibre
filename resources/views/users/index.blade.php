@extends('layouts.main')

@section('content')

    <div class="bg-white">
        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    <h2 class="text-6xl font-extrabold text-center text-gray-800 mb-6 relative">
        <span class="bg-gradient-to-r from-[#45C4EB] to-[#F7881B] text-transparent bg-clip-text ">
             Gestion des utilisateurs
        </span>
        <span class="block w-16 h-1 bg-[#F7881B] mx-auto mt-2 rounded-full"></span>
    </h2>
        <div class="mb-6">
            <!-- Barre de recherche -->
            <div class="flex items-center space-x-4 p-6">
                @role('admin')
                <a href="{{ route('users.create') }}" class="bg-[#45C4EB] hover:bg-[#F7881B] text-white px-4 py-2 rounded-lg shadow-md p-6">
                    Ajouter  un utilisateur
                </a>
                @endrole
            </div>
            <div class="overflow-x-auto rounded-lg shadow-lg p-5">
                <table class="min-w-full bg-white rounded-lg overflow-hidden">
                    <!-- En-tête de la table -->
                    <thead class="bg-[#45C4EB] text-white">
                        <tr>
                            <th class="py-3 px-4 text-left font-semibold uppercase">Nom </th>
                            <th class="py-3 px-4 text-left font-semibold uppercase">Prénom </th>
                            <th class="py-3 px-4 text-left font-semibold uppercase">email</th>
                            <th class="py-3 px-4 text-left font-semibold uppercase">Roles</th>
                          
                            <th class="py-3 px-4 text-left font-semibold uppercase">Actions</th>
                        </tr>
                    </thead>
                    <!-- Corps de la table -->
                    <tbody >
                        @foreach($users as $user)
                        <tr class="hover:bg-gray-50 transition duration-200 ">
                            <td class="py-3 px-4 border-b-1 border-[#F7881B] border-dashed"">{{ explode(' ', $user->name)[0] }}</td>
                            <td class="py-3 px-4 border-b-1 border-[#F7881B] border-dashed""> {{ explode(' ', $user->name)[1] ?? '' }}</td>
                            <td class="py-3 px-4 border-b-1 border-[#F7881B] border-dashed"">{{$user->email}}</td>
                            <td class="py-3 px-4 border-b-1 border-[#F7881B] border-dashed"">
                                <!-- Affichage des rôles de l'utilisateur -->
                                @foreach($user->getRoleNames() as $role)
                                    <span class="text-sm text-gray-600">{{$role}}</span>
                                @endforeach
                            </td>
                            <td class="px-6 py-4   border-b-1 border-[#F7881B] border-dashed text-center">
                                <div class="flex justify-center space-x-4">
                                    <!-- Icône "Modifier" -->
                                    <a href="{{ route('users.edit', $user->id) }}" class="text-green-500 hover:text-green-600 transition duration-200" title="Modifier un utilisateur">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                        </svg>
                                    </a>
                                  
                                    <!-- Icône "Supprimer" -->
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-600 transition duration-200" title="Supprimer">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                    
                                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                                    <script>
                                        document.addEventListener('DOMContentLoaded', function () {
                                            const deleteForms = document.querySelectorAll('.delete-form');
                                    
                                            deleteForms.forEach(form => {
                                                form.addEventListener('submit', function (e) {
                                                    e.preventDefault();
                                    
                                                    Swal.fire({
                                                        title: 'Êtes-vous sûr ?',
                                                        text: "Vous ne pourrez pas annuler cette action !",
                                                        icon: 'warning',
                                                        showCancelButton: true,
                                                        confirmButtonColor: '#3085d6',
                                                        cancelButtonColor: '#d33',
                                                        confirmButtonText: 'Oui, supprimer !',
                                                        cancelButtonText: 'Annuler'
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
                            </td>
                        </tr>
                    @endforeach
                    
                      
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection