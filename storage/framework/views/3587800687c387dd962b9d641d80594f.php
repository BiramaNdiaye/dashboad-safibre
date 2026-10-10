<?php $__env->startSection('content'); ?>
<h2 class="text-5xl font-extrabold text-center text-gray-800 mb-6 relative">
    <span class="bg-[#45C4EB]  text-transparent bg-clip-text ">
         KPI par chef de projet
    </span>
    <span class="block w-16 h-1 bg-[#F7881B] mx-auto mt-2 rounded-full"></span>
</h2>
<div class="max-w-5xl mx-auto p-6 bg-white shadow-lg rounded-lg">
    

    <!-- Formulaire de filtrage -->
    <form method="GET" action="<?php echo e(route('statistiques.index')); ?>" class="flex items-center space-x-4 mb-6">
        <!-- Sélection du mois -->
        <select name="mois" class="border rounded px-4 py-2">
            <?php $__currentLoopData = range(1, 12); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e(sprintf('%02d', $m)); ?>" <?php echo e($mois == $m ? 'selected' : ''); ?>>
                    <?php echo e(\Carbon\Carbon::create()->month($m)->translatedFormat('F')); ?> <!-- Mois en français -->
                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    
        <!-- Sélection de l'année -->
        <select name="annee" class="border rounded px-4 py-2">
            <?php $__currentLoopData = range(date('Y') - 5, date('Y')); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($a); ?>" <?php echo e($annee == $a ? 'selected' : ''); ?>>
                    <?php echo e($a); ?>

                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    
        <!-- Bouton Filtrer -->
        <button type="submit" class="bg-[#45C4EB] text-white px-4 py-2 rounded-md hover:bg-[#F58719]">
            Filtrer
        </button>
    </form>
    

    <!-- Conteneur pour le graphique -->
    <div class="mt-6 flex justify-center">
        <div class="w-full max-w-3xl"> <!-- Augmente la largeur max -->
            <canvas id="projetsChart" class="w-full h-[400px]"></canvas> <!-- Augmentation de la hauteur -->
        </div>
    </div>
</div>

<!-- Script Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('projetsChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($labels, 15, 512) ?>,
                datasets: [{
                    label: 'Nombre de projets réalisés (Mois : <?php echo e($mois); ?>)',
                    data: <?php echo json_encode($data, 15, 512) ?>,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { beginAtZero: true }
                },
                plugins: {
                    legend: { position: 'top' },
                    title: {
                        display: true,
                        text: 'Nombre de projets par utilisateur (Mois : <?php echo e($mois); ?>)',
                        font: { size: 16 }
                    }
                }
            }
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/safibrq/dashboard/csmaadministration/resources/views/statistiques/index.blade.php ENDPATH**/ ?>