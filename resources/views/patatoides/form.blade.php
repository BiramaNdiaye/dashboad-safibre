<div class="grid grid-cols-2 gap-4">

    <!-- Type Projet -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Type Projet</label>
        <select name="type_projet"
                class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg">
            <option value="PROD" {{ old('type_projet', $patatoide->type_projet ?? '') == 'PROD' ? 'selected' : '' }}>PROD</option>
            <option value="RATTRAP FCI" {{ old('type_projet', $patatoide->type_projet ?? '') == 'RATTRAP FCI' ? 'selected' : '' }}>RATTRAP FCI</option>
            <option value="AUTRE" {{ old('type_projet', $patatoide->type_projet ?? '') == 'AUTRE' ? 'selected' : '' }}>AUTRE</option>
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
        <select name="site"
                class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg">
            <option value="PROD">PROD</option>
            <option value="RATTRAP FCI">RATTRAP FCI</option>
            <option value="AUTRE">AUTRE</option>
        </select>
    </div>

    <!-- Date Réception -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Date Réception</label>
        <input type="date" name="date_reception" value="{{ old('date_reception', $patatoide->date_reception ?? '') }}"
               class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg">
    </div>

    <!-- Nombre BPE -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Nombre BPE</label>
        <input type="number" name="nbre_bpe" value="{{ old('nbre_bpe', $patatoide->nbre_bpe ?? '') }}"
               class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg">
    </div>

    <!-- Nombre Client -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Nombre Client</label>
        <input type="number" name="nbre_client" value="{{ old('nbre_client', $patatoide->nbre_client ?? '') }}"
               class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg">
    </div>

    <!-- Nombre Cable Ext -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Nombre Cable Ext</label>
        <input type="number" name="nbre_cable_ext" value="{{ old('nbre_cable_ext', $patatoide->nbre_cable_ext ?? '') }}"
               class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg">
    </div>

    <!-- Nombre Racco Client -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Nombre Racco Client</label>
        <input type="number" name="nbre_racco_client" value="{{ old('nbre_racco_client', $patatoide->nbre_racco_client ?? '') }}"
               class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg">
    </div>

    <!-- Statut Patatoide -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Statut Patatoïde</label>
        <select name="statut_patatoide"
                class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg">
            <option value="EN ATTENTE">EN ATTENTE</option>
            <option value="EN COURS">EN COURS</option>
            <option value="LIVRÉ">LIVRÉ</option>
            <option value="VALIDÉ">VALIDÉ</option>
        </select>
    </div>

    <!-- Date Livraison -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Date Livraison Patatoïde</label>
        <input type="date" name="date_liv_patatoide" value="{{ old('date_liv_patatoide', $patatoide->date_liv_patatoide ?? '') }}"
               class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg">
    </div>

    <!-- Validation Covage -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Validation Covage</label>
        <select name="validation_covage"
                class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg">
            <option value="OUI">OUI</option>
            <option value="NON">NON</option>
            <option value="EN ATTENTE">EN ATTENTE</option>
        </select>
    </div>

    <!-- Commentaires -->
    <div class="col-span-2">
        <label class="block text-sm font-medium text-gray-700">Commentaires</label>
        <textarea name="commentaires" rows="3"
                  class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg">{{ old('commentaires', $patatoide->commentaires ?? '') }}</textarea>
    </div>

</div>
