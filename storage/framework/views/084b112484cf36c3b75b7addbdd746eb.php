<?php $__env->startSection('content'); ?>
<h2 class="text-3xl font-extrabold text-center text-gray-800 mb-6 relative">
    <span class="bg-[#45C4EB]  text-transparent bg-clip-text uppercase">
        Ajouter  une Etude de Faisabilite
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


<form action="<?php echo e(route('etudes-faisabilite.store')); ?>" method="POST" class="space-y-5">
    <?php echo csrf_field(); ?>
  
   <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    <!-- Type Projet -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Commune</label>
       <input type="text" name="commune" value="<?php echo e(old('ref_projet', $etudesfai->commune ?? '')); ?>"
               class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg">
    </div>

    <!-- Ref Projet -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Code Postal</label>
        <input type="text" name="code_postal" value="<?php echo e(old('code_postal', $etudesfai->code_postal ?? '')); ?>"
               class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg">
    </div>

    <!-- Site -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Code Ensei</label>
        <input type="text" name="code_ensei" value="<?php echo e(old('etudesfai' , $etudesfai->code_ensei ?? '')); ?>"
               class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg">
    </div>

    <!-- Date Réception -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Numero Etude</label>
         <input type="text" name="numero_etude" value="<?php echo e(old('numero_etude', $etudesfai->numero_etude ?? '')); ?>"
               class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg">
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

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/safibrq/dashboard/csmaadministration/resources/views/nexloop/etudes/create.blade.php ENDPATH**/ ?>