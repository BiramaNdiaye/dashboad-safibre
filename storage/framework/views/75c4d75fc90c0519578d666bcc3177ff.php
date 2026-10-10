<?php $__env->startSection('content'); ?>
<div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6 mb-8">
            <div class="flex-1">
                <div class="flex items-center space-x-3 mb-2">
                    <div class="p-2 bg-gradient-to-r from-[#45C4EB] to-blue-500 rounded-xl shadow-lg">
                        <i class="fas fa-project-diagram text-white text-lg"></i>
                    </div>
                    <h1 class="text-2xl md:text-3xl font-bold text-[#45C4EB] ">
                        Liste des FCI NEXLOOP
                    </h1>
                </div>
               
            </div>
            
            <a href="<?php echo e(route('nexloop.fci.create')); ?>" 
               class="group inline-flex items-center space-x-2 bg-[#45C4EB] text-white hover:bg-[#F7881B] font-semibold px-6 py-3 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                <i class="fas fa-plus-circle group-hover:rotate-90 transition-transform duration-300"></i>
                <span>Nouveau FCI</span>
            </a>
</div>
 <?php if(session('success')): ?>
        <div class="mb-6 bg-green-50 border-l-4 border-green-400 p-4 rounded">
            <!-- Même structure que ci-dessus -->
            <div class="flex">
                <!-- ... -->
                <p class="text-sm font-medium text-green-800">
                    <?php echo e(session('success')); ?>

                </p>
                <!-- ... -->
            </div>
        </div>
    <?php endif; ?>
<div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6 mb-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Recherche</h2>
        <form method="GET" action="<?php echo e(route('nexloop.fci.index')); ?>" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Recherche par site -->
                <div>
                    <label for="search_site" class="block text-sm font-medium text-gray-700 mb-1">
                        Site
                    </label>
                    <input type="text" 
                           name="search_site" 
                           id="search_site" 
                           value="<?php echo e($search_site ?? ''); ?>"
                           placeholder="Rechercher par site..."
                           class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200">
                </div>
                
                <!-- Recherche par numéro FCI -->
                <div>
                    <label for="search_numero_fci" class="block text-sm font-medium text-gray-700 mb-1">
                        Numéro FCI
                    </label>
                    <input type="text" 
                           name="search_numero_fci" 
                           id="search_numero_fci" 
                           value="<?php echo e($search_numero_fci ?? ''); ?>"
                           placeholder="Rechercher par numéro FCI..."
                           class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200">
                </div>
                
                <!-- Recherche par type -->
                <div>
                    <label for="search_type" class="block text-sm font-medium text-gray-700 mb-1">
                        Type
                    </label>
                    <select name="search_type" 
                            id="search_type"
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200">
                        <option value="">Tous les types</option>
                        <option value="Simple" <?php echo e(($search_type ?? '') == 'Simple' ? 'selected' : ''); ?>>Simple</option>
                        <option value="Complexe" <?php echo e(($search_type ?? '') == 'Complexe' ? 'selected' : ''); ?>>Complexe</option>
                    </select>
                </div>
            </div>
            
            <div class="flex justify-end space-x-3 pt-2">
                <!-- Bouton Réinitialiser -->
                <a href="<?php echo e(route('nexloop.fci.index')); ?>" 
                   class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg font-medium transition duration-200">
                    Réinitialiser
                </a>
                
                <!-- Bouton Rechercher -->
                <button type="submit"
                        class="bg-[#45C4EB] hover:bg-[#F7881B] text-white px-6 py-2 rounded-lg font-medium transition duration-200 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Rechercher
                </button>
            </div>
        </form>
    </div>
<div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-[#45C4EB] text-white">
                <tr>
                    <th class="px-4 py-4 text-left text-sm font-semibold uppercase tracking-wider">
                        Site
                    </th>
                    <th class="px-4 py-4 text-left text-sm font-semibold uppercase tracking-wider">
                        Type
                    </th>
                    <th class="px-4 py-4 text-left text-sm font-semibold uppercase tracking-wider">
                        Études associées
                    </th>
                    <th class="px-4 py-4 text-left text-sm font-semibold uppercase tracking-wider">
                        Communes
                    </th>
                    <th class="px-4 py-4 text-left text-sm font-semibold uppercase tracking-wider">
                        Numéro FCI
                    </th>
                    <th class="px-4 py-4 text-left text-sm font-semibold uppercase tracking-wider">
                        Client
                    </th>
                    <th class="px-4 py-4 text-left text-sm font-semibold uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200 bg-white">
                <?php $__empty_1 = true; $__currentLoopData = $fcinexloops; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fci): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <!-- Site du FCI -->
                        <td class="px-4 py-4 text-sm font-medium text-gray-900">
                            <?php echo e($fci->site); ?>

                        </td>
                        
                        <!-- Type du FCI -->
                        <td class="px-4 py-4 text-sm">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                <?php echo e($fci->type === 'Simple' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800'); ?>">
                                <?php echo e($fci->type); ?>

                            </span>
                        </td>
                        
                        <!-- Études associées (listées) -->
                        <td class="px-4 py-4 text-sm text-gray-700">
                            <?php if($fci->etudes_list): ?>
                                <div class="space-y-1 max-h-32 overflow-y-auto pr-2">
                                    <?php $__currentLoopData = explode('; ', $fci->etudes_list); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $etude): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(trim($etude)): ?>
                                            <div class="border-l-4 border-[#45C4EB] pl-2 py-1">
                                                <?php echo e($etude); ?>

                                            </div>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            <?php else: ?>
                                <span class="text-gray-400 italic">Aucune étude</span>
                            <?php endif; ?>
                        </td>
                        
                        <!-- Communes et codes postaux -->
                        <td class="px-4 py-4 text-sm text-gray-700">
                            <?php if($fci->communes_list): ?>
                                <div class="space-y-1 max-h-32 overflow-y-auto pr-2">
                                    <?php $__currentLoopData = explode('; ', $fci->communes_list); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $commune): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(trim($commune)): ?>
                                            <div class="py-1"><?php echo e($commune); ?></div>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            <?php else: ?>
                                <span class="text-gray-400 italic">-</span>
                            <?php endif; ?>
                        </td>
                        
                        <!-- Numéro FCI -->
                        <td class="px-4 py-4 text-sm font-medium text-gray-900">
                            <?php echo e($fci->numero_fci); ?>

                        </td>

                          <td class="px-4 py-4 text-sm font-medium text-gray-900">
                            <?php echo e($fci->client); ?>

                        </td>
                        
                        <!-- Actions -->
                        <td class="px-4 py-4 text-sm font-medium">
                            <div class="flex space-x-2">
                                <!-- Bouton Voir le FCI 
                                <a href="<?php echo e(route('nexloop.fci.show', $fci->id)); ?>" 
                                   class="bg-[#45C4EB] hover:bg-[#F7881B] text-white px-3 py-1 rounded-lg text-sm font-medium transition duration-200 flex items-center"
                                   title="Voir les détails">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Détails
                                </a>-->
                                <a href="<?php echo e(route('nexloop.fci.edit', $fci->id)); ?>" 
                                class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-lg text-sm font-medium transition duration-200 flex items-center">
                                    Modifier
                                </a>
                                <form action="<?php echo e(route('nexloop.fci.destroy', $fci->id)); ?>" method="POST" class="inline">
            <?php echo csrf_field(); ?>
            <?php echo method_field('DELETE'); ?>
            <button type="submit" 
                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg text-sm font-medium transition duration-200 flex items-center"
                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce FCI ?')">
                Supprimer
            </button>
        </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="px-4 py-6 text-center text-gray-500">
                            Aucun FCI trouvé
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <?php if($fcinexloops->hasPages()): ?>
        <div class="px-6 py-4 border-t border-gray-200">
            <?php echo e($fcinexloops->links()); ?>

        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/safibrq/dashboard/csmaadministration/resources/views/nexloop/fci/index.blade.php ENDPATH**/ ?>