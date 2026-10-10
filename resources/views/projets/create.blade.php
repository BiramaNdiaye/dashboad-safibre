@extends('layouts.main')

@section('content')

<h2 class="text-5xl font-extrabold text-center text-gray-800 mb-6 relative mt-3">
    <span class="bg-[#45C4EB] text-transparent bg-clip-text uppercase">
        Ajouter un nouveau projet
    </span>
    <span class="block w-16 h-1 bg-[#45C4EB] mx-auto mt-2 rounded-full"></span>
</h2>

<div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-lg mt-10 border border-gray-200">

    <form action="{{ route('projets.store') }}" method="POST"
          class="bg-white p-8 rounded-xl shadow-lg border border-[#45C4EB] space-y-6">

        @csrf

        {{-- Nom site + Référence --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="nom_site" class="block text-sm font-semibold text-gray-700">Nom du site</label>
                <input type="text" id="nom_site" name="nom_site"
                       class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg">
            </div>

            <div>
                <label for="reference" class="block text-sm font-semibold text-gray-700">Référence</label>
                <input type="text" id="reference" name="reference" value="{{ old('reference') }}"
                       class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg">

                @error('reference')
                    <span style="color:red;">{{ $message }}</span>
                @enderror
            </div>
        </div>

        {{-- Client --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div>
                <label for="clients_id" class="block text-sm font-semibold text-gray-700">Client</label>
                <select id="clients_id" name="clients_id"
                        class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg">

                    @foreach ($clients as $client)
                        <option value="{{ $client->id }}">
                            {{ $client->nom }}
                        </option>
                    @endforeach

                </select>
            </div>

            {{-- 🔥 CODE SITE (SPIE uniquement) --}}
            <div id="code_site_container" class="hidden">
                <label for="code_site" class="block text-sm font-semibold text-gray-700">
                    Code site (SPIE)
                </label>
                <input type="text" id="code_site" name="code_site"
                       class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg">
            </div>

        </div>

        {{-- Dates --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700">Date commande</label>
                <input type="date" name="date_commande"
                       class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700">Date livraison</label>
                <input type="date" name="date_livraison"
                       class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg">
            </div>
        </div>

        {{-- Statut + Chef de projet --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div>
                <label class="block text-sm font-semibold text-gray-700">Statut</label>
                <select name="statut_projet"
                        class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg">
                    <option>En cours</option>
                    <option>Livré</option>
                    <option>Traité</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700">Chef de projet</label>
                <select name="users_id"
                        class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg">

                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach

                </select>
            </div>

        </div>

        {{-- Type projet --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700">Type de projet</label>
            <select name="type_projet"
                    class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg">

                <option value="Production">Production</option>
                <option value="Production V2">Production V2</option>
                <option value="RATTRAP BLO">RATTRAP BLO</option>

            </select>
        </div>

        {{-- Commentaire --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700">Commentaire</label>
            <textarea name="commentaires"
                      class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg"></textarea>
        </div>

        {{-- Bouton --}}
        <div class="flex justify-end">
            <button type="submit"
                    class="bg-[#45C4EB] hover:bg-[#45C4EB] text-white px-6 py-2 rounded-lg">
                Ajouter
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

{{-- 🔥 SCRIPT --}}
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
    toggleCodeSite();

});
</script>

@endsection