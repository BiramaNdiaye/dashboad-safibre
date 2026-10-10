@extends('layouts.main')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50/30">
        <!-- Header -->
        <div class="bg-white/80 backdrop-blur-sm border-b border-gray-200/60 sticky top-0 z-10">
            <div class="container mx-auto px-4 py-4">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-gradient-to-r from-[#45C4EB] to-blue-500 rounded-xl shadow-lg">
                            <i class="fas fa-project-diagram text-white text-lg"></i>
                        </div>
                        <div>
                            <h1 class="text-2xl md:text-3xl font-bold bg-gradient-to-r from-[#45C4EB] to-blue-600 bg-clip-text text-transparent">
                                Détails du Patatoïde
                            </h1>
                            <p class="text-gray-500 text-sm mt-1">Informations complètes du projet</p>
                        </div>
                    </div>
                    @php
                        $routeProjet = url()->previous();
                    @endphp
                    <a href="{{ $routeProjet }}" 
                       class="group inline-flex items-center space-x-2 bg-white hover:bg-[#45C4EB] text-gray-700 hover:text-white font-medium px-5 py-2.5 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 border border-gray-200 hover:border-[#45C4EB]">
                        <i class="fas fa-arrow-left group-hover:transform group-hover:-translate-x-1 transition-transform duration-300"></i>
                        <span>Retour à la liste</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <main class="container mx-auto px-4 py-8">
            <div class="max-w-6xl mx-auto">
                <!-- Main Card -->
                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-1">
                    <!-- Card Header with Gradient -->
                    <div class="bg-gradient-to-r from-[#45C4EB]/10 to-blue-500/10 border-b border-gray-200/50 px-8 py-6">
                        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
                            <div class="flex items-center space-x-4">
                                <div class="p-3 bg-white rounded-xl shadow-sm border border-gray-200">
                                    <i class="fas fa-folder text-[#45C4EB] text-xl"></i>
                                </div>
                                <div>
                                    <h2 class="text-2xl font-bold text-gray-800">{{ $patatoide->ref_projet }}</h2>
                                    <div class="flex items-center space-x-3 mt-2">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-sm font-medium">
                                            <i class="fas fa-tag text-xs mr-1"></i>
                                            {{ $patatoide->type_projet }}
                                        </span>
                                        <span class="text-gray-500 text-sm">
                                            <i class="fas fa-map-marker-alt mr-1"></i>
                                            {{ Str::limit($patatoide->site, 40) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                @php
                                    $statusColors = [
                                        'Livré' => 'from-green-500 to-emerald-500',
                                        'En cours' => 'from-blue-500 to-cyan-500',
                                        'Traité' => 'from-purple-500 to-indigo-500',
                                        'Annulée' => 'from-red-500 to-pink-500',
                                        'Attente Info Supp' => 'from-orange-500 to-amber-500',
                                        'Reprise' => 'from-yellow-500 to-orange-500'
                                    ];
                                    $statusColor = $statusColors[$patatoide->statut_patatoide] ?? 'from-gray-500 to-gray-600';
                                @endphp
                                <span class="status-badge bg-gradient-to-r {{ $statusColor }} text-white px-4 py-2 rounded-full font-semibold text-sm shadow-md">
                                    <i class="fas fa-circle animate-pulse text-xs mr-2"></i>
                                    {{ $patatoide->statut_patatoide }}
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Card Body -->
                    <div class="p-8">
                        <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">
                            <!-- Informations principales -->
                            <div class="space-y-6">
                                <div class="flex items-center space-x-3">
                                    <div class="p-2 bg-[#45C4EB]/10 rounded-lg">
                                        <i class="fas fa-info-circle text-[#45C4EB] text-lg"></i>
                                    </div>
                                    <h3 class="text-xl font-semibold text-gray-800">Informations principales</h3>
                                </div>
                                
                                <div class="space-y-4">
                                    @foreach([
                                        ['icon' => 'fa-tag', 'label' => 'Type Projet', 'value' => $patatoide->type_projet],
                                        ['icon' => 'fa-hashtag', 'label' => 'Référence Projet', 'value' => $patatoide->ref_projet],
                                        ['icon' => 'fa-map-marker-alt', 'label' => 'Site', 'value' => $patatoide->site],
                                        ['icon' => 'fa-calendar-alt', 'label' => 'Date Réception', 'value' => optional($patatoide->date_reception)->format('d/m/Y')],
                                        ['icon' => 'fa-check-circle', 'label' => 'Validation Covage', 'value' => $patatoide->validation_covage]
                                    ] as $info)
                                    <div class="flex items-center justify-between p-4 bg-gray-50/50 hover:bg-gray-50 rounded-xl transition-colors duration-200 border border-gray-200/50">
                                        <div class="flex items-center space-x-3">
                                            <div class="p-2 bg-white rounded-lg shadow-sm border border-gray-200">
                                                <i class="fas {{ $info['icon'] }} text-[#45C4EB] text-sm"></i>
                                            </div>
                                            <span class="text-gray-600 font-medium">{{ $info['label'] }}</span>
                                        </div>
                                        <span class="text-gray-900 font-semibold bg-white px-3 py-1 rounded-lg border border-gray-200/70 min-w-[120px] text-right">
                                            {{ $info['value'] ?? 'N/A' }}
                                        </span>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            
                            <!-- Détails techniques -->
                            <div class="space-y-6">
                                <div class="flex items-center space-x-3">
                                    <div class="p-2 bg-blue-500/10 rounded-lg">
                                        <i class="fas fa-cogs text-blue-500 text-lg"></i>
                                    </div>
                                    <h3 class="text-xl font-semibold text-gray-800">Détails techniques</h3>
                                </div>
                                
                                <div class="space-y-4">
                                    @foreach([
                                        ['icon' => 'fa-server', 'label' => 'Nb BPE', 'value' => $patatoide->nbre_bpe, 'color' => 'blue'],
                                        ['icon' => 'fa-users', 'label' => 'Nb Client', 'value' => $patatoide->nbre_client, 'color' => 'green'],
                                        ['icon' => 'fa-network-wired', 'label' => 'Nb Câble Ext', 'value' => $patatoide->nbre_cable_ext, 'color' => 'purple'],
                                        ['icon' => 'fa-plug', 'label' => 'Nb Racco Client', 'value' => $patatoide->nbre_racco_client, 'color' => 'orange'],
                                        ['icon' => 'fa-shipping-fast', 'label' => 'Date Livraison', 'value' => optional($patatoide->date_liv_patatoide)->format('d/m/Y'), 'color' => 'cyan']
                                    ] as $detail)
                                    <div class="flex items-center justify-between p-4 bg-gray-50/50 hover:bg-gray-50 rounded-xl transition-colors duration-200 border border-gray-200/50">
                                        <div class="flex items-center space-x-3">
                                            <div class="p-2 bg-white rounded-lg shadow-sm border border-gray-200">
                                                <i class="fas {{ $detail['icon'] }} text-{{ $detail['color'] }}-500 text-sm"></i>
                                            </div>
                                            <span class="text-gray-600 font-medium">{{ $detail['label'] }}</span>
                                        </div>
                                        <span class="text-gray-900 font-semibold bg-white px-3 py-1 rounded-lg border border-gray-200/70 min-w-[120px] text-right">
                                            {{ $detail['value'] ?? 'N/A' }}
                                        </span>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        
                        <!-- Commentaires -->
                        <div class="mt-8 pt-8 border-t border-gray-200/60">
                            <div class="flex items-center space-x-3 mb-4">
                                <div class="p-2 bg-purple-500/10 rounded-lg">
                                    <i class="fas fa-comment-dots text-purple-500 text-lg"></i>
                                </div>
                                <h3 class="text-xl font-semibold text-gray-800">Commentaires</h3>
                            </div>
                            
                            <div class="bg-gradient-to-r from-purple-50 to-blue-50/50 p-6 rounded-2xl border border-purple-200/50 shadow-sm">
                                @if($patatoide->commentaires)
                                    <p class="text-gray-700 leading-relaxed text-lg">{{ $patatoide->commentaires }}</p>
                                @else
                                    <div class="text-center py-8">
                                        <i class="fas fa-comment-slash text-gray-300 text-4xl mb-3"></i>
                                        <p class="text-gray-500 text-lg">Aucun commentaire</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-8">
                    <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100 text-center transform hover:scale-105 transition-transform duration-300">
                        <div class="p-3 bg-blue-100 rounded-full w-12 h-12 mx-auto mb-3 flex items-center justify-center">
                            <i class="fas fa-server text-blue-600 text-xl"></i>
                        </div>
                        <h4 class="text-2xl font-bold text-gray-800">{{ $patatoide->nbre_bpe ?? 0 }}</h4>
                        <p class="text-gray-500 text-sm">BPE</p>
                    </div>
                    
                    <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100 text-center transform hover:scale-105 transition-transform duration-300">
                        <div class="p-3 bg-green-100 rounded-full w-12 h-12 mx-auto mb-3 flex items-center justify-center">
                            <i class="fas fa-users text-green-600 text-xl"></i>
                        </div>
                        <h4 class="text-2xl font-bold text-gray-800">{{ $patatoide->nbre_client ?? 0 }}</h4>
                        <p class="text-gray-500 text-sm">Clients</p>
                    </div>
                    
                    <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100 text-center transform hover:scale-105 transition-transform duration-300">
                        <div class="p-3 bg-purple-100 rounded-full w-12 h-12 mx-auto mb-3 flex items-center justify-center">
                            <i class="fas fa-network-wired text-purple-600 text-xl"></i>
                        </div>
                        <h4 class="text-2xl font-bold text-gray-800">{{ $patatoide->nbre_cable_ext ?? 0 }}</h4>
                        <p class="text-gray-500 text-sm">Câbles Ext</p>
                    </div>
                    
                    <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100 text-center transform hover:scale-105 transition-transform duration-300">
                        <div class="p-3 bg-orange-100 rounded-full w-12 h-12 mx-auto mb-3 flex items-center justify-center">
                            <i class="fas fa-plug text-orange-600 text-xl"></i>
                        </div>
                        <h4 class="text-2xl font-bold text-gray-800">{{ $patatoide->nbre_racco_client ?? 0 }}</h4>
                        <p class="text-gray-500 text-sm">Raccos Client</p>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <style>
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
        .status-badge {
            transition: all 0.3s ease;
        }
        .animate-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
    </style>
@endsection