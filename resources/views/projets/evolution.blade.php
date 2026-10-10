@extends('layouts.main')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold text-gray-700 mb-6">Évolution mensuelle des projets par statut</h2>

    <canvas id="evolutionChart"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const ctx = document.getElementById('evolutionChart').getContext('2d');

        const moisLabels = @json($moisLabels);
        const datasets = @json($datasets);

        // Couleurs pour chaque statut
        const couleurs = {
            "En cours": "#3498db", // Bleu
            "Livré": "#2ecc71", // Vert
            "Terminé": "#e74c3c", // Rouge
            "A traiter": "#f39c12", // Orange
            "Traité": "#9b59b6" // Violet
        };

        // Appliquer les couleurs aux datasets
        const formattedDatasets = datasets.map(dataset => ({
            ...dataset,
            borderColor: couleurs[dataset.label] || "#000",
            backgroundColor: "transparent",
            borderWidth: 2,
            tension: 0.4, // Rend la courbe plus fluide
        }));

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: moisLabels,
                datasets: formattedDatasets
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Évolution mensuelle des projets par statut'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Nombre de projets'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Mois'
                        }
                    }
                }
            }
        });
    });
</script>
@endsection
