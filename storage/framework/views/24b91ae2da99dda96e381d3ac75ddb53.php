<?php $__env->startSection('title', 'Dashboard ROP'); ?>

<?php $__env->startSection('styles'); ?>
<style>
    /* Styles personnalisés pour le dashboard */
    .dashboard-container {
        font-family: 'Inter', sans-serif !important;
        background-color: #f8fafc !important;
    }
    
    .gradient-bg {
        background: linear-gradient(135deg, #45C4EB 0%, #F7881B 100%) !important;
    }
    
    .card-hover {
        transition: all 0.3s ease !important;
    }
    
    .card-hover:hover {
        transform: translateY(-5px) !important;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04) !important;
    }
    
    .stat-card {
        position: relative !important;
        overflow: hidden !important;
    }
    
    .stat-card::before {
        content: '' !important;
        position: absolute !important;
        top: 0 !important;
        left: 0 !important;
        right: 0 !important;
        height: 4px !important;
        background: linear-gradient(90deg, #45C4EB, #F7881B) !important;
    }
    
    .filter-section {
        background: linear-gradient(to bottom right, #ffffff, #f1f5f9) !important;
        backdrop-filter: blur(10px) !important;
    }
    
    /* Assurer que les styles personnalisés prennent le dessus */
    .custom-text-primary-blue {
        color: #45C4EB !important;
    }
    
    .custom-text-primary-orange {
        color: #F7881B !important;
    }
    
    .custom-bg-primary-blue {
        background-color: #45C4EB !important;
    }
    
    .custom-bg-primary-orange {
        background-color: #F7881B !important;
    }
    
    .custom-border-primary-blue {
        border-color: #45C4EB !important;
    }
    
    .custom-border-primary-orange {
        border-color: #F7881B !important;
    }
    
    /* Styles pour les graphiques */
    .chart-container {
        position: relative;
        height: 300px;
        width: 100%;
    }
    
    /* Header decorations */
    .header-decoration {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        overflow: hidden;
        z-index: 0;
    }
    
    .header-content {
        position: relative;
        z-index: 10;
    }
    
    /* Amélioration responsive */
    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)) !important;
        }
        
        .filter-form {
            grid-template-columns: 1fr !important;
        }
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- En-tête améliorée avec dégradé -->
    <div class="text-center mb-10 py-10 rounded-2xl shadow-lg bg-[#45C4EB] text-white relative overflow-hidden">
        <div class="header-decoration">
            <div class="absolute -top-4 -right-4 w-28 h-28 rounded-full bg-white opacity-10"></div>
            <div class="absolute -bottom-8 -left-8 w-36 h-36 rounded-full bg-white opacity-10"></div>
        </div>
        <div class="header-content">
            <h1 class="text-4xl font-bold mb-2">
                <?php echo e(__('Bienvenue')); ?> <span class="text-white"><?php echo e(Auth::user()->name); ?></span> !
            </h1>
            <?php if (\Illuminate\Support\Facades\Blade::check('hasanyrole', 'admin|Manager')): ?>
                <p class="text-xl opacity-90">Aperçu global de l'activité des ROP</p>
            <?php endif; ?>
        </div>
    </div>
 <?php if (\Illuminate\Support\Facades\Blade::check('hasanyrole', 'admin|Manager')): ?>
    <!-- Formulaire de filtres amélioré -->
    <div class="filter-section p-6 rounded-2xl shadow-lg mb-8 border border-gray-100">
        <h2 class="text-lg font-semibold text-gray-700 mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2 custom-text-primary-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
            </svg>
            Filtres
        </h2>
        <form method="GET" action="<?php echo e(route('home.index')); ?>" class="grid grid-cols-1 md:grid-cols-4 gap-5 filter-form">
            <!-- Année -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Année</label>
                <div class="relative">
                    <select name="annee" class="w-full rounded-xl border-gray-200 shadow-sm focus:border-[#45C4EB] focus:ring-[#45C4EB] py-3 px-4 border bg-white appearance-none">
                        <?php $__currentLoopData = $availableYears; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($year); ?>" <?php echo e($selectedYear == $year ? 'selected' : ''); ?>><?php echo e($year); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Mois -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Mois</label>
                <div class="relative">
                    <select name="mois" class="w-full rounded-xl border-gray-200 shadow-sm focus:border-[#45C4EB] focus:ring-[#45C4EB] py-3 px-4 border bg-white appearance-none">
                        <option value="">Tous</option>
                        <?php $__currentLoopData = $availableMonths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $num => $mois): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($num); ?>" <?php echo e($selectedMonth == $num ? 'selected' : ''); ?>><?php echo e($mois); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Client -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Client</label>
                <div class="relative">
                    <select name="client" class="w-full rounded-xl border-gray-200 shadow-sm focus:border-[#45C4EB] focus:ring-[#45C4EB] py-3 px-4 border bg-white appearance-none">
                        <option value="">Tous</option>
                        <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($client->id); ?>" <?php echo e($selectedClient == $client->id ? 'selected' : ''); ?>><?php echo e($client->nom); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Boutons -->
            <div class="flex items-end gap-3">
                <button type="submit" 
                        class="flex-1 bg-[#45C4EB] hover:from-[#3aa8d1] hover:to-[#45C4EB] text-white font-medium py-3 px-4 rounded-xl shadow-md transition-all duration-200 ease-in-out transform hover:scale-[1.02] flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                    </svg>
                    Filtrer
                </button>
                <a href="<?php echo e(route('home.index')); ?>" 
                   class="flex-1 bg-white text-[#45C4EB] hover:text-[#3aa8d1] font-medium py-3 px-4 rounded-xl border border-gray-200 hover:border-[#3aa8d1] shadow-sm transition-all duration-200 ease-in-out transform hover:scale-[1.02] flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Réinitialiser
                </a>
            </div>
        </form>
    </div>

    <!-- Cartes clients améliorées -->
    <div class="mb-8">
        <h2 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
            <svg class="w-6 h-6 mr-2 custom-text-primary-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
            Statistiques par client
        </h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-5 stats-grid">
            <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $total = $cardsData[$client->id]->total ?? 0;
                    $bgColors = ['bg-gradient-to-br from-indigo-50 to-indigo-100', 'bg-gradient-to-br from-blue-50 to-blue-100', 'bg-gradient-to-br from-emerald-50 to-emerald-100', 'bg-gradient-to-br from-amber-50 to-amber-100', 'bg-gradient-to-br from-purple-50 to-purple-100'];
                    $textColors = ['text-indigo-700', 'text-blue-700', 'text-emerald-700', 'text-amber-700', 'text-purple-700'];
                    $borderColors = ['border-indigo-200', 'border-blue-200', 'border-emerald-200', 'border-amber-200', 'border-purple-200'];
                    $colorIndex = $index % count($bgColors);
                ?>
                <div class="rounded-2xl shadow-md p-5 card-hover stat-card <?php echo e($bgColors[$colorIndex]); ?> <?php echo e($borderColors[$colorIndex]); ?> border">
                    <div class="text-center">
                        <h5 class="text-md font-semibold text-gray-800 mb-3 truncate" title="<?php echo e($client->nom); ?>"><?php echo e($client->nom); ?></h5>
                        <h2 class="text-4xl font-bold <?php echo e($textColors[$colorIndex]); ?> mb-2"><?php echo e($total); ?></h2>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">ROP livrés</p>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

    <!-- Dashboard Charts améliorés -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Pie Chart -->
        <div class="bg-white p-6 rounded-2xl shadow-lg card-hover">
            <h2 class="text-xl font-semibold text-gray-800 mb-4 text-center flex items-center justify-center">
                <svg class="w-6 h-6 mr-2 custom-text-primary-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
                </svg>
                Répartition des ROP par client
            </h2>
            <div class="chart-container">
                <canvas id="ropPieChart"></canvas>
            </div>
        </div>

        <!-- Line Chart -->
        <div class="bg-white p-6 rounded-2xl shadow-lg card-hover">
            <h2 class="text-xl font-semibold text-gray-800 mb-4 text-center flex items-center justify-center">
                <svg class="w-6 h-6 mr-2 custom-text-primary-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                </svg>
                Évolution des ROP livrés
            </h2>
            <div class="chart-container h-96">
                <canvas id="evolutionChart"></canvas>
            </div>
        </div>
    </div>
 <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Pie Chart
    const ctxPie = document.getElementById('ropPieChart');
    if (ctxPie) {
        new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode($pieLabels, 15, 512) ?>,
                datasets: [{
                    data: <?php echo json_encode($pieValues, 15, 512) ?>,
                    backgroundColor: [
                        '#45C4EB', '#F7881B', '#3B82F6', '#10B981', '#8B5CF6', 
                        '#EC4899', '#F59E0B', '#EF4444', '#84CC16', '#6366F1'
                    ],
                    borderWidth: 2,
                    borderColor: '#fff',
                    hoverOffset: 15,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { 
                        position: 'right', 
                        labels: { 
                            padding: 20, 
                            font: { 
                                size: 13, 
                                weight: '500',
                                family: 'Inter'
                            } 
                        } 
                    },
                    tooltip: {
    backgroundColor: 'rgba(255, 255, 255, 0.9)',
    titleColor: '#1F2937',
    bodyColor: '#1F2937',
    borderColor: '#E5E7EB',
    borderWidth: 1,
    padding: 12,
    callbacks: {
        label: function(context) {
            let total = context.chart._metasets[0].total; // somme des valeurs
            let value = context.raw;
            let percentage = ((value / total) * 100).toFixed(1) + '%';
            return context.label + ': ' + value + ' (' + percentage + ')';
        }
    }
}

                },
                cutout: '50%'
            }
        });
    }

   // Bar Chart (ROP livrés par mois)
const ctxBar = document.getElementById('evolutionChart');
if (ctxBar) {
    new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($labels, 15, 512) ?>,
            datasets: <?php echo json_encode($chartData, 15, 512) ?>
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                title: {
                    display: true,
                    text: 'ROP livrés par mois - <?php echo e($selectedYear); ?>',
                    font: { size: 18, weight: '600', family: 'Inter' },
                    color: '#1F2937'
                },
                legend: {
                    position: 'bottom',
                    labels: {
                        boxWidth: 20,  // taille du carré de couleur
                        padding: 15
                    }
                },
                tooltip: { mode: 'index', intersect: false }
            },
            interaction: { mode: 'nearest', intersect: false },
            scales: {
                x: {
                    stacked: false,
                    grid: { display: false },
                    categoryPercentage: 1,  // 80% de la largeur de la catégorie utilisée
                    barPercentage: 1        // chaque barre utilise 90% de l'espace disponible
                },
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            }
        }
    });
}



});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/safibrq/dashboard/csmaadministration/resources/views/home/index.blade.php ENDPATH**/ ?>