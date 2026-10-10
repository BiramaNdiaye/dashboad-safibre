<?php $__env->startSection('content'); ?>
<style>
    .blo-wrap { overflow-x: auto; border-radius: 12px; box-shadow: 0 4px 16px rgba(0,0,0,0.08), 0 1px 4px rgba(0,0,0,0.05); }
    .blo-table { width: 100%; border-collapse: collapse; background: #fff; font-size: 11px; }

    .blo-table thead tr { background: #45C4EB; }
    .blo-table thead th { padding: 10px 12px; text-align: left; font-size: 10px; font-weight: 700;
                          letter-spacing: 0.8px; text-transform: uppercase; color: #fff; white-space: nowrap; }

    .blo-table tbody tr { border-bottom: 1px dashed #fde4c8; transition: background 0.15s ease; }
    .blo-table tbody tr:last-child { border-bottom: none; }
    .blo-table tbody tr:hover { background: rgba(247,136,27,0.06); }
    .blo-table td { padding: 8px 12px; font-size: 11px; color: #374151;
                    vertical-align: middle; white-space: nowrap; text-transform: uppercase; }

    .blo-ref { color: #45C4EB; font-weight: 700; }

    .fci-pill { display: inline-flex; align-items: center; background: #f0fdf4;
                color: #15803d; font-size: 10px; font-weight: 700;
                padding: 2px 8px; border-radius: 999px; letter-spacing: 0.4px; }

    .statut-badge { display: inline-flex; align-items: center; font-size: 10px; font-weight: 700;
                    padding: 3px 9px; border-radius: 999px; letter-spacing: 0.4px; text-transform: uppercase; }
    .s-termine  { background: #fee2e2; color: #b91c1c; }
    .s-encours  { background: #fff4e8; color: #c2560a; }
    .s-livre    { background: #dcfce7; color: #15803d; }
    .s-attente  { background: #fef3c7; color: #92400e; }
    .s-default  { background: #ede9fe; color: #6d28d9; }

    .blo-empty td { text-align: center; padding: 2rem; color: #9ca3af;
                    font-style: italic; font-size: 12px; text-transform: none; }
</style>
    <div class="bg-white ">
        <h2 class="text-6xl font-extrabold text-center text-gray-800 mb-6 relative">
            <span class="bg-[#45C4EB]  text-transparent bg-clip-text ">
                Backlog BLO
            </span>
            <span class="block w-16 h-1 bg-[#F7881B] mx-auto mt-2 rounded-full"></span>
        </h2>
        
        <div class="mt-6 mb-10">
            <form action="<?php echo e(route('taches.afficheBlo')); ?>" method="GET" class="bg-white p-8 rounded-xl shadow-lg">
                
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="p-6 border border-[#45C4EB] rounded-lg shadow-sm bg-gray-50">
                        <h3 class="text-lg font-semibold text-gray-700 mb-4 flex items-center gap-2">
                            <svg class="w-6 h-6 text-[#45C4EB]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Date de livraison
                        </h3>
        
                        <div class="space-y-4">
                            <div class="flex items-center space-x-4">
                                <label for="date_debut" class="text-sm font-semibold text-gray-700 w-20">Début :</label>
                                <input type="date" name="date_debut" id="date_debut_livraison" 
                                    class="border-[#45C4EB] rounded-lg p-2 w-full shadow-sm focus:ring-2 focus:ring-[#45C4EB] focus:border-transparent"
                                    value="<?php echo e(request('date_debut')); ?>">
                            </div>
        
                            <div class="flex items-center space-x-4">
                                <label for="date_fin" class="text-sm font-semibold text-gray-700 w-20">Fin :</label>
                                <input type="date" name="date_fin" id="date_fin_livraison" 
                                    class="border-[#45C4EB] rounded-lg p-2 w-full shadow-sm focus:ring-2 focus:ring-[#45C4EB] focus:border-transparent"
                                    value="<?php echo e(request('date_fin')); ?>">
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
                                    <option value="Livré : Dépôt ANNX sur WT" <?php echo e(request('statut') == 'Livré : Dépôt ANNX sur WT' ? 'selected' : ''); ?>>Livré : Dépôt ANNX sur WT</option>
                                    <option value="Attente RETOUR TERRAIN" <?php echo e(request('statut') == 'Attente RETOUR TERRAIN' ? 'selected' : ''); ?>>Attente RETOUR TERRAIN</option>
                                    <option value="En cours de TRAITEMENT" <?php echo e(request('statut') == 'En cours de TRAITEMENT' ? 'selected' : ''); ?>>En cours de TRAITEMENT</option>
                                    <option value="Dépôt WEBOP-V1" <?php echo e(request('statut') == 'Dépôt WEBOP-V1' ? 'selected' : ''); ?>>Dépôt WEBOP-V1</option>
                                    <option value="Dépôt WEBOP-V2" <?php echo e(request('statut') == 'Dépôt WEBOP-V2' ? 'selected' : ''); ?>>Dépôt WEBOP-V2</option>
                                    <option value="Dépôt WEBOP-V3" <?php echo e(request('statut') == 'Dépôt WEBOP-V3' ? 'selected' : ''); ?>>Dépôt WEBOP-V3</option>
                                    <option value="Dépôt WEBOP-V1 OK" <?php echo e(request('statut') == 'Dépôt WEBOP-V1 OK' ? 'selected' : ''); ?>>Dépôt WEBOP-V1 OK</option>
                                    <option value="Dépôt WEBOP-V2 OK" <?php echo e(request('statut') == 'Dépôt WEBOP-V2 OK' ? 'selected' : ''); ?>>Dépôt WEBOP-V2 OK</option>
                                    <option value="Dépôt WEBOP-V3 OK" <?php echo e(request('statut') == 'Dépôt WEBOP-V3 OK' ? 'selected' : ''); ?>>Dépôt WEBOP-V3 OK</option>
                                    <option value="Dépôt WEBOP-V1 NOK" <?php echo e(request('statut') == 'Dépôt WEBOP-V1 NOK' ? 'selected' : ''); ?>>Dépôt WEBOP-V1 NOK</option>
                                    <option value="Dépôt WEBOP-V2 NOK" <?php echo e(request('statut') == 'Dépôt WEBOP-V2 NOK' ? 'selected' : ''); ?>>Dépôt WEBOP-V2 NOK</option>
                                    <option value="Retour WEBOP-V1 OK" <?php echo e(request('statut') == 'Retour WEBOP-V1 OK' ? 'selected' : ''); ?>>Retour WEBOP-V1 OK</option>
                                    <option value="Retour WEBOP-V2 OK" <?php echo e(request('statut') == 'Retour WEBOP-V2 OK' ? 'selected' : ''); ?>>Retour WEBOP-V2 OK</option>
                                    <option value="Retour WEBOP-V3 OK" <?php echo e(request('statut') == 'Retour WEBOP-V3 OK' ? 'selected' : ''); ?>>Retour WEBOP-V3 OK</option>
                                    <option value="Retour WEBOP-V1 NOK " <?php echo e(request('statut') == 'Retour WEBOP-V1 NOK' ? 'selected' : ''); ?>>Retour WEBOP-V1 NOK</option>
                                    <option value="Retour WEBOP-V2 NOK" <?php echo e(request('statut') == 'Retour WEBOP-V2 NOK' ? 'selected' : ''); ?>>Retour WEBOP-V2 NOK</option>
                                    <option value="Retour WEBOP-V3 NOK" <?php echo e(request('statut') == 'Retour WEBOP-V3 NOK' ? 'selected' : ''); ?>>Retour WEBOP-V3 NOK</option>
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

        <a href="<?php echo e(route('taches.afficheBlo')); ?>" 
           class="bg-gray-400 hover:bg-gray-600 text-white font-semibold px-6 py-2 rounded-lg shadow-md transition duration-300 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
            </svg>
            <span>Réinitialiser</span>
        </a>
    </div>
</div>
            </form>
        </div>
     
         <div class="blo-wrap">
    <table class="blo-table">
        <thead>
            <tr>
                <th>Référence</th>
                <th>Site</th>
                <th>Type BLO</th>
                <th>N° FCI</th>
                <th>Date de livraison</th>
                <th>Statut BLO</th>
            </tr>
        </thead>
        <tbody>
            <?php $hasRows = false; ?>

            <?php $__currentLoopData = $projets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $projet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $hasBloTask   = false;
                    $type_blo     = '—';
                    $num_fci      = null;
                    $date_livraison = null;
                    $statut_blo   = '';
                ?>

                <?php $__currentLoopData = $projet->taches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tache): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($tache->typeTache->nom == 'BLO'): ?>
                        <?php
                            $hasBloTask     = true;
                            $type_blo       = $tache->informations['type_blo'] ?? '—';
                            $num_fci        = $tache->informations['num_fci'] ?? null;
                            $date_livraison = $tache->informations['date_livraison_blo'] ?? null;
                            $statut_blo     = $tache->informations['statut_blo'] ?? '';
                        ?>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <?php if($hasBloTask): ?>
                    <?php
                        $hasRows = true;
                        $statutClass = match(true) {
                            str_contains(strtolower($statut_blo), 'terminé')  => 's-termine',
                            str_contains(strtolower($statut_blo), 'en cours') => 's-encours',
                            str_contains(strtolower($statut_blo), 'livré')    => 's-livre',
                            str_contains(strtolower($statut_blo), 'attente')  => 's-attente',
                            default => 's-default',
                        };
                    ?>
                    <tr>
                        <td><span class="blo-ref"><?php echo e($projet->reference); ?></span></td>
                        <td><?php echo e($projet->nom_site); ?></td>
                        <td><?php echo e($type_blo); ?></td>
                        <td>
                            <?php if($num_fci): ?>
                                <span class="fci-pill"><?php echo e($num_fci); ?></span>
                            <?php else: ?>
                                <span style="color:#d1d5db;">—</span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo e($date_livraison ?? 'Non livré'); ?></td>
                        <td>
                            <?php if($statut_blo): ?>
                                <span class="statut-badge <?php echo e($statutClass); ?>"><?php echo e($statut_blo); ?></span>
                            <?php else: ?>
                                <span style="color:#d1d5db;">—</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <?php if(!$hasRows): ?>
                <tr class="blo-empty">
                    <td colspan="6">Aucune tâche BLO trouvée.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
        <div class="mt-6 flex justify-center mb-10">
            <?php echo e($projets->links('vendor.pagination.tailwind')); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/safibrq/dashboard/csmaadministration/resources/views/corbeille-blo/index.blade.php ENDPATH**/ ?>