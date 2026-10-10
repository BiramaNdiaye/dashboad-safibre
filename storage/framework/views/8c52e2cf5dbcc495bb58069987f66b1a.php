<?php $__env->startSection('content'); ?>
<div class="container mx-auto p-4">
    <h2 class="text-6xl font-extrabold text-center text-gray-800 mb-6 relative">
        <span class="bg-[#45C4EB]  text-transparent bg-clip-text ">
            Liste des productions APD GC
        </span>
        <span class="block w-16 h-1 bg-[#F7881B] mx-auto mt-2 rounded-full"></span>
    </h2>
    <form method="GET" action="<?php echo e(route('prodApd.index')); ?>" >
        <div class="mb-6 flex gap-4 items-center">
            <input type="text" name="search" placeholder="🔍 Rechercher par référence ou site..." 
                   class="px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200 w-1/4" 
                   value="<?php echo e(request('search')); ?>">
            <button type="submit" class="bg-[#45C4EB] hover:bg-[#F7881B] text-white font-semibold px-4 py-2 rounded-lg shadow-md transition duration-300 transform hover:scale-105">
                Rechercher
            </button>
        </div>
    </form>
    <div class="mt-6 mb-10">
        <table class="min-w-full bg-white rounded-lg overflow-hidden">
            <thead class="bg-[#45C4EB] text-white">
                <tr class="uppercase">
                    <th class="py-3 px-4 border-b text-left">Référence</th>
                    <th class="py-3 px-4 border-b text-left">Type projet</th>
                    <th class="py-3 px-4 border-b text-left">Date demande</th>
                    <th class="py-3 px-4 border-b text-left">Date livraison</th>
                    <th class="py-3 px-4 border-b text-left">Lineaire projet</th>
                    <th class="py-3 px-4 border-b text-left">Adresse</th>
                    <th class="py-3 px-4 border-b text-left">Code postal</th>
                    <th class="py-3 px-4 border-b text-left">Ville</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $projets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $projet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $doeTask = $projet->taches->firstWhere('typeTache.nom', 'APD GC/DOE GC');
                    ?>
                    
                    <?php if($doeTask): ?>
                        <?php
                            $infos = $doeTask->informations ?? [];
                        ?>
                        <tr>
                            <td class="py-3 px-4 border-b-1 border-[#F7881B] border-dashed"><?php echo e($projet->reference); ?></td>
                            <td class="py-3 px-4 border-b-1 border-[#F7881B] border-dashed"><?php echo e($infos['type_prod'] ?? 'N/A'); ?></td>
                            <td class="py-3 px-4 border-b-1 border-[#F7881B] border-dashed"><?php echo e($infos['date_demande_prod'] ?? 'N/A'); ?></td>
                            <td class="py-3 px-4 border-b-1 border-[#F7881B] border-dashed"><?php echo e($infos['date_livraison_prod'] ?? 'N/A'); ?></td>
                            <td class="py-3 px-4 border-b-1 border-[#F7881B] border-dashed"><?php echo e($infos['lineaire'] ?? 'N/A'); ?></td>
                            <td class="py-3 px-4 border-b-1 border-[#F7881B] border-dashed"><?php echo e($infos['adresse'] ?? 'N/A'); ?></td>
                            <td class="py-3 px-4 border-b-1 border-[#F7881B] border-dashed"><?php echo e($infos['code_postal'] ?? 'N/A'); ?></td>
                            <td class="py-3 px-4 border-b-1 border-[#F7881B] border-dashed"><?php echo e($infos['ville'] ?? 'N/A'); ?></td>
                            
                        </tr>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="9" class="py-4 text-center text-gray-500">Aucun DOE trouvé</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/safibrq/dashboard/csmaadministration/resources/views/prodApd/index.blade.php ENDPATH**/ ?>