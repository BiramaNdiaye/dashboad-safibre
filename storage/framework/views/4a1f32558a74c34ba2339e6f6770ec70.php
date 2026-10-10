<?php $__env->startSection('content'); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@500;600&display=swap" rel="stylesheet">
<style>
    .font-display { font-family: 'Space Grotesk', sans-serif; }
    .font-mono-tech { font-family: 'JetBrains Mono', monospace; }
</style>
<?php $__env->stopPush(); ?>

<div class="container mx-auto px-4 py-8 max-w-full">

    
    <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-6">
        <div>
            
            <h1 class="text-3xl md:text-4xl font-bold text-[#07677A] font-display tracking-tight">
                Gestion des Integrations
            </h1>
        </div>
        <p class="text-sm text-slate-400">
            <?php echo e($commandes->total() ?? $commandes->count()); ?> commande(s) au total
        </p>
    </div>

    
    <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200/70 mb-6">

    <form method="GET" action="<?php echo e(route('commandes.index')); ?>" class="flex flex-col gap-5">

        
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

            
            <div class="bg-slate-50/60 border border-slate-100 rounded-xl p-3.5 space-y-3">
                <div>
                    <label class="block text-[11px] font-semibold text-slate-500 uppercase tracking-wider mb-1.5">
                        Statut
                    </label>
                    <div class="relative">
                       
                        <select name="statut"
                                class="pl-10 pr-8 py-2.5 border border-slate-200 rounded-lg text-sm text-slate-700 shadow-sm focus:ring-2 focus:ring-[#F7881B]/30 focus:border-[#F7881B] outline-none transition appearance-none w-full bg-white">
                            <option value="">Tous statuts</option>
                            <?php $__currentLoopData = \App\Models\Commande::getStatuts(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $statut): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($statut); ?>" <?php echo e(request('statut') == $statut ? 'selected' : ''); ?>>
                                    <?php echo e(ucfirst($statut)); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-slate-500 uppercase tracking-wider mb-1.5">
                        Client
                    </label>
                    <div class="relative">
                        
                        <select name="client_id"
                                class="pl-10 pr-8 py-2.5 border border-slate-200 rounded-lg text-sm text-slate-700 shadow-sm focus:ring-2 focus:ring-[#F7881B]/30 focus:border-[#F7881B] outline-none transition appearance-none w-full bg-white">
                            <option value="">Tous clients</option>
                            <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($client->id); ?>" <?php echo e(request('client_id') == $client->id ? 'selected' : ''); ?>>
                                    <?php echo e($client->nom); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
            </div>

            
            <div class="bg-slate-50/60 border border-slate-100 rounded-xl p-3.5 space-y-3">
                <div>
                    <label class="block text-[11px] font-semibold text-slate-500 uppercase tracking-wider mb-1.5">
                        Livraison — début
                    </label>
                    <div class="relative">
                       
                        <input type="date"
                               name="date_livraison_debut"
                               class="pl-10 pr-3 py-2.5 border border-slate-200 rounded-lg text-sm text-slate-600 shadow-sm focus:ring-2 focus:ring-[#F7881B]/30 focus:border-[#F7881B] outline-none transition w-full bg-white"
                               value="<?php echo e(request('date_livraison_debut')); ?>">
                    </div>
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-slate-500 uppercase tracking-wider mb-1.5">
                        Livraison — fin
                    </label>
                    <div class="relative">
                       
                        <input type="date"
                               name="date_livraison_fin"
                               class="pl-10 pr-3 py-2.5 border border-slate-200 rounded-lg text-sm text-slate-600 shadow-sm focus:ring-2 focus:ring-[#F7881B]/30 focus:border-[#F7881B] outline-none transition w-full bg-white"
                               value="<?php echo e(request('date_livraison_fin')); ?>">
                    </div>
                </div>
            </div>

            
            <div class="bg-slate-50/60 border border-slate-100 rounded-xl p-3.5 flex flex-col justify-center gap-2.5">
                <button type="submit"
                        class="inline-flex items-center justify-center gap-2 w-full px-4 py-2.5 bg-[#07677A] hover:bg-[#16374A] text-white font-semibold rounded-lg shadow-sm transition-colors text-sm">
                    <i class="fas fa-filter"></i> Filtrer
                </button>
                <?php if(request()->filled('search') || request()->filled('statut') || request()->filled('client_id') || request()->filled('date_livraison_debut') || request()->filled('date_livraison_fin')): ?>
                    <a href="<?php echo e(route('commandes.index')); ?>"
                       class="inline-flex items-center justify-center gap-2 w-full px-4 py-2 bg-white hover:bg-slate-100 border border-slate-200 text-slate-600 font-semibold rounded-lg transition-colors text-sm">
                        <i class="fas fa-xmark"></i> Réinitialiser
                    </a>
                <?php else: ?>
                    <span class="inline-flex items-center justify-center gap-2 w-full px-4 py-2 text-slate-300 font-medium rounded-lg text-sm border border-dashed border-slate-200">
                        Aucun filtre actif
                    </span>
                <?php endif; ?>
            </div>

        </div>

        
        <div class="flex flex-col sm:flex-row sm:items-center gap-3 pt-4 border-t border-slate-100">
            <div class="relative flex-1">
               
                <input type="text"
                       name="search"
                       class="w-full pl-10 pr-4 py-2.5 border border-slate-200 rounded-lg text-sm text-slate-700 shadow-sm focus:ring-2 focus:ring-[#F7881B]/30 focus:border-[#F7881B] outline-none transition"
                       placeholder="Rechercher par référence ou site..."
                       value="<?php echo e(request('search')); ?>">
            </div>

            <div class="flex gap-3 shrink-0">
                <a href="<?php echo e(route('commandes.export.excel', request()->query())); ?>"
                   class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-lg shadow-sm transition-colors">
                    <i class="fas fa-file-excel"></i>
                    Export Excel
                </a>

                <a href="<?php echo e(route('commandes.create')); ?>"
                   class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-[#F7881B] hover:bg-[#e07a12] text-white text-sm font-semibold rounded-lg shadow-sm transition-colors">
                    <i class="fas fa-plus"></i>
                    Nouvelle intergration
                </a>
            </div>
        </div>

    </form>
</div>
    </form>


</div>

    
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/70 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100 text-sm">
                <thead class="bg-[#07677A]">
                    <tr>
                        
                        <th class="px-4 py-3.5 text-left text-[11px] font-semibold text-slate-300 uppercase tracking-wider">Référence</th>
                        <th class="px-4 py-3.5 text-left text-[11px] font-semibold text-slate-300 uppercase tracking-wider">Site</th>
                        <th class="px-4 py-3.5 text-left text-[11px] font-semibold text-slate-300 uppercase tracking-wider">Client</th>
                        <th class="px-4 py-3.5 text-left text-[11px] font-semibold text-slate-300 uppercase tracking-wider">Affecté à</th>
                        <th class="px-4 py-3.5 text-left text-[11px] font-semibold text-slate-300 uppercase tracking-wider">Statut</th>
                        <th class="px-4 py-3.5 text-left text-[11px] font-semibold text-slate-300 uppercase tracking-wider">Date réception</th>
                        <th class="px-4 py-3.5 text-center text-[11px] font-semibold text-slate-300 uppercase tracking-wider">Éléments</th>
                        <th class="px-4 py-3.5 text-center text-[11px] font-semibold text-slate-300 uppercase tracking-wider" style="min-width: 140px;">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php $__empty_1 = true; $__currentLoopData = $commandes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $commande): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            
                            <td class="px-4 py-3.5">
                                <a href="<?php echo e(route('commandes.show', $commande)); ?>" class="font-semibold text-[#0E2939] hover:text-[#F7881B] transition-colors">
                                    <?php echo e($commande->reference); ?>

                                </a>
                            </td>
                            <td class="px-4 py-3.5 text-slate-600"><?php echo e($commande->nom_site); ?></td>
                            <td class="px-4 py-3.5 text-slate-600"><?php echo e($commande->client->nom ?? '-'); ?></td>
                            <td class="px-4 py-3.5 text-slate-600"><?php echo e($commande->user->name ?? '-'); ?></td>
                            <td class="px-4 py-3.5">
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium
                                    <?php if($commande->statut == 'en_cours'): ?> bg-blue-100 text-blue-700
                                    <?php elseif($commande->statut == 'livré'): ?> bg-green-100 text-green-700
                                    <?php elseif($commande->statut == 'traité'): ?> bg-purple-100 text-purple-700
                                    <?php else: ?> bg-gray-100 text-gray-700 <?php endif; ?>">
                                    <?php echo e(ucfirst($commande->statut)); ?>

                                </span>
                            </td>
                            <td class="px-4 py-3.5 text-slate-500 font-mono-tech text-xs">
                                <?php echo e($commande->date_reception ? \Carbon\Carbon::parse($commande->date_reception)->format('d/m/Y') : '-'); ?>

                            </td>
                            <td class="px-4 py-3.5 text-center">
                                <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded bg-slate-100 text-slate-600 text-xs font-mono-tech">
                                    <i class="fas fa-layer-group text-[10px]"></i>
                                    <?php echo e($commande->commandeElements_count ?? $commande->commandeElements->count()); ?>

                                </span>
                            </td>
                            <td class="px-4 py-3.5">
                                <div class="flex items-center justify-center gap-1.5">
                                    <a href="<?php echo e(route('commandes.show', $commande)); ?>"
                                       title="Voir"
                                       class="w-8 h-8 flex items-center justify-center rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 transition-colors">
                                        <i class="fas fa-eye text-xs"></i>
                                    </a>
                                    <a href="<?php echo e(route('commandes.edit', $commande)); ?>"
                                       title="Modifier"
                                       class="w-8 h-8 flex items-center justify-center rounded-lg bg-amber-50 text-amber-600 hover:bg-amber-100 transition-colors">
                                        <i class="fas fa-pen text-xs"></i>
                                    </a>
                                    <form action="<?php echo e(route('commandes.destroy', $commande)); ?>"
                                          method="POST"
                                          onsubmit="return confirm('Supprimer cette commande ?')"
                                          class="inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit"
                                                title="Supprimer"
                                                class="w-8 h-8 flex items-center justify-center rounded-lg bg-red-50 text-red-600 hover:bg-red-100 transition-colors">
                                            <i class="fas fa-trash-can text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="9" class="px-4 py-16 text-center">
                              
                                <p class="text-slate-400 font-medium">Aucune intergration trouvée</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        
        <?php if($commandes->hasPages()): ?>
            <div class="px-5 py-4 border-t border-slate-100">
                <?php echo e($commandes->links()); ?>

            </div>
        <?php endif; ?>
    </div>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/safibrq/dashboard/csmaadministration/resources/views/commandes/index.blade.php ENDPATH**/ ?>