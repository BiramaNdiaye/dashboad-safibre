<?php $__env->startSection('content'); ?>
<h2 class="text-6xl font-extrabold text-center text-gray-800 mb-6 relative">
    <span class="bg-[#45C4EB]  text-transparent bg-clip-text uppercase">
        Modifier  une tâche
    </span>
    <span class="block w-16 h-1 bg-[#F7881B] mx-auto mt-2 rounded-full"></span>
</h2>
<div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-lg mt-10">
   
    <form action="<?php echo e(route('taches.update', $tache->id)); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
    
        <!-- Affichage des erreurs de validation -->
        <?php if($errors->any()): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            <ul>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
        <?php endif; ?>
    
       <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
    <!-- Informations du projet -->
    <div class="mx-2">
        <label for="projet_reference" class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200">Référence du projet</label>
        <input type="text" name="projet_reference" value="<?php echo e($tache->projet->reference); ?>" class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200"" readonly>
    </div>
    <div class="mx-2">
        <label for="projet_nom" class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200">Nom du projet</label>
        <input type="text" name="projet_nom" value="<?php echo e($tache->projet->nom_site); ?>" class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200"" readonly>
    </div>
    <div class="mx-2">
        <label for="chef_projet" class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200">Chef du projet</label>
        <input type="text" name="chef_projet" value="<?php echo e($tache->projet->chefProjet->name); ?>" class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200"" readonly>
    </div> 

    <!-- Type de tâche -->
    <div class="mx-2">
        <label for="type_tache" class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200">Type de tâche</label>
        <select id="type_tache" name="type_tache" class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200"">
            <option value="">Sélectionnez un type</option>
            <option value="ROP" <?php echo e(old('type_tache', $tache->type_tache) == 'ROP' ? 'selected' : ''); ?>>ROP</option>
            <option value="BLO" <?php echo e(old('type_tache', $tache->type_tache) == 'BLO' ? 'selected' : ''); ?>>BLO</option>
            <option value="DOE OPTIQUE" <?php echo e(old('type_tache', $tache->type_tache) == 'DOE OPTIQUE' ? 'selected' : ''); ?>>DOE OPTIQUE</option>
            <option value="Accompagnement" <?php echo e(old('type_tache', $tache->type_tache) == 'Accompagnement' ? 'selected' : ''); ?>>Accompagnement</option>
            <option value="APD GC/DOE GC" <?php echo e(old('type_tache', $tache->type_tache) == 'APD GC/DOE GC' ? 'selected' : ''); ?>>APD GC/DOE GC</option>
          
        </select>
    </div>
</div>
    
        <!-- Champs dynamiques -->
        <div id="dynamic-fields" class="mb-6"></div>
    
        <!-- Bouton de soumission -->
        <div class="mt-6">
            <button type="submit" class="w-1/4 px-4 py-2 bg-[#45C4EB] text-white rounded-md hover:bg-[#F58719] transition duration-200">Mettre à jour</button>
        </div>
    </form>
</div>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        const typeTacheSelect = document.getElementById("type_tache");
        const dynamicFields = document.getElementById("dynamic-fields");

        // Fonction pour générer les champs dynamiques
        function generateFields(type, data = {}) {
            dynamicFields.innerHTML = "";
            switch (type) {
                case 'ROP':
                    dynamicFields.innerHTML = `
                   <div x-data="{ statut: '<?php echo e(old('informations.statut_rop', $rop->informations['statut_rop'] ?? '')); ?>' }">
                   <div x-data="{ statutNetgeo: '<?php echo e(old('informations.statut_rop_netgeo', $rop->informations['statut_rop_netgeo'] ?? '')); ?>' }">
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">Type ROP</label>
            <select name="informations[type_rop]" class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200">
                <option value="simple" ${data.type_rop === 'simple' ? 'selected' : ''}>Simple</option>
                <option value="Complexe" ${data.type_rop === 'Complexe' ? 'selected' : ''}>Complexe</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Version ROP</label>
            <select name="informations[version_rop]" class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200">
                <option value="V1" ${data.version_rop === 'V1' ? 'selected' : ''}>V1</option>
                <option value="V2" ${data.version_rop === 'V2' ? 'selected' : ''}>V2</option>
                <option value="V3" ${data.version_rop === 'V3' ? 'selected' : ''}>V3</option>
                <option value="V4" ${data.version_rop === 'V4' ? 'selected' : ''}>V4</option>
                <option value="V5" ${data.version_rop === 'V5' ? 'selected' : ''}>V5</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Nombre de BPE</label>
            <input type="number" name="informations[nbre_bpe]" value="${data.nbre_bpe || ''}" class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Statut ROP</label>
            <select name="informations[statut_rop]" x-model="statut" class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200">
                <option value="Livré" ${data.statut_rop === 'Livré' ? 'selected' : ''}>Livré</option>
                <option value="En cours" ${data.statut_rop === 'En cours' ? 'selected' : ''}>En cours</option>
                <option value="Annulation ROP" ${data.statut_rop === 'Annulation ROP' ? 'selected' : ''}>Annulation ROP</option>
                <option value="Attente Info Supp" ${data.statut_rop === 'Attente Info Supp' ? 'selected' : ''}>Attente Info Supp</option>
                <option value="Attente Validation Syno" ${data.statut_rop === 'Attente Validation Syno' ? 'selected' : ''}>Attente Validation Syno</option>
                <option value="Attente Validation Lien résilié" ${data.statut_rop === 'Attente Validation Lien résilié' ? 'selected' : ''}>Attente Validation Lien résilié</option>
                <option value="Cable Saturé" ${data.statut_rop === 'Cable Saturé' ? 'selected' : ''}>Cable Saturé</option>
                <option value="Pop Saturé" ${data.statut_rop === 'Pop Saturé' ? 'selected' : ''}>Pop Saturé</option>
                <option value="BPE Sensible" ${data.statut_rop === 'BPE Sensible' ? 'selected' : ''}>BPE Sensible</option>
                <option value="Traité" ${data.statut_rop === 'Traité' ? 'selected' : ''}>Traité</option>
                <option value="Date intégration retour terrain OK" ${data.statut_rop === 'Date intégration retour terrain OK' ? 'selected' : ''}>Date intégration retour terrain OK</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Statut ROP Netgeo</label>
            <select name="informations[statut_rop_netgeo]" x-model="statut_rop_netgeo" class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200">
              <option value="" ${!data.statut_rop_netgeo ? 'selected' : ''}>-- Sélectionner un statut --</option>      
            <option value="Affecté" ${data.statut_rop_netgeo === 'Affecté' ? 'selected' : ''}>Affecté</option>
                <option value="Réservé" ${data.statut_rop_netgeo === 'Réservé' ? 'selected' : ''}>Réservé</option>
              </select> 
        </div>

        <div x-show="statut === 'Annulation ROP'" x-transition class="col-span-2">
            <label class="block text-sm font-medium text-gray-700">Moment de l'annulation</label>
            <select name="informations[moment_annulation]" class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200">
                <option value="Avant production" ${data.moment_annulation === 'Avant production' ? 'selected' : ''}>Avant production</option>
                <option value="Après production" ${data.moment_annulation === 'Après production' ? 'selected' : ''}>Après production</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Date de livraison ROP</label>
            <input type="date" name="informations[date_livraison_rop]" value="${data.date_livraison_rop || ''}" class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Lien résilié</label>
            <select name="informations[lien_resilie]" class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200">
                <option value="Oui" ${data.lien_resilie === 'Oui' ? 'selected' : ''}>Oui</option>
                <option value="Non" ${data.lien_resilie === 'Non' ? 'selected' : ''}>Non</option>
            </select>
        </div>
        <div>
    <label class="block text-sm font-medium text-gray-700">Longueur extension</label>
    <input
        type="number"
        name="informations[capacite]"
        step="0.01"
        min="0"
        value="${data.capacite ?? ''}"
        class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200"
    >
</div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Liste de BPE</label>
            <textarea 
                name="informations[liste_bpe]"
                rows="4"
                class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200"
            >${data.liste_bpe || ''}</textarea>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Commentaires</label>
            <textarea 
                name="informations[com_rop]" 
                rows="4"
                class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200"
            >${data.com_rop || ''}</textarea>
        </div>
    </div>
</div>
                    `;
                    break;
                case 'BLO':
                    dynamicFields.innerHTML = `
                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Type BLO</label>
                                <select name="informations[type_blo]" class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200"">
                                    <option value="simple" ${data.type_blo === 'simple' ? 'selected' : ''}>Simple</option>
                                    <option value="Complexe" ${data.type_blo === 'Complexe' ? 'selected' : ''}>Complexe</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Numéro FCI</label>
                                <input type="text" name="informations[num_fci]" value="${data.num_fci|| ''}" class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200"">
                            </div>
                             <div>
                                <label class="block text-sm font-medium text-gray-700">Version ROP</label>
                                 <select name="informations[version_rop]" value="${data.version_rop|| ''}" class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200">
                                    <option value="V1" ${data.version_rop === 'V1' ? 'selected' : ''}>V1</option>
                                    <option value="V2" ${data.version_rop === 'V2' ? 'selected' : ''}>V2</option>
                                    <option value="V3" ${data.version_rop === 'V3' ? 'selected' : ''}>V3</option>
                                    <option value="V4" ${data.version_rop === 'V4' ? 'selected' : ''}>V4</option>
                                    <option value="V5" ${data.version_rop === 'V5' ? 'selected' : ''}>V5</option>
                                   
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Date de livraison BLO</label>
                                <input type="date" name="informations[date_livraison_blo]" value="${data.date_livraison_blo || ''}" class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200"">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Statut BLO</label>
                                <select name="informations[statut_blo]" value="${data.statut_blo || ''}" class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200"">
                                    <option value="Livré : Dépôt ANNX sur WT" ${data.statut_blo === 'Livré : Dépôt ANNX sur WT' ? 'selected' : ''}>Livré : Dépôt ANNX sur WT</option>
                                    <option value="Attente RETOUR TERRAIN" ${data.statut_blo === 'Attente RETOUR TERRAIN' ? 'selected' : ''}>Attente RETOUR TERRAIN</option>
                                    <option value="En cours de TRAITEMENT" ${data.statut_blo === 'En cours de TRAITEMENT' ? 'selected' : ''}>En cours de TRAITEMENT</option>
                                    <option value="Dépôt WEBOP-V1" ${data.statut_blo === 'Dépôt WEBOP-V1' ? 'selected' : ''}>Dépôt WEBOP-V1</option>
                                    <option value="Dépôt WEBOP-V2" ${data.statut_blo === 'Dépôt WEBOP-V2' ? 'selected' : ''}>Dépôt WEBOP-V2</option>
                                    <option value="Dépôt WEBOP-V3" ${data.statut_blo === 'Dépôt WEBOP-V3' ? 'selected' : ''}>Dépôt WEBOP-V3</option>
                                    <option value="Dépôt WEBOP-V1 OK" ${data.statut_blo === 'Dépôt WEBOP-V1 OK' ? 'selected' : ''}>Dépôt WEBOP-V1 OK</option>
                                    <option value="Dépôt WEBOP-V2 OK" ${data.statut_blo === 'Dépôt WEBOP-V2 OK' ? 'selected' : ''}>Dépôt WEBOP-V2 OK</option>
                                    <option value="Dépôt WEBOP-V3 OK" ${data.statut_blo === 'Dépôt WEBOP-V3 OK' ? 'selected' : ''}>Dépôt WEBOP-V3 OK</option>
                                    <option value="Dépôt WEBOP-V1 NOK" ${data.statut_blo === 'Dépôt WEBOP-V1 NOK' ? 'selected' : ''}>Dépôt WEBOP-V1 NOK</option>
                                    <option value="Dépôt WEBOP-V2 NOK" ${data.statut_blo === 'Dépôt WEBOP-V2 NOK' ? 'selected' : ''}>Dépôt WEBOP-V2 NOK</option>
                                    <option value="Retour WEBOP-V1 OK" ${data.statut_blo === 'Retour WEBOP-V1 OK' ? 'selected' : ''}>Dépôt WEBOP-V1 OK</option>
                                    <option value="Retour WEBOP-V2 OK" ${data.statut_blo === 'Retour WEBOP-V2 OK' ? 'selected' : ''}>Dépôt WEBOP-V2 OK</option>
                                    <option value="Retour WEBOP-V3 OK" ${data.statut_blo === 'Retour WEBOP-V3 OK' ? 'selected' : ''}>Dépôt WEBOP-V3 OK</option>
                                    <option value="Retour WEBOP-V1 NOK" ${data.statut_blo === 'Retour WEBOP-V1 NOK' ? 'selected' : ''}>Dépôt WEBOP-V1 NOK</option>
                                    <option value="Retour WEBOP-V2 NOK" ${data.statut_blo === 'Retour WEBOP-V2 NOK' ? 'selected' : ''}>Dépôt WEBOP-V2 NOK</option>
                                    <option value="Retour WEBOP-V3 NOK" ${data.statut_blo === 'Retour WEBOP-V3 NOK' ? 'selected' : ''}>Dépôt WEBOP-V3 NOK</option>
                                </select>
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
        <input type="date" name="informations[date_demande_doe]" value="${data.date_demande_doe || ''}" class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200">
    </div>
    
    <!-- Colonne 2 -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Support hotline</label>
        <select name="informations[support]"  value="${data.support || ''}" class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200">
            <option value="Avec hotline" ${data.support === 'Avec hotline' ? 'selected' : ''}>Avec hotline</option>
            <option value="Sans hotline" ${data.support === 'Sans hotline' ? 'selected' : ''}>Sans hotline</option>                     
         </select>
    </div>
    
    <!-- Colonne 1 -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Date integration DOE</label>
        <input type="date" name="informations[date_integration]" value="${data.date_integration || ''}" class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200">
    </div>
    
    <!-- Colonne 2 -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Statut DOE</label>
        <select name="informations[statut_doe]" value="${data.statut_doe || ''}"  class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200">
                                    <option value="Livré" ${data.statut_doe === 'Livré' ? 'selected' : ''}>Livré</option>
                                    <option value="Incompatibilité" ${data.statut_doe === 'Incompatibilité' ? 'selected' : ''}>Incompatibilité</option>
                                    <option value="Attente Info Sup" ${data.statut_doe === 'Attente Info Sup' ? 'selected' : ''}>Attente Info Sup</option>
                                   
         </select>
    </div>
    
    <!-- Colonne 1 -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Rectification après inter</label>
        <select name="informations[rectification]" value="${data.rectification || ''}" class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200">
            <option value="OUI" ${data.rectification=== 'OUI' ? 'selected' : ''}>OUI</option>
            <option value="NON" ${data.rectification === 'NON' ? 'selected' : ''}>NON</option>
        </select>
    </div>
    
    <!-- Colonne 2 -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Nbre BPE</label>
        <input type="number" name="informations[doe_bpe]" value="${data.doe_bpe || ''}" class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200">
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Lien Résilié</label>
       <select name="informations[doe_lien]" value="${data.doe_lien || ''}" class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200">
             <option value="OUI" ${data.doe_lien=== 'OUI' ? 'selected' : ''}>OUI</option>
            <option value="NON" ${data.doe_lien === 'NON' ? 'selected' : ''}>NON</option>
        </select>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Commentaires</label>
        <input type="text" name="informations[doe_com]" value="${data.doe_com || ''}" class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200">
    </div>
</div>
 `;
break;
case 'Accompagnement':
    dynamicFields.innerHTML = `
        <div class="grid grid-cols-2 gap-4">
             <div>
                            <label class="block text-sm font-medium text-gray-700">Type Projet</label>
                        <select name="informations[type_projet_acc]" value="${data.type_projet_acc || ''}" class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200">
                                <option value="CHAMBRE SECURISEE">CHAMBRE SECURISEE</option>
                                <option value="ACCES NRA" ${data.type_projet_acc=== 'ACCES NRA' ? 'selected' : ''}>ACCES NRA</option>
                                <option value="LOCAL" ${data.type_projet_acc=== 'LOCAL' ? 'selected' : ''}>LOCAL</option>
                            </select>
                        </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Date Dépot</label>
                <input type="date" name="informations[duree]" value="${data.date_depot || ''}" class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200"">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Numéro ticket</label>
                <input type="text" name="informations[responsable]" value="${data.num_ticket || ''}" class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200"">
            </div>

             <div>
             <label class="block text-sm font-medium text-gray-700">Commentaires</label>
             <input type="text" name="informations[acc_com]" value="${data.acc_com || ''}" class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200">
            </div>
        </div>
    `;
    break;
    case 'APD GC/DOE GC':
                    dynamicFields.innerHTML = `
                       <div class="grid grid-cols-2 gap-4">
                        <!-- Colonne 1 -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Type </label>
                        <select name="informations[type_prod]" value="${data.type_prod || ''}"  class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200">
                                <option value="APD GC" ${data.type_prod=== 'APD GC' ? 'selected' : ''}>APD GC</option>
                                <option value="DOE GC" ${data.type_prod=== 'DOE GC' ? 'selected' : ''}>DOE GC</option>
                               
                            </select>
                        </div>
                        
                        <!-- Colonne 2 -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Date Demande</label>
                            <input type="date" name="informations[date_demande_prod]" value="${data.date_demande_prod || ''}" class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200">
                        </div>
                        
                        <!-- Colonne 1 -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Date de Livraison</label>
                            <input type="date" name="informations[date_livraison_prod]" value="${data.date_livraison_prod || ''}" class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200">
                        </div>
                        
                        <!-- Colonne 2 -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Linéaire du projet</label>
                                <input type="number" name="informations[lineaire]" value="${data.lineaire || ''}" step="0.01"
                                    class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200">
                            </div>

                             <div>
                                <label class="block text-sm font-medium text-gray-700">Coordonnées</label>
                                <input type="text" name="informations[coordonnee]" value="${data.coordonnee || ''}" step="0.01"
                                    class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200">
                            </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Adresse</label>
                            <input type="text" name="informations[adresse]" value="${data.adresse || ''}" class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Code postal</label>
                            <input type="text" name="informations[code_postal]" value="${data.code_postal || ''}" class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Ville</label>
                            <input type="text" name="informations[ville]" value="${data.ville || ''}" class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200">
                        </div>
                    </div>
                    `
                break;

            }
        }

        // Charger les champs dynamiques avec les données existantes
        const existingData = JSON.parse('<?php echo json_encode(old('informations', $tache->informations ?? []), 512) ?>');
        generateFields(typeTacheSelect.value, existingData);

        // Mettre à jour les champs dynamiques lorsque le type de tâche change
        typeTacheSelect.addEventListener("change", function () {
            generateFields(this.value, existingData);
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/safibrq/dashboard/csmaadministration/resources/views/taches/edit.blade.php ENDPATH**/ ?>