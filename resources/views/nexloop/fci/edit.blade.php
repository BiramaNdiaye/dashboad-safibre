@extends('layouts.main')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- En-tête -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-2">Modifier le FCI</h1>
        <p class="text-gray-600">Modifiez les informations du FCI et ses études associées</p>
    </div>

    <form action="{{ route('nexloop.fci.update', $fci->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Grille 2 colonnes -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Site -->
            <div>
                <label for="site" class="block font-semibold mb-1">Site *</label>
                <input type="text" name="site" id="site" value="{{ old('site', $fci->site) }}" required
                    class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200">
                @error('site')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Type -->
            <div>
                <label for="type" class="block font-semibold mb-1">Type *</label>
                <select name="type" id="type" required
                    class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200">
                    <option value="Simple" {{ old('type', $fci->type) == 'Simple' ? 'selected' : '' }}>Simple</option>
                    <option value="Complexe" {{ old('type', $fci->type) == 'Complexe' ? 'selected' : '' }}>Complexe</option>
                </select>
                @error('type')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Numéro FCI -->
            <div>
                <label for="numero_fci" class="block font-semibold mb-1">Numéro FCI *</label>
                <input type="text" name="numero_fci" id="numero_fci" value="{{ old('numero_fci', $fci->numero_fci) }}" required
                    class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200">
                @error('numero_fci')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
            <label for="type" class="block font-semibold mb-1">Client</label>
            <select name="type" id="type" class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200">
                <option value="NEXLOOP" {{ old('client', $fci->client) }}>NEXLOOP</option>
                <option value="MCCONNECTIC" {{ old('client', $fci->client) }}>MCCONNECTIC</option>
            </select>
             @error('client')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
        </div>
        </div>

        <!-- Codes Ensei et Études -->
        <div id="codes_ensees_container" class="mt-6">
            <label class="block font-semibold mb-2">Codes Ensei et Études *</label>
            
            @php
                $oldCodes = old('codes_ensei', []);
                $oldEtudes = old('etudes_ids', []);
                $hasOld = !empty($oldCodes) || !empty($oldEtudes);
                
                // Déterminer les données à afficher
                if ($hasOld) {
                    // Utiliser les anciennes valeurs (en cas d'erreur de validation)
                    $studiesData = [];
                    foreach ($oldCodes as $index => $code) {
                        if (isset($oldEtudes[$index][0])) {
                            $studiesData[] = [
                                'code_ensei' => $code,
                                'etude_id' => $oldEtudes[$index][0]
                            ];
                        }
                    }
                } else {
                    // Utiliser les données existantes
                    $studiesData = [];
                    foreach ($fci->etudes as $index => $etude) {
                        $studiesData[] = [
                            'code_ensei' => $etude->code_ensei,
                            'etude_id' => $etude->id
                        ];
                    }
                    // Si aucune étude, ajouter un bloc vide
                    if (empty($studiesData)) {
                        $studiesData[] = ['code_ensei' => '', 'etude_id' => ''];
                    }
                }
            @endphp
            
            @foreach($studiesData as $index => $study)
                <div class="code_ensee_block mb-4 grid grid-cols-1 md:grid-cols-2 gap-4" data-index="{{ $index }}">
                    <!-- Code Ensei -->
                    <div>
                        <input type="text" name="codes_ensei[]" 
                               value="{{ $study['code_ensei'] }}"
                               placeholder="Code Ensei" 
                               class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] code_ensei_input"
                               data-index="{{ $index }}"
                               list="codes_ensei_list">
                        <datalist id="codes_ensei_list">
                            @foreach($codesEnsei as $code)
                                <option value="{{ $code->code_ensei }}">
                            @endforeach
                        </datalist>
                    </div>
                    
                    <!-- Études -->
                    <div>
                        <select name="etudes_ids[{{ $index }}][]" 
                                class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] etudes_select"
                                data-index="{{ $index }}">
                            <option value="">-- Sélectionnez d'abord un code Ensei --</option>
                            @if($study['code_ensei'] && $study['etude_id'])
                                <option value="{{ $study['etude_id'] }}" selected>
                                    {{ $study['etude_id'] }} (pré-sélectionné)
                                </option>
                            @endif
                        </select>
                    </div>
                    
                    @if($index > 0 || ($fci->type === 'Complexe' && $index === 0 && count($studiesData) > 1))
                        <div class="col-span-2 flex justify-end">
                            <button type="button" class="remove_code_ensei text-red-500 hover:text-red-700 text-sm font-medium">
                                Supprimer ce code Ensei
                            </button>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        <!-- Bouton Ajouter un code Ensei -->
        <button type="button" id="add_code_ensei" 
                class="mt-2 bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg text-sm font-medium transition duration-200">
            + Ajouter un code Ensei
        </button>

        <!-- Boutons d'action -->
        <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
            <a href="{{ route('nexloop.fci.index') }}" 
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

<script>
let count = {{ count($studiesData) }};

// Afficher/masquer bouton ajouter selon le type
document.getElementById('type').addEventListener('change', function() {
    let addBtn = document.getElementById('add_code_ensei');
    let container = document.getElementById('codes_ensees_container');
    
    if(this.value === 'Complexe') {
        addBtn.style.display = 'inline-block';
    } else {
        addBtn.style.display = 'none';
        // Garder seulement le premier bloc si pas complexe
        let blocks = container.querySelectorAll('.code_ensee_block');
        for(let i = 1; i < blocks.length; i++) {
            blocks[i].remove();
        }
        count = 1;
    }
});

// Initialiser l'état du bouton
document.addEventListener('DOMContentLoaded', function() {
    let type = document.getElementById('type').value;
    let addBtn = document.getElementById('add_code_ensei');
    addBtn.style.display = type === 'Complexe' ? 'inline-block' : 'none';
    
    // Pour chaque bloc existant, charger les études si code_ensei est présent
    document.querySelectorAll('.code_ensei_input').forEach(input => {
        let code = input.value;
        let index = input.dataset.index;
        let select = document.querySelector(`.etudes_select[data-index="${index}"]`);
        
        if(code) {
            fetchEtudes(code, select, true);
        }
    });
});

// Ajouter un nouveau bloc code Ensei
document.getElementById('add_code_ensei').addEventListener('click', function() {
    let container = document.getElementById('codes_ensees_container');
    let newBlock = document.createElement('div');
    newBlock.classList.add('code_ensee_block', 'mb-4', 'grid', 'grid-cols-1', 'md:grid-cols-2', 'gap-4');
    newBlock.innerHTML = `
        <div>
            <input type="text" name="codes_ensei[]" placeholder="Code Ensei" 
                class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] code_ensei_input"
                data-index="${count}"
                list="codes_ensei_list">
        </div>
        <div>
            <select name="etudes_ids[${count}][]" 
                class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] etudes_select"
                data-index="${count}">
                <option value="">-- Tapez un code Ensei d'abord --</option>
            </select>
        </div>
        <div class="col-span-2 flex justify-end">
            <button type="button" class="remove_code_ensei text-red-500 hover:text-red-700 text-sm font-medium">
                Supprimer ce code Ensei
            </button>
        </div>
    `;
    container.appendChild(newBlock);
    count++;
});

// Supprimer un bloc
document.addEventListener('click', function(e) {
    if(e.target.classList.contains('remove_code_ensei')) {
        let block = e.target.closest('.code_ensee_block');
        block.remove();
        
        // Réorganiser les index si nécessaire
        reorganizeIndexes();
    }
});

// Reorganiser les index après suppression
function reorganizeIndexes() {
    let blocks = document.querySelectorAll('.code_ensee_block');
    count = 0;
    
    blocks.forEach((block, index) => {
        let inputs = block.querySelectorAll('[data-index]');
        inputs.forEach(input => {
            input.dataset.index = index;
            if(input.name === 'codes_ensei[]') {
                input.name = 'codes_ensei[]';
            } else if(input.tagName === 'SELECT') {
                input.name = `etudes_ids[${index}][]`;
            }
        });
        count++;
    });
}

// Chargement dynamique des études
document.addEventListener('input', function(e) {
    if(e.target.classList.contains('code_ensei_input')) {
        let codeEnsei = e.target.value.trim();
        let index = e.target.dataset.index;
        let select = document.querySelector(`.etudes_select[data-index="${index}"]`);
        
        select.innerHTML = '<option value="">-- Chargement...</option>';
        select.disabled = true;
        
        if(codeEnsei.length >= 2) {
            clearTimeout(window.searchTimeout);
            window.searchTimeout = setTimeout(() => {
                fetchEtudes(codeEnsei, select);
            }, 300);
        } else {
            select.innerHTML = '<option value="">-- Tapez un code Ensei d\'abord --</option>';
            select.disabled = true;
        }
    }
});

// Fonction pour récupérer les études
function fetchEtudes(codeEnsei, selectElement, isInitialLoad = false) {
    fetch(`/etudesfa/search-result?code_ensei=${encodeURIComponent(codeEnsei)}`)
        .then(response => response.json())
        .then(data => {
            selectElement.innerHTML = '<option value="">-- Sélectionner un numéro d\'étude --</option>';
            
            if(data.length > 0) {
                data.forEach(etude => {
                    let option = document.createElement('option');
                    option.value = etude.id;
                    option.textContent = etude.numero_etude;
                    
                    // Si c'est un chargement initial, vérifier si c'est l'étude pré-sélectionnée
                    if(isInitialLoad && selectElement.querySelector('option[selected]')) {
                        let selectedValue = selectElement.querySelector('option[selected]').value;
                        if(etude.id == selectedValue) {
                            option.selected = true;
                        }
                    }
                    
                    selectElement.appendChild(option);
                });
                selectElement.disabled = false;
            } else {
                selectElement.innerHTML = '<option value="">Aucune étude trouvée</option>';
                selectElement.disabled = true;
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            selectElement.innerHTML = '<option value="">Erreur de chargement</option>';
            selectElement.disabled = true;
        });
}
</script>
@endsection