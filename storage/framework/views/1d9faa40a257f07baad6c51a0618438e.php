<?php $__env->startSection('content'); ?>
<div class="container mx-auto p-4">
     <div class="flex flex-col lg:flex-row justify-between items-center mb-8 gap-4">
        <h2 class="text-6xl font-extrabold text-center text-gray-800 mb-6 relative">
            <span class="bg-[#45C4EB] text-transparent bg-clip-text ">
                Liste Déclaration FCI
            </span>
            <span class="block w-16 h-1 bg-[#F7881B] mx-auto mt-2 rounded-full"></span>
        </h2>
            
            <a href="<?php echo e(route('frontals.create')); ?>" class="group bg-white hover:bg-[#45C4EB] text-[#45C4EB] hover:text-white font-semibold px-8 py-4 rounded-xl shadow-lg transition-all duration-300 transform hover:scale-105 hover:shadow-xl border-2 border-[#45C4EB] flex items-center gap-2">
                <svg class="w-5 h-5 group-hover:rotate-90 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Ajouter un FCI
            </a>
        </div>
    
    <?php if(session('success')): ?>
        <div class="bg-green-200 text-green-800 p-2 mb-4 rounded">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>
<div class="mt-6 mb-10">
    
<div class="flex flex-wrap justify-between items-center mb-6 gap-4 bg-white p-4 rounded-lg shadow-sm border border-gray-200">
    <!-- Formulaire de recherche et filtre date -->
    <form action="<?php echo e(route('frontals.index')); ?>" method="GET" class="flex flex-wrap items-center gap-3 w-full md:w-auto">
        <!-- Barre de recherche -->
        <div class="relative flex-1 min-w-[250px]">
            <input type="text" 
                   name="search" 
                   value="<?php echo e(request('search')); ?>" 
                   placeholder="🔍 Rechercher FCI, Code Ensee ou Étude" 
                   class="w-full border border-gray-300 focus:border-[#45C4EB] focus:ring-1 focus:ring-[#45C4EB] rounded-lg py-2 px-3 text-sm placeholder-gray-400 transition duration-200">
        </div>

        <!-- Filtres de date -->
        <div class="flex flex-wrap items-center gap-2">
            <label for="date_from" class="text-sm font-medium text-gray-600">Du :</label>
            <input type="date" 
                   name="date_from" 
                   value="<?php echo e(request('date_from')); ?>" 
                   class="border border-gray-300 rounded-lg py-2 px-3 text-sm focus:border-[#45C4EB] focus:ring-1 focus:ring-[#45C4EB] transition duration-200">
            
            <label for="date_to" class="text-sm font-medium text-gray-600">Au :</label>
            <input type="date" 
                   name="date_to" 
                   value="<?php echo e(request('date_to')); ?>" 
                   class="border border-gray-300 rounded-lg py-2 px-3 text-sm focus:border-[#45C4EB] focus:ring-1 focus:ring-[#45C4EB] transition duration-200">
        </div>

        <!-- Boutons -->
        <div class="flex items-center gap-2">
            <button type="submit" 
                    class="bg-[#45C4EB] hover:bg-[#F7881B] text-white font-semibold text-sm px-4 py-2 rounded-lg shadow-sm transition duration-200">
                Rechercher
            </button>
            <a href="<?php echo e(route('frontals.index')); ?>" 
               class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm px-4 py-2 rounded-lg transition duration-200 shadow-sm">
                Réinitialiser
            </a>
        </div>
    </form>
</div>





</div>
    <table class="min-w-full bg-white rounded-lg overflow-hidden text-sm">
    <thead class="bg-[#45C4EB] text-white text-xs uppercase tracking-wider">
        <tr>
            <th class="py-2 px-3 border-b text-left font-semibold">Type Projet</th>
            <th class="py-2 px-3 border-b text-left font-semibold">Statut FCI</th>
            <th class="py-2 px-3 border-b text-left font-semibold">Date Déclaration</th>
            <th class="py-2 px-3 border-b text-left font-semibold">Numéro FCI</th>
            <th class="py-2 px-3 border-b text-left font-semibold">Numéro FCI Annulation</th>
            <th class="py-2 px-3 border-b text-left font-semibold">Projet</th>
            <th class="py-2 px-3 border-b text-left font-semibold">Nom site</th>
            <th class="py-2 px-3 border-b text-left font-semibold">Codes Ensee / Numéros Étude</th>
            <th class="py-2 px-3 border-b text-left font-semibold">Actions</th>
        </tr>
    </thead>

    <tbody class="divide-y divide-gray-100">
        <?php $__currentLoopData = $frontals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $frontal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr class="hover:bg-gray-50 transition">
                <td class="py-2 px-3"><?php echo e($frontal->type_projet); ?></td>
                <td class="py-2 px-3"><?php echo e($frontal->statut_fci); ?></td>
                <td class="py-2 px-3"><?php echo e($frontal->date_declaration->format('Y-m-d')); ?></td>
                <td class="py-2 px-3"><?php echo e($frontal->numero_fci); ?></td>
                <td class="py-2 px-3"><?php echo e($frontal->numero_fci_annulation); ?></td>
                <td class="py-2 px-3"><?php echo e($frontal->projet->reference ?? ''); ?></td>
                <td class="py-2 px-3"><?php echo e($frontal->projet->nom_site ?? ''); ?></td>
                <td class="py-2 px-3 leading-tight">
                    <?php $__currentLoopData = $frontal->etudes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $etude): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <span class="block text-gray-700"><?php echo e($etude->code_ensee); ?> - <?php echo e($etude->numero_etude); ?></span>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </td>
                <td class="py-2 px-3">
                    <a href="<?php echo e(route('frontals.edit', $frontal)); ?>" 
                       class="text-[#45C4EB] hover:text-[#F7881B] font-medium transition">
                        Éditer
                    </a>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>

    <div class="mt-6 flex justify-center mb-10">
            <?php echo e($frontals->links('vendor.pagination.tailwind')); ?>

        </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/safibrq/dashboard/csmaadministration/resources/views/frontals/index.blade.php ENDPATH**/ ?>