<?php $__env->startSection('content'); ?>
<div class="container mx-auto p-4">

    <h2 class="text-5xl font-extrabold text-center text-gray-800 mb-6 relative mt-3">
        <span class="text-[#07677A]">Nouvelle commande</span>
        <span class="block w-16 h-1 bg-[#F7881B] mx-auto mt-2 rounded-full"></span>
    </h2>

    <?php if(session('success')): ?>
        <div class="bg-green-200 text-green-800 p-3 mb-4 rounded-lg font-semibold shadow">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <div class="max-w-full mx-auto bg-white p-8 rounded-lg shadow-lg mt-10 border border-gray-200">

        <form action="<?php echo e(route('commandes.store')); ?>" method="POST" class="space-y-6">
            <?php echo csrf_field(); ?>

            <!-- Grille 2 colonnes -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Référence -->
                <div>
                    <label class="block font-semibold mb-1">
                       Référence
                    </label>
                    <input type="text" name="reference" value="Générée automatiquement" disabled 
                       
                        class="w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-[#0E2939] focus:border-[#0E2939] <?php $__errorArgs = ['reference'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        required>
                    <?php $__errorArgs = ['reference'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-sm text-red-600 mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Site principal -->
                <div>
                    <label class="block font-semibold mb-1">
                        Site principal
                    </label>
                    <input type="text" name="nom_site" value="<?php echo e(old('nom_site')); ?>"
                        placeholder="Nom du site"
                        class="w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-[#0E2939] focus:border-[#0E2939] <?php $__errorArgs = ['nom_site'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        required>
                    <?php $__errorArgs = ['nom_site'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-sm text-red-600 mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Date réception -->
                <div>
                    <label class="block font-semibold mb-1">
                        Date réception
                    </label>
                    <input type="date" name="date_reception" value="<?php echo e(old('date_reception')); ?>"
                        class="w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-[#0E2939] focus:border-[#0E2939] <?php $__errorArgs = ['date_reception'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <?php $__errorArgs = ['date_reception'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-sm text-red-600 mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>


                <!-- Date livraison -->
                <div>
                    <label class="block font-semibold mb-1">
                      Date Livraison
                    </label>
                    <input type="date" name="date_livraison" value="<?php echo e(old('date_livraison')); ?>"
                        class="w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-[#0E2939] focus:border-[#0E2939] <?php $__errorArgs = ['date_livraison'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <?php $__errorArgs = ['date_livraison'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-sm text-red-600 mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>



                <!-- Client -->
                <div>
                    <label class="block font-semibold mb-1">
                         Client
                    </label>
                    <select name="client_id" class="w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-[#0E2939] focus:border-[#0E2939] <?php $__errorArgs = ['client_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                        <option value="">Sélectionner un client</option>
                        <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($client->id); ?>" <?php echo e(old('client_id') == $client->id ? 'selected' : ''); ?>>
                                <?php echo e($client->nom); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php $__errorArgs = ['client_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-sm text-red-600 mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Utilisateur affecté -->
                <div>
                    <label class="block font-semibold mb-1">
                     Utilisateur affecté
                    </label>
                    <select name="user_id" class="w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-[#0E2939] focus:border-[#0E2939] <?php $__errorArgs = ['user_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                        <option value="">Sélectionner un utilisateur</option>
                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($user->id); ?>" <?php echo e(old('user_id') == $user->id ? 'selected' : ''); ?>>
                                <?php echo e($user->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php $__errorArgs = ['user_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-sm text-red-600 mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Statut -->
                <div>
                    <label class="block font-semibold mb-1">
                       Statut
                    </label>
                    <select name="statut" class="w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-[#0E2939] focus:border-[#0E2939] <?php $__errorArgs = ['statut'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <option value="en_cours" <?php echo e(old('statut') == 'en_cours' ? 'selected' : ''); ?>>En cours</option>
                        <option value="livré" <?php echo e(old('statut') == 'livré' ? 'selected' : ''); ?>>Livré</option>
                        <option value="traité" <?php echo e(old('statut') == 'traité' ? 'selected' : ''); ?>>Traité</option>
                    </select>
                    <?php $__errorArgs = ['statut'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-sm text-red-600 mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Description (pleine largeur) -->
                <div class="md:col-span-2">
                    <label class="block font-semibold mb-1">
                        Description
                    </label>
                    <textarea name="description" rows="3"
                        placeholder="Décrivez la commande..."
                        class="w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-[#0E2939] focus:border-[#0E2939] <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"><?php echo e(old('description')); ?></textarea>
                    <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-sm text-red-600 mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                

            </div>

            <hr class="my-6 border-gray-200">

            <!-- Section Éléments réseau -->
           <!-- Section Éléments réseau -->
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-4">
    <h3 class="text-xl font-bold text-[#0E2939] flex items-center">
         Éléments réseau
        <span id="elementCount" class="ml-3 inline-flex items-center justify-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-[#F7881B] text-white">
            0
        </span>
    </h3>
    <button type="button" id="addElement"
        class="px-5 py-2 bg-[#07677A] hover:bg-[#F7881B] text-white font-semibold rounded-lg shadow-md transition flex items-center">
         Ajouter un élément
    </button>
</div>

<div class="overflow-x-auto shadow-lg rounded-xl border border-gray-200">
    <table class="min-w-full divide-y divide-gray-200" id="elementsTable">
        <thead class="bg-gradient-to-r from-[#0E2939] to-[#1a4a5a]">
            <tr>
                <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                     Type
                </th>
                <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                     Nom
                </th>
                <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                  Action
                </th>
                <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                   Origine
                </th>
                <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                   Destination
                </th>
                <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                     Cap. FO
                </th>
                <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                    Commentaire
                </th>
                <th class="px-4 py-3 text-center text-xs font-medium text-white uppercase tracking-wider" style="width: 80px;">
                  Action
                </th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            <tr id="noElementsRow">
                <td colspan="8" class="px-4 py-6 text-center text-gray-400 italic">
                 Aucun élément ajouté
                </td>
            </tr>
        </tbody>
    </table>
</div>

            <!-- Boutons d'action -->
            <div class="flex flex-col sm:flex-row justify-end gap-3 pt-6 border-t border-gray-200">
                <a href="<?php echo e(route('commandes.index')); ?>"
                    class="px-6 py-2 border border-gray-300 text-gray-700 font-semibold rounded-lg shadow-sm hover:bg-gray-50 transition text-center">
                     Annuler
                </a>
                <button type="submit"
                    class="px-8 py-2 bg-[#07677A] hover:bg-[#F7881B] text-white font-semibold rounded-lg shadow-md transition">
                    Enregistrer la commande
                </button>
            </div>

        </form>
    </div>
</div>


<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<?php $__env->stopPush(); ?>


<script>
    let index = 0;

    function updateCounter() {
        const tbody = document.querySelector('#elementsTable tbody');
        const rows = tbody.querySelectorAll('tr:not(#noElementsRow)');
        const count = rows.length;
        document.getElementById('elementCount').textContent = count;
        // Si aucune ligne, afficher le message
        const noRow = document.getElementById('noElementsRow');
        if (count === 0 && !noRow) {
            const newNoRow = document.createElement('tr');
            newNoRow.id = 'noElementsRow';
            newNoRow.innerHTML = `<td colspan="8" class="px-4 py-6 text-center text-gray-400 italic">
                <i class="fas fa-info-circle mr-1"></i> Aucun élément ajouté
            </td>`;
            tbody.appendChild(newNoRow);
        } else if (count > 0 && noRow) {
            noRow.remove();
        }
    }

    document.getElementById('addElement').addEventListener('click', function () {
        const tbody = document.querySelector('#elementsTable tbody');
        const noRow = document.getElementById('noElementsRow');
        if (noRow) noRow.remove();

        const row = document.createElement('tr');
        row.classList.add('hover:bg-blue-50', 'odd:bg-gray-50', 'transition', 'duration-150');
        row.innerHTML = `
            <td class="px-4 py-2">
                <select name="elements[${index}][type]" class="w-full px-3 py-1.5 border rounded-md shadow-sm focus:ring-[#0E2939] focus:border-[#0E2939] text-sm">
                    <option value="cable">Câble</option>
                    <option value="boite">Boîte</option>
                    <option value="chambre">Chambre</option>
                    <option value="site">Site</option>
                </select>
            </td>
            <td class="px-4 py-2">
                <input type="text" name="elements[${index}][nom]" placeholder="Nom"
                    class="w-full px-3 py-1.5 border rounded-md shadow-sm focus:ring-[#0E2939] focus:border-[#0E2939] text-sm">
            </td>
            <td class="px-4 py-2">
                <select name="elements[${index}][action]" class="w-full px-3 py-1.5 border rounded-md shadow-sm focus:ring-[#0E2939] focus:border-[#0E2939] text-sm">
                    <option value="creation">Création</option>
                    <option value="modification">Modification</option>
                    <option value="suppression">Suppression</option>
                    <option value="existant">Existant</option>
                </select>
            </td>
            <td class="px-4 py-2">
                <input type="text" name="elements[${index}][origine]" placeholder="Origine"
                    class="w-full px-3 py-1.5 border rounded-md shadow-sm focus:ring-[#0E2939] focus:border-[#0E2939] text-sm">
            </td>
            <td class="px-4 py-2">
                <input type="text" name="elements[${index}][destination]" placeholder="Destination"
                    class="w-full px-3 py-1.5 border rounded-md shadow-sm focus:ring-[#0E2939] focus:border-[#0E2939] text-sm">
            </td>
            <td class="px-4 py-2">
                <input type="number" name="elements[${index}][capacite_fo]" placeholder="Nb fibres"
                    class="w-full px-3 py-1.5 border rounded-md shadow-sm focus:ring-[#0E2939] focus:border-[#0E2939] text-sm">
            </td>
            <td class="px-4 py-2">
                <input type="text" name="elements[${index}][commentaire]" placeholder="Commentaire"
                    class="w-full px-3 py-1.5 border rounded-md shadow-sm focus:ring-[#0E2939] focus:border-[#0E2939] text-sm">
            </td>
            <td class="px-4 py-2 text-center">
                <button type="button" class="remove-row bg-red-500 hover:bg-red-700 text-white w-8 h-8 rounded-full shadow-md transition flex items-center justify-center mx-auto" title="Supprimer">
                    <i class="fas fa-trash-alt text-sm"></i>
                </button>
            </td>
        `;
        tbody.appendChild(row);
        index++;
        updateCounter();
    });

    // Suppression d'une ligne (délégation)
    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.remove-row');
        if (btn) {
            const row = btn.closest('tr');
            if (confirm('Supprimer cet élément ?')) {
                row.remove();
                updateCounter();
            }
        }
    });

    // Initialisation du compteur
    document.addEventListener('DOMContentLoaded', updateCounter);
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/safibrq/dashboard/csmaadministration/resources/views/commandes/create.blade.php ENDPATH**/ ?>