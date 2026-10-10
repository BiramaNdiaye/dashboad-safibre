@extends('layouts.main')

@section('content')
<h2 class="text-3xl font-extrabold text-center text-gray-800 mb-6 relative">
    <span class="bg-[#45C4EB]  text-transparent bg-clip-text uppercase">
        Ajouter  une patatoide
    </span>
    <span class="block w-16 h-1 bg-[#F7881B] mx-auto mt-2 rounded-full"></span>
</h2>
 @if(session('success'))
        <div class="bg-green-200 text-green-800 p-2 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-200 text-red-800 p-2 mb-4 rounded">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
<div class="max-w-4xl mx-auto bg-white shadow-lg rounded-2xl p-6 mt-6">


<form action="{{ route('patatoides.store') }}" method="POST" class="space-y-5">
    @csrf
  
   <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    <!-- Type Projet -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Type Projet</label>
        <select name="type_projet"
                class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg">
            <option value="PROD" {{ old('type_projet') == 'PROD' ? 'selected' : '' }}>PROD</option>
            <option value="RATTRAP" {{ old('type_projet') == 'RATTRAP ' ? 'selected' : '' }}>RATTRAP </option>
            
        </select>
    </div>

    <!-- Ref Projet -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Réference Projet</label>
        <input type="text" name="ref_projet" value="{{ old('ref_projet', $patatoide->ref_projet ?? '') }}"
               class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg">
    </div>

    <!-- Site -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Site</label>
        <input type="text" name="site" value="{{ old('site') }}"
               class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg">
    </div>

    <!-- Date Réception -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Date Réception</label>
        <input type="date" name="date_reception" value="{{ old('date_reception') }}"
               class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg">
    </div>

    <!-- Nombre BPE -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Nombre BPE</label>
        <input type="number" name="nbre_bpe" value="{{ old('nbre_bpe') }}"
               class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg">
    </div>

    <!-- Nombre Client -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Nombre Client</label>
        <input type="number" name="nbre_client" value="{{ old('nbre_client') }}"
               class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg">
    </div>

    <!-- Nombre Cable Ext -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Nombre Cable Ext</label>
        <input type="number" name="nbre_cable_ext" value="{{ old('nbre_cable_ext') }}"
               class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg">
    </div>

    <!-- Nombre Racco Client -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Nombre Racco Client</label>
        <input type="number" name="nbre_racco_client" value="{{ old('nbre_racco_client') }}"
               class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg">
    </div>

    <!-- Statut Patatoide -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Statut Patatoïde</label>
        <select name="statut_patatoide"
                class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg">
            <option value="EN COURS">EN COURS</option>
            <option value="LIVRÉ">LIVRÉ</option>
            <option value="ATTENTE INFO SUPP ">ATTENTE INFO SUPP</option>
            <option value="DEPOT KMZ">DEPOT KMZ</option>
            <option value="TRAITE">TRAITE</option>
            <option value="ANNULE">ANNULE</option>
            <option value="REPRISE">REPRISE</option>
        </select>
    </div>

    <!-- Date Livraison -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Date Livraison Patatoïde</label>
        <input type="date" name="date_liv_patatoide" value="{{ old('date_liv_patatoide') }}"
               class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg">
    </div>

    <!-- Validation Covage -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Validation Covage</label>
        <select name="validation_covage"
                class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg">
            <option value="OUI">OUI</option>
            <option value="NON">NON</option>
            <option value="EN COURS">EN COURS</option>
        </select>
    </div>

    <!-- Commentaires -->
    <div class="col-span-2">
        <label class="block text-sm font-medium text-gray-700">Commentaires</label>
        <textarea name="commentaires" rows="3"
                  class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg">{{ old('commentaires') }}</textarea>
    </div>

</div>

    <div class="flex justify-end pt-3">
            <button type="submit"
                class="bg-[#45C4EB] hover:bg-[#F7881B] text-white font-semibold px-5 py-2 rounded-lg transition transform hover:scale-105 shadow-md">
                Enregistrer
            </button>
        </div>
</form>
</div>
@endsection
