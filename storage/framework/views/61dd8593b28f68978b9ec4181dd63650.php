<?php $__env->startSection('content'); ?>
<style>
    .tbl-wrap { overflow-x: auto; border-radius: 12px; box-shadow: 0 4px 16px rgba(0,0,0,0.08), 0 1px 4px rgba(0,0,0,0.05); }
    .proj-table { width: 100%; border-collapse: collapse; background: #fff; font-size: 12px; }

    /* Header */
    .proj-table thead tr { background: #45C4EB; }
    .proj-table thead th { padding: 10px 12px; text-align: left; font-size: 10px; font-weight: 700;
                           letter-spacing: 0.8px; text-transform: uppercase; color: #fff;
                           border-bottom: none; white-space: nowrap; }
    .proj-table thead th.center { text-align: center; }

    /* Rows */
    .proj-table tbody tr { transition: background 0.15s ease; border-bottom: 1px dashed #fde4c8; }
    .proj-table tbody tr:last-child { border-bottom: none; }
    .proj-table tbody tr:hover { background: rgba(247,136,27,0.06); }
    .proj-table td { padding: 8px 12px; font-size: 11px; color: #374151; vertical-align: middle; white-space: nowrap; }
    .proj-table td.center { text-align: center; }

    /* Statut badges */
    .statut-badge { display: inline-flex; align-items: center; font-size: 10px; font-weight: 700;
                    padding: 3px 9px; border-radius: 999px; letter-spacing: 0.4px; text-transform: uppercase; }
    .s-termine  { background: #fee2e2; color: #b91c1c; }
    .s-encours  { background: #fff4e8; color: #c2560a; }
    .s-livre    { background: #dcfce7; color: #15803d; }
    .s-atraiter { background: #fef3c7; color: #92400e; }
    .s-traite   { background: #ede9fe; color: #6d28d9; }
    .s-default  { background: #f3f4f6; color: #4b5563; }

    /* Tâches select */
    .tache-select { border: 0.5px solid #e5e7eb; border-radius: 6px; padding: 4px 8px;
                    font-size: 11px; color: #374151; background: #f9fafb;
                    width: 100%; max-width: 180px; cursor: pointer; outline: none; }
    .tache-select:focus { border-color: #45C4EB; }
    .no-tache { font-size: 11px; color: #9ca3af; font-style: italic; }

    /* Action icons */
    .actions { display: flex; align-items: center; justify-content: center; gap: 6px; }
    .act-btn { display: inline-flex; align-items: center; justify-content: center;
               width: 28px; height: 28px; border-radius: 6px; border: none;
               cursor: pointer; transition: background 0.15s, color 0.15s;
               background: transparent; text-decoration: none; }
    .act-btn svg { width: 14px; height: 14px; }
    .act-btn:hover { background: #f3f4f6; }

    .act-add   { color: #d97706; } .act-add:hover   { background: #fef3c7 !important; }
    .act-tasks { color: #0284c7; } .act-tasks:hover { background: #e0f2fe !important; }
    .act-view  { color: #16a34a; } .act-view:hover  { background: #dcfce7 !important; }
    .act-edit  { color: #2563eb; } .act-edit:hover  { background: #dbeafe !important; }
    .act-del   { color: #dc2626; } .act-del:hover   { background: #fee2e2 !important; }
    .act-dis   { color: #d1d5db; cursor: not-allowed; }

    /* Checkbox */
    .proj-table input[type="checkbox"] { width: 13px; height: 13px; accent-color: #45C4EB; cursor: pointer; }
</style>
<div class="bg-white  text-center">
    <?php if(session('success')): ?>
    <div x-data="{ show: true }" x-show="show" x-transition 
         class="flex items-center justify-between bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded-lg shadow-md mb-6">
        <!-- Icône -->
        <div class="flex items-center space-x-2">
            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m0 5.8V19a2 2 0 01-2 2H7a2 2 0 01-2-2V7a2 2 0 012-2h4"></path>
            </svg>
            <span class="text-sm font-medium"><?php echo e(session('success')); ?></span>
        </div>

        <!-- Bouton de fermeture -->
        <button @click="show = false" class="text-green-700 hover:text-green-900 focus:outline-none">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>
<?php endif; ?>


    <div class="overflow-x-auto   mt-1">
        <h2 class="text-6xl font-extrabold text-center text-gray-800 mb-6 relative">
            <span class="bg-[#45C4EB] text-transparent bg-clip-text ">
                Backlog des Projets
            </span>
            <span class="block w-16 h-1 bg-[#F7881B] mx-auto mt-2 rounded-full"></span>
        </h2>
        
        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Première case : Nombre de projets livrés -->
                <div class="bg-blue-50 p-6 rounded-lg text-center hover:shadow-lg transition-shadow duration-300 relative">
                    <div class="flex justify-center mb-4">
                        <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <p class="text-lg font-semibold text-blue-800 mb-2">Projets Livrés</p>
                    <p class="text-3xl font-bold text-blue-900"><?php echo e($nombreProjetsLivre); ?></p>
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
                    <p class="text-lg font-semibold text-green-800 mb-2">Projets En Cours</p>
                    <p class="text-3xl font-bold text-green-900"><?php echo e($nombreProjetsEncours); ?></p>
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
                    <p class="text-lg font-semibold text-purple-800 mb-2">Projets Traités</p>
                    <p class="text-3xl font-bold text-purple-900"><?php echo e($nombreProjetsTraites); ?></p>
                    <!-- Ligne en bas -->
                    <div class="absolute bottom-0 left-0 right-0 h-1 bg-purple-600 rounded-b-lg"></div>
                </div>
        
                <!-- Quatrième case : Nombre de projets à traiter -->
                <div class="bg-orange-50 p-6 rounded-lg text-center hover:shadow-lg transition-shadow duration-300 relative">
                    <div class="flex justify-center mb-4">
                        <svg class="w-10 h-10 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <p class="text-lg font-semibold text-orange-800 mb-2">Projets total</p>
                    <p class="text-3xl font-bold text-orange-900"><?php echo e($projetTotal); ?></p>
                    <!-- Ligne en bas -->
                    <div class="absolute bottom-0 left-0 right-0 h-1 bg-orange-600 rounded-b-lg"></div>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg  mb-6">
            <div class="flex justify-between items-center">
                
                <!-- Bouton Créer un projet -->
              
                <a href="<?php echo e(route('projets.create')); ?>" 
                   class="bg-[#45C4EB] hover:bg-[#F7881B] text-white font-semibold px-6 py-3 rounded-lg shadow-md transition duration-300 transform hover:scale-105">
                     Créer un projet
                </a>
               
                 <?php if (\Illuminate\Support\Facades\Blade::check('hasanyrole', ['admin', 'Manager','operation'])): ?>
                <a href="<?php echo e(route('projets.filter', array_merge(request()->all(), ['export' => 'true']))); ?>"  class="bg-[#45C4EB] hover:bg-[#F7881B] text-white font-semibold px-6 py-3 rounded-lg shadow-md transition duration-300 transform hover:scale-105">
                    Exporter en Excel
                </a>
                 <?php endif; ?> 
                <!-- Barre de recherche -->
                <div class="relative">
                    <form action="<?php echo e(route('projets.search')); ?>" method="GET" class="flex items-center space-x-2">
                        <input type="text" name="search" placeholder="🔍 Rechercher par référence ou site..." 
                               class="px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200" 
                               value="<?php echo e(request('search')); ?>">
                        <button type="submit" class="bg-[#45C4EB] hover:bg-[#F7881B] text-white font-semibold px-4 py-2 rounded-lg shadow-md transition duration-300 transform hover:scale-105">
                            Rechercher
                        </button>
                    </form>
                </div>
            </div>
        
            <!-- Filtrage -->
            <div class="mt-6">
                <form action="<?php echo e(route('projets.filter')); ?>" method="GET" class="bg-white p-8 rounded-xl shadow-lg">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Date de commande -->
                        <div class="p-6 border border-[#45C4EB] rounded-lg shadow-sm bg-gray-50">
                            <h3 class="text-lg font-semibold text-gray-700 mb-4 flex items-center gap-2">
                                <svg class="w-6 h-6 text-[#45C4EB]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                Date de commande
                            </h3>
                            <div class="space-y-4">
                                <div class="flex items-center space-x-2">
                                    <label for="date_debut" class="text-sm font-semibold text-gray-700 w-16">Début :</label>
                                    <input type="date" name="date_debut" id="date_debut"
                                           class="border-[#45C4EB] rounded-lg p-2 w-full shadow-sm focus:ring-2 focus:ring-[#45C4EB] focus:border-transparent">
                                </div>
                                
                                <div class="flex items-center space-x-2">
                                    <label for="date_fin" class="text-sm font-semibold text-gray-700 w-16">Fin :</label>
                                    <input type="date" name="date_fin" id="date_fin" 
                                           class="border-[#45C4EB] rounded-lg p-2 w-full shadow-sm focus:ring-2 focus:ring-[#45C4EB] focus:border-transparent"
                                           value="<?php echo e(request('date_fin')); ?>">
                                </div>
                            </div>
                            
                        </div>
            
  <!-- Date de livraison -->
                            <div class="p-6 border border-[#45C4EB] rounded-lg shadow-sm bg-gray-50">
                                <h3 class="text-lg font-semibold text-gray-700 mb-4 flex items-center gap-2">
                                    <svg class="w-6 h-6 text-[#45C4EB]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Date de livraison
                                </h3>

                                <div class="space-y-4">
                                    <div class="flex items-center space-x-4">
                                        <label for="date_debut_livraison" class="text-sm font-semibold text-gray-700 w-20">Début :</label>
                                        <input type="date" name="date_debut_livraison" id="date_debut_livraison" 
                                            class="border-[#45C4EB] rounded-lg p-2 w-full shadow-sm focus:ring-2 focus:ring-[#45C4EB] focus:border-transparent"
                                            value="<?php echo e(request('date_debut_livraison')); ?>">
                                    </div>

                                    <div class="flex items-center space-x-4">
                                        <label for="date_fin_livraison" class="text-sm font-semibold text-gray-700 w-20">Fin :</label>
                                        <input type="date" name="date_fin_livraison" id="date_fin_livraison" 
                                            class="border-[#45C4EB] rounded-lg p-2 w-full shadow-sm focus:ring-2 focus:ring-[#45C4EB] focus:border-transparent"
                                            value="<?php echo e(request('date_fin_livraison')); ?>">
                                    </div>
                                </div>
                            </div>

                            <!-- Statut & Client -->
                           <div class="p-6 border border-[#45C4EB] rounded-lg shadow-sm bg-gray-50">
    <h3 class="text-lg font-semibold text-gray-700 mb-4 flex items-center gap-2">
        <svg class="w-6 h-6 text-[#45C4EB]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
        </svg>
        Filtres
    </h3>

    <div class="space-y-4">
        <!-- Filtre Statut -->
        <div class="flex items-center space-x-4">
            <label for="statut_projet" class="text-sm font-semibold text-gray-700 w-20">Statut :</label>
            <select name="statut_projet" id="statut_projet" 
                    class="w-full px-3 py-2 border border-[#45C4EB] rounded-lg focus:ring-2 focus:ring-[#45C4EB] focus:border-transparent transition-all duration-200 appearance-none bg-white bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyNCIgaGVpZ2h0PSIyNCIgdmlld0JveD0iMCAwIDI0IDI0IiBmaWxsPSJub25lIiBzdHJva2U9IiM0NTVDRUUiIHN0cm9rZS13aWR0aD0iMiIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIiBjbGFzcz0ibHVjaWRlIGx1Y2lkZS1jaGV2cm9uLWRvd24iPjxwYXRoIGQ9Im03IDE1IDUgNSA1LTUiLz48L3N2Zz4=')] bg-no-repeat bg-[center_right_0.5rem]">
                <option value="">Tous</option>
                <?php $__currentLoopData = $statuts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $statut): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($statut); ?>" <?php echo e(request('statut_projet') == $statut ? 'selected' : ''); ?>>
                        <?php echo e(ucfirst($statut)); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <!-- Filtre Client -->
        <div class="flex items-center space-x-4">
            <label for="clients_id" class="text-sm font-semibold text-gray-700 w-20">Client :</label>
            <select name="clients_id" id="clients_id" 
                    class="w-full px-3 py-2 border border-[#45C4EB] rounded-lg focus:ring-2 focus:ring-[#45C4EB] focus:border-transparent transition-all duration-200 appearance-none bg-white bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyNCIgaGVpZ2h0PSIyNCIgdmlld0JveD0iMCAwIDI0IDI0IiBmaWxsPSJub25lIiBzdHJva2U9IiM0NTVDRUUiIHN0cm9rZS13aWR0aD0iMiIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIiBjbGFzcz0ibHVjaWRlIGx1Y2lkZS1jaGV2cm9uLWRvd24iPjxwYXRoIGQ9Im03IDE1IDUgNSA1LTUiLz48L3N2Zz4=')] bg-no-repeat bg-[center_right_0.5rem]">
                <option value="">Tous les clients</option>
                <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($client->id); ?>" <?php echo e(request('clients_id') == $client->id ? 'selected' : ''); ?>>
                        <?php echo e($client->nom); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <!-- Nouveau filtre Chef de projet -->
        <div class="flex items-center space-x-4">
            <label for="chef_projet_id" class="text-sm font-semibold text-gray-700 w-20">Chef :</label>
            <select name="chef_projet_id" id="chef_projet_id" 
                    class="w-full px-3 py-2 border border-[#45C4EB] rounded-lg focus:ring-2 focus:ring-[#45C4EB] focus:border-transparent transition-all duration-200 appearance-none bg-white bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyNCIgaGVpZ2h0PSIyNCIgdmlld0JveD0iMCAwIDI0IDI0IiBmaWxsPSJub25lIiBzdHJva2U9IiM0NTVDRUUiIHN0cm9rZS13aWR0aD0iMiIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIiBjbGFzcz0ibHVjaWRlIGx1Y2lkZS1jaGV2cm9uLWRvd24iPjxwYXRoIGQ9Im03IDE1IDUgNSA1LTUiLz48L3N2Zz4=')] bg-no-repeat bg-[center_right_0.5rem]">
                <option value="">Tous les chefs de projets</option>
                <?php $__currentLoopData = $chefsProjet; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chef): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($chef->id); ?>" <?php echo e(request('chef_projet_id') == $chef->id ? 'selected' : ''); ?>>
                        <?php echo e($chef->name); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
    </div>
</div>
           
    <div class="flex gap-4">
        <button type="submit" 
                class="bg-[#45C4EB] hover:bg-[#F7881B] text-white font-semibold px-6 py-2 rounded-lg shadow-md transition duration-300 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
            </svg>
            <span>Filtrer</span>
        </button>

        <a href="<?php echo e(route('projets.index')); ?>" 
           class="bg-gray-400 hover:bg-gray-600 text-white font-semibold px-6 py-2 rounded-lg shadow-md transition duration-300 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
            </svg>
            <span>Réinitialiser</span>
        </a>
    </div>

    
    
</div>
                </form>

                
               <?php if($projets->count()): ?>
                <div class="mt-6 px-4 py-3 bg-blue-50 border border-blue-100 rounded-lg inline-flex items-center text-[#45C4EB] text-sm font-medium animate-fade-in">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <?php echo e($projets->total()); ?> projet<?php echo e($projets->total() > 1 ? 's' : ''); ?> trouvé<?php echo e($projets->total() > 1 ? 's' : ''); ?>.
                </div>
                    <?php else: ?>
                        <div class="mt-6 px-4 py-3 bg-red-50 border border-red-100 rounded-lg inline-flex items-center text-red-600 text-sm font-medium animate-fade-in">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Aucun projet trouvé avec les filtres sélectionnés.
                        </div>
                    <?php endif; ?>

            </div>
            
        </div>
        
      

<form method="POST" action="<?php echo e(route('projets.changeStatus')); ?>">
    <?php echo csrf_field(); ?>

   <div class="flex items-center gap-4 mb-6">
    <select 
        name="new_status" 
        required 
        class="border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-[#45C4EB] focus:border-[#45C4EB] outline-none transition-all shadow-sm"
    >
        <option value="" disabled selected>-- Nouveau statut --</option>
        
        <option value="En cours">En cours</option>
        <option value="Livré">Livré</option>
        <option value="Terminé">Terminé</option>
        <option value="Traité">Traité</option>
    </select>

    <button 
        type="submit" 
        class="bg-[#45C4EB] hover:bg-[#3AB0D6] text-white px-5 py-2.5 rounded-lg text-sm font-medium transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-[#45C4EB] focus:ring-opacity-50"
    >
        Changer le statut des projets sélectionnés
    </button>
</div>

   <div class="tbl-wrap">
    <table class="proj-table">
        <thead>
            <tr>
                <th style="width:36px;"><input type="checkbox" id="select-all"></th>
                <th>Nom site</th>
                <th>Référence</th>
                <th>Date commande</th>
                <th class="center">Statut</th>
                <th class="center">Tâches</th>
                <th class="center">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $projets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $projet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $statutMap = [
                        'Terminé'   => 's-termine',
                        'En cours'  => 's-encours',
                        'Livré'     => 's-livre',
                        'A Traiter' => 's-atraiter',
                        'Traité'    => 's-traite',
                    ];
                    $statutClass = $statutMap[$projet->statut_projet] ?? 's-default';

                    $canManage = $projet->chefProjet &&
                        (auth()->user()->id === $projet->chefProjet->id
                         || auth()->user()->hasRole('admin')
                         || auth()->user()->hasRole('Manager'));
                ?>

                <tr>
                    
                    <td class="center">
                        <input type="checkbox" name="selected_ids[]" value="<?php echo e($projet->id); ?>">
                    </td>

                    
                    <td class="uppercase"><?php echo e($projet->nom_site); ?></td>

                    
                    <td class="uppercase" style="color:#45C4EB; font-weight:600;"><?php echo e($projet->reference); ?></td>

                    
                    <td><?php echo e($projet->date_commande); ?></td>

                    
                    <td class="center">
                        <span class="statut-badge <?php echo e($statutClass); ?>"><?php echo e($projet->statut_projet); ?></span>
                    </td>

                    
                    <td class="center">
                        <?php if($projet->taches->count()): ?>
                            <select class="tache-select">
                                <?php $__currentLoopData = $projet->taches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tache): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $isRop  = optional($tache->typeTache)->nom === 'ROP';
                                        $version = $isRop ? ($tache->informations['version_rop'] ?? '?') : '';
                                    ?>
                                    <option><?php echo e(($tache->typeTache->nom ?? 'Inconnu') . $version . ' ' . $tache->nom); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        <?php else: ?>
                            <span class="no-tache">Aucune tâche</span>
                        <?php endif; ?>
                    </td>

                    
                    <td>
                        <div class="actions">

                            
                            <?php if($canManage): ?>
                                <a href="<?php echo e(route('taches.create', $projet->id)); ?>" class="act-btn act-add" title="Ajouter une tâche">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                                </a>
                            <?php else: ?>
                                <span class="act-btn act-dis" title="Non autorisé">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                                </span>
                            <?php endif; ?>

                            
                            <a href="<?php echo e(route('projets.taches.index', $projet->id)); ?>" class="act-btn act-tasks" title="Voir les tâches">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                            </a>

                            
                            <a href="<?php echo e(route('projets.show', $projet->id)); ?>" class="act-btn act-view" title="Voir le projet">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </a>

                            
                            <?php if($canManage): ?>
                                <a href="<?php echo e(route('projets.edit', $projet->id)); ?>" class="act-btn act-edit" title="Modifier le projet">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                            <?php else: ?>
                                <span class="act-btn act-dis" title="Non autorisé">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </span>
                            <?php endif; ?>

                            
                            <?php if (\Illuminate\Support\Facades\Blade::check('hasanyrole', ['admin', 'Manager', 'operation'])): ?>
                                <button type="button" class="act-btn act-del btn-delete"
                                        data-id="<?php echo e($projet->id); ?>" title="Supprimer">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            <?php else: ?>
                                <span class="act-btn act-dis" title="Non autorisé">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </span>
                            <?php endif; ?>

                        </div>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>
</form>

<?php $__currentLoopData = $projets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $projet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <form id="delete-form-<?php echo e($projet->id); ?>" 
        action="<?php echo e(route('projets.destroy', $projet->id)); ?>" 
        method="POST" 
        style="display: none;">
        <?php echo csrf_field(); ?>
        <?php echo method_field('DELETE'); ?>
    </form>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<script>
    // Coche/décoche toutes les cases à cocher
    document.getElementById('select-all').addEventListener('change', function () {
        document.querySelectorAll('input[name="selected_ids[]"]').forEach(cb => cb.checked = this.checked);
    });
</script>


        <div class="mt-6 flex justify-center mb-10">
            <?php echo e($projets->links('vendor.pagination.tailwind')); ?>

        </div>
    </div>

   
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const deleteButtons = document.querySelectorAll('.btn-delete');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            const projetId = this.getAttribute('data-id');
            Swal.fire({
                title: 'Êtes-vous sûr ?',
                text: "Cette action est irréversible.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Oui, supprimer',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`delete-form-${projetId}`).submit();
                }
            });
        });
    });
});
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/safibrq/dashboard/csmaadministration/resources/views/projets/index.blade.php ENDPATH**/ ?>