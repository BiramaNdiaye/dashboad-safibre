@extends('layouts.main')

@section('content')

<h2 class="text-5xl font-extrabold text-center text-gray-800 mb-6 relative mt-3">
    <span class="bg-[#45C4EB] text-transparent bg-clip-text uppercase">
        Mettre à jour le projet
    </span>
    <span class="block w-16 h-1 bg-[#45C4EB] mx-auto mt-2 rounded-full"></span>
</h2>

<div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-lg mt-10">

<form action="{{ route(isset($projet) ? 'projets.update' : 'projets.store', $projet->id ?? '') }}"
      method="POST"
      class="bg-white p-8 rounded-xl shadow-lg border border-[#45C4EB] space-y-6">

    @csrf
    @if(isset($projet))
        @method('PUT')
    @endif

    {{-- NOM + REFERENCE --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <div>
            <label class="block text-sm font-medium text-gray-700">Nom du site</label>
            <input type="text" name="nom_site"
                   value="{{ old('nom_site', $projet->nom_site ?? '') }}"
                   class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Référence</label>
            <input type="text" name="reference"
                   value="{{ old('reference', $projet->reference ?? '') }}"
                   class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg">
        </div>

    </div>

    {{-- CLIENT + CODE SITE SPIE --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <div>
            <label class="block text-sm font-medium text-gray-700">Client</label>

            <select id="clients_id" name="clients_id"
                    class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg">

                @foreach ($clients as $client)
                    <option value="{{ $client->id }}"
                        {{ old('clients_id', $projet->clients_id ?? '') == $client->id ? 'selected' : '' }}>
                        {{ $client->nom }}
                    </option>
                @endforeach

            </select>
        </div>

        {{-- 🔥 CODE SITE SPIE --}}
        <div id="code_site_container" class="hidden">
            <label class="block text-sm font-medium text-gray-700">
                Code site (SPIE)
            </label>

            <input type="text" name="code_site"
                   value="{{ old('code_site', $projet->code_site ?? '') }}"
                   class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg">
        </div>

    </div>

    {{-- DATES --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <div>
            <label class="block text-sm font-medium text-gray-700">Date commande</label>
            <input type="date" name="date_commande"
                   value="{{ old('date_commande', $projet->date_commande ?? '') }}"
                   class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Date livraison</label>
            <input type="date" name="date_livraison"
                   value="{{ old('date_livraison', $projet->date_livraison ?? '') }}"
                   class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg">
        </div>

    </div>

    {{-- PROJET + STATUT --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <div>
            <label class="block text-sm font-medium text-gray-700">Chef de projet</label>

            <select name="users_id"
                    class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg">

                @foreach ($users as $user)
                    <option value="{{ $user->id }}"
                        {{ old('users_id', $projet->users_id ?? '') == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach

            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Statut</label>

            <select name="statut_projet"
                    class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg">

                <option value="En cours" {{ old('statut_projet', $projet->statut_projet ?? '') == 'En cours' ? 'selected' : '' }}>En cours</option>
                <option value="Livré" {{ old('statut_projet', $projet->statut_projet ?? '') == 'Livré' ? 'selected' : '' }}>Livré</option>
                <option value="Traité" {{ old('statut_projet', $projet->statut_projet ?? '') == 'Traité' ? 'selected' : '' }}>Traité</option>

            </select>
        </div>

    </div>

    {{-- TYPE --}}
    <div>
        <label class="block text-sm font-medium text-gray-700">Type de projet</label>

        <select name="type_projet"
                class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg">

            <option value="Production" {{ old('type_projet', $projet->type_projet ?? '') == 'Production' ? 'selected' : '' }}>Production</option>
            <option value="Production V2" {{ old('type_projet', $projet->type_projet ?? '') == 'Production V2' ? 'selected' : '' }}>Production V2</option>
            <option value="RATTRAP BLO" {{ old('type_projet', $projet->type_projet ?? '') == 'RATTRAP BLO' ? 'selected' : '' }}>RATTRAP BLO</option>

        </select>
    </div>

    {{-- COMMENTAIRE --}}
    <div>
        <label class="block text-sm font-medium text-gray-700">Commentaire</label>

        <textarea name="commentaires"
                  class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg">{{ old('commentaires', $projet->commentaires ?? '') }}</textarea>
    </div>

    {{-- BUTTON --}}
    <div class="flex justify-end">
        <button type="submit"
                class="bg-[#45C4EB] hover:bg-[#45C4EB] text-white px-6 py-2 rounded-lg">
            Mettre à jour
        </button>
    </div>

</form>

<div class="mt-6">
    <a href="{{ route('projets.index') }}"
       class="bg-[#45C4EB] hover:bg-[#45C4EB] text-white px-6 py-3 rounded-lg">
        ⬅ Retour aux projets
    </a>
</div>

</div>

{{-- 🔥 SCRIPT SPIE --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    const clientSelect = document.getElementById('clients_id');
    const codeSiteContainer = document.getElementById('code_site_container');

    function toggleCodeSite() {
        const selectedText = clientSelect.options[clientSelect.selectedIndex].text.trim();

        if (selectedText === 'SPIE') {
            codeSiteContainer.classList.remove('hidden');
        } else {
            codeSiteContainer.classList.add('hidden');
        }
    }

    clientSelect.addEventListener('change', toggleCodeSite);

    // affichage initial
    toggleCodeSite();

});
</script>

@endsection