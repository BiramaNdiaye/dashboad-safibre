@extends('layouts.main')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Éditer Frontal</h1>

    @if($errors->any())
        <div class="bg-red-200 text-red-800 p-2 mb-4 rounded">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('frontals.update', $frontal) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block font-semibold">Type de projet</label>
            <input type="text" name="type_projet" value="{{ old('type_projet', $frontal->type_projet) }}" class="border rounded p-2 w-full">
            <select name="type_projet" id="type_projet" class="border p-2 w-full">
                <option value="PROD" {{ old('type_projet', $frontal->type_projet) == 'PROD' ? 'selected' : '' }}>PROD</option>
                <option value="RATTRAP FCI" {{ old('type_projet', $frontal->type_projet) == 'RATTRAP FCI' ? 'selected' : '' }}>RATTRAP FCI</option>
               
            </select>
        </div>

        <div>
            <label class="block font-semibold">Statut FCI</label>
            <select name="statut_fci" id="statut_fci" class="border p-2 w-full">
                <option value="simple" {{ old('statut_fci', $frontal->statut_fci) == 'simple' ? 'selected' : '' }}>Simple</option>
                <option value="complexe" {{ old('statut_fci', $frontal->statut_fci) == 'complexe' ? 'selected' : '' }}>Complexe</option>
                <option value="annulation" {{ old('statut_fci', $frontal->statut_fci) == 'annulation' ? 'selected' : '' }}>Annulation</option>
                <option value="Accompagnement" {{ old('statut_fci', $frontal->statut_fci) == 'Accompagnement' ? 'selected' : '' }}>Accompagnement</option>
            </select>
        </div>

        <div>
            <label class="block font-semibold">Date de déclaration</label>
            <input type="date" name="date_declaration" value="{{ old('date_declaration', $frontal->date_declaration->format('Y-m-d')) }}" class="border rounded p-2 w-full">
        </div>

        <div>
            <label class="block font-semibold">Numéro FCI</label>
            <input type="text" name="numero_fci" value="{{ old('numero_fci', $frontal->numero_fci) }}" class="border rounded p-2 w-full">
        </div>

        <div>
            <label class="block font-semibold">Numéro FCI Annulation</label>
            <input type="text" name="numero_fci_annulation" value="{{ old('numero_fci_annulation', $frontal->numero_fci_annulation) }}" class="border rounded p-2 w-full">
        </div>

        <div>
            <label class="block font-semibold">Référence Projet</label>
             <input type="text" name="reference" value="{{ old('reference', $frontal->reference) }}" class="border rounded p-2 w-full">
        </div>

        <!-- Codes Ensee et Numéros d'études -->
        <div id="codes_ensees_container" class="mt-4">
            @foreach($etudes as $index => $etude)
            <div class="code_ensee_block mb-2">
                <input type="text" name="codes_ensee[]" value="{{ old('codes_ensee.'.$index, $etude->code_ensee) }}" placeholder="Code Ensee" class="border p-2 mb-2 w-full code_ensee_input">
                <select name="etudes_ids[{{ $index }}][]" class="border p-2 w-full etudes_select">
                    <option value="{{ $etude->id }}" selected>{{ $etude->numero_etude }}</option>
                </select>
            </div>
            @endforeach
        </div>

        <button type="button" id="add_code_ensee" class="bg-blue-500 text-white px-3 py-1 rounded mt-2 {{ $frontal->statut_fci == 'complexe' ? '' : 'hidden' }}">
            Ajouter un code Ensee
        </button>

        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded mt-4 hover:bg-green-700">
            Mettre à jour
        </button>
    </form>
</div>

<script>
let count = {{ $etudes->count() }};

// Afficher bouton ajouter si complexe
document.getElementById('statut_fci').addEventListener('change', function() {
    let addBtn = document.getElementById('add_code_ensee');
    let container = document.getElementById('codes_ensees_container');
    if(this.value === 'complexe'){
        addBtn.style.display = 'inline-block';
    } else {
        addBtn.style.display = 'none';
        let firstBlock = container.querySelector('.code_ensee_block').outerHTML;
        container.innerHTML = firstBlock;
    }
});

// Ajouter un nouveau code Ensee + select
document.getElementById('add_code_ensee').addEventListener('click', function() {
    let container = document.getElementById('codes_ensees_container');
    let newBlock = document.createElement('div');
    newBlock.classList.add('code_ensee_block', 'mt-2');
    newBlock.innerHTML = `
        <input type="text" name="codes_ensee[]" placeholder="Code Ensee" class="border p-2 mb-2 w-full code_ensee_input">
        <select name="etudes_ids[${count}][]" class="border p-2 w-full etudes_select">
            <option value="">-- Sélectionner un numéro d'étude --</option>
        </select>
    `;
    container.appendChild(newBlock);
    count++;
});

// Remplir les selects dynamiquement selon code Ensee
document.addEventListener('input', function(e){
    if(e.target.matches('.code_ensee_input')){
        let code = e.target.value;
        let select = e.target.nextElementSibling;
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
@endsection
