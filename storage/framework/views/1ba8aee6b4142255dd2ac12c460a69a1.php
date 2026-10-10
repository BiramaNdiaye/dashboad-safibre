<?php $__env->startSection('content'); ?>
<h2 class="text-6xl font-extrabold text-center text-gray-800 mb-6 relative">
    <span class="bg-gradient-to-r from-[#45C4EB] to-[#F7881B] text-transparent bg-clip-text uppercase">
        Modifier un client
    </span>
    <span class="block w-16 h-1 bg-[#F7881B] mx-auto mt-2 rounded-full"></span>
</h2>
<div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-lg mt-10">
   

        <?php if($errors->any()): ?>
            <div class="mb-6">
                <ul class="bg-red-500 text-white p-4 rounded-md">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if(session('success')): ?>
            <div class="mb-6">
                <div class="bg-green-500 text-white p-4 rounded-md">
                    <?php echo e(session('success')); ?>

                </div>
            </div>
        <?php endif; ?>
    <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg">
            <div class="w-full space-y-8">

                <!-- Formulaire pour la mise à jour du client -->
            <form action="<?php echo e(route('clients.update', $client->id)); ?>" method="POST" class="bg-white p-8 rounded-xl shadow-lg border border-[#45C4EB] space-y-6">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="nom" class="block text-sm font-medium text-gray-700">Nom client</label>
                        <input type="text" id="nom" name="nom" value="<?php echo e(old('nom', $client->nom)); ?>"  class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200 <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    </div>

                    <div>
                        <label for="reference" class="block text-sm font-medium text-gray-700">Référence</label>
                        <input type="text" id="reference" name="reference" value="<?php echo e(old('reference', $client->reference)); ?>"  class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200 <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="telephone" class="block text-sm font-medium text-gray-700">Téléphone Responsable</label>
                        <input type="text" id="telephone" name="telephone" value="<?php echo e(old('telephone', $client->telephone)); ?>"  class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200 <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    </div>

                    <div>
                        <label for="date_integration" class="block text-sm font-medium text-gray-700">Date d'intégration</label>
                        <input type="date" id="date_integration" name="date_integration" value="<?php echo e(old('date_integration', $client->date_integration)); ?>"  class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200 <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    </div>
                </div>

                <div class="mb-6">
                    <label for="responsable" class="block text-sm font-medium text-gray-700">Responsable</label>
                    <input type="text" id="responsable" name="responsable" value="<?php echo e(old('responsable', $client->responsable)); ?>"  class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200 <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-[#45C4EB] text-white px-4 py-2 rounded-md hover:bg-[#F58719] focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Modifier
                    </button>
                </div>
            </form>
            </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/safibrq/dashboard/csmaadministration/resources/views/clients/edit.blade.php ENDPATH**/ ?>