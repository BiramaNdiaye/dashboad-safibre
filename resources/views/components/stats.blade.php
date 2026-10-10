<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cartes avec Tailwind CSS</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-10">

  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
    <!-- Carte 1 -->
    <div class="bg-white p-6 rounded-lg shadow-lg text-center">
      <div class="text-blue-500 text-4xl mb-4">
        <i class="fas fa-users"></i> <!-- Icône FontAwesome -->
      </div>
      <h3 class="text-xl font-semibold mb-2">Utilisateurs</h3>
      <p class="text-3xl font-bold"></p>
    </div>

    <!-- Carte 2 -->
    <div class="bg-white p-6 rounded-lg shadow-lg text-center">
      <div class="text-green-500 text-4xl mb-4">
        <i class="fas fa-chart-line"></i> <!-- Icône FontAwesome -->
      </div>
      <h3 class="text-xl font-semibold mb-2">Croissance</h3>
      <p class="text-3xl font-bold">567</p>
    </div>

    <!-- Carte 3 -->
    <div class="bg-white p-6 rounded-lg shadow-lg text-center">
      <div class="text-purple-500 text-4xl mb-4">
        <i class="fas fa-shopping-cart"></i> <!-- Icône FontAwesome -->
      </div>
      <h3 class="text-xl font-semibold mb-2">Ventes</h3>
      <p class="text-3xl font-bold">890</p>
    </div>

    <!-- Carte 4 -->
    <div class="bg-white p-6 rounded-lg shadow-lg text-center">
      <div class="text-yellow-500 text-4xl mb-4">
        <i class="fas fa-coins"></i> <!-- Icône FontAwesome -->
      </div>
      <h3 class="text-xl font-semibold mb-2">Revenus</h3>
      <p class="text-3xl font-bold">$12,345</p>
    </div>

    <!-- Carte 5 -->
    <div class="bg-white p-6 rounded-lg shadow-lg text-center">
      <div class="text-red-500 text-4xl mb-4">
        <i class="fas fa-heart"></i> <!-- Icône FontAwesome -->
      </div>
      <h3 class="text-xl font-semibold mb-2">Engagement</h3>
      <p class="text-3xl font-bold">98%</p>
    </div>
  </div>

  <!-- Lien vers FontAwesome pour les icônes -->
  <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>
</html>