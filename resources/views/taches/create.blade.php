@extends('layouts.main')

@section('content')
<h2 class="text-6xl font-extrabold text-center text-gray-800 mb-6 relative">
    <span class="bg-[#45C4EB] text-transparent bg-clip-text uppercase">
        Ajouter  une tâche
    </span>
    <span class="block w-16 h-1 bg-[#F7881B] mx-auto mt-2 rounded-full"></span>
</h2>
<div  class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-lg mt-10 border border-gray-200">
  
    @if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
        <strong class="font-bold">Erreur(s) :</strong>
        <ul class="mt-2">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    <form action="{{ route('taches.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-8 rounded-xl shadow-lg border border-[#45C4EB] space-y-6">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Affichage des informations du projet -->
            <div>
                <label for="projet_reference" class="block text-sm font-medium text-gray-700">Référence du projet</label>
                <input type="text" name="projet_reference" value="{{ $projet->reference }}"  class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200" readonly>
            </div>
            <div>
                <label for="projet_nom" class="block text-sm font-medium text-gray-700">Nom du projet</label>
                <input type="text" name="projet_nom" value="{{ $projet->nom_site }}"  class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200"readonly>
            </div>
            <div>
                <label for="projet_description" class="block text-sm font-medium text-gray-700">Chef du projet</label>
                <input type="text" name="projet_nom" value="{{ $projet->chefProjet->name}}"  class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200"readonly>
            </div>
    
            <!-- Type de tâche -->
            <div>
                <label for="type_tache" class="block text-sm font-medium text-gray-700">Type de tâche</label>
                <select id="type_tache" name="type_tache"  class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200">
                    <option value="">Sélectionnez un type</option>
                    <option value="ROP" {{ old('type_tache') == 'ROP' ? 'selected' : '' }}>ROP</option>
                    <option value="BLO" {{ old('type_tache') == 'BLO' ? 'selected' : '' }}>BLO</option>
                    <option value="DOE OPTIQUE" {{ old('type_tache') == 'DOE OPTIQUE' ? 'selected' : '' }}>DOE OPTIQUE</option>
                    <option value="APD GC/DOE GC" {{ old('type_tache') == 'APD GC DOE GC' ? 'selected' : '' }}>APD GC/DOE GC</option>
                    <option value="Accompagnement" {{ old('type_tache') == 'Accompagnement' ? 'selected' : '' }}>Accompagnement</option>
                    
                </select>
            </div>
        </div>
    
        <!-- Champs dynamiques -->
        <div id="dynamic-fields" class="mb-6">
            <!-- Champs dynamiques seront ajoutés ici -->
        </div>
    
        <div class="mt-6">
            <button type="submit" class="bg-[#45C4EB] text-white px-4 py-2 rounded-md hover:bg-[#F58719]" >Ajouter</button>
        </div>
    </form>
    <div class="mt-6 text-center">
        <a href="{{ route('projets.index') }}" class="bg-[#45C4EB] hover:bg-[#F7881B] text-white px-6 py-3 rounded-lg shadow-md transition transform hover:scale-105">
            ⬅ Retour aux projets
        </a>
      </div>
</div>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        const typeTacheSelect = document.getElementById("type_tache");
        const dynamicFields = document.getElementById("dynamic-fields");

        typeTacheSelect.addEventListener("change", function () {
            const selectedType = this.value;
            dynamicFields.innerHTML = "";

            switch (selectedType) {
                case 'ROP':
                    dynamicFields.innerHTML = `
                                      <div x-data="{ statut: '' }">

    <div class="grid grid-cols-2 gap-4">

        <!-- Type ROP -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Type ROP</label>
            <select name="informations[type_rop]" class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200">
                <option value="Simple">Simple</option>
                <option value="Complexe">Complexe</option>
            </select>
        </div>

        <!-- Version ROP -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Version ROP</label>
            <select name="informations[version_rop]" class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200">
                <option value="V1">V1</option>
                <option value="V2">V2</option>
                <option value="V3">V3</option>
                <option value="V4">V4</option>
                <option value="V5">V5</option>
            </select>
        </div>

        <!-- Nombre de BPE -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Nombre de BPE</label>
            <input type="number" required name="informations[nbre_bpe]" min="0"  class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200">
        </div>

        <!-- Statut ROP -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Statut ROP</label>
            <select name="informations[statut_rop]" x-model="statut" class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200">
                <option value="Livré">Livré</option>
                <option value="En cours">En cours</option>
                <option value="Annulation ROP">Annulation ROP</option>
                <option value="Attente Info Supp">Attente Info Supp</option>
                <option value="Attente Validation Syno">Attente Validation Syno</option>
                <option value="Attente Validation Lien résilié">Attente Validation Lien résilié</option>
                <option value="Cable Saturé">Cable Saturé</option>
                <option value="Pop Saturé">Pop Saturé</option>
                <option value="BPE Sensible">BPE Sensible</option>
                <option value="Traité">Traité</option>
                <option value="Date intégration retour terrain OK">Date intégration retour terrain OK</option>
            </select>
        </div>


         <div>
    <label class="block text-sm font-medium text-gray-700">Statut ROP Netgeo</label>
    
    <select 
        name="informations[statut_rop_netgeo]" 
        x-model="statut"
        class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200"
    >
        <option value="">-- Sélectionner un statut --</option>
        <option value="Affecté">Affecté</option>
        <option value="Réservé">Réservé</option>
    </select>
</div>

        <!-- Moment de l'annulation (apparait seulement si Annulation ROP) -->
        <div x-show="statut === 'Annulation ROP'" x-transition class="col-span-2">
            <label class="block text-sm font-medium text-gray-700">Moment de l'annulation</label>
            <select name="informations[moment_annulation]" class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200">
                <option value="Avant production">Avant production</option>
                <option value="Après production">Après production</option>
            </select>
        </div>

        <!-- Date de livraison ROP -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Date de livraison ROP</label>
            <input type="date" name="informations[date_livraison_rop]" class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200">
        </div>

        <!-- Lien résilié -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Lien résilié</label>
            <select name="informations[lien_resilie]" class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200">
                <option value="Oui">Oui</option>
                <option value="Non">Non</option>
            </select>
        </div>

         <div>
    <label class="block text-sm font-medium text-gray-700">
        Longueur extension
    </label>
    <input
        type="number"
        name="informations[capacite]"
        step="0.01"
        min="0"
        class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200"
    >
</div>

        <!-- Liste de BPE et Commentaires restent sur la même ligne -->
        <div class="col-span-2 grid grid-cols-2 gap-4">
            <!-- Liste de BPE -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Liste de BPE</label>
                <textarea name="informations[liste_bpe]" rows="4" class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200"></textarea>
            </div>

            <!-- Commentaires -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Commentaires</label>
                <textarea name="informations[com_rop]" rows="4" class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200"></textarea>
            </div>
        </div>

    </div>
</div>
                    `;
                    break;
                case 'BLO':
                    dynamicFields.innerHTML = `
                     <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Type BLO</label>
                            <select name="informations[type_blo]"  class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200">
                                    <option value="simple">simple</option>
                                    <option value="Complexe">Complexe</option>
                                   
                                </select>

                                
                        </div>
                        <div>
                                <label class="block text-sm font-medium text-gray-700">Version ROP</label>
                                 <select name="informations[version_rop]"  class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200">
                                    <option value="V1">V1</option>
                                    <option value="V2">V2</option>
                                    <option value="V3">V3</option>
                                    <option value="V4">V4</option>
                                    <option value="V5">V5</option>
                                   
                                </select>
                            </div>
                         <div>
                                <label class="block text-sm font-medium text-gray-700">Numero FCI</label>
                                <input type="text" name="informations[num_fci]"  class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200">
                            </div>
                             <div>
                                <label class="block text-sm font-medium text-gray-700">Date de livraison BLO</label>
                                <input type="date" name="informations[date_livraison_blo]"  class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Statut BLO</label>
                                <select name="informations[statut_blo]"  class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200">
                                    <option value="Livré : Dépôt ANNX sur WT">Livré : Dépôt ANNX sur WT</option>
                                    <option value="Attente RETOUR TERRAIN">Attente RETOUR TERRAIN</option>
                                    <option value="En cours de TRAITEMENT">En cours de TRAITEMENT</option>
                                    <option value="Dépôt WEBOP-V1">Dépôt WEBOP-V1</option>
                                    <option value="Dépôt WEBOP-V2">Dépôt WEBOP-V2</option>
                                    <option value="Dépôt WEBOP-V3">Dépôt WEBOP-V3</option>
                                    <option value="Dépôt WEBOP-V1 OK">Dépôt WEBOP-V1 OK</option>
                                    <option value="Dépôt WEBOP-V2 OK">Dépôt WEBOP-V2 OK</option>
                                    <option value="Dépôt WEBOP-V3 OK">Dépôt WEBOP-V3 OK</option>
                                    <option value="Dépôt WEBOP-V1 NOK">Dépôt WEBOP-V1 NOK</option>
                                    <option value="Dépôt WEBOP-V2 NOK">Dépôt WEBOP-V2 NOK</option>
                                    <option value="Retour WEBOP-V1 OK">Dépôt WEBOP-V1 OK</option>
                                    <option value="Retour WEBOP-V2 OK">Dépôt WEBOP-V2 OK</option>
                                    <option value="Retour WEBOP-V3 OK">Dépôt WEBOP-V3 OK</option>
                                    <option value="Retour WEBOP-V1 NOK">Dépôt WEBOP-V1 NOK</option>
                                    <option value="Retour WEBOP-V2 NOK">Dépôt WEBOP-V2 NOK</option>
                                    <option value="Retour WEBOP-V3 NOK">Dépôt WEBOP-V3 NOK</option>
                                </select>
                            </div>
                             

                                <div class="col-span-2">
                                        <label class="block text-sm font-medium text-gray-700">Fichier BLO</label>
                                        <input type="file" name="fichier" accept=".zip, .xls, .xlsx"  class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200">
                                    </div>
                    </div>
                    `;
                    break;
                case 'DOE OPTIQUE':
                    dynamicFields.innerHTML = `
                       <div class="grid grid-cols-2 gap-4">
                        <!-- Colonne 1 -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Date demande</label>
                            <input type="date" name="informations[date_demande_doe]" class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200">
                        </div>
                        
                        <!-- Colonne 2 -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Support hotline</label>
                            <select name="informations[support]"  class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200">
                                <option value="Avec hotline">Avec hotline</option>
                                <option value="Sans hotline">Sans hotline</option>                     
                            </select>
                        </div>
                        
                        <!-- Colonne 1 -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Date integration DOE</label>
                            <input type="date" name="informations[date_integration]" class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200">
                        </div>
                        
                        <!-- Colonne 2 -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Statut DOE</label>
                            <select name="informations[statut_doe]"  class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200">
                                                        <option value="Livré">Livré</option>
                                                        <option value="Incompatibilité">Incompatibilité</option>
                                                        <option value="Attente Info Sup">Attente Info Sup</option>
                                                    
                            </select>
                        </div>
                        
                        <!-- Colonne 1 -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Rectification après inter</label>
                            <select name="informations[rectification]" class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200">
                                <option value="OUI">OUI</option>
                                <option value="NON">NON</option>
                            </select>
                        </div>
                        
                        <!-- Colonne 2 -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nbre BPE</label>
                            <input type="number" name="informations[doe_bpe]" class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Lien Résilié</label>
                        <select name="informations[doe_lien]" class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200">
                                <option value="OUI">OUI</option>
                                <option value="NON">NON</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Commentaires</label>
                            <input type="text" name="informations[doe_com]" class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200">
                        </div>
                    </div>
                    `;
                break;

                case 'Accompagnement':
                    dynamicFields.innerHTML = `
                       <div class="grid grid-cols-2 gap-4">
                        <!-- Colonne 1 -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Type Projet</label>
                        <select name="informations[type_projet_acc]" class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200">
                                <option value="CHAMBRE SECURISEE">CHAMBRE SECURISEE</option>
                                <option value="ACCES NRA">ACCES NRA</option>
                                <option value="LOCAL">LOCAL</option>
                            </select>
                        </div>
                        
                        <!-- Colonne 2 -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Date Dépot</label>
                            <input type="date" name="informations[date_depot]" class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200">
                        </div>
                        
                        <!-- Colonne 1 -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Numéro ticket</label>
                            <input type="text" name="informations[num_ticket]" class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200">
                        </div>
                        
                        <!-- Colonne 2 -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Commentaires</label>
                            <input type="text" name="informations[acc_com]" class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200">
                        </div>
                        
                    </div>
                    `
                break;

                case 'APD GC/DOE GC':
                    dynamicFields.innerHTML = `
                       <div class="grid grid-cols-2 gap-4">
                        <!-- Colonne 1 -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Type </label>
                        <select name="informations[type_prod]" class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200">
                                <option value="APD GC">APD GC</option>
                                <option value="DOE GC">DOE GC</option>
                               
                            </select>
                        </div>
                        
                        <!-- Colonne 2 -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Date Demande</label>
                            <input type="date" name="informations[date_demande_prod]" class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200">
                        </div>
                        
                        <!-- Colonne 1 -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Date de Livraison</label>
                            <input type="date" name="informations[date_livraison_prod]" class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200">
                        </div>
                        
                        <!-- Colonne 2 -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Linéaire du projet</label>
                                <input type="number" name="informations[lineaire]" step="0.01"
                                    class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200">
                            </div>
<div>
                            <label class="block text-sm font-medium text-gray-700">Coordonnées GPS</label>
                            <input type="text" name="informations[coordonnee]" class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Adresse</label>
                            <input type="text" name="informations[adresse]" class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Code postal</label>
                            <input type="text" name="informations[code_postal]" class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Ville</label>
                            <input type="text" name="informations[ville]" class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200">
                        </div>
                    </div>
                    `
                break;
                  
            }
        });
    });
</script>

@endsection
