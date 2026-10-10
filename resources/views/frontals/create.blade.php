@extends('layouts.main')

@section('content')
<div class="container mx-auto p-4">

    <h2 class="text-5xl font-extrabold text-center text-gray-800 mb-6 relative mt-3">
        <span class="text-[#45C4EB]">Ajouter un nouveau FCI</span>
        <span class="block w-16 h-1 bg-[#F7881B] mx-auto mt-2 rounded-full"></span>
    </h2>

    @if(session('success'))
        <div class="bg-green-200 text-green-800 p-3 mb-4 rounded-lg font-semibold shadow">
            {{ session('success') }}
        </div>
    @endif

   


    <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-lg mt-10 border border-gray-200">

        <form action="{{ route('frontals.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Grille 2 colonnes -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Type de projet -->
                <div>
                    <label class="block font-semibold mb-1">Type de projet</label>
                    <select name="type_projet" class="w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-[#45C4EB]">
                        <option value="PROD" {{ old('type_projet') == 'PROD' ? 'selected' : '' }}>PROD</option>
                        <option value="RATTRAP FCI" {{ old('type_projet') == 'RATTRAP FCI' ? 'selected' : '' }}>RATTRAP FCI</option>
                    </select>

                    @error('type_projet')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Statut FCI -->
                <div>
                    <label class="block font-semibold mb-1">Statut FCI</label>
                    <select name="statut_fci" id="statut_fci" class="w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-[#45C4EB]">
                        <option value="simple">Simple</option>
                        <option value="complexe">Complexe</option>
                        <option value="annulation">Annulation</option>
                        <option value="Accompagnement">Accompagnement</option>
                    </select>

                    @error('statut_fci')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Date déclaration -->
                <div>
                    <label class="block font-semibold mb-1">Date de déclaration</label>
                    <input type="date" name="date_declaration" value="{{ old('date_declaration') }}"
                        class="w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-[#45C4EB]">

                    @error('date_declaration')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Numéro FCI -->
                <div>
                    <label class="block font-semibold mb-1">Numéro FCI</label>
                    <input type="text" name="numero_fci" value="{{ old('numero_fci') }}"
                        class="w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-[#45C4EB]">

                    @error('numero_fci')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Numéro FCI Annulation -->
                <div id="fci_annulation_block" style="display:none;">
                    <label class="block font-semibold mb-1">Numéro FCI Annulation</label>
                    <input type="text" name="numero_fci_annulation" value="{{ old('numero_fci_annulation') }}"
                        class="w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-[#45C4EB]">

                    @error('numero_fci_annulation')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Projet -->
                <div>
                    <label class="block font-semibold mb-1">Projet</label>
                    <input type="text" name="reference" value="{{ old('reference') }}"
                        class="w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-[#45C4EB]">

                    @error('reference')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <!-- Codes Ensee & Études -->
            <div id="codes_ensees_container" class="mt-6">
                <label class="block font-semibold mb-2">Codes Ensee et Études</label>

                <div class="code_ensee_block grid grid-cols-1 md:grid-cols-2 gap-4">

                    <div>
                        <input type="text" name="codes_ensee[]" placeholder="Code Ensee"
                               class="w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-[#45C4EB] code_ensee_input">

                        @error('codes_ensee.*')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <select name="etudes_ids[0][]" class="w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-[#45C4EB] etudes_select">
                            <option value="">-- Sélectionner un numéro d'étude --</option>
                        </select>

                        @error('etudes_ids.*.*')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                </div>
            </div>

            <button type="button" id="add_code_ensee"
                class="px-4 py-2 border rounded-lg shadow-sm text-gray-800 mt-2 hidden">
                Ajouter un code Ensee
            </button>

            <!-- Boutons -->
            <div class="flex justify-end space-x-3 mt-4">
                <a href="{{ route('etudes.create') }}"
                   class="bg-[#45C4EB] hover:bg-[#F7881B] text-white font-semibold px-5 py-2 rounded-lg shadow-md flex items-center">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Ajouter une étude
                </a>

                <button type="submit"
                    class="bg-[#45C4EB] hover:bg-[#F7881B] text-white font-semibold px-6 py-2 rounded-lg shadow-md">
                    Enregistrer
                </button>
            </div>

        </form>
    </div>

</div>


{{-- Scripts --}}
<script>
let count = 1;

// Afficher bouton ajouter si complexe
document.getElementById('statut_fci').addEventListener('change', function() {
    let addBtn = document.getElementById('add_code_ensee');
    let container = document.getElementById('codes_ensees_container');

    if (this.value === 'complexe') addBtn.style.display = 'inline-block';
    else {
        addBtn.style.display = 'none';
        let firstBlock = container.querySelector('.code_ensee_block').outerHTML;
        container.innerHTML = firstBlock;
    }
});

// Ajouter un nouveau code Ensee
document.getElementById('add_code_ensee').addEventListener('click', function() {
    let container = document.getElementById('codes_ensees_container');
    let newBlock = document.createElement('div');
    newBlock.classList.add('code_ensee_block', 'mt-2', 'grid', 'grid-cols-1', 'md:grid-cols-2', 'gap-4');

    newBlock.innerHTML = `
        <div>
            <input type="text" name="codes_ensee[]" placeholder="Code Ensee"
                   class="w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-[#45C4EB] code_ensee_input">
        </div>

        <div>
            <select name="etudes_ids[${count}][]" class="w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-[#45C4EB] etudes_select">
                <option value="">-- Sélectionner un numéro d'étude --</option>
            </select>
        </div>
    `;

    container.appendChild(newBlock);
    count++;
});

// Recherche études par code Ensee
document.addEventListener('input', function(e){
    if(e.target.matches('.code_ensee_input')){
        let code = e.target.value;
        let select = e.target.parentElement.nextElementSibling.querySelector('select');

        if(!code){
            select.innerHTML = '<option value="">-- Sélectionner un numéro d\'étude --</option>';
            return;
        }

        fetch(`/etudes/search-result?code_ensee=${code}`)
            .then(res => res.json())
            .then(data => {
                select.innerHTML = '<option value="">-- Sélectionner un numéro d\'étude --</option>';
                data.forEach(etude => {
                    select.innerHTML += `<option value="${etude.id}">${etude.numero_etude}</option>`;
                });
            });
    }
});
</script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const statutFci = document.getElementById('statut_fci');
    const block = document.getElementById('fci_annulation_block');

    function toggle() {
        if (statutFci.value === 'annulation') block.style.display = 'block';
        else {
            block.style.display = 'none';
            document.getElementById('numero_fci_annulation').value = '';
        }
    }

    toggle();
    statutFci.addEventListener('change', toggle);
});
</script>

@endsection
