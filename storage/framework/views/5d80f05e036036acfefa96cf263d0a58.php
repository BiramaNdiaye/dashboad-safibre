<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <h2 class="font-jakarta text-6xl font-extrabold text-center text-gray-800 mb-6 relative">
        <span class="bg-[#45C4EB]  text-transparent bg-clip-text uppercase">
             Mes Projets
        </span>
        <span class="block w-16 h-1 bg-[#F7881B] mx-auto mt-2 rounded-full"></span>
    </h2>

    <?php if(session('success')): ?>
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
            <p><?php echo e(session('success')); ?></p>
        </div>
    <?php endif; ?>

    <?php if($projets->isEmpty()): ?>
        <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4" role="alert">
            <p>Vous n'avez aucun projet.</p>
        </div>
    <?php else: ?>
  <div class="mt-6 mb-10">
        <form action=" <?php echo e(route('projets.mes-projets')); ?>" method="GET" class="bg-white p-8 rounded-xl shadow-lg">
            
            <!-- Barre de recherche -->
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <div class="p-6 border border-[#45C4EB] rounded-lg shadow-sm bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-700 mb-4 flex items-center gap-2">
                        <svg class="w-6 h-6 text-[#45C4EB]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Date de commande
                    </h3>
    
                    <div class="space-y-4">
                        <div class="flex items-center space-x-4">
                            <label for="commande_debut" class="text-sm font-semibold text-gray-700 w-20">Début :</label>
                            <input type="date" name="commande_debut" id="date_debut" 
                                class="border-[#45C4EB] rounded-lg p-2 w-full shadow-sm focus:ring-2 focus:ring-[#45C4EB] focus:border-transparent"
                                value="<?php echo e(request('commande_debut')); ?>">
                        </div>
    
                        <div class="flex items-center space-x-4">
                            <label for="commande_fin" class="text-sm font-semibold text-gray-700 w-20">Fin :</label>
                            <input type="date" name="commande_fin" id="date_fin" 
                                class="border-[#45C4EB] rounded-lg p-2 w-full shadow-sm focus:ring-2 focus:ring-[#45C4EB] focus:border-transparent"
                                value="<?php echo e(request('commande_fin')); ?>">
                        </div>
                    </div>
                </div>
                <div class="p-6 border border-[#45C4EB] rounded-lg shadow-sm bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-700 mb-4 flex items-center gap-2">
                        <svg class="w-6 h-6 text-[#45C4EB]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Date de livraison
                    </h3>
    
                    <div class="space-y-4">
                        <div class="flex items-center space-x-4">
                            <label for="livraison_debut" class="text-sm font-semibold text-gray-700 w-20">Début :</label>
                            <input type="date" name="livraison_debut" id="date_debut_livraison" 
                                class="border-[#45C4EB] rounded-lg p-2 w-full shadow-sm focus:ring-2 focus:ring-[#45C4EB] focus:border-transparent"
                                value="<?php echo e(request('livraison_debut')); ?>">
                        </div>
    
                        <div class="flex items-center space-x-4">
                            <label for="livraison_fin" class="text-sm font-semibold text-gray-700 w-20">Fin :</label>
                            <input type="date" name="livraison_fin" id="date_fin_livraison" 
                                class="border-[#45C4EB] rounded-lg p-2 w-full shadow-sm focus:ring-2 focus:ring-[#45C4EB] focus:border-transparent"
                                value="<?php echo e(request('livraison_fin')); ?>">
                        </div>
                    </div>
                </div>
    
                <!-- Statut & Client -->
                <div class="p-6 border border-[#45C4EB] rounded-lg shadow-sm bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-700 mb-4 flex items-center gap-2">
                        <svg class="w-6 h-6 text-[#45C4EB]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        Statut & Client
                    </h3>
    
                    <div class="space-y-4">
                        <div class="flex items-center space-x-4">
                            <label for="statut_projet" class="text-sm font-semibold text-gray-700 w-20">Statut :</label>
                            <select name="statut" id="statut" 
                                    class="border-[#45C4EB] rounded-lg p-2 w-full shadow-sm focus:ring-2 focus:ring-[#45C4EB] focus:border-transparent">
                                <option value="">Tous les statuts</option>
                                <option value="En cours" <?php echo e(request('statut') == 'En cours' ? 'selected' : ''); ?>>En cours</option>
                                <option value="Livré" <?php echo e(request('statut') == 'Livré' ? 'selected' : ''); ?>>Livré</option>
                                <option value="Attente Info Supp" <?php echo e(request('statut') == 'Attente Info Supp' ? 'selected' : ''); ?>>Attente Info Supp</option>
                                <option value="Attente Validation Syno" <?php echo e(request('statut') == 'Attente Validation Syno' ? 'selected' : ''); ?>>Attente Validation Syno</option>
                                <option value="Attente Validation Lien résilié" <?php echo e(request('statut') == 'Attente Validation Lien résilié' ? 'selected' : ''); ?>>Attente Validation Lien résilié</option>
                                <option value="Cable Saturé" <?php echo e(request('statut') == 'Cable Saturé' ? 'selected' : ''); ?>>Cable Saturé</option>
                                <option value="Pop Saturé" <?php echo e(request('statut') == 'Pop Saturé' ? 'selected' : ''); ?>>Pop Saturé</option>
                                <option value="BPE Sensible" <?php echo e(request('statut') == 'BPE Sensible' ? 'selected' : ''); ?>>BPE Sensible</option>
                            </select>
                        </div>
                        <?php if (\Illuminate\Support\Facades\Blade::check('hasanyrole', 'operation|Manager|admin')): ?>
                        <div class="flex items-center space-x-4">
                            <label for="clients_id" class="text-sm font-semibold text-gray-700 w-20">Client :</label>
                            <select name="clients_id" id="clients_id" 
                                    class="border-[#45C4EB] rounded-lg p-2 w-full bg-white shadow-sm focus:ring-2 focus:ring-[#45C4EB] focus:border-transparent">
                                <option value="">Tous les clients</option>
                                <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($client->id); ?>" <?php echo e(request('clients_id') == $client->id ? 'selected' : ''); ?>>
                                        <?php echo e($client->nom); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <?php endif; ?>  
                    </div>
                </div>
    
                    </div>
            
                    <!-- Boutons -->
                    
                    <div class="mb-6 mt-6 flex justify-between gap-4 items-center">
    <!-- Barre de recherche + bouton Rechercher -->
                    <div class="flex gap-4 items-center">
                        <input type="text" name="search" placeholder="🔍 Rechercher par référence ou site..." 
                            class="px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200 w-64" 
                            value="<?php echo e(request('search')); ?>">
                        <button type="submit" class="bg-[#45C4EB] hover:bg-[#F7881B] text-white font-semibold px-4 py-2 rounded-lg shadow-md transition duration-300 transform hover:scale-105">
                            Rechercher
                        </button>
                    </div>

    <!-- Boutons Filtrer et Réinitialiser -->
                    <div class="flex gap-4 items-center">
                        <button type="submit" 
                                class="bg-[#45C4EB] hover:bg-[#F7881B] text-white font-semibold px-6 py-2 rounded-lg shadow-md transition duration-300 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                            </svg>
                            <span>Filtrer</span>
                        </button>

                        <a href=" <?php echo e(route('projets.mes-projets')); ?>" 
                        class="bg-gray-400 hover:bg-gray-600 text-white font-semibold px-6 py-2 rounded-lg shadow-md transition duration-300 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            <span>Réinitialiser</span>
                        </a>
                    </div>

           
        </form>
</div>
    <div class="overflow-x-auto rounded-lg shadow-lg p-5">
        <table class="min-w-full bg-white rounded-lg overflow-hidden">
            <thead class="bg-[#45C4EB] text-white">
                <tr>
                    <th class="px-2 py-1 text-left font-semibold uppercase">Nom du site</th>
                    <th class="px-2 py-1 text-left font-semibold uppercase">Référence</th>
                    <th class="px-2 py-1 text-left font-semibold uppercase">Client</th>
                    <th class="px-2 py-1 text-left font-semibold uppercase">Date de commande</th>
                    <th class="px-2 py-1 text-left font-semibold uppercase">Chef de projet</th>
                    <th class="px-2 py-1 text-center font-semibold uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <?php $__currentLoopData = $projets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $projet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="hover:bg-[#F7881B] transition duration-200 uppercase">
                        <td class="px-2 py-1 border-b-1 border-[#F7881B] border-dashed"><?php echo e($projet->nom_site); ?></td>
                        <td class="px-2 py-1 border-b-1 border-[#F7881B] border-dashed"><?php echo e($projet->reference); ?></td>
                        <td class="px-2 py-1 border-b-1 border-[#F7881B] border-dashed"><?php echo e($projet->client?->nom); ?></td>
                        <td class="px-2 py-1 border-b-1 border-[#F7881B] border-dashed"><?php echo e($projet->date_commande); ?></td>
                        <td class="px-2 py-1 border-b-1 border-[#F7881B] border-dashed">
                            <?php echo e($projet->chefProjet ? $projet->chefProjet->name : 'Non attribué'); ?>

                        </td>
                        <td class="px-2 py-1 border-b-1 border-[#F7881B] border-dashed text-center space-x-4">
                            <!-- Icône "Ajouter tâches" -->
                            <a href="<?php echo e(route('taches.create', $projet->id)); ?>" class="text-yellow-500 hover:text-yellow-600 transition duration-200" title="Ajouter tâches">
                                <svg class="w-6 h-6 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                            </a>
    
                            <!-- Icône "Voir les tâches" -->
                            <a href="<?php echo e(route('projets.taches.index', $projet->id)); ?>" class="text-blue-500 hover:text-blue-600 transition duration-200" title="Voir les tâches">
                                <svg class="w-6 h-6 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2 17l4 4 4-4M2 7l4-4 4 4"></path>
                                </svg>
                            </a>
    
                          
                           
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
    <div class="mt-6 flex justify-center mb-10">
        <?php echo e($projets->links('vendor.pagination.tailwind')); ?>

    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/safibrq/dashboard/csmaadministration/resources/views/projets/mes-projets.blade.php ENDPATH**/ ?>