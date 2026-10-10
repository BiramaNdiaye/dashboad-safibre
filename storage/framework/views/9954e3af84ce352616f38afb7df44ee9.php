<?php $__env->startSection('content'); ?>
  <!-- Formulaire de filtre -->
 
    
<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-lg font-semibold text-gray-700 mb-4">📊 Filtrer l'évolution des projets</h2>
    <form action="<?php echo e(route('statistiques.evolution-projet')); ?>" method="GET" class="flex flex-col md:flex-row gap-4 items-center">
        
        <!-- Sélection de l'année -->
        <label for="annee" class="text-sm font-medium text-gray-700">Année :</label>
        <select id="annee" name="annee" class="w-full md:w-40 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            <?php for($i = date('Y'); $i >= 2020; $i--): ?>
                <option value="<?php echo e($i); ?>" <?php echo e($annee == $i ? 'selected' : ''); ?>><?php echo e($i); ?></option>
            <?php endfor; ?>
        </select>

        <!-- Sélection du mois -->
        <label for="mois" class="text-sm font-medium text-gray-700">Mois :</label>
        <select id="mois" name="mois" class="w-full md:w-40 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            <option value="">Tous</option>
            <?php $__currentLoopData = range(1, 12); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($m); ?>" <?php echo e($mois == $m ? 'selected' : ''); ?>>
                    <?php echo e(DateTime::createFromFormat('!m', $m)->format('F')); ?>

                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>

        <button type="submit" class="bg-[#45C4EB] text-white px-4 py-2 rounded-md shadow-md transition-all hover:bg-[#F7881B] hover:scale-105">
            Filtrer
        </button>
    </form>
</div>

<!-- Conteneur pour le graphique -->
<div class="mt-8 bg-white p-6 rounded-lg shadow-md">
    <h3 class="text-lg font-semibold text-gray-700 mb-4">📈 Évolution mensuelles des projets Livrées </h3>
    <div class="w-full">
        <canvas id="evolutionChart" class="w-full h-[400px]"></canvas>
    </div>
</div>

<!-- Script pour initialiser Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('evolutionChart').getContext('2d');
        const evolutionChart = new Chart(ctx, {
            type: 'bar', 
            data: {
                labels: <?php echo json_encode($labels, 15, 512) ?>, 
                datasets: <?php echo json_encode($datasets, 15, 512) ?> 
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { beginAtZero: true },
                    x: { stacked: false }
                },
                plugins: {
                    legend: { position: 'top' },
                    title: {
                        display: true,
                        text: 'Évolution mensuelle des projets par client (Année : <?php echo e($annee); ?> <?php echo e($mois ? "- Mois : " . DateTime::createFromFormat("!m", $mois)->format("F") : ""); ?>)'
                    }
                }
            }
        });
    });
</script>






<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/safibrq/dashboard/csmaadministration/resources/views/statistiques/evolution-projet.blade.php ENDPATH**/ ?>