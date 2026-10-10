<?php $__env->startSection('content'); ?>
<div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-lg mt-10"> 
    <div class="w-full space-y-6"> 
        <div class="text-center">
            <h2 class="mt-4 text-4xl font-extrabold text-gray-900"> 
                <?php echo e(__('Bienvenue sur notre portail client')); ?>

            </h2>
            <img src="<?php echo e(asset('images/csma.png')); ?>" alt="Logo" class="w-64 h-auto mx-auto">
        </div>
        
        <form method="POST" action="<?php echo e(route('login')); ?>" class="mt-6 space-y-4"> 
            <?php echo csrf_field(); ?>

            <!-- Email Input -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">
                    <?php echo e(__('Email')); ?>

                </label>
                <div class="mt-1">
                    <input id="email" type="email" name="email" value="<?php echo e(old('email')); ?>" required autocomplete="email" autofocus
                        class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span class="text-red-500 text-xs mt-1" role="alert"> 
                            <strong><?php echo e($message); ?></strong>
                        </span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <!-- Password Input -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">
                    <?php echo e(__('Mot de passe')); ?>

                </label>
                <div class="mt-1">
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                        class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span class="text-red-500 text-xs mt-1" role="alert"> 
                            <strong><?php echo e($message); ?></strong>
                        </span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            

            <!-- Submit Button -->
            <div class="text-center"> 
                <button type="submit"
                    class="w-1/2 py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-[#F78719] hover:bg-[#F78719] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"> <!-- Changé w-1/4 en w-1/2 et ajusté le padding -->
                    <?php echo e(__('Se connecter')); ?>

                </button>
            </div>

           
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/safibrq/dashboard/csmaadministration/resources/views/auth/login.blade.php ENDPATH**/ ?>