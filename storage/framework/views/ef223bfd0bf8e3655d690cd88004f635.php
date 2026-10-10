<?php $__env->startSection('content'); ?>

<h2 class="text-5xl font-extrabold text-center text-gray-800 mb-6 relative mt-3">
    <span class="bg-[#45C4EB] text-transparent bg-clip-text uppercase">
        Mettre à jour le projet
    </span>
    <span class="block w-16 h-1 bg-[#45C4EB] mx-auto mt-2 rounded-full"></span>
</h2>

<div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-lg mt-10">

<form action="<?php echo e(route(isset($projet) ? 'projets.update' : 'projets.store', $projet->id ?? '')); ?>"
      method="POST"
      class="bg-white p-8 rounded-xl shadow-lg border border-[#45C4EB] space-y-6">

    <?php echo csrf_field(); ?>
    <?php if(isset($projet)): ?>
        <?php echo method_field('PUT'); ?>
    <?php endif; ?>

    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <div>
            <label class="block text-sm font-medium text-gray-700">Nom du site</label>
            <input type="text" name="nom_site"
                   value="<?php echo e(old('nom_site', $projet->nom_site ?? '')); ?>"
                   class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Référence</label>
            <input type="text" name="reference"
                   value="<?php echo e(old('reference', $projet->reference ?? '')); ?>"
                   class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg">
        </div>

    </div>

    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <div>
            <label class="block text-sm font-medium text-gray-700">Client</label>

            <select id="clients_id" name="clients_id"
                    class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg">

                <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($client->id); ?>"
                        <?php echo e(old('clients_id', $projet->clients_id ?? '') == $client->id ? 'selected' : ''); ?>>
                        <?php echo e($client->nom); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </select>
        </div>

        
        <div id="code_site_container" class="hidden">
            <label class="block text-sm font-medium text-gray-700">
                Code site (SPIE)
            </label>

            <input type="text" name="code_site"
                   value="<?php echo e(old('code_site', $projet->code_site ?? '')); ?>"
                   class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg">
        </div>

    </div>

    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <div>
            <label class="block text-sm font-medium text-gray-700">Date commande</label>
            <input type="date" name="date_commande"
                   value="<?php echo e(old('date_commande', $projet->date_commande ?? '')); ?>"
                   class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Date livraison</label>
            <input type="date" name="date_livraison"
                   value="<?php echo e(old('date_livraison', $projet->date_livraison ?? '')); ?>"
                   class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg">
        </div>

    </div>

    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <div>
            <label class="block text-sm font-medium text-gray-700">Chef de projet</label>

            <select name="users_id"
                    class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg">

                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($user->id); ?>"
                        <?php echo e(old('users_id', $projet->users_id ?? '') == $user->id ? 'selected' : ''); ?>>
                        <?php echo e($user->name); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Statut</label>

            <select name="statut_projet"
                    class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg">

                <option value="En cours" <?php echo e(old('statut_projet', $projet->statut_projet ?? '') == 'En cours' ? 'selected' : ''); ?>>En cours</option>
                <option value="Livré" <?php echo e(old('statut_projet', $projet->statut_projet ?? '') == 'Livré' ? 'selected' : ''); ?>>Livré</option>
                <option value="Traité" <?php echo e(old('statut_projet', $projet->statut_projet ?? '') == 'Traité' ? 'selected' : ''); ?>>Traité</option>

            </select>
        </div>

    </div>

    
    <div>
        <label class="block text-sm font-medium text-gray-700">Type de projet</label>

        <select name="type_projet"
                class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg">

            <option value="Production" <?php echo e(old('type_projet', $projet->type_projet ?? '') == 'Production' ? 'selected' : ''); ?>>Production</option>
            <option value="Production V2" <?php echo e(old('type_projet', $projet->type_projet ?? '') == 'Production V2' ? 'selected' : ''); ?>>Production V2</option>
            <option value="RATTRAP BLO" <?php echo e(old('type_projet', $projet->type_projet ?? '') == 'RATTRAP BLO' ? 'selected' : ''); ?>>RATTRAP BLO</option>

        </select>
    </div>

    
    <div>
        <label class="block text-sm font-medium text-gray-700">Commentaire</label>

        <textarea name="commentaires"
                  class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg"><?php echo e(old('commentaires', $projet->commentaires ?? '')); ?></textarea>
    </div>

    
    <div class="flex justify-end">
        <button type="submit"
                class="bg-[#45C4EB] hover:bg-[#45C4EB] text-white px-6 py-2 rounded-lg">
            Mettre à jour
        </button>
    </div>

</form>

<div class="mt-6">
    <a href="<?php echo e(route('projets.index')); ?>"
       class="bg-[#45C4EB] hover:bg-[#45C4EB] text-white px-6 py-3 rounded-lg">
        ⬅ Retour aux projets
    </a>
</div>

</div>


<script>
document.addEventListener('DOMContentLoaded', function () {

    const clientSelect = document.getElementById('clients_id');
    const codeSiteContainer = document.getElementById('code_site_container');

    function toggleCodeSite() {
        const selectedText = clientSelect.options[clientSelect.selectedIndex].text.trim();

        if (selectedText === 'SPIE') {
            codeSiteContainer.classList.remove('hidden');
        } else {
            codeSiteContainer.classList.add('hidden');
        }
    }

    clientSelect.addEventListener('change', toggleCodeSite);

    // affichage initial
    toggleCodeSite();

});
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/safibrq/dashboard/csmaadministration/resources/views/projets/edit.blade.php ENDPATH**/ ?>