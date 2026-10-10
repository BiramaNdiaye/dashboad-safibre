<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <!-- En-tête -->
    <div class="mb-8">
      <h2 class="text-3xl font-extrabold text-center text-gray-800 mb-6 relative">
    <span class="bg-[#45C4EB]  text-transparent bg-clip-text uppercase">
        Modifier une Etude de faisabilité
    </span>
    <span class="block w-16 h-1 bg-[#F7881B] mx-auto mt-2 rounded-full"></span>
</h2>
    </div>

    <!-- Carte du formulaire -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6">
        <form action="<?php echo e(route('nexloop.etudes.update', $etude->id)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            
            <!-- Grille 2 colonnes -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Commune -->
                <div>
                    <label for="commune" class="block text-sm font-medium text-gray-700 mb-1">
                        Commune *
                    </label>
                    <input type="text" 
                           name="commune" 
                           id="commune" 
                           value="<?php echo e(old('commune', $etude->commune)); ?>"
                           required
                           class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] focus:border-[#45C4EB] transition duration-200">
                    <?php $__errorArgs = ['commune'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                
                <!-- Code postal -->
                <div>
                    <label for="code_postal" class="block text-sm font-medium text-gray-700 mb-1">
                        Code postal *
                    </label>
                    <input type="number" 
                           name="code_postal" 
                           id="code_postal" 
                           value="<?php echo e(old('code_postal', $etude->code_postal)); ?>"
                           required
                           min="0"
                           class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] focus:border-[#45C4EB] transition duration-200">
                    <?php $__errorArgs = ['code_postal'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                
                <!-- Code ENSEI -->
                <div>
                    <label for="code_ensei" class="block text-sm font-medium text-gray-700 mb-1">
                        Code ENSEI *
                    </label>
                    <input type="number" 
                           name="code_ensei" 
                           id="code_ensei" 
                           value="<?php echo e(old('code_ensei', $etude->code_ensei)); ?>"
                           required
                           min="0"
                           class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] focus:border-[#45C4EB] transition duration-200">
                    <?php $__errorArgs = ['code_ensei'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                
                <!-- Numéro d'étude -->
                <div>
                    <label for="numero_etude" class="block text-sm font-medium text-gray-700 mb-1">
                        Numéro d'étude *
                    </label>
                    <input type="text" 
                           name="numero_etude" 
                           id="numero_etude" 
                           value="<?php echo e(old('numero_etude', $etude->numero_etude)); ?>"
                           required
                           class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] focus:border-[#45C4EB] transition duration-200">
                    <?php $__errorArgs = ['numero_etude'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>
            
            <!-- Boutons d'action -->
            <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200 mt-6">
                <a href="<?php echo e(route('nexloop.etudes.index')); ?>" 
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
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/safibrq/dashboard/csmaadministration/resources/views/nexloop/etudes/edit.blade.php ENDPATH**/ ?>