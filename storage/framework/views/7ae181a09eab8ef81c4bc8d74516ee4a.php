<?php $__env->startSection('content'); ?>
<div class="container mx-auto p-4">
    <h2 class="text-6xl font-extrabold text-center text-gray-800 mb-6 relative">
        <span class="bg-[#45C4EB]  text-transparent bg-clip-text ">
            Backlog des DOE
        </span>
        <span class="block w-16 h-1 bg-[#F7881B] mx-auto mt-2 rounded-full"></span>
    </h2>
    <form method="GET" action="<?php echo e(route('doe.index')); ?>">

    <!-- 🔍 Barre de recherche -->
    <div class="mb-6 flex gap-4 items-center">
        <input type="text" name="search" placeholder="🔍 Rechercher par référence ou site..." 
            class="px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:ring-2 w-1/3"
            value="<?php echo e(request('search')); ?>">

        <button type="submit" 
            class="bg-[#45C4EB] hover:bg-[#F7881B] text-white font-semibold px-4 py-2 rounded-lg shadow-md">
            Rechercher
        </button>
    </div>

    <!-- ⭐ Filtres organisés en 2 colonnes -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

        <!-- Colonne 1 -->
        <div class="p-4 border border-[#45C4EB] rounded-lg shadow-sm bg-gray-50"> 
              <div class="space-y-4">

            <!-- Support -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Support</label>
                <select name="support" 
                    class="px-3 py-2 border rounded-lg shadow-sm w-full border-[#45C4EB]">
                    <option value="">-- Support --</option>
                    <option value="Avec hotline" <?php echo e(request('support') == 'Avec hotline' ? 'selected' : ''); ?>>Avec hotline</option>
                    <option value="Sans hotline" <?php echo e(request('support') == 'Sans hotline' ? 'selected' : ''); ?>>Sans hotline</option>
                </select>
            </div>

            <!-- Statut DOE -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Statut DOE</label>
                <select name="statut_doe" 
                    class="px-3 py-2 border rounded-lg shadow-sm w-full border-[#45C4EB]">
                    <option value="">-- Statut DOE --</option>
                    <option value="En cours" <?php echo e(request('statut_doe') == 'En cours' ? 'selected' : ''); ?>>En cours</option>
                    <option value="Livré" <?php echo e(request('statut_doe') == 'Livré' ? 'selected' : ''); ?>>Livré</option>
                    <option value="Incompatibilité" <?php echo e(request('statut_doe') == 'Incompatibilité' ? 'selected' : ''); ?>>Incompatibilité</option>
                    <option value="Attente Info Sup" <?php echo e(request('statut_doe') == 'Attente Info Sup' ? 'selected' : ''); ?>>Attente Info Sup</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Client</label>
                <select name="clients_id" class="px-3 py-2 border rounded-lg shadow-sm w-full border-[#45C4EB]">
                    <option value="">-- Tous les clients --</option>
                    <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($client->id); ?>" <?php echo e(request('clients_id') == $client->id ? 'selected' : ''); ?>>
                            <?php echo e($client->nom); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

        </div>
        </div>
      

        <!-- Colonne 2 : Date intégration -->
        <div class="p-4 border border-[#45C4EB] rounded-lg shadow-sm bg-gray-50">

            <h3 class="text-sm font-semibold text-gray-700 mb-3 flex items-center gap-2">
                <svg class="w-5 h-5 text-[#45C4EB]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Date d’intégration
            </h3>

            <div class="space-y-3">
                <div class="flex items-center space-x-2">
                    <label class="text-xs font-semibold text-gray-700 w-14">Début :</label>
                    <input type="date" name="date_integration_debut" 
                        value="<?php echo e(request('date_integration_debut')); ?>"
                        class="border border-[#45C4EB] rounded-lg p-2 w-full shadow-sm focus:ring-2 focus:ring-[#45C4EB]">
                </div>

                <div class="flex items-center space-x-2">
                    <label class="text-xs font-semibold text-gray-700 w-14">Fin :</label>
                    <input type="date" name="date_integration_fin" 
                        value="<?php echo e(request('date_integration_fin')); ?>"
                        class="border border-[#45C4EB] rounded-lg p-2 w-full shadow-sm focus:ring-2 focus:ring-[#45C4EB]">
                </div>
            </div>

        </div>

    </div>

    <!-- Bouton appliquer -->
    <div class="flex justify-between mb-6">
    <!-- Bouton gauche -->
    <button type="submit"
        class="bg-[#45C4EB] hover:bg-[#F7881B] text-white font-semibold px-6 py-2 rounded-lg shadow-md">
        Appliquer les filtres
    </button>

    <!-- Bouton droite 
    <a href="<?php echo e(route('doe.export', request()->query())); ?>"
       class="bg-[#F7881B] hover:bg-[#45C4EB] text-white font-semibold px-4 py-2 rounded-lg shadow-md transition">
        Exporter en Excel
    </a>
    -->
</div>


</form>
    <div class="mt-6 mb-10">
        <table class="min-w-full bg-white rounded-lg overflow-hidden">
            <thead class="bg-[#45C4EB] text-white">
                <tr class="uppercase">
                    <th class="py-3 px-4 border-b text-left">Référence</th>
                    <th class="py-3 px-4 border-b text-left">Date demande</th>
                    <th class="py-3 px-4 border-b text-left">Support</th>
                    <th class="py-3 px-4 border-b text-left">Date intégration</th>
                    <th class="py-3 px-4 border-b text-left">Statut</th>
                    <th class="py-3 px-4 border-b text-left">Rectification</th>
                    <th class="py-3 px-4 border-b text-left">BPE</th>
                    <th class="py-3 px-4 border-b text-left">Lien</th>
                    
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <?php $__empty_1 = true; $__currentLoopData = $projets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $projet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $doeTask = $projet->taches->firstWhere('typeTache.nom', 'DOE OPTIQUE');
                    ?>
                    
                    <?php if($doeTask): ?>
                        <?php
                            $infos = $doeTask->informations ?? [];
                        ?>
                        <tr class="hover:bg-gray-50 transition duration-200 uppercase">
                            <td class="px-2 py-1 border-b-1 border-[#F7881B] border-dashed"><?php echo e($projet->reference); ?></td>
                            <td class="px-2 py-1 border-b-1 border-[#F7881B] border-dashed"><?php echo e($infos['date_demande_doe'] ?? ''); ?></td>
                            <td class="px-2 py-1 border-b-1 border-[#F7881B] border-dashed"><?php echo e($infos['support'] ?? ''); ?></td>
                            <td class="px-2 py-1 border-b-1 border-[#F7881B] border-dashed"><?php echo e($infos['date_integration'] ?? ''); ?></td>
                            <td class="px-2 py-1 border-b-1 border-[#F7881B] border-dashed"><?php echo e($infos['statut_doe'] ?? ''); ?></td>
                            <td class="px-2 py-1 border-b-1 border-[#F7881B] border-dashed"><?php echo e($infos['rectification'] ?? ''); ?></td>
                            <td class="px-2 py-1 border-b-1 border-[#F7881B] border-dashed"><?php echo e($infos['doe_bpe'] ?? ''); ?></td>
                            <td class="px-2 py-1 border-b-1 border-[#F7881B] border-dashed"><?php echo e($infos['doe_lien'] ?? ''); ?></td>
                            
            
                        </tr>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="9" class="py-4 text-center text-gray-500">Aucun DOE trouvé</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

         <div class="mt-6 flex justify-center mb-10">
            <?php echo e($projets->links('vendor.pagination.tailwind')); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/safibrq/dashboard/csmaadministration/resources/views/doe/index.blade.php ENDPATH**/ ?>