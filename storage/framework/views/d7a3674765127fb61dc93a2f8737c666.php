<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <h2 class="text-6xl font-extrabold text-center text-gray-800 mb-6 relative">
        <span class="bg-[#45C4EB] text-transparent bg-clip-text uppercase">
            Mes Projets
        </span>
        <span class="block w-16 h-1 bg-[#F7881B] mx-auto mt-2 rounded-full"></span>
    </h2>

    <?php if(session('success')): ?>
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
            <p><?php echo e(session('success')); ?></p>
        </div>
    <?php endif; ?>

    <div class="mt-6">
        <form action="<?php echo e(route('mes-projets-prestataires')); ?>" method="GET" class="bg-white p-6 rounded-xl shadow-lg">
            <div class="mb-6 flex gap-4 items-center">
                <input type="text" name="search" placeholder="🔍 Rechercher par référence ou site..." 
                       class="px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200 w-1/4" 
                       value="<?php echo e(request('search')); ?>">
                <button type="submit" class="bg-[#45C4EB] hover:bg-[#F7881B] text-white font-semibold px-4 py-2 rounded-lg shadow-md transition duration-300 transform hover:scale-105">
                    Rechercher
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Date de commande -->
               <!-- Date de commande -->
        <div class="p-4 border border-[#45C4EB] rounded-lg shadow-sm bg-gray-50">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Date de commande</h3>
            <div class="flex items-center mb-3">
                <label class="w-24 text-sm font-semibold text-gray-700">Début :</label>
                <input type="date" name="commande_debut" value="<?php echo e(request('commande_debut')); ?>"
                    class="border-[#45C4EB] rounded-lg p-2 w-full shadow-sm focus:ring-2 focus:ring-[#45C4EB]">
            </div>
            <div class="flex items-center">
                <label class="w-24 text-sm font-semibold text-gray-700">Fin :</label>
                <input type="date" name="commande_fin" value="<?php echo e(request('commande_fin')); ?>"
                    class="border-[#45C4EB] rounded-lg p-2 w-full shadow-sm focus:ring-2 focus:ring-[#45C4EB]">
            </div>
        </div>

<!-- Date de livraison -->
<div class="p-4 border border-[#45C4EB] rounded-lg shadow-sm bg-gray-50">
    <h3 class="text-lg font-semibold text-gray-700 mb-4">Date de livraison</h3>
    <div class="flex items-center mb-3">
        <label class="w-24 text-sm font-semibold text-gray-700">Début :</label>
        <input type="date" name="livraison_debut" value="<?php echo e(request('livraison_debut')); ?>"
               class="border-[#45C4EB] rounded-lg p-2 w-full shadow-sm focus:ring-2 focus:ring-[#45C4EB]">
    </div>
    <div class="flex items-center">
        <label class="w-24 text-sm font-semibold text-gray-700">Fin :</label>
        <input type="date" name="livraison_fin" value="<?php echo e(request('livraison_fin')); ?>"
               class="border-[#45C4EB] rounded-lg p-2 w-full shadow-sm focus:ring-2 focus:ring-[#45C4EB]">
    </div>
</div>

<!-- Statut -->
<div class="p-4 border border-[#45C4EB] rounded-lg shadow-sm bg-gray-50">
    <h3 class="text-lg font-semibold text-gray-700 mb-4">Statut</h3>
    <div class="flex items-center">
        <label class="w-24 text-sm font-semibold text-gray-700">Statut :</label>
        <select name="statut_projet"
                class="border-[#45C4EB] rounded-lg p-2 w-full bg-white shadow-sm focus:ring-2 focus:ring-[#45C4EB]">
            <option value="">Tous</option>
            <?php $__currentLoopData = $statuts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $statut): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($statut); ?>" <?php echo e(request('statut_projet') == $statut ? 'selected' : ''); ?>>
                    <?php echo e(ucfirst($statut)); ?>

                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
</div>

            </div>

            <div class="mt-6 flex justify-end gap-4">
                <button type="submit" class="bg-[#45C4EB] hover:bg-[#F7881B] text-white font-semibold px-6 py-2 rounded-lg shadow-md flex items-center gap-2">
                    🔍 <span>Filtrer</span>
                </button>
                <a href="<?php echo e(route('mes-projets-prestataires')); ?>" class="bg-gray-400 hover:bg-gray-600 text-white font-semibold px-6 py-2 rounded-lg shadow-md flex items-center gap-2">
                    🔄 <span>Réinitialiser</span>
                </a>
            </div>
        </form>
    </div>

    <div class="overflow-x-auto rounded-lg shadow-lg p-5 mt-6">
        <table class="min-w-full bg-white rounded-lg overflow-hidden">
            <thead class="bg-[#45C4EB] text-white">
                <tr>
                    <th class="py-1 px-2 text-left font-semibold uppercase">Nom du site</th>
                    <th class="py-1 px-2 text-left font-semibold uppercase">Référence</th>
                    <th class="py-1 px-2 text-left font-semibold uppercase">Date de commande</th>
                    <th class="py-1 px-2 text-left font-semibold uppercase">Date de livraison</th>
                    <th class="py-1 px-2 text-left font-semibold uppercase">Statut</th>
                    <th class="py-1 px-2 text-left font-semibold uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <?php $__empty_1 = true; $__currentLoopData = $projets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $projet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-gray-50 transition duration-200">
                        <td class="px-1 py-2 border-b border-[#F7881B] border-dashed uppercase"><?php echo e($projet->nom_site); ?></td>
                        <td class="px-1 py-2 border-b border-[#F7881B] border-dashed uppercase"><?php echo e($projet->reference); ?></td>
                        <td class="px-1 py-2 border-b border-[#F7881B] border-dashed uppercase"><?php echo e($projet->date_commande); ?></td>
                        <td class="px-1 py-2 border-b border-[#F7881B] border-dashed uppercase"><?php echo e($projet->date_livraison); ?></td>
                         <td class="px-1 py-2 border-b border-[#F7881B] border-dashed uppercase"><?php echo e($projet->statut_projet); ?></td>
                         <td class="px-1 py-2 border-b-1 border-[#F7881B] border-dashed text-center space-x-4">
                            <!-- Icône "Ajouter tâches" -->
                            <?php if($projet->chefProjet && (auth()->user()->id === $projet->chefProjet->id || auth()->user()->hasRole('admin'))): ?>
                                <a href="<?php echo e(route('taches.create', $projet->id)); ?>" class="text-yellow-500 hover:text-yellow-600 transition duration-200" title="Ajouter tâches">
                                    <svg class="w-6 h-6 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </a>
                            <?php endif; ?>
                        
                            <!-- Icône "Voir les tâches" - Toujours visible -->
                            <a href="<?php echo e(route('projets.taches.index', $projet->id)); ?>" class="text-blue-500 hover:text-blue-600 transition duration-200" title="Voir les tâches">
                                <svg class="w-6 h-6 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2 17l4 4 4-4M2 7l4-4 4 4"></path>
                                </svg>
                            </a>
                        
                            <!-- Icône "Voir le projet" - Toujours visible -->
                            <a href="<?php echo e(route('projets.show', $projet->id)); ?>" class="text-green-500 hover:text-green-600 transition duration-200" title="Voir le projet">
                                <svg class="w-6 h-6 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3C8.13 3 5 6.13 5 9c0 2.66 3 5 7 5s7-2.34 7-5c0-2.87-3.13-6-7-6zm0 8c-1.74 0-3-1.26-3-3s1.26-3 3-3s3 1.26 3 3-1.26 3-3 3z"></path>
                                </svg>
                            </a>
                            
                            <!-- Icône "Modifier projet" - Uniquement admin -->
                            <?php if (\Illuminate\Support\Facades\Blade::check('role', 'admin')): ?>
                                <a href="<?php echo e(route('projets.edit', $projet->id)); ?>" class="text-blue-500 hover:text-blue-600 transition duration-200" title="Modifier projet">
                                    <svg class="w-6 h-6 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12l-4 4h3v5h5v-3h3l4-4-7-7-4 4-3-3z"></path>
                                    </svg>
                                </a>
                            <?php endif; ?>
                            
                            <!-- Icône "Supprimer" - Uniquement admin -->
                            <?php if (\Illuminate\Support\Facades\Blade::check('role', 'admin')): ?>
                                <form action="<?php echo e(route('projets.destroy', $projet->id)); ?>" method="POST" class="delete-form inline-block">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="text-red-500 hover:text-red-600 transition duration-200" title="Supprimer">
                                        <svg class="w-6 h-6 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            <?php endif; ?>
                            
                            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                            <script>
                                document.addEventListener('DOMContentLoaded', function () {
                                    const deleteForms = document.querySelectorAll('.delete-form');
                            
                                    deleteForms.forEach(form => {
                                        form.addEventListener('submit', function (e) {
                                            e.preventDefault();
                            
                                            Swal.fire({
                                                title: 'Êtes-vous sûr ?',
                                                text: "Vous ne pourrez pas annuler cette action !",
                                                icon: 'warning',
                                                showCancelButton: true,
                                                confirmButtonColor: '#3085d6',
                                                cancelButtonColor: '#d33',
                                                confirmButtonText: 'Oui, supprimer !',
                                                cancelButtonText: 'Annuler'
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    form.submit();
                                                }
                                            });
                                        });
                                    });
                                });
                            </script>
                        </td>

                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="text-center py-4 text-gray-500 italic">Aucun projet trouvé.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <div class="mt-4">
    <?php echo e($projets->links('pagination::tailwind')); ?>

</div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/safibrq/dashboard/csmaadministration/resources/views/projets/projet-client.blade.php ENDPATH**/ ?>