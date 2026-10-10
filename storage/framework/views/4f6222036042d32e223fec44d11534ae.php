<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CSMA Admin</title>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.getElementById("loginBtn").addEventListener("click", function () {
                window.location.href = "/login";
            });
        });
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center h-screen bg-gray-100">
    <div class="bg-white p-8 rounded-lg shadow-lg w-96 text-center">
        <h2 class="text-2xl font-bold text-gray-800 mb-2">CSMA Admin</h2>
        <p class="text-gray-600 mb-6">Bienvenue sur notre plateforme dédié au suivi de vos projets</p>
        <button id="loginBtn" class="px-6 py-3 bg-[#F78719] text-white font-semibold rounded-lg shadow-md hover:bg-[#44C4EE] transition">
            Se connecter
        </button>
    </div>
</body>
</html>
<?php /**PATH /home/safibrq/dashboard/csmaadministration/resources/views/welcome.blade.php ENDPATH**/ ?>