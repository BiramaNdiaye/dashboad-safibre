<?php $__env->startSection('content'); ?>
<div class="container mx-auto p-4">

    <h2 class="text-5xl font-extrabold text-center text-gray-800 mb-6 relative mt-3">
        <span class="text-[#45C4EB]">Ajouter un nouveau FCI</span>
        <span class="block w-16 h-1 bg-[#F7881B] mx-auto mt-2 rounded-full"></span>
    </h2>

    <?php if(session('success')): ?>
        <div class="bg-green-200 text-green-800 p-3 mb-4 rounded-lg font-semibold shadow">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

   


    <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-lg mt-10 border border-gray-200">

        <form action="<?php echo e(route('frontals.store')); ?>" method="POST" class="space-y-6">
            <?php echo csrf_field(); ?>

            <!-- Grille 2 colonnes -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Type de projet -->
                <div>
                    <label class="block font-semibold mb-1">Type de projet</label>
                    <select name="type_projet" class="w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-[#45C4EB]">
                        <option value="PROD" <?php echo e(old('type_projet') == 'PROD' ? 'selected' : ''); ?>>PROD</option>
                        <option value="RATTRAP FCI" <?php echo e(old('type_projet') == 'RATTRAP FCI' ? 'selected' : ''); ?>>RATTRAP FCI</option>
                    </select>

                    <?php $__errorArgs = ['type_projet'];
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

                <!-- Statut FCI -->
                <div>
                    <label class="block font-semibold mb-1">Statut FCI</label>
                    <select name="statut_fci" id="statut_fci" class="w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-[#45C4EB]">
                        <option value="simple">Simple</option>
                        <option value="complexe">Complexe</option>
                        <option value="annulation">Annulation</option>
                        <option value="Accompagnement">Accompagnement</option>
                    </select>

                    <?php $__errorArgs = ['statut_fci'];
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

                <!-- Date déclaration -->
                <div>
                    <label class="block font-semibold mb-1">Date de déclaration</label>
                    <input type="date" name="date_declaration" value="<?php echo e(old('date_declaration')); ?>"
                        class="w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-[#45C4EB]">

                    <?php $__errorArgs = ['date_declaration'];
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

                <!-- Numéro FCI -->
                <div>
                    <label class="block font-semibold mb-1">Numéro FCI</label>
                    <input type="text" name="numero_fci" value="<?php echo e(old('numero_fci')); ?>"
                        class="w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-[#45C4EB]">

                    <?php $__errorArgs = ['numero_fci'];
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

                <!-- Numéro FCI Annulation -->
                <div id="fci_annulation_block" style="display:none;">
                    <label class="block font-semibold mb-1">Numéro FCI Annulation</label>
                    <input type="text" name="numero_fci_annulation" value="<?php echo e(old('numero_fci_annulation')); ?>"
                        class="w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-[#45C4EB]">

                    <?php $__errorArgs = ['numero_fci_annulation'];
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

                <!-- Projet -->
                <div>
                    <label class="block font-semibold mb-1">Projet</label>
                    <input type="text" name="reference" value="<?php echo e(old('reference')); ?>"
                        class="w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-[#45C4EB]">

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

            </div>

            <!-- Codes Ensee & Études -->
            <div id="codes_ensees_container" class="mt-6">
                <label class="block font-semibold mb-2">Codes Ensee et Études</label>

                <div class="code_ensee_block grid grid-cols-1 md:grid-cols-2 gap-4">

                    <div>
                        <input type="text" name="codes_ensee[]" placeholder="Code Ensee"
                               class="w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-[#45C4EB] code_ensee_input">

                        <?php $__errorArgs = ['codes_ensee.*'];
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

                    <div>
                        <select name="etudes_ids[0][]" class="w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-[#45C4EB] etudes_select">
                            <option value="">-- Sélectionner un numéro d'étude --</option>
                        </select>

                        <?php $__errorArgs = ['etudes_ids.*.*'];
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
            </div>

            <button type="button" id="add_code_ensee"
                class="px-4 py-2 border rounded-lg shadow-sm text-gray-800 mt-2 hidden">
                Ajouter un code Ensee
            </button>

            <!-- Boutons -->
            <div class="flex justify-end space-x-3 mt-4">
                <a href="<?php echo e(route('etudes.create')); ?>"
                   class="bg-[#45C4EB] hover:bg-[#F7881B] text-white font-semibold px-5 py-2 rounded-lg shadow-md flex items-center">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Ajouter une étude
                </a>

                <button type="submit"
                    class="bg-[#45C4EB] hover:bg-[#F7881B] text-white font-semibold px-6 py-2 rounded-lg shadow-md">
                    Enregistrer
                </button>
            </div>

        </form>
    </div>

</div>



<script>
let count = 1;

// Afficher bouton ajouter si complexe
document.getElementById('statut_fci').addEventListener('change', function() {
    let addBtn = document.getElementById('add_code_ensee');
    let container = document.getElementById('codes_ensees_container');

    if (this.value === 'complexe') addBtn.style.display = 'inline-block';
    else {
        addBtn.style.display = 'none';
        let firstBlock = container.querySelector('.code_ensee_block').outerHTML;
        container.innerHTML = firstBlock;
    }
});

// Ajouter un nouveau code Ensee
document.getElementById('add_code_ensee').addEventListener('click', function() {
    let container = document.getElementById('codes_ensees_container');
    let newBlock = document.createElement('div');
    newBlock.classList.add('code_ensee_block', 'mt-2', 'grid', 'grid-cols-1', 'md:grid-cols-2', 'gap-4');

    newBlock.innerHTML = `
        <div>
            <input type="text" name="codes_ensee[]" placeholder="Code Ensee"
                   class="w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-[#45C4EB] code_ensee_input">
        </div>

        <div>
            <select name="etudes_ids[${count}][]" class="w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-[#45C4EB] etudes_select">
                <option value="">-- Sélectionner un numéro d'étude --</option>
            </select>
        </div>
    `;

    container.appendChild(newBlock);
    count++;
});

// Recherche études par code Ensee
document.addEventListener('input', function(e){
    if(e.target.matches('.code_ensee_input')){
        let code = e.target.value;
        let select = e.target.parentElement.nextElementSibling.querySelector('select');

        if(!code){
            select.innerHTML = '<option value="">-- Sélectionner un numéro d\'étude --</option>';
            return;
        }

        fetch(`/etudes/search-result?code_ensee=${code}`)
            .then(res => res.json())
            .then(data => {
                select.innerHTML = '<option value="">-- Sélectionner un numéro d\'étude --</option>';
                data.forEach(etude => {
                    select.innerHTML += `<option value="${etude.id}">${etude.numero_etude}</option>`;
                });
            });
    }
});
</script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const statutFci = document.getElementById('statut_fci');
    const block = document.getElementById('fci_annulation_block');

    function toggle() {
        if (statutFci.value === 'annulation') block.style.display = 'block';
        else {
            block.style.display = 'none';
            document.getElementById('numero_fci_annulation').value = '';
        }
    }

    toggle();
    statutFci.addEventListener('change', toggle);
});
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/safibrq/dashboard/csmaadministration/resources/views/frontals/create.blade.php ENDPATH**/ ?>