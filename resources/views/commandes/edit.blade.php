@extends('layouts.main')

@section('content')
<div class="container mx-auto p-4">

    <h2 class="text-5xl font-extrabold text-center text-gray-800 mb-6 relative mt-3">
        <span class="text-[#0E2939]">Modifier la commande</span>
        <span class="block w-16 h-1 bg-[#F7881B] mx-auto mt-2 rounded-full"></span>
    </h2>

    @if(session('success'))
        <div class="bg-green-200 text-green-800 p-3 mb-4 rounded-lg font-semibold shadow">
            {{ session('success') }}
        </div>
    @endif

    <div class="max-w-full mx-auto bg-white p-8 rounded-lg shadow-lg mt-10 border border-gray-200">

        <form action="{{ route('commandes.update', $commande) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Grille 2 colonnes -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Référence -->
                <div>
                    <label class="block font-semibold mb-1">
                        <i class="fas fa-hashtag text-[#0E2939] mr-1"></i> Référence
                    </label>
                    <input type="text" name="reference" value="{{ old('reference', $commande->reference) }}" readonly
                        placeholder="Ex: CMD-2026-001"
                        class="w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-[#0E2939] focus:border-[#0E2939] @error('reference') border-red-500 @enderror"
                        required>
                    @error('reference')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Site principal -->
                <div>
                    <label class="block font-semibold mb-1">
                        <i class="fas fa-map-pin text-[#0E2939] mr-1"></i> Site principal
                    </label>
                    <input type="text" name="nom_site" value="{{ old('nom_site', $commande->nom_site) }}"
                        placeholder="Nom du site"
                        class="w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-[#0E2939] focus:border-[#0E2939] @error('nom_site') border-red-500 @enderror"
                        required>
                    @error('nom_site')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Date réception -->
                <div>
                    <label class="block font-semibold mb-1">
                        <i class="fas fa-calendar-alt text-[#0E2939] mr-1"></i> Date réception
                    </label>
                    <input type="date" name="date_reception" value="{{ old('date_reception', $commande->date_reception) }}"
                        class="w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-[#0E2939] focus:border-[#0E2939] @error('date_reception') border-red-500 @enderror">
                    @error('date_reception')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Date livraison -->
                <div>
                    <label class="block font-semibold mb-1">
                        <i class="fas fa-calendar-alt text-[#0E2939] mr-1"></i> Date Livraison
                    </label>
                    <input type="date" name="date_livraison" value="{{ old('date_livraison', $commande->date_livraison) }}"
                        class="w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-[#0E2939] focus:border-[#0E2939] @error('date_livraison') border-red-500 @enderror">
                    @error('date_livraison')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Client -->
                <div>
                    <label class="block font-semibold mb-1">
                        <i class="fas fa-user text-[#0E2939] mr-1"></i> Client
                    </label>
                    <select name="client_id" class="w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-[#0E2939] focus:border-[#0E2939] @error('client_id') border-red-500 @enderror" required>
                        <option value="">Sélectionner un client</option>
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}" {{ old('client_id', $commande->client_id) == $client->id ? 'selected' : '' }}>
                                {{ $client->nom }}
                            </option>
                        @endforeach
                    </select>
                    @error('client_id')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>


                <!-- Statut -->
                    <div>
                        <label class="block font-semibold mb-1">
                            <i class="fas fa-tag text-[#0E2939] mr-1"></i> Statut
                        </label>
                        <select name="statut" class="w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-[#0E2939] focus:border-[#0E2939] @error('statut') border-red-500 @enderror">
                            <option value="en_cours" {{ old('statut', $commande->statut) == 'en_cours' ? 'selected' : '' }}>En cours</option>
                            <option value="livré" {{ old('statut', $commande->statut) == 'livré' ? 'selected' : '' }}>Livré</option>
                            <option value="traité" {{ old('statut', $commande->statut) == 'traité' ? 'selected' : '' }}>Traité</option>
                        </select>
                        @error('statut')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                <!-- Utilisateur affecté -->
                <div>
                    <label class="block font-semibold mb-1">
                        <i class="fas fa-user-cog text-[#0E2939] mr-1"></i> Utilisateur affecté
                    </label>
                    <select name="user_id" class="w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-[#0E2939] focus:border-[#0E2939] @error('user_id') border-red-500 @enderror" required>
                        <option value="">Sélectionner un utilisateur</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id', $commande->user_id) == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description (pleine largeur) -->
                <div class="md:col-span-2">
                    <label class="block font-semibold mb-1">
                        <i class="fas fa-align-left text-[#0E2939] mr-1"></i> Description
                    </label>
                    <textarea name="description" rows="3"
                        placeholder="Décrivez la commande..."
                        class="w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-[#0E2939] focus:border-[#0E2939] @error('description') border-red-500 @enderror">{{ old('description', $commande->description) }}</textarea>
                    @error('description')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <hr class="my-6 border-gray-200">

            <!-- Section Éléments réseau -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-4">
                <h3 class="text-xl font-bold text-[#0E2939] flex items-center">
                    <i class="fas fa-network-wired mr-2"></i> Éléments réseau
                    <span id="elementCount" class="ml-3 inline-flex items-center justify-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-[#F7881B] text-white">
                        {{ $commande->commandeElements->count() }}
                    </span>
                </h3>
                <button type="button" id="addElement"
                    class="px-5 py-2 bg-[#0E2939] hover:bg-[#F7881B] text-white font-semibold rounded-lg shadow-md transition flex items-center">
                    <i class="fas fa-plus mr-2"></i> Ajouter un élément
                </button>
            </div>

            <div class="overflow-x-auto shadow-lg rounded-xl border border-gray-200">
                <table class="min-w-full divide-y divide-gray-200" id="elementsTable">
                    <thead class="bg-gradient-to-r from-[#0E2939] to-[#1a4a5a]">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                <i class="fas fa-tag mr-1"></i> Type
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                <i class="fas fa-signature mr-1"></i> Nom
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                <i class="fas fa-bolt mr-1"></i> Action
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                <i class="fas fa-flag mr-1"></i> Origine
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                <i class="fas fa-location-arrow mr-1"></i> Destination
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                <i class="fas fa-fiber mr-1"></i> Cap. FO
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                <i class="fas fa-comment mr-1"></i> Commentaire
                            </th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-white uppercase tracking-wider" style="width: 80px;">
                                <i class="fas fa-cog mr-1"></i> Action
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($commande->commandeElements as $i => $element)
                            <tr>
                                <td class="px-4 py-2">
                                    <select name="elements[{{ $i }}][type]" class="w-full px-3 py-1.5 border rounded-md shadow-sm focus:ring-[#0E2939] focus:border-[#0E2939] text-sm">
                                        <option value="cable" {{ $element->type == 'cable' ? 'selected' : '' }}>Câble</option>
                                        <option value="boite" {{ $element->type == 'boite' ? 'selected' : '' }}>Boîte</option>
                                        <option value="chambre" {{ $element->type == 'chambre' ? 'selected' : '' }}>Chambre</option>
                                        <option value="site" {{ $element->type == 'site' ? 'selected' : '' }}>Site</option>
                                    </select>
                                </td>
                                <td class="px-4 py-2">
                                    <input type="text" name="elements[{{ $i }}][nom]" value="{{ $element->nom }}" placeholder="Nom"
                                        class="w-full px-3 py-1.5 border rounded-md shadow-sm focus:ring-[#0E2939] focus:border-[#0E2939] text-sm">
                                </td>
                                <td class="px-4 py-2">
                                    <select name="elements[{{ $i }}][action]" class="w-full px-3 py-1.5 border rounded-md shadow-sm focus:ring-[#0E2939] focus:border-[#0E2939] text-sm">
                                        <option value="creation" {{ $element->action == 'creation' ? 'selected' : '' }}>Création</option>
                                        <option value="modification" {{ $element->action == 'modification' ? 'selected' : '' }}>Modification</option>
                                        <option value="suppression" {{ $element->action == 'suppression' ? 'selected' : '' }}>Suppression</option>
                                        <option value="existant" {{ $element->action == 'existant' ? 'selected' : '' }}>Existant</option>
                                    </select>
                                </td>
                                <td class="px-4 py-2">
                                    <input type="text" name="elements[{{ $i }}][origine]" value="{{ $element->origine }}" placeholder="Origine"
                                        class="w-full px-3 py-1.5 border rounded-md shadow-sm focus:ring-[#0E2939] focus:border-[#0E2939] text-sm">
                                </td>
                                <td class="px-4 py-2">
                                    <input type="text" name="elements[{{ $i }}][destination]" value="{{ $element->destination }}" placeholder="Destination"
                                        class="w-full px-3 py-1.5 border rounded-md shadow-sm focus:ring-[#0E2939] focus:border-[#0E2939] text-sm">
                                </td>
                                <td class="px-4 py-2">
                                    <input type="number" name="elements[{{ $i }}][capacite_fo]" value="{{ $element->capacite_fo }}" placeholder="Nb fibres"
                                        class="w-full px-3 py-1.5 border rounded-md shadow-sm focus:ring-[#0E2939] focus:border-[#0E2939] text-sm">
                                </td>
                                <td class="px-4 py-2">
                                    <input type="text" name="elements[{{ $i }}][commentaire]" value="{{ $element->commentaire }}" placeholder="Commentaire"
                                        class="w-full px-3 py-1.5 border rounded-md shadow-sm focus:ring-[#0E2939] focus:border-[#0E2939] text-sm">
                                </td>
                                <td class="px-4 py-2 text-center">
                                    <button type="button" class="remove-row bg-red-500 hover:bg-red-700 text-white w-8 h-8 rounded-full shadow-md transition flex items-center justify-center mx-auto" title="Supprimer">
                                        <i class="fas fa-trash-alt text-sm"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr id="noElementsRow">
                                <td colspan="8" class="px-4 py-6 text-center text-gray-400 italic">
                                    <i class="fas fa-info-circle mr-1"></i> Aucun élément ajouté
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Boutons d'action -->
            <div class="flex flex-col sm:flex-row justify-end gap-3 pt-6 border-t border-gray-200">
                <a href="{{ route('commandes.index') }}"
                    class="px-6 py-2 border border-gray-300 text-gray-700 font-semibold rounded-lg shadow-sm hover:bg-gray-50 transition text-center">
                    <i class="fas fa-times mr-1"></i> Annuler
                </a>
                <button type="submit"
                    class="px-8 py-2 bg-[#0E2939] hover:bg-[#F7881B] text-white font-semibold rounded-lg shadow-md transition">
                    <i class="fas fa-save mr-1"></i> Enregistrer les modifications
                </button>
            </div>

        </form>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endpush

<script>
    // Nombre d'éléments existants
    let index = {{ $commande->commandeElements->count() }};

    function updateCounter() {
        const tbody = document.querySelector('#elementsTable tbody');
        const rows = tbody.querySelectorAll('tr:not(#noElementsRow)');
        const count = rows.length;
        document.getElementById('elementCount').textContent = count;

        const noRow = document.getElementById('noElementsRow');
        if (count === 0 && !noRow) {
            const newNoRow = document.createElement('tr');
            newNoRow.id = 'noElementsRow';
            newNoRow.innerHTML = `<td colspan="8" class="px-4 py-6 text-center text-gray-400 italic">
                <i class="fas fa-info-circle mr-1"></i> Aucun élément ajouté
            </td>`;
            tbody.appendChild(newNoRow);
        } else if (count > 0 && noRow) {
            noRow.remove();
        }
    }

    document.getElementById('addElement').addEventListener('click', function () {
        const tbody = document.querySelector('#elementsTable tbody');
        const noRow = document.getElementById('noElementsRow');
        if (noRow) noRow.remove();

        const row = document.createElement('tr');
        row.innerHTML = `
            <td class="px-4 py-2">
                <select name="elements[${index}][type]" class="w-full px-3 py-1.5 border rounded-md shadow-sm focus:ring-[#0E2939] focus:border-[#0E2939] text-sm">
                    <option value="cable">Câble</option>
                    <option value="boite">Boîte</option>
                    <option value="chambre">Chambre</option>
                    <option value="site">Site</option>
                </select>
            </td>
            <td class="px-4 py-2">
                <input type="text" name="elements[${index}][nom]" placeholder="Nom"
                    class="w-full px-3 py-1.5 border rounded-md shadow-sm focus:ring-[#0E2939] focus:border-[#0E2939] text-sm">
            </td>
            <td class="px-4 py-2">
                <select name="elements[${index}][action]" class="w-full px-3 py-1.5 border rounded-md shadow-sm focus:ring-[#0E2939] focus:border-[#0E2939] text-sm">
                    <option value="creation">Création</option>
                    <option value="modification">Modification</option>
                    <option value="suppression">Suppression</option>
                    <option value="existant">Existant</option>
                </select>
            </td>
            <td class="px-4 py-2">
                <input type="text" name="elements[${index}][origine]" placeholder="Origine"
                    class="w-full px-3 py-1.5 border rounded-md shadow-sm focus:ring-[#0E2939] focus:border-[#0E2939] text-sm">
            </td>
            <td class="px-4 py-2">
                <input type="text" name="elements[${index}][destination]" placeholder="Destination"
                    class="w-full px-3 py-1.5 border rounded-md shadow-sm focus:ring-[#0E2939] focus:border-[#0E2939] text-sm">
            </td>
            <td class="px-4 py-2">
                <input type="number" name="elements[${index}][capacite_fo]" placeholder="Nb fibres"
                    class="w-full px-3 py-1.5 border rounded-md shadow-sm focus:ring-[#0E2939] focus:border-[#0E2939] text-sm">
            </td>
            <td class="px-4 py-2">
                <input type="text" name="elements[${index}][commentaire]" placeholder="Commentaire"
                    class="w-full px-3 py-1.5 border rounded-md shadow-sm focus:ring-[#0E2939] focus:border-[#0E2939] text-sm">
            </td>
            <td class="px-4 py-2 text-center">
                <button type="button" class="remove-row bg-red-500 hover:bg-red-700 text-white w-8 h-8 rounded-full shadow-md transition flex items-center justify-center mx-auto" title="Supprimer">
                    <i class="fas fa-trash-alt text-sm"></i>
                </button>
            </td>
        `;
        tbody.appendChild(row);
        index++;
        updateCounter();
    });

    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.remove-row');
        if (btn) {
            if (confirm('Supprimer définitivement cet élément ?')) {
                const row = btn.closest('tr');
                row.remove();
                updateCounter();
            }
        }
    });

    document.addEventListener('DOMContentLoaded', updateCounter);
</script>
@endsection