<?php $__env->startSection('content'); ?>
<h2 class="text-3xl font-extrabold text-center text-gray-800 mb-6 relative">
    <span class="bg-[#45C4EB]  text-transparent bg-clip-text uppercase">
        Ajouter  une FCI 
    </span>
    <span class="block w-16 h-1 bg-[#F7881B] mx-auto mt-2 rounded-full"></span>
</h2>


 <?php if(session('success')): ?>
        <div class="bg-green-200 text-green-800 p-2 mb-4 rounded">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <?php if($errors->any()): ?>
        <div class="bg-red-200 text-red-800 p-2 mb-4 rounded">
            <ul>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>
<div class="max-w-4xl mx-auto bg-white shadow-lg rounded-2xl p-6 mt-6">


<form action="<?php echo e(route('fci-nexloop.store')); ?>" method="POST" class="space-y-6">
    <?php echo csrf_field(); ?>

    <!-- Grille 2 colonnes -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Projet -->
        <div>
            <label for="site" class="block font-semibold mb-1">Site Client</label>
            <input type="text" name="site" id="site" value="<?php echo e(old('site')); ?>" 
                class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200">
        </div>

        <!-- Statut FCI -->
        <div>
            <label for="type" class="block font-semibold mb-1">Statut FCI</label>
            <select name="type" id="type" class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200">
                <option value="Simple">Simple</option>
                <option value="Complexe">Complexe</option>
            </select>
        </div>

        <!-- Numéro FCI -->
        <div>
            <label for="numero_fci" class="block font-semibold mb-1">Numéro FCI</label>
            <input type="text" name="numero_fci" id="numero_fci" value="<?php echo e(old('numero_fci')); ?>" 
                class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200">
        </div>

        <div>
            <label for="client" class="block font-semibold mb-1">Client</label>
            <select name="client" id="client" class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] transition duration-200">
                <option value="NEXLOOP">NEXLOOP</option>
                <option value="MCCONNECTIC">MCCONNECTIC</option>
            </select>
        </div>
    </div>

    <!-- Codes Ensei et Études -->
    <div id="codes_ensees_container" class="mt-6">
        <label class="block font-semibold mb-2">Codes Ensei et Études</label>
        <div class="code_ensee_block mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
            <input type="text" name="codes_ensei[]" placeholder="Code Ensei" 
                class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] code_ensei_input"
                data-index="0">
            <select name="etudes_ids[0][]" 
                class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] etudes_select"
                data-index="0">
                <option value="">-- Tapez un code Ensei d'abord --</option>
            </select>
        </div>
    </div>

    <button type="button" id="add_code_ensei" class="mt-1 w-1/4 px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] hidden">
        Ajouter un code Ensei
    </button>

    <div class="flex justify-end space-x-3 mt-4">
        <!-- Bouton Ajouter une étude -->
        <a href="<?php echo e(route('nexloop.etudes.create')); ?>"
           class="bg-[#45C4EB] hover:bg-[#F7881B] text-white font-semibold px-5 py-2 rounded-lg shadow-md transition duration-300 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Ajouter une étude
        </a>

        <!-- Bouton Enregistrer -->
        <button type="submit"
            class="bg-[#45C4EB] hover:bg-[#F7881B] text-white font-semibold px-6 py-2 rounded-lg shadow-md transition duration-300 focus:outline-none focus:ring-2 focus:ring-[#45C4EB]">
            Enregistrer
        </button>
    </div>
</form>

<script>
let count = 1;

// Afficher/masquer bouton ajouter selon le type
// Dans votre script JavaScript
document.getElementById('type').addEventListener('change', function() {
    let addBtn = document.getElementById('add_code_ensei');
    
    if(this.value === 'Complexe') {
        addBtn.classList.remove('hidden');
        addBtn.style.display = 'inline-block';
        
        // Pour Complexe, vous pouvez pré-remplir avec 2 blocs
        if (count === 1) {
            // Ajouter un deuxième bloc automatiquement pour Complexe
            let container = document.getElementById('codes_ensees_container');
            let newBlock = document.createElement('div');
            newBlock.classList.add('code_ensee_block', 'mb-4', 'grid', 'grid-cols-1', 'md:grid-cols-2', 'gap-4');
            newBlock.innerHTML = `
                <input type="text" name="codes_ensei[]" placeholder="Code Ensei" 
                    class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] code_ensei_input"
                    data-index="1">
                <select name="etudes_ids[1][]" 
                    class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] etudes_select"
                    data-index="1">
                    <option value="">-- Tapez un code Ensei d'abord --</option>
                </select>
            `;
            container.appendChild(newBlock);
            count = 2;
        }
    } else {
        addBtn.classList.add('hidden');
        addBtn.style.display = 'none';
        
        // Pour Simple: garder seulement le premier bloc
        let blocks = document.querySelectorAll('.code_ensee_block');
        if (blocks.length > 1) {
            for(let i = 1; i < blocks.length; i++) {
                blocks[i].remove();
            }
        }
        count = 1;
    }
});

// Ajouter un nouveau bloc code Ensei + select
document.getElementById('add_code_ensei').addEventListener('click', function() {
    let container = document.getElementById('codes_ensees_container');
    let newBlock = document.createElement('div');
    newBlock.classList.add('code_ensee_block', 'mb-4', 'grid', 'grid-cols-1', 'md:grid-cols-2', 'gap-4');
    newBlock.innerHTML = `
        <input type="text" name="codes_ensei[]" placeholder="Code Ensei" 
            class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] code_ensei_input"
            data-index="${count}">
        <select name="etudes_ids[${count}][]" 
            class="mt-1 block w-full px-4 py-2 border border-[#45C4EB] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#45C4EB] etudes_select"
            data-index="${count}">
            <option value="">-- Tapez un code Ensei d'abord --</option>
        </select>
    `;
    container.appendChild(newBlock);
    count++;
});

// Utiliser l'événement input pour détecter la saisie
document.addEventListener('input', function(e) {
    if(e.target.classList.contains('code_ensei_input')) {
        let codeEnsei = e.target.value.trim();
        let index = e.target.dataset.index;
        let select = document.querySelector(`.etudes_select[data-index="${index}"]`);
        
        // Vider le select
        select.innerHTML = '<option value="">-- Chargement...</option>';
        select.disabled = true;
        
        if(codeEnsei.length >= 2) { // Attendre au moins 2 caractères
            // Debounce pour éviter trop d'appels
            clearTimeout(window.searchTimeout);
            window.searchTimeout = setTimeout(() => {
                fetchEtudes(codeEnsei, select);
            }, 300);
        } else {
            select.innerHTML = '<option value="">-- Tapez un code Ensei d\'abord --</option>';
            select.disabled = true;
        }
    }
});

// Fonction pour récupérer les études
function fetchEtudes(codeEnsei, selectElement) {
    fetch(`/etudesfa/search-result?code_ensei=${encodeURIComponent(codeEnsei)}`)
        .then(response => {
            if(!response.ok) {
                throw new Error('Erreur réseau');
            }
            return response.json();
        })
        .then(data => {
            selectElement.innerHTML = '<option value="">-- Sélectionner un numéro d\'étude --</option>';
            
            if(data.length > 0) {
                data.forEach(etude => {
                    let option = document.createElement('option');
                    option.value = etude.id;
                    option.textContent = etude.numero_etude;
                    selectElement.appendChild(option);
                });
                selectElement.disabled = false;
            } else {
                selectElement.innerHTML = '<option value="">Aucune étude trouvée</option>';
                selectElement.disabled = true;
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            selectElement.innerHTML = '<option value="">Erreur de chargement</option>';
            selectElement.disabled = true;
        });
}

// Pré-remplir si anciennes valeurs existent
<?php if(old('codes_ensei')): ?>
    document.addEventListener('DOMContentLoaded', function() {
        let codeInputs = document.querySelectorAll('.code_ensei_input');
        <?php $__currentLoopData = old('codes_ensei', []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $codeEnsei): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if(isset($codeInputs[$index]) && $codeEnsei): ?>
                codeInputs[<?php echo e($index); ?>].value = '<?php echo e($codeEnsei); ?>';
                // Déclencher l'événement input après un délai
                setTimeout(() => {
                    let event = new Event('input');
                    codeInputs[<?php echo e($index); ?>].dispatchEvent(event);
                    
                    // Sélectionner l'ancienne valeur si elle existe
                    <?php if(isset(old('etudes_ids')[$index][0])): ?>
                        setTimeout(() => {
                            let select = document.querySelector(`.etudes_select[data-index="<?php echo e($index); ?>"]`);
                            if(select) {
                                select.value = '<?php echo e(old("etudes_ids")[$index][0]); ?>';
                            }
                        }, 500);
                    <?php endif; ?>
                }, 100);
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    });
<?php endif; ?>
</script>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/safibrq/dashboard/csmaadministration/resources/views/nexloop/fci/create.blade.php ENDPATH**/ ?>