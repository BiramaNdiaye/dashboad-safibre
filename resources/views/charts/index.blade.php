<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Graphique avec Chart.js</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

    <canvas id="myChart" width="400" height="200"></canvas>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            fetch("/chart-data")
                .then(response => response.json())
                .then(data => {
                    const labels = data.map(item => `Mois ${item.mois}`);
                    const values = data.map(item => item.total);

                    const ctx = document.getElementById('myChart').getContext('2d');
                    new Chart(ctx, {
                        type: 'bar', // 'line', 'pie', 'doughnut', etc.
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Ventes mensuelles',
                                data: values,
                                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                y: { beginAtZero: true }
                            }
                        }
                    });
                });
        });
    </script>

</body>
</html>
