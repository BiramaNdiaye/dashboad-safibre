<?php $__env->startSection('content'); ?>
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Éditer Frontal</h1>

    <?php if($errors->any()): ?>
        <div class="bg-red-200 text-red-800 p-2 mb-4 rounded">
            <ul>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?php echo e(route('frontals.update', $frontal)); ?>" method="POST" class="space-y-4">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div>
            <label class="block font-semibold">Type de projet</label>
            <input type="text" name="type_projet" value="<?php echo e(old('type_projet', $frontal->type_projet)); ?>" class="border rounded p-2 w-full">
            <select name="type_projet" id="type_projet" class="border p-2 w-full">
                <option value="PROD" <?php echo e(old('type_projet', $frontal->type_projet) == 'PROD' ? 'selected' : ''); ?>>PROD</option>
                <option value="RATTRAP FCI" <?php echo e(old('type_projet', $frontal->type_projet) == 'RATTRAP FCI' ? 'selected' : ''); ?>>RATTRAP FCI</option>
               
            </select>
        </div>

        <div>
            <label class="block font-semibold">Statut FCI</label>
            <select name="statut_fci" id="statut_fci" class="border p-2 w-full">
                <option value="simple" <?php echo e(old('statut_fci', $frontal->statut_fci) == 'simple' ? 'selected' : ''); ?>>Simple</option>
                <option value="complexe" <?php echo e(old('statut_fci', $frontal->statut_fci) == 'complexe' ? 'selected' : ''); ?>>Complexe</option>
                <option value="annulation" <?php echo e(old('statut_fci', $frontal->statut_fci) == 'annulation' ? 'selected' : ''); ?>>Annulation</option>
                <option value="Accompagnement" <?php echo e(old('statut_fci', $frontal->statut_fci) == 'Accompagnement' ? 'selected' : ''); ?>>Accompagnement</option>
            </select>
        </div>

        <div>
            <label class="block font-semibold">Date de déclaration</label>
            <input type="date" name="date_declaration" value="<?php echo e(old('date_declaration', $frontal->date_declaration->format('Y-m-d'))); ?>" class="border rounded p-2 w-full">
        </div>

        <div>
            <label class="block font-semibold">Numéro FCI</label>
            <input type="text" name="numero_fci" value="<?php echo e(old('numero_fci', $frontal->numero_fci)); ?>" class="border rounded p-2 w-full">
        </div>

        <div>
            <label class="block font-semibold">Numéro FCI Annulation</label>
            <input type="text" name="numero_fci_annulation" value="<?php echo e(old('numero_fci_annulation', $frontal->numero_fci_annulation)); ?>" class="border rounded p-2 w-full">
        </div>

        <div>
            <label class="block font-semibold">Référence Projet</label>
             <input type="text" name="reference" value="<?php echo e(old('reference', $frontal->reference)); ?>" class="border rounded p-2 w-full">
        </div>

        <!-- Codes Ensee et Numéros d'études -->
        <div id="codes_ensees_container" class="mt-4">
            <?php $__currentLoopData = $etudes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $etude): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="code_ensee_block mb-2">
                <input type="text" name="codes_ensee[]" value="<?php echo e(old('codes_ensee.'.$index, $etude->code_ensee)); ?>" placeholder="Code Ensee" class="border p-2 mb-2 w-full code_ensee_input">
                <select name="etudes_ids[<?php echo e($index); ?>][]" class="border p-2 w-full etudes_select">
                    <option value="<?php echo e($etude->id); ?>" selected><?php echo e($etude->numero_etude); ?></option>
                </select>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <button type="button" id="add_code_ensee" class="bg-blue-500 text-white px-3 py-1 rounded mt-2 <?php echo e($frontal->statut_fci == 'complexe' ? '' : 'hidden'); ?>">
            Ajouter un code Ensee
        </button>

        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded mt-4 hover:bg-green-700">
            Mettre à jour
        </button>
    </form>
</div>

<script>
let count = <?php echo e($etudes->count()); ?>;

// Afficher bouton ajouter si complexe
document.getElementById('statut_fci').addEventListener('change', function() {
    let addBtn = document.getElementById('add_code_ensee');
    let container = document.getElementById('codes_ensees_container');
    if(this.value === 'complexe'){
        addBtn.style.display = 'inline-block';
    } else {
        addBtn.style.display = 'none';
        let firstBlock = container.querySelector('.code_ensee_block').outerHTML;
        container.innerHTML = firstBlock;
    }
});

// Ajouter un nouveau code Ensee + select
document.getElementById('add_code_ensee').addEventListener('click', function() {
    let container = document.getElementById('codes_ensees_container');
    let newBlock = document.createElement('div');
    newBlock.classList.add('code_ensee_block', 'mt-2');
    newBlock.innerHTML = `
        <input type="text" name="codes_ensee[]" placeholder="Code Ensee" class="border p-2 mb-2 w-full code_ensee_input">
        <select name="etudes_ids[${count}][]" class="border p-2 w-full etudes_select">
            <option value="">-- Sélectionner un numéro d'étude --</option>
        </select>
    `;
    container.appendChild(newBlock);
    count++;
});

// Remplir les selects dynamiquement selon code Ensee
document.addEventListener('input', function(e){
    if(e.target.matches('.code_ensee_input')){
        let code = e.target.value;
        let select = e.target.nextElementSibling;
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/safibrq/dashboard/csmaadministration/resources/views/frontals/edit.blade.php ENDPATH**/ ?>