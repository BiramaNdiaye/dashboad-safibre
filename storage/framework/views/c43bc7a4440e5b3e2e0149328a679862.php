<?php $__env->startSection('content'); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@500;600&display=swap" rel="stylesheet">
<style>
    .font-display { font-family: 'Space Grotesk', sans-serif; }
    .font-mono-tech { font-family: 'JetBrains Mono', monospace; }
    .bg-dot-pattern {
        background-image: radial-gradient(circle at 1.5px 1.5px, rgba(255,255,255,0.14) 1.5px, transparent 0);
        background-size: 22px 22px;
    }
</style>
<?php $__env->stopPush(); ?>

<div class="container mx-auto px-4 py-8 max-w-full">

    
    <div class="flex items-center gap-2 text-xs font-medium text-slate-400 uppercase tracking-[0.15em] mb-5">
        <a href="<?php echo e(route('commandes.index')); ?>" class="hover:text-[#F7881B] transition-colors">Commandes</a>
        <i class="fas fa-chevron-right text-[9px]"></i>
        <span class="text-slate-500 font-mono-tech normal-case tracking-normal"><?php echo e($commande->reference); ?></span>
    </div>

    
    <div class="relative overflow-hidden rounded-2xl bg-[#07677A] mb-8 shadow-xl shadow-slate-900/10">
        <div class="absolute inset-0 bg-dot-pattern"></div>
        <div class="absolute -right-16 -top-16 w-64 h-64 rounded-full bg-[#F7881B]/10 blur-3xl"></div>

        <div class="relative px-6 py-8 md:px-10 md:py-10 flex flex-col md:flex-row md:items-start md:justify-between gap-6">
            <div>
                <p class="text-[#F7881B] text-xs font-semibold uppercase tracking-[0.2em] mb-3 font-display">
                    Commande réseau
                </p>
                <h1 class="text-3xl md:text-4xl font-bold text-white font-display tracking-tight">
                    <?php echo e($commande->reference); ?>

                </h1>
                <p class="mt-3 flex items-center gap-2 text-slate-300 text-sm">
                    <i class="fas fa-location-dot text-[#F7881B]"></i> <?php echo e($commande->nom_site); ?>

                </p>
            </div>

            <div class="flex flex-col items-start md:items-end gap-4">
                <div class="flex items-center">
   <p><strong>Statut :</strong> <?php echo e($commande->statut); ?></p>
</div>
                <div class="flex flex-wrap gap-2">
                    <a href="<?php echo e(route('commandes.edit', $commande)); ?>"
                       class="inline-flex items-center gap-2 px-4 py-2 bg-[#F7881B] hover:bg-[#e07a12] text-white text-sm font-semibold rounded-lg shadow-md transition-colors">
                        <i class="fas fa-pen"></i> Modifier
                    </a>
                    <a href="<?php echo e(route('commandes.index')); ?>"
                       class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 hover:bg-white/15 border border-white/20 text-white text-sm font-semibold rounded-lg transition-colors">
                        <i class="fas fa-arrow-left"></i> Retour
                    </a>
                </div>
            </div>
        </div>
    </div>

    
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <?php
            $infoCards = [
                ['icon' => 'fa-building', 'label' => 'Client', 'value' => $commande->client->nom ?? '-'],
                ['icon' => 'fa-user-gear', 'label' => "Chargé d'étude", 'value' => $commande->user->name ?? '-'],
                ['icon' => 'fa-calendar-check', 'label' => 'Date réception', 'value' => $commande->date_reception ? \Carbon\Carbon::parse($commande->date_reception)->format('d/m/Y') : '-'],
                ['icon' => 'fa-truck-fast', 'label' => 'Date livraison', 'value' => $commande->date_livraison ? \Carbon\Carbon::parse($commande->date_livraison)->format('d/m/Y') : '-'],
            ];
        ?>
        <?php $__currentLoopData = $infoCards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="group bg-white p-5 rounded-2xl shadow-sm border border-slate-200/70 hover:shadow-md hover:border-slate-300 transition-all">
                <div class="w-9 h-9 rounded-lg bg-[#0E2939]/5 flex items-center justify-center mb-3 group-hover:bg-[#F7881B]/10 transition-colors">
                    <i class="fas <?php echo e($card['icon']); ?> text-[#0E2939] text-sm group-hover:text-[#F7881B] transition-colors"></i>
                </div>
                <h6 class="text-[11px] text-slate-400 font-semibold uppercase tracking-wider mb-1"><?php echo e($card['label']); ?></h6>
                <p class="text-base font-semibold text-[#0E2939] font-display"><?php echo e($card['value']); ?></p>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200/70 mb-6">
        <h5 class="flex items-center gap-2 font-display font-semibold text-[#0E2939] mb-3">
            <i class="fas fa-align-left text-[#F7881B]"></i> Description
        </h5>
        <p class="text-slate-600 leading-relaxed border-l-4 border-[#F7881B]/30 pl-4">
            <?php echo e($commande->description ?? 'Aucune description'); ?>

        </p>
    </div>

    
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <?php
            $stats = [
                ['label' => 'Éléments',      'value' => $commande->commandeElements->count(), 'icon' => 'fa-layer-group', 'accent' => '#0E2939'],
                ['label' => 'Créations',     'value' => $commande->commandeElements->where('action','creation')->count(), 'icon' => 'fa-circle-plus', 'accent' => '#16A34A'],
                ['label' => 'Modifications', 'value' => $commande->commandeElements->where('action','modification')->count(), 'icon' => 'fa-pen-to-square', 'accent' => '#D97706'],
                ['label' => 'Suppressions',  'value' => $commande->commandeElements->where('action','suppression')->count(), 'icon' => 'fa-trash-can', 'accent' => '#DC2626'],
            ];
        ?>
        <?php $__currentLoopData = $stats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-200/70 border-t-[3px]" style="border-top-color: <?php echo e($stat['accent']); ?>">
                <div class="flex items-center justify-between mb-2">
                    <i class="fas <?php echo e($stat['icon']); ?> text-sm" style="color: <?php echo e($stat['accent']); ?>"></i>
                </div>
                <h2 class="text-3xl font-bold font-display text-[#0E2939]"><?php echo e($stat['value']); ?></h2>
                <p class="text-xs uppercase tracking-wider text-slate-400 font-semibold mt-0.5"><?php echo e($stat['label']); ?></p>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    
    <?php
        $groupes = [
            'creation'     => ['label' => 'Créations',     'icon' => 'fa-circle-plus',   'color' => 'emerald'],
            'modification' => ['label' => 'Modifications', 'icon' => 'fa-pen-to-square', 'color' => 'amber'],
            'suppression'  => ['label' => 'Suppressions',  'icon' => 'fa-trash-can',     'color' => 'red'],
        ];
        $colorMap = [
            'emerald' => ['dot' => 'bg-emerald-500', 'chip' => 'bg-emerald-50 text-emerald-700 border-emerald-100', 'text' => 'text-emerald-600'],
            'amber'   => ['dot' => 'bg-amber-500',   'chip' => 'bg-amber-50 text-amber-700 border-amber-100',       'text' => 'text-amber-600'],
            'red'     => ['dot' => 'bg-red-500',     'chip' => 'bg-red-50 text-red-700 border-red-100',             'text' => 'text-red-600'],
        ];
    ?>
    <?php if($commande->commandeElements->count() > 0): ?>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200/70 mb-6">
            <h5 class="flex items-center gap-2 font-display font-semibold text-[#0E2939] mb-5">
                <i class="fas fa-clipboard-list text-[#F7881B]"></i> Journal des opérations
            </h5>

            <div class="space-y-6">
                <?php $__currentLoopData = $groupes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $action => $meta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $items = $commande->commandeElements->where('action', $action); ?>
                    <?php if($items->count() > 0): ?>
                        <div>
                            <div class="flex items-center gap-2 mb-3">
                                <span class="w-1.5 h-1.5 rounded-full <?php echo e($colorMap[$meta['color']]['dot']); ?>"></span>
                                <span class="text-sm font-semibold <?php echo e($colorMap[$meta['color']]['text']); ?>"><?php echo e($meta['label']); ?></span>
                                <span class="text-xs text-slate-400 font-mono-tech">(<?php echo e($items->count()); ?>)</span>
                            </div>
                            <div class="flex flex-wrap gap-2">
                                <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span class="inline-flex items-center gap-2 pl-2.5 pr-3 py-1.5 rounded-lg border <?php echo e($colorMap[$meta['color']]['chip']); ?> text-sm">
                                        <span class="text-[10px] font-bold uppercase tracking-wide opacity-70"><?php echo e($element->type); ?></span>
                                        <span class="font-medium"><?php echo e($element->nom); ?></span>
                                    </span>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    <?php endif; ?>

    
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200/70 mb-6">
        <h5 class="flex items-center gap-2 font-display font-semibold text-[#0E2939] mb-5">
            <i class="fas fa-list-ul text-[#F7881B]"></i> Détail des éléments réseau
        </h5>
        <div class="overflow-x-auto rounded-xl border border-slate-200">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Type</th>
                        <th class="px-4 py-3 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Nom</th>
                        <th class="px-4 py-3 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Action</th>
                        <th class="px-4 py-3 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Origine</th>
                        <th class="px-4 py-3 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Destination</th>
                        <th class="px-4 py-3 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">FO</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php
                        $actionColors = [
                            'creation'     => 'text-emerald-700 bg-emerald-50',
                            'modification' => 'text-amber-700 bg-amber-50',
                            'suppression'  => 'text-red-700 bg-red-50',
                        ];
                    ?>
                    <?php $__empty_1 = true; $__currentLoopData = $commande->commandeElements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="px-4 py-3 text-slate-600 font-medium"><?php echo e(ucfirst($element->type)); ?></td>
                            <td class="px-4 py-3 text-[#0E2939] font-semibold"><?php echo e($element->nom); ?></td>
                            <td class="px-4 py-3">
                                <span class="inline-block px-2 py-0.5 rounded text-xs font-semibold <?php echo e($actionColors[$element->action] ?? 'text-slate-600 bg-slate-100'); ?>">
                                    <?php echo e(ucfirst($element->action)); ?>

                                </span>
                            </td>
                            <td class="px-4 py-3 text-slate-600"><?php echo e($element->origine); ?></td>
                            <td class="px-4 py-3 text-slate-600"><?php echo e($element->destination); ?></td>
                            <td class="px-4 py-3 font-mono-tech text-slate-500"><?php echo e($element->capacite_fo); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr><td colspan="6" class="px-4 py-10 text-center text-slate-400">Aucun élément</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    
    <?php if($commande->commandeElements->filter(fn($e) => $e->liaisons->count() > 0)->count() > 0): ?>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200/70 mb-6">
            <h5 class="flex items-center gap-2 font-display font-semibold text-[#0E2939] mb-5">
                <i class="fas fa-diagram-project text-[#F7881B]"></i> Liaisons des câbles
            </h5>

            <div class="space-y-6">
                <?php $__currentLoopData = $commande->commandeElements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($element->liaisons->count()): ?>
                        <div class="rounded-xl border border-slate-200 overflow-hidden">
                            <div class="bg-slate-50 px-4 py-2.5 border-b border-slate-200">
                                <h6 class="font-semibold text-[#0E2939] text-sm"><?php echo e($element->nom); ?></h6>
                            </div>
                            <div class="divide-y divide-slate-100 px-4">
                                <?php $__currentLoopData = $element->liaisons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $liaison): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="flex items-center gap-3 py-4">
                                        <div class="flex-1 text-right min-w-0">
                                            <p class="text-sm font-semibold text-[#0E2939] truncate"><?php echo e($liaison->origine); ?></p>
                                            <p class="text-[10px] uppercase tracking-wide text-slate-400 mt-0.5">Origine</p>
                                        </div>

                                        <div class="flex flex-col items-center shrink-0 px-1 w-32">
                                            <div class="w-full flex items-center">
                                                <span class="w-2 h-2 rounded-full bg-[#F7881B]"></span>
                                                <span class="flex-1 border-t-2 border-dashed border-[#F7881B]/40 mx-1"></span>
                                                <i class="fas fa-wave-square text-[#F7881B] text-[11px]"></i>
                                                <span class="flex-1 border-t-2 border-dashed border-[#F7881B]/40 mx-1"></span>
                                                <span class="w-2 h-2 rounded-full bg-[#F7881B]"></span>
                                            </div>
                                            <span class="mt-1.5 text-[11px] font-mono-tech text-slate-400"><?php echo e($liaison->distance); ?></span>
                                        </div>

                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-semibold text-[#0E2939] truncate"><?php echo e($liaison->destination); ?></p>
                                            <p class="text-[10px] uppercase tracking-wide text-slate-400 mt-0.5">Destination</p>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    <?php endif; ?>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/safibrq/dashboard/csmaadministration/resources/views/commandes/show.blade.php ENDPATH**/ ?>