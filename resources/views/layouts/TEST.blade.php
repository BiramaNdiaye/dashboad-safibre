<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    @vite('resources/css/app.css') <!-- Pour Tailwind avec Vite -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        .active-menu {
            background-color: rgba(255, 255, 255, 0.1);
            border-left: 4px solid #F78719;
        }
    </style>
</head>
<body class="bg-gray-100">

    <div class="min-h-screen flex" x-data="{ sidebarHover: false, dropdownOpen: false, currentPath: window.location.pathname }">
        <!-- Sidebar -->
        <aside 
            class="text-white shadow-lg transition-all duration-300"
            :class="sidebarHover ? 'w-60' : 'w-20'"
            style="background: linear-gradient( #07677A, #07677A)"
            @mouseenter="sidebarHover = true"
            @mouseleave="sidebarHover = false"
        >
            <!-- Logo -->
            <div class="flex justify-center items-center mb-8">
                <img src="{{ asset('images/csma.png') }}" alt="Logo" 
                    :class="sidebarHover ? 'w-64' : 'w-24'" 
                    class="transition-all duration-300">
            </div>

            <!-- Menu -->
            <nav class="space-y-6 px-2">
                <a href="/home" class="flex items-center p-2 hover:text-blue-200 transition-all duration-300" :class="currentPath === '/home' ? 'active-menu' : ''">
                    <i class="material-icons text-[#F78719]">home</i>
                    <span x-show="sidebarHover" class="ml-2">Accueil</span>
                </a>
            
                <a href="/clients" class="flex items-center p-2 hover:text-blue-200 transition-all duration-300" :class="currentPath === '/clients' ? 'active-menu' : ''">
                    <i class="material-icons text-[#F78719]">people</i>
                    <span x-show="sidebarHover" class="ml-2">Gestion des clients</span>
                </a>
                
                <a href="/projets" class="flex items-center p-2 hover:text-blue-200 transition-all duration-300" :class="currentPath === '/projets' ? 'active-menu' : ''">
                    <i class="material-icons text-[#F78719]">work</i>
                    <span x-show="sidebarHover" class="ml-2">Gestion des projets</span>
                </a>
               

                @role('user')
                <a href="/mes-projets" class="flex items-center p-2 hover:text-blue-200 transition-all duration-300" :class="currentPath === '/mes-projets' ? 'active-menu' : ''">
                    <i class="material-icons text-[#F78719]">work</i>
                    <span x-show="sidebarHover" class="ml-2">Mes projets</span>
                </a>
                @endrole

                @role('client')
                <a href="/mes-projets-prestataires" class="flex items-center p-2 hover:text-blue-200 transition-all duration-300" :class="currentPath === '/mes-projets-prestataires' ? 'active-menu' : ''">
                    <i class="material-icons text-[#F78719]">work</i>
                    <span x-show="sidebarHover" class="ml-2">Mes projets </span>
                </a>
                @endrole

                <a href="/corbeille-rop" class="flex items-center p-2 hover:text-blue-200 transition-all duration-300" :class="currentPath === '/corbeille-rop' ? 'active-menu' : ''">
                    <i class="material-icons text-[#F78719]">folder</i>
                    <span x-show="sidebarHover" class="ml-2">Corbeille ROP</span>
                </a>

                <a href="/corbeille-blo" class="flex items-center p-2 hover:text-blue-200 transition-all duration-300" :class="currentPath === '/corbeille-blo' ? 'active-menu' : ''">
                    <i class="material-icons text-[#F78719]">folder</i>
                    <span x-show="sidebarHover" class="ml-2">Corbeille BLO</span>
                </a>
                @role('admin')
                <a href="/users" class="flex items-center p-2 hover:text-blue-200 transition-all duration-300" :class="currentPath === '/users' ? 'active-menu' : ''">
                    <i class="material-icons text-[#F78719]">person</i>
                    <span x-show="sidebarHover" class="ml-2">Gestion des utilisateurs</span>
                </a>
                @endrole

                @role('admin')
                <a href="/statistiques" class="flex items-center p-2 hover:text-blue-200 transition-all duration-300" :class="currentPath === '/statistiques' ? 'active-menu' : ''">
                    <i class="material-icons text-[#F78719]">bar_chart</i>
                    <span x-show="sidebarHover" class="ml-2">Statistiques  Utilisateurs</span>
                </a>
                @endrole

                @role('admin')
                <a href="/evolution-projet" class="flex items-center p-2 hover:text-blue-200 transition-all duration-300" :class="currentPath === '/evolution-projet' ? 'active-menu' : ''">
                    <i class="material-icons text-[#F78719]">show_chart</i>
                    <span x-show="sidebarHover" class="ml-2">Evolutions des projets</span>
                </a>
                @endrole
            </nav>
        </aside>

        <!-- Contenu principal -->
        <div class="flex flex-col flex-1">
            <header class="bg-white p-4 shadow-md">
                <div class="container mx-auto flex justify-between items-center">
                    <h1 class="text-2xl font-bold">Dashboard</h1>
                    <nav class="flex items-center space-x-6 relative">
                        @auth
                            <div class="flex items-center space-x-4">
                                <span class="font-semibold">{{ Auth::user()->name }}</span>
                                <!-- Bouton pour ouvrir le dropdown -->
                                <button @click="dropdownOpen = !dropdownOpen" class="focus:outline-none">
                                    <i class="material-icons text-gray-600">arrow_drop_down</i>
                                </button>
                            </div>

                            <!-- Dropdown pour le logout -->
                            <div 
                                x-show="dropdownOpen" 
                                @click.away="dropdownOpen = false"
                                class="absolute right-0 mt-10 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50"
                            >
                                <div class="py-1">
                                    <a 
                                        href="{{ route('logout') }}" 
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                    >
                                        Déconnexion
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                        @csrf
                                    </form>
                                </div>
                            </div>
                        @endauth
                    </nav>
                </div>
            </header>

            <main class="flex-1 p-6 bg-white shadow-inner">
                @yield('content')
                @role('admin')
                    <!-- Contenu réservé à l'admin -->
                @endrole
            </main>
        </div>
    </div>

    <!-- Icônes SVG -->
    <svg style="display: none;">
        <symbol id="icon-home" viewBox="0 0 24 24">
            <path d="M3 12l9-9 9 9h-3v9h-12v-9h-3z"/>
        </symbol>
        <symbol id="icon-users" viewBox="0 0 24 24">
            <path d="M16 11c1.66 0 3-1.34 3-3s-1.34-3-3-3-3 1.34-3 3 1.34 3 3 3zm-4 2h-8c-1.1 0-2 .9-2 2v2h12v-2c0-1.1-.9-2-2-2zm8 2v-1h2v1c0 1.1-.9 2-2 2h-2v-2h2z"/>
        </symbol>
        <symbol id="icon-project" viewBox="0 0 24 24">
            <path d="M2 2h20v20h-20v-20zm2 2v16h16v-16h-16zm2 2h12v4h-12v-4zm0 6h12v4h-12v-4z"/>
        </symbol>
        <symbol id="icon-trash" viewBox="0 0 24 24">
            <path d="M3 6l3 14h12l3-14h-18zm15 12h-12l-2.5-12h17l-2.5 12zm-10-10h2v8h-2v-8zm4 0h2v8h-2v-8zm4 0h2v8h-2v-8z"/>
        </symbol>
    </svg>
</body>
</html>