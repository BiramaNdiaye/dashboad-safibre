<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Projet;
use App\Models\Taches;
use App\Models\Client;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $selectedYear = $request->input('annee', Carbon::now()->year);
        $selectedMonth = $request->input('mois', '');
        $selectedClient = $request->input('client', '');

        // Années disponibles
        $availableYears = Projet::selectRaw('YEAR(date_commande) as year')
            ->groupBy('year')
            ->orderByDesc('year')
            ->pluck('year');

        // Mois disponibles
        $availableMonths = [
            1 => 'Janvier', 2 => 'Février', 3 => 'Mars', 4 => 'Avril',
            5 => 'Mai', 6 => 'Juin', 7 => 'Juillet', 8 => 'Août',
            9 => 'Septembre', 10 => 'Octobre', 11 => 'Novembre', 12 => 'Décembre'
        ];

        $clients = Client::orderBy('nom')->get();

        // Base query pour toutes les données (bar chart, pie chart, cards)
       $baseQuery = Taches::join('projets', 'taches.projet_reference', '=', 'projets.reference')
    ->join('type_taches', 'taches.type_taches_id', '=', 'type_taches.id')
    ->where('type_taches.nom', 'ROP')
    ->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(taches.informations, '$.statut_rop')) = ?", ['Livré'])
    ->whereYear(
        DB::raw("STR_TO_DATE(JSON_UNQUOTE(JSON_EXTRACT(taches.informations, '$.date_livraison_rop')), '%Y-%m-%d')"),
        $selectedYear
    );

// mois
if ($selectedMonth) {
    $baseQuery->whereMonth(
        DB::raw("STR_TO_DATE(JSON_UNQUOTE(JSON_EXTRACT(taches.informations, '$.date_livraison_rop')), '%Y-%m-%d')"),
        $selectedMonth
    );
}

// client
if ($selectedClient) {
    $baseQuery->where('projets.clients_id', $selectedClient);
}

        // ------------------ BAR CHART ------------------
        $tachesMensuelles = (clone $baseQuery)
            ->selectRaw('projets.clients_id, MONTH(STR_TO_DATE(JSON_UNQUOTE(JSON_EXTRACT(taches.informations, "$.date_livraison_rop")), "%Y-%m-%d")) as mois, COUNT(*) as total')
            ->groupBy('projets.clients_id', 'mois')
            ->get()
            ->groupBy('clients_id');

        $colors = [
            '#1cc88a', '#f6c23e', '#36b9cc', '#4e73df',
            '#e74a3b', '#858796', '#fd7e14', '#20c997',
            '#6610f2', '#6f42c1'
        ];

        $labels = array_values($availableMonths);
        $chartData = [];

        foreach ($clients as $index => $client) {
            $monthlyData = array_fill(0, 12, 0); // 12 mois

            if (isset($tachesMensuelles[$client->id])) {
                foreach ($tachesMensuelles[$client->id] as $data) {
                    $monthlyData[$data->mois - 1] = $data->total;
                }
            }

            $chartData[] = [
                'label' => $client->nom,
                'data' => $monthlyData,
                'backgroundColor' => $colors[$index % count($colors)],
            ];
        }

        // ------------------ CARDS ------------------
       $cardsData = (clone $baseQuery)
    ->selectRaw('projets.clients_id,
        SUM((SELECT COUNT(*) FROM projets p2 WHERE p2.reference = projets.reference)) as total')
    ->groupBy('projets.clients_id')
    ->get()
    ->keyBy('clients_id');


        // ------------------ PIE CHART ------------------
        $pieDataQuery = (clone $baseQuery)
    ->selectRaw('projets.clients_id,
        SUM((SELECT COUNT(*) FROM projets p2 WHERE p2.reference = projets.reference)) as total')
    ->groupBy('projets.clients_id')
    ->get();


        $pieLabels = $pieDataQuery->map(fn($item) => Client::find($item->clients_id)->nom);
        $pieValues = $pieDataQuery->pluck('total');
        $pieColors = $colors;

        return view('home.index', compact(
            'clients',
            'availableYears',
            'availableMonths',
            'selectedYear',
            'selectedMonth',
            'selectedClient',
            'labels',
            'chartData',
            'cardsData',
            'pieLabels',
            'pieValues',
            'pieColors'
        ));
    }
}
