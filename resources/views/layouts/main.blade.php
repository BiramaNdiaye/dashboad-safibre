<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Csma Admin</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>

    <style>
        * { box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #f1f5f9; margin: 0; }

        /* ── Sidebar ── */
        .sidebar {
            width: 230px;
            min-height: 100vh;
            background: #07677A;
            display: flex;
            flex-direction: column;
            box-shadow: 2px 0 12px rgba(0,0,0,0.12);
            flex-shrink: 0;
        }

        .sidebar-logo {
            padding: 20px 16px 16px;
            border-bottom: 0.5px solid rgba(255,255,255,0.1);
            display: flex;
            justify-content: center;
        }
        .sidebar-logo img { width: 140px; }

        .sidebar-nav { padding: 12px 8px; flex: 1; overflow-y: auto; }

        /* Nav items */
        .nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 10px;
            border-radius: 8px;
            color: rgba(255,255,255,0.80);
            font-size: 12px;
            font-weight: 500;
            text-decoration: none;
            transition: background 0.15s, color 0.15s;
            margin-bottom: 2px;
            white-space: nowrap;
        }
        .nav-item:hover { background: rgba(255,255,255,0.10); color: #fff; }
        .nav-item.active-menu {
            background: rgba(255,255,255,0.12);
            color: #fff;
            border-left: 3px solid #F7881B;
            padding-left: 7px;
        }
        .nav-item svg { width: 16px; height: 16px; flex-shrink: 0; color: #F7881B; }

        /* Section labels */
        .nav-section-label {
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: rgba(255,255,255,0.35);
            padding: 10px 10px 4px;
            margin-top: 4px;
        }

        /* Dropdown */
        .dropdown-toggle {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 10px;
            border-radius: 8px;
            color: rgba(255,255,255,0.80);
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.15s;
            margin-bottom: 2px;
            user-select: none;
        }
        .dropdown-toggle:hover { background: rgba(255,255,255,0.10); color: #fff; }
        .dropdown-toggle svg.main-icon { width: 16px; height: 16px; flex-shrink: 0; color: #F7881B; }
        .dropdown-toggle .chevron { width: 14px; height: 14px; margin-left: auto; color: rgba(255,255,255,0.4); transition: transform 0.25s; }
        .dropdown.active .chevron { transform: rotate(90deg); }

        .dropdown-menu {
            display: none;
            padding-left: 12px;
            border-left: 1.5px solid rgba(255,255,255,0.1);
            margin-left: 18px;
            margin-bottom: 4px;
        }
        .dropdown.active .dropdown-menu { display: block; }
        .dropdown-menu .nav-item { font-size: 11px; color: rgba(255,255,255,0.65); padding: 6px 10px; }
        .dropdown-menu .nav-item:hover { color: #fff; }
        .dropdown-menu .nav-item svg { width: 14px; height: 14px; }

        /* ── Header ── */
        .topbar {
            background: #fff;
            padding: 0 24px;
            height: 56px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 1px 8px rgba(0,0,0,0.07);
            flex-shrink: 0;
        }
        .topbar-title {
            font-size: 15px;
            font-weight: 600;
            color: #111827;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .topbar-title::before {
            content: '';
            display: block;
            width: 3px;
            height: 18px;
            background: #45C4EB;
            border-radius: 999px;
        }
        .topbar-right { display: flex; align-items: center; gap: 16px; }
        .topbar-user {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            font-weight: 500;
            color: #374151;
        }
        .topbar-avatar {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: #dbeafe;
            color: #1e40af;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 700;
        }
        .topbar-logout {
            font-size: 11px;
            font-weight: 600;
            color: #F7881B;
            text-decoration: none;
            padding: 5px 12px;
            border: 0.5px solid #fde4c8;
            border-radius: 6px;
            transition: background 0.15s;
        }
        .topbar-logout:hover { background: #fff4e8; }

        /* ── Main ── */
        .main-content { flex: 1; padding: 24px; overflow-y: auto; }

        /* ── Layout ── */
        .app-shell { display: flex; min-height: 100vh; }
        .app-body { display: flex; flex-direction: column; flex: 1; overflow: hidden; }
    </style>
</head>
<body>
<div class="app-shell">

    {{-- ── Sidebar ── --}}
    <aside class="sidebar">
        <div class="sidebar-logo">
            <img src="{{ asset('images/csma.png') }}" alt="Logo CSMA">
        </div>

        <nav class="sidebar-nav" x-data="{ currentPath: window.location.pathname }">

            {{-- Accueil --}}
            <a href="/home" class="nav-item" :class="currentPath === '/home' ? 'active-menu' : ''">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Accueil
            </a>

            {{-- Admin : Clients --}}
            @role('admin')
                <div class="nav-section-label">Administration</div>
                <a href="/clients" class="nav-item" :class="currentPath === '/clients' ? 'active-menu' : ''">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Gestion des clients
                </a>
            @endrole

            {{-- Production --}}
            @role('admin|operation|Manager')
                <div class="nav-section-label">Production</div>
                <div x-data="{ open: false }" class="dropdown" :class="{ 'active': open }">
                    <div class="dropdown-toggle" @click="open = !open">
                        <svg class="main-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        <span>Gestion Production</span>
                        <svg class="chevron" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </div>
                    <div class="dropdown-menu">
                        <a href="/projets" class="nav-item" :class="currentPath === '/projets' ? 'active-menu' : ''">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7a2 2 0 012-2h4l2 2h8a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V7z"/></svg>
                            Backlog Projets
                        </a>
                        @role('operation|Manager')
                            <a href="/mes-projets" class="nav-item" :class="currentPath === '/mes-projets' ? 'active-menu' : ''">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                Mes projets
                            </a>
                        @endrole
                        <a href="/corbeille-rop" class="nav-item" :class="currentPath === '/corbeille-rop' ? 'active-menu' : ''">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            Backlog ROP
                        </a>
                        <a href="/corbeille-blo" class="nav-item" :class="currentPath === '/corbeille-blo' ? 'active-menu' : ''">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            Backlog BLO
                        </a>
                        <a href="/accompagnements" class="nav-item" :class="currentPath === '/accompagnements' ? 'active-menu' : ''">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            Escort Request
                        </a>
                        <a href="/doe" class="nav-item" :class="currentPath === '/doe' ? 'active-menu' : ''">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            DOE Optique
                        </a>
                        <a href="/productionAPD" class="nav-item" :class="currentPath === '/productionAPD' ? 'active-menu' : ''">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            APD | DOE GC
                        </a>
                         <a href="/commandes" class="nav-item" :class="currentPath === '/commandes' ? 'active-menu' : ''">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            Intégration
                        </a>

                        
                        
                    </div>
                </div>
            @endrole

            {{-- Client --}}
            @role('client')
                <div class="nav-section-label">Mon espace</div>
                <a href="/mes-projets-prestataires" class="nav-item" :class="currentPath === '/mes-projets-prestataires' ? 'active-menu' : ''">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7a2 2 0 012-2h4l2 2h8a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V7z"/></svg>
                    Mes projets
                </a>
                <a href="/corbeille-rop" class="nav-item" :class="currentPath === '/corbeille-rop' ? 'active-menu' : ''">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Ma Production ROP
                </a>
                <a href="/corbeille-blo" class="nav-item" :class="currentPath === '/corbeille-blo' ? 'active-menu' : ''">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Mes Dossiers BLO
                </a>
                <a href="/accompagnements" class="nav-item" :class="currentPath === '/accompagnements' ? 'active-menu' : ''">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Escort Request
                </a>
                <a href="/doe" class="nav-item" :class="currentPath === '/doe' ? 'active-menu' : ''">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    DOE Optique
                </a>
                <a href="/productionAPD" class="nav-item" :class="currentPath === '/productionAPD' ? 'active-menu' : ''">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    APD | DOE GC
                </a>
            @endrole

            {{-- Admin : Utilisateurs & KPI --}}
            @role('admin')
                <div class="nav-section-label">Analytique</div>
                <a href="/users" class="nav-item" :class="currentPath === '/users' ? 'active-menu' : ''">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM3 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 019.374 21c-2.331 0-4.512-.645-6.374-1.766z"/></svg>
                    Gestion utilisateurs
                </a>
                
                <a href="/rop-graph" class="nav-item" :class="currentPath === '/rop-graph' ? 'active-menu' : ''">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                            KPI Production Clients
                </a>
                 <a href="/rapports/rop-operateurs" class="nav-item" :class="currentPath === '/evolution-projet' ? 'active-menu' : ''">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/></svg>
                            KPI ROP Operateur
                </a>

               
            @endrole

              {{-- Admin : Utilisateurs & KPI --}}
            @role('Manager')
                <div class="nav-section-label">Analytique</div>
                
    
                <a href="/rop-graph" class="nav-item" :class="currentPath === '/rop-graph' ? 'active-menu' : ''">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                            KPI Production Clients
                </a>
                
               
            @endrole

            {{-- Divers --}}
            <div class="nav-section-label">Ressources</div>
            <a href="/frontals" class="nav-item" :class="currentPath === '/frontals' ? 'active-menu' : ''">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Listes FCI
            </a>
            <a href="/etudes" class="nav-item" :class="currentPath === '/etudes' ? 'active-menu' : ''">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                Listes Etudes
            </a>
            <a href="/patatoides" class="nav-item" :class="currentPath === '/patatoides' ? 'active-menu' : ''">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                Gestion Patatoides
            </a>

            {{-- Nexloop --}}
            <div x-data="{ open: false }" class="dropdown" :class="{ 'active': open }">
                <div class="dropdown-toggle" @click="open = !open">
                    <svg class="main-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    <span>Gestion Nexloop</span>
                    <svg class="chevron" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </div>
                <div class="dropdown-menu">
                    <a href="/etudes-faisabilite" class="nav-item" :class="currentPath === '/etudes-faisabilite' ? 'active-menu' : ''">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2"/></svg>
                        Etude
                    </a>
                    <a href="/fci-nexloop" class="nav-item" :class="currentPath === '/fci-nexloop' ? 'active-menu' : ''">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        FCI
                    </a>
                    <a href="/blo-mcconnect" class="nav-item" :class="currentPath === '/blo-mcconnect' ? 'active-menu' : ''">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Backlog MCconnect
                    </a>
                    <a href="/blo-nexloop" class="nav-item" :class="currentPath === '/blo-nexloop' ? 'active-menu' : ''">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Backlog Nexloop
                    </a>
                </div>
            </div>

        </nav>
    </aside>

    {{-- ── App body ── --}}
    <div class="app-body">

        {{-- Header --}}
        <header class="topbar">
            <div class="topbar-title">Dashboard</div>
            @auth
            <div class="topbar-right">
                <div class="topbar-user">
                    <div class="topbar-avatar">
                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                    </div>
                    <span>{{ Auth::user()->name }}</span>
                </div>
                <a href="{{ route('logout') }}" class="topbar-logout"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Déconnexion
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
            </div>
            @endauth
        </header>

        {{-- Content --}}
        <main class="main-content">
            @yield('content')
        </main>
    </div>

</div>
@stack('scripts')
@yield('scripts')
</body>
</html>
