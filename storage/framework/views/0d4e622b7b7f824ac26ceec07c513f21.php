<?php $__env->startSection('content'); ?>
<div class="bg-gray-50 min-h-screen py-8 px-4 sm:px-6 lg:px-8">

    
    <div class="text-center mb-8">
        <h1 class="text-4xl md:text-5xl font-extrabold bg-gradient-to-r from-cyan-500 to-orange-500 text-transparent bg-clip-text inline-block">
            Suivi des ROP livrées
        </h1>
        <div class="w-24 h-1 bg-gradient-to-r from-cyan-500 to-orange-500 mx-auto mt-3 rounded-full"></div>
        <p class="text-gray-500 mt-2">Visualisez les livraisons ROP, Extensions et BPE par jour et par client</p>
    </div>

    
    <div class="bg-white rounded-xl shadow-md p-6 mb-8">
        <form method="GET" action="<?php echo e(route('rop.graph.index')); ?>" class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">

            <div>
                <label for="client_id" class="block text-sm font-medium text-gray-700">Client</label>
                <select id="client_id" name="client_id"
                    class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-cyan-400 focus:border-cyan-400">
                    <option value="">Tous les clients</option>
                    <?php $__currentLoopData = $allClients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($client->id); ?>" <?php echo e(request('client_id') == $client->id ? 'selected' : ''); ?>>
                            <?php echo e($client->nom); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div>
                <label for="rop_date_debut" class="block text-sm font-medium text-gray-700">Date livraison ROP — du</label>
                <input type="date" id="rop_date_debut" name="rop_date_debut"
                    value="<?php echo e(request('rop_date_debut')); ?>"
                    class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-cyan-400 focus:border-cyan-400">
            </div>

            <div>
                <label for="rop_date_fin" class="block text-sm font-medium text-gray-700">Date livraison ROP — au</label>
                <input type="date" id="rop_date_fin" name="rop_date_fin"
                    value="<?php echo e(request('rop_date_fin')); ?>"
                    class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-cyan-400 focus:border-cyan-400">
            </div>

            <div>
                <button type="submit"
                    class="w-full px-6 py-2.5 bg-cyan-500 hover:bg-cyan-600 text-white font-semibold rounded-lg shadow-md transition transform hover:scale-105">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Appliquer
                </button>
            </div>

            <div>
                <a href="<?php echo e(route('rop.graph.index')); ?>"
                    class="w-full inline-flex justify-center items-center px-6 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-lg shadow-md transition transform hover:scale-105">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 4v5h.582M20 20v-5h-.581M4.582 9A8 8 0 1119.419 15"/>
                    </svg>
                    Réinitialiser
                </a>
            </div>
        </form>
    </div>

    
    <?php $__empty_1 = true; $__currentLoopData = $perClientCharts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chart): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="bg-white rounded-xl shadow-md p-6 mb-8">
            <h2 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-3">
                <?php echo e($chart['client_nom']); ?>

                <span class="flex items-center gap-3 ml-4">
                    <span class="flex items-center gap-1">
                        <span class="w-3 h-3 rounded-full bg-cyan-500 inline-block"></span>
                        <span class="text-xs text-gray-500 font-normal">ROP</span>
                    </span>
                    <span class="flex items-center gap-1">
                        <span class="w-3 h-3 rounded-full bg-orange-400 inline-block"></span>
                        <span class="text-xs text-gray-500 font-normal">Extension</span>
                    </span>
                    <span class="flex items-center gap-1">
                        <span class="w-3 h-3 rounded-full bg-purple-500 inline-block"></span>
                        <span class="text-xs text-gray-500 font-normal">BPE</span>
                    </span>
                </span>
            </h2>
            <div style="height: 350px;">
                <canvas id="chart-<?php echo e($chart['client_id']); ?>"></canvas>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="bg-white rounded-xl shadow-md p-6 mb-8 text-center text-gray-400">
            Aucune donnée à afficher
        </div>
    <?php endif; ?>

    
    <div class="bg-white rounded-xl shadow-md p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
            <svg class="w-6 h-6 text-cyan-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2"/>
            </svg>
            Détail par jour
        </h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase" rowspan="2">Date</th>
                        <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $nom): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase border-l border-gray-200" colspan="3">
                                <?php echo e($nom); ?>

                            </th>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </tr>
                    
                    <tr>
                        <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $nom): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <th class="px-4 py-2 text-center text-xs font-medium text-cyan-500 uppercase border-l border-gray-200">ROP</th>
                            <th class="px-4 py-2 text-center text-xs font-medium text-orange-400 uppercase">Extension</th>
                            <th class="px-4 py-2 text-center text-xs font-medium text-purple-500 uppercase">BPE</th>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php $__empty_1 = true; $__currentLoopData = $tableData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 text-sm text-gray-700"><?php echo e($row['date']); ?></td>
                            <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $nom): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <td class="px-4 py-2 text-sm text-gray-700 text-center border-l border-gray-100"><?php echo e($row[$id] ?? 0); ?></td>
                                <td class="px-4 py-2 text-sm text-gray-700 text-center"><?php echo e(number_format($row['capacite_' . $id] ?? 0, 2)); ?></td>
                                <td class="px-4 py-2 text-sm text-gray-700 text-center"><?php echo e(number_format($row['nbre_bpe_' . $id] ?? 0, 2)); ?></td>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="<?php echo e((count($clients) * 3) + 4); ?>" class="text-center py-4 text-gray-500">
                                Aucune donnée disponible
                            </td>
                        </tr>
                    <?php endif; ?>

                    
                    <?php if(count($tableData) > 0): ?>
                        <tr class="bg-cyan-50 border-t-2 border-cyan-300 font-bold">
                            <td class="px-4 py-3 text-sm text-cyan-700 uppercase tracking-wide">Total</td>

                            <td class="px-4 py-3 text-sm text-cyan-700 text-center border-l border-cyan-200">
                                <?php echo e(array_sum(array_column($tableData, 'total'))); ?>

                            </td>
                            <td class="px-4 py-3 text-sm text-orange-500 text-center">
                                <?php echo e(number_format(array_sum(array_column($tableData, 'total_capacite')), 2)); ?>

                            </td>
                            <td class="px-4 py-3 text-sm text-purple-500 text-center">
                                <?php echo e(number_format(array_sum(array_column($tableData, 'total_nbre_bpe')), 2)); ?>

                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const labels          = <?php echo json_encode($labels, 15, 512) ?>;
        const perClientCharts = <?php echo json_encode($perClientCharts, 15, 512) ?>;

        const COLOR_ROP = '#06b6d4';
        const COLOR_CAP = '#fb923c';
        const COLOR_BPE = '#a855f7';

        perClientCharts.forEach(function (chart) {
            const canvas = document.getElementById('chart-' + chart.client_id);
            if (!canvas) return;
            const ctx = canvas.getContext('2d');

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'ROP',
                            data: chart.rop,
                            backgroundColor: COLOR_ROP + 'aa',
                            borderColor: COLOR_ROP,
                            borderWidth: 1,
                            yAxisID: 'yRop',
                            grouped: true,
                            order: 1
                        },
                        {
                            label: 'Extension',
                            data: chart.capacite,
                            backgroundColor: COLOR_CAP + 'aa',
                            borderColor: COLOR_CAP,
                            borderWidth: 1,
                            yAxisID: 'yCap',
                            grouped: true,
                            order: 2
                        },
                        {
                            label: 'BPE',
                            data: chart.bpe,
                            backgroundColor: COLOR_BPE + 'aa',
                            borderColor: COLOR_BPE,
                            borderWidth: 1,
                            yAxisID: 'yBpe',
                            grouped: true,
                            order: 3
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }, // légende déjà affichée au-dessus du graphique
                        tooltip: {
                            callbacks: {
                                label: function (ctx) {
                                    const label = ctx.dataset.label;
                                    const value = ctx.parsed.y;
                                    if (label === 'ROP') return label + ' : ' + value;
                                    return label + ' : ' + value.toFixed(2);
                                }
                            }
                        }
                    },
                    scales: {
                        yRop: {
                            type: 'linear',
                            position: 'left',
                            beginAtZero: true,
                            ticks: { precision: 0, color: COLOR_ROP },
                            title: { display: true, text: 'ROP', color: COLOR_ROP },
                            grid: { drawOnChartArea: true }
                        },
                        yCap: {
                            type: 'linear',
                            position: 'right',
                            beginAtZero: true,
                            ticks: { color: COLOR_CAP },
                            title: { display: true, text: 'Extension', color: COLOR_CAP },
                            grid: { drawOnChartArea: false }
                        },
                        yBpe: {
                            type: 'linear',
                            position: 'right',
                            beginAtZero: true,
                            ticks: { color: COLOR_BPE },
                            title: { display: true, text: 'BPE', color: COLOR_BPE },
                            grid: { drawOnChartArea: false },
                            offset: true
                        },
                        x: {
                            title: { display: true, text: 'Date de livraison ROP' }
                        }
                    }
                }
            });
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/safibrq/dashboard/csmaadministration/resources/views/rop-graph/index.blade.php ENDPATH**/ ?>