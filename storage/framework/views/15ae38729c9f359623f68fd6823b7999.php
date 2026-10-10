<?php $__env->startSection('content'); ?>
<h2 class="text-3xl font-extrabold text-center text-gray-800 mb-6 relative">
    <span class="bg-[#45C4EB]  text-transparent bg-clip-text uppercase">
        Ajouter  une patatoide
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


<form action="<?php echo e(route('patatoides.store')); ?>" method="POST" class="space-y-5">
    <?php echo csrf_field(); ?>
  
   <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    <!-- Type Projet -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Type Projet</label>
        <select name="type_projet"
                class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg">
            <option value="PROD" <?php echo e(old('type_projet') == 'PROD' ? 'selected' : ''); ?>>PROD</option>
            <option value="RATTRAP" <?php echo e(old('type_projet') == 'RATTRAP ' ? 'selected' : ''); ?>>RATTRAP </option>
            
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
        <input type="text" name="site" value="<?php echo e(old('site')); ?>"
               class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg">
    </div>

    <!-- Date Réception -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Date Réception</label>
        <input type="date" name="date_reception" value="<?php echo e(old('date_reception')); ?>"
               class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg">
    </div>

    <!-- Nombre BPE -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Nombre BPE</label>
        <input type="number" name="nbre_bpe" value="<?php echo e(old('nbre_bpe')); ?>"
               class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg">
    </div>

    <!-- Nombre Client -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Nombre Client</label>
        <input type="number" name="nbre_client" value="<?php echo e(old('nbre_client')); ?>"
               class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg">
    </div>

    <!-- Nombre Cable Ext -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Nombre Cable Ext</label>
        <input type="number" name="nbre_cable_ext" value="<?php echo e(old('nbre_cable_ext')); ?>"
               class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg">
    </div>

    <!-- Nombre Racco Client -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Nombre Racco Client</label>
        <input type="number" name="nbre_racco_client" value="<?php echo e(old('nbre_racco_client')); ?>"
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
        <input type="date" name="date_liv_patatoide" value="<?php echo e(old('date_liv_patatoide')); ?>"
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
                  class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg"><?php echo e(old('commentaires')); ?></textarea>
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

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/safibrq/dashboard/csmaadministration/resources/views/patatoides/create.blade.php ENDPATH**/ ?>