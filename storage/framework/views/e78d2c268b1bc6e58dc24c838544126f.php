<?php $__env->startSection('content'); ?>
<div class="flex-1">
                <div class="flex items-center space-x-3 mb-2">
                    <div class="p-2 bg-gradient-to-r from-[#45C4EB] to-blue-500 rounded-xl shadow-lg">
                        <i class="fas fa-project-diagram text-white text-lg"></i>
                    </div>
                    <h1 class="text-2xl md:text-3xl font-bold text-[#45C4EB] ">
                        Liste des BLO MCCONNECT
                    </h1>
                </div>
               
            </div>
 <table class="min-w-full bg-white rounded-lg overflow-hidden">
            <thead class="bg-[#45C4EB] text-white">
                <tr class="uppercase">
                    <th class="py-1 px-2 border-b text-left">Référence</th>
                    <th class="py-1 px-2 border-b text-left">Site</th>
                    <th class="py-1 px-2 border-b text-left">Type BLO</th>
                    <th class="py-1 px-2 border-b text-left">N° FCI</th>
                    <th class="py-1 px-2 border-b text-left">Date de livraison</th>
                    <th class="py-1 px-2 border-b text-left">Statut Blo</th>
                   
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <?php $__currentLoopData = $projets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $projet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $hasRopTask = false;
                        $type_rop = '';
                        $nbre_bpe = 'Non spécifié';
                        $statut_rop = 'Non spécifié';
                        $date_livraison = 'Non spécifié';
                        $lien_resilie = 'Non spécifié';
                    ?>
                    
                    <?php $__currentLoopData = $projet->taches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tache): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($tache->typeTache->nom == 'BLO'): ?>
                            <?php
                                $hasRopTask = true;
                                $type_rop = $tache->informations['type_blo'] ?? 'Non spécifié';
                                $nbre_bpe = $tache->informations['num_fci'] ?? 'Non spécifié';
                                $statut_rop = $tache->informations['date_livraison_blo'] ?? 'Non spécifié';
                                $date_livraison = $tache->informations['statut_blo'] ?? 'Non spécifié';
                               
                            ?>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <?php if($hasRopTask): ?> 
                        <tr class="hover:bg-[#F7881B] transition duration-200 uppercase" >
                            <td class="px-2 py-1 border-b-1 border-[#F7881B] border-dashed"><?php echo e($projet->reference); ?></td>
                            <td class="px-2 py-1 border-b-1 border-[#F7881B] border-dashed"><?php echo e($projet->nom_site); ?></td>
                            <td class="px-2 py-1 border-b-1 border-[#F7881B] border-dashed"><?php echo e($type_rop); ?></td>
                            <td class="px-2 py-1 border-b-1 border-[#F7881B] border-dashed"><?php echo e($nbre_bpe); ?></td>
                            <td class="py-2 px-3 border-b-1 border-[#F7881B] border-dashed <?php echo e($statut_rop === 'Terminé' ? 'text-red-500 font-bold' : ''); ?>">
                                <?php echo e($statut_rop); ?>

                            </td>
                            <td class="px-2 py-1 border-b-1 border-[#F7881B] border-dashed"><?php echo e($date_livraison); ?></td>
                            
                        </tr>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
        <div class="mt-6 flex justify-center mb-10">
            <?php echo e($projets->links('vendor.pagination.tailwind')); ?>

        </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/safibrq/dashboard/csmaadministration/resources/views/McConnect/index.blade.php ENDPATH**/ ?>