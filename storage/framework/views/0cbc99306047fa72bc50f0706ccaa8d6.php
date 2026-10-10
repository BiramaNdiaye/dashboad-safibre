<?php $__env->startSection('content'); ?>
<h2 class="text-3xl font-extrabold text-center text-gray-800 mb-6 relative">
    <span class="bg-[#45C4EB]  text-transparent bg-clip-text uppercase">
        Modifier  une patatoide
    </span>
    <span class="block w-16 h-1 bg-[#F7881B] mx-auto mt-2 rounded-full"></span>
</h2>
 <?php if(session('success')): ?>
        <div class="bg-green-200 text-green-800 p-2 mb-4 rounded">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <?php if($errors->any()): ?>
        <div class="bg-red-200 text-red-800 p-2 mb-4 rounded">
            <ul>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>
<div class="max-w-4xl mx-auto bg-white shadow-lg rounded-2xl p-6 mt-6">
<form action="<?php echo e(route('patatoides.update',$patatoide)); ?>" method="POST" class="space-y-5">
    <?php echo csrf_field(); ?>
<?php echo method_field('PUT'); ?>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    <!-- Type Projet -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Type Projet</label>
        <select name="type_projet"
                class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg">
            <option value="PROD" <?php echo e(old('type_projet') == 'PROD' ? 'selected' : ''); ?>>PROD</option>
            <option value="RATTRAP FCI" <?php echo e(old('type_projet') == 'RATTRAP FCI' ? 'selected' : ''); ?>>RATTRAP FCI</option>
            <option value="AUTRE" <?php echo e(old('type_projet') == 'AUTRE' ? 'selected' : ''); ?>>AUTRE</option>
        </select>
    </div>

    <!-- Ref Projet -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Réference Projet</label>
        <input type="text" name="ref_projet" value="<?php echo e(old('ref_projet', $patatoide->ref_projet ?? '')); ?>"
               class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg">
    </div>

    <!-- Site -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Site</label>
        <input type="text" name="site" value="<?php echo e(old('site',$patatoide->site ?? '')); ?>"
               class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg">
    </div>

    <!-- Date Réception -->
    <div>
    <label class="block text-sm font-medium text-gray-700">Date Réception</label>
    <input type="date" 
           name="date_reception" 
           value="<?php echo e(old('date_reception', $patatoide->date_reception?->format('Y-m-d') ?? '')); ?>"
           class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg">
</div>


    <!-- Nombre BPE -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Nombre BPE</label>
        <input type="number" name="nbre_bpe" value="<?php echo e(old('nbre_bpe',$patatoide->nbre_bpe ?? '')); ?>"
               class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg">
    </div>

    <!-- Nombre Client -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Nombre Client</label>
        <input type="number" name="nbre_client" value="<?php echo e(old('nbre_client',$patatoide->nbre_client ?? '')); ?>"
               class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg">
    </div>

    <!-- Nombre Cable Ext -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Nombre Cable Ext</label>
        <input type="number" name="nbre_cable_ext" value="<?php echo e(old('nbre_cable_ext',$patatoide->nbre_cable_ext ?? '')); ?>"
               class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg">
    </div>

    <!-- Nombre Racco Client -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Nombre Racco Client</label>
        <input type="number" name="nbre_racco_client" value="<?php echo e(old('nbre_racco_client',$patatoide->nbre_racco_client ?? '')); ?>"
               class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg">
    </div>

    <!-- Statut Patatoide -->
    <div>
    <label class="block text-sm font-medium text-gray-700">Statut Patatoïde</label>
    <select name="statut_patatoide"
            class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg">
        <?php
            $oldStatut = old('statut_patatoide', $patatoide->statut_patatoide ?? '');
        ?>
        <option value="EN COURS" <?php echo e($oldStatut == 'EN COURS' ? 'selected' : ''); ?>>EN COURS</option>
        <option value="LIVRÉ" <?php echo e($oldStatut == 'LIVRÉ' ? 'selected' : ''); ?>>LIVRÉ</option>
        <option value="ATTENTE INFO SUPP" <?php echo e($oldStatut == 'ATTENTE INFO SUPP' ? 'selected' : ''); ?>>ATTENTE INFO SUPP</option>
        <option value="DEPOT KMZ" <?php echo e($oldStatut == 'DEPOT KMZ' ? 'selected' : ''); ?>>DEPOT KMZ</option>
        <option value="TRAITE" <?php echo e($oldStatut == 'TRAITE' ? 'selected' : ''); ?>>TRAITE</option>
        <option value="ANNULE" <?php echo e($oldStatut == 'ANNULE' ? 'selected' : ''); ?>>ANNULE</option>
        <option value="REPRISE" <?php echo e($oldStatut == 'REPRISE' ? 'selected' : ''); ?>>REPRISE</option>
    </select>
</div>


    <!-- Date Livraison -->
    <div>
    <label class="block text-sm font-medium text-gray-700">Date Livraion</label>
    <input type="date" 
           name="date_liv_patatoide" 
           value="<?php echo e(old('date_liv_patatoide', $patatoide->date_liv_patatoide?->format('Y-m-d') ?? '')); ?>"
           class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg">
</div>


    <!-- Validation Covage -->
   <div>
    <label class="block text-sm font-medium text-gray-700">Validation Covage</label>
    <select name="validation_covage"
            class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg">
        <?php
            $oldValidation = old('validation_covage', $patatoide->validation_covage ?? '');
        ?>
        <option value="OUI" <?php echo e($oldValidation == 'OUI' ? 'selected' : ''); ?>>OUI</option>
        <option value="NON" <?php echo e($oldValidation == 'NON' ? 'selected' : ''); ?>>NON</option>
        <option value="EN COURS" <?php echo e($oldValidation == 'EN COURS' ? 'selected' : ''); ?>>EN COURS</option>
    </select>
</div>


    <!-- Commentaires -->
    <div class="col-span-2">
        <label class="block text-sm font-medium text-gray-700">Commentaires</label>
        <textarea name="commentaires" rows="3"
                  class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg"><?php echo e(old('commentaires', $patatoide->commentaires ?? '')); ?></textarea>
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


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/safibrq/dashboard/csmaadministration/resources/views/patatoides/edit.blade.php ENDPATH**/ ?>