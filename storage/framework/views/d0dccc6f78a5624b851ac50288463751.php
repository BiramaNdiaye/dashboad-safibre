<?php $__env->startSection('content'); ?>
<style>
    .rop-wrap { overflow-x: auto; border-radius: 12px; box-shadow: 0 4px 16px rgba(0,0,0,0.08), 0 1px 4px rgba(0,0,0,0.05); margin-top: 1.5rem; }
    .rop-table { width: 100%; border-collapse: collapse; background: #fff; font-size: 11px; }

    .rop-table thead tr { background: #45C4EB; }
    .rop-table thead th { padding: 10px 12px; text-align: left; font-size: 10px; font-weight: 700;
                          letter-spacing: 0.8px; text-transform: uppercase; color: #fff;
                          white-space: nowrap; }

    .rop-table tbody tr { border-bottom: 1px dashed #fde4c8; transition: background 0.15s ease; }
    .rop-table tbody tr:last-child { border-bottom: none; }
    .rop-table tbody tr:hover { background: rgba(247,136,27,0.06); }
    .rop-table td { padding: 8px 12px; font-size: 11px; color: #374151; vertical-align: middle;
                    white-space: nowrap; text-transform: uppercase; }
    .rop-table td.center { text-align: center; }

    /* Référence highlight */
    .rop-ref { color: #45C4EB; font-weight: 700; }

    /* Version pill */
    .version-pill { display: inline-flex; align-items: center; background: #e0f2fe;
                    color: #075985; font-size: 10px; font-weight: 700;
                    padding: 2px 8px; border-radius: 999px; letter-spacing: 0.4px; }

    /* Statut badges */
    .statut-badge { display: inline-flex; align-items: center; font-size: 10px; font-weight: 700;
                    padding: 3px 9px; border-radius: 999px; letter-spacing: 0.4px; text-transform: uppercase; }
    .s-termine   { background: #fee2e2; color: #b91c1c; }
    .s-encours   { background: #fff4e8; color: #c2560a; }
    .s-livre     { background: #dcfce7; color: #15803d; }
    .s-annule    { background: #f3f4f6; color: #4b5563; }
    .s-default   { background: #ede9fe; color: #6d28d9; }

    /* Lien résilié */
    .lien-oui { color: #b91c1c; font-weight: 700; }
    .lien-non { color: #9ca3af; font-style: italic; }

    /* Empty state */
    .rop-empty td { text-align: center; padding: 2rem; color: #9ca3af; font-style: italic; font-size: 12px; text-transform: none; }
</style>
<div class="bg-white">
    <h2 class="text-5xl font-extrabold text-center text-gray-800 mb-6 relative">
        <span class="bg-[#45C4EB] text-transparent bg-clip-text ">
            Backlog ROP
        </span>
        <span class="block w-16 h-1 bg-[#F7881B] mx-auto mt-2 rounded-full"></span>
    </h2>
    <div class="bg-white shadow-md rounded-lg p-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6">
                <!-- Première case : Nombre de projets livrés -->
                <div class="bg-blue-50 p-6 rounded-lg text-center hover:shadow-lg transition-shadow duration-300 relative">
                    <div class="flex justify-center mb-4">
                        <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <p class="text-lg font-semibold text-blue-800 mb-2">Rop En Cours</p>
                    <p class="text-3xl font-bold text-blue-900"><?php echo e($nombreCableSature); ?></p>
                    <!-- Ligne en bas -->
                    <div class="absolute bottom-0 left-0 right-0 h-1 bg-blue-600 rounded-b-lg"></div>
                </div>
        
                <!-- Deuxième case : Nombre de projets en cours -->
                <div class="bg-green-50 p-6 rounded-lg text-center hover:shadow-lg transition-shadow duration-300 relative">
                    <div class="flex justify-center mb-4">
                        <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <p class="text-lg font-semibold text-green-800 mb-2">Rop En Attente Info</p>
                    <p class="text-3xl font-bold text-green-900"><?php echo e($nombreAttenteInfoSupp); ?></p>
                    <!-- Ligne en bas -->
                    <div class="absolute bottom-0 left-0 right-0 h-1 bg-green-600 rounded-b-lg"></div>
                </div>
        
                <!-- Troisième case : Nombre de projets traités -->
                <div class="bg-purple-50 p-6 rounded-lg text-center hover:shadow-lg transition-shadow duration-300 relative">
                    <div class="flex justify-center mb-4">
                        <svg class="w-10 h-10 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <p class="text-lg font-semibold text-purple-800 mb-2">Attente Validation Syno</p>
                    <p class="text-3xl font-bold text-purple-900"><?php echo e($nombreAttenteValidationSyno); ?></p>
                    <!-- Ligne en bas -->
                    <div class="absolute bottom-0 left-0 right-0 h-1 bg-purple-600 rounded-b-lg"></div>
                </div>

                <div class="bg-blue-50 p-6 rounded-lg text-center hover:shadow-lg transition-shadow duration-300 relative">
                    <div class="flex justify-center mb-4">
                        <svg class="w-10 h-10 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <p class="text-lg font-semibold text-orange-800 mb-2">Rop Livrées</p>
                    <p class="text-3xl font-bold text-orange-900">  <?php echo e($nombreRopLivrees); ?></p>
                    <!-- Ligne en bas -->
                    <div class="absolute bottom-0 left-0 right-0 h-1 bg-orange-600 rounded-b-lg"></div>
                </div> 
        
                <!-- Quatrième case : Nombre de projets à traiter  nombreRopLivrees-->
                <div class="bg-orange-50 p-6 rounded-lg text-center hover:shadow-lg transition-shadow duration-300 relative">
                    <div class="flex justify-center mb-4">
                        <svg class="w-10 h-10 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <p class="text-lg font-semibold text-orange-800 mb-2">Total Rop</p>
                    <p class="text-3xl font-bold text-orange-900">  <?php echo e($nombreRop); ?></p>
                    <!-- Ligne en bas -->
                    <div class="absolute bottom-0 left-0 right-0 h-1 bg-orange-600 rounded-b-lg"></div>
                </div> 

                
            </div>
        </div>
    <!-- Formulaire de filtrage -->
    <div class="mt-6 mb-12">
        <form action="<?php echo e(route('taches.afficheRop')); ?>" method="GET" class="bg-white p-8 rounded-xl shadow-lg">
            
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
                                <option value="Annulation ROP" <?php echo e(request('statut') == 'Annulation ROP' ? 'selected' : ''); ?>>Annulation ROP</option>
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
                         <?php if (\Illuminate\Support\Facades\Blade::check('hasanyrole', ['admin', 'Manager','operation'])): ?>
                         <a href="<?php echo e(route('projets.rop.export', request()->query())); ?>"
                            class="inline-flex items-center bg-[#F7881B] hover:bg-[#45C4EB] text-white font-medium px-4 py-2 rounded-lg transition-colors duration-200 shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                </svg>
                                Exporter les ROP
                            </a>
                              <?php endif; ?> 
                        <a href="<?php echo e(route('taches.afficheRop')); ?>" 
                        class="bg-gray-400 hover:bg-gray-600 text-white font-semibold px-6 py-2 rounded-lg shadow-md transition duration-300 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            <span>Réinitialiser</span>
                        </a>
                    </div>

           
        </form>
    </div>



    
    <!-- Tableau des ROP -->
   <div class="rop-wrap">
    <table class="rop-table">
        <thead>
            <tr>
                <th>Référence</th>
                <th>Site</th>
                <th>Client</th>
                <th>Type ROP</th>
                <th>Version</th>
                <th>Statut ROP</th>
               
                <th>Date livraison</th>
               
            </tr>
        </thead>
        <tbody>
            <?php $hasRows = false; ?>

            <?php $__currentLoopData = $projets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $projet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php $__currentLoopData = $projet->taches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tache): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(isset($tache->typeTache) && $tache->typeTache->nom == 'ROP'): ?>
                        <?php
                            $hasRows = true;
                            $informations  = is_array($tache->informations) ? $tache->informations : json_decode($tache->informations, true);
                            $type_rop      = $informations['type_rop'] ?? '—';
                            $version_rop   = $informations['version_rop'] ?? null;
                            $statut_rop    = $informations['statut_rop'] ?? $informations['Statut_Rop'] ?? '';
                            $date_livraison= $informations['date_livraison_rop'] ?? null;
                            $lien_resilie  = $informations['lien_resilie'] ?? null;

                            $statutClass = match(true) {
                                str_contains(strtolower($statut_rop), 'terminé') => 's-termine',
                                str_contains(strtolower($statut_rop), 'en cours') => 's-encours',
                                str_contains(strtolower($statut_rop), 'livré')   => 's-livre',
                                str_contains(strtolower($statut_rop), 'annul')   => 's-annule',
                                default => 's-default',
                            };
                        ?>

                        <tr>
                            <td><span class="rop-ref"><?php echo e($projet->reference); ?></span></td>
                            <td><?php echo e($projet->nom_site); ?></td>
                            <td><?php echo e($projet->client?->nom ?? '—'); ?></td>
                            <td><?php echo e($type_rop); ?></td>
                            <td class="center">
                                <?php if($version_rop): ?>
                                    <span class="version-pill"><?php echo e($version_rop); ?></span>
                                <?php else: ?>
                                    <span style="color:#d1d5db;">—</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($statut_rop): ?>
                                    <span class="statut-badge <?php echo e($statutClass); ?>"><?php echo e($statut_rop); ?></span>
                                <?php else: ?>
                                    <span style="color:#d1d5db;">—</span>
                                <?php endif; ?>
                            </td>
                            
                            <td><?php echo e($date_livraison ?? 'Non livré'); ?></td>
                            
                        </tr>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <?php if(!$hasRows): ?>
                <tr class="rop-empty">
                    <td colspan="9">Aucune tâche ROP trouvée.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

  <?php if($projets->hasPages()): ?>
    <div class="mt-6 flex justify-center mb-10">
        <?php echo e($projets->links('vendor.pagination.tailwind')); ?>

    </div>
<?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/safibrq/dashboard/csmaadministration/resources/views/corbeille-rop/index.blade.php ENDPATH**/ ?>