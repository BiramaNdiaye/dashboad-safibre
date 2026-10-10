<?php


namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Projet;
use Carbon\Carbon;
use App\Models\Client;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class StatistiqueController extends Controller
{
    public function index(Request $request)
{
    // Récupérer le mois et l'année sélectionnés (par défaut, mois et année actuels)
    $mois = $request->input('mois', date('m'));
    $annee = $request->input('annee', date('Y'));

    // Vérifier que le mois est bien un nombre valide entre 1 et 12
    $mois = is_numeric($mois) && $mois >= 1 && $mois <= 12 ? (int) $mois : date('m');

    // Récupérer les utilisateurs avec le nombre de projets correspondant au filtre, en excluant ceux avec le rôle CLIENT
    $users = User::whereDoesntHave('roles', function ($query) {
               $query->whereIn('name', ['CLIENT','ADMIN']); // Exclure les utilisateurs ayant le rôle CLIENT
    })
    ->withCount(['projets' => function ($query) use ($mois, $annee) {
        $query->when($mois, fn($q) => $q->whereMonth('date_commande', $mois))
              ->when($annee, fn($q) => $q->whereYear('date_commande', $annee));
    }])->get();

    // Préparer les données pour le graphique
    $labels = $users->pluck('name'); // Noms des utilisateurs
    $data = $users->pluck('projets_count'); // Nombre de projets par utilisateur

    // Passer les valeurs sélectionnées à la vue
    return view('statistiques.index', compact('labels', 'data', 'mois', 'annee'));
}

    
    

    public function evolutionMensuelle(Request $request)
    {
        // Récupérer l'année et le mois sélectionnés (par défaut, année actuelle et mois null)
        $annee = $request->input('annee', date('Y'));
        $mois = $request->input('mois'); // Peut être null si aucun mois n'est sélectionné
    
        // Construire la requête pour récupérer les projets mensuels
        $query = Projet::select(
                'clients_id',
                DB::raw('YEAR(date_livraison) as annee'),
                DB::raw('MONTH(date_livraison) as mois'),
                DB::raw('COUNT(*) as total_projets')
            )
            ->whereYear('date_livraison', $annee); // Filtrer par année
    
        if ($mois) {
            $query->whereMonth('date_livraison', $mois); // Filtrer par mois si sélectionné
        }
    
        $projetsMensuels = $query->groupBy('clients_id', 'annee', 'mois')
            ->orderBy('annee')
            ->orderBy('mois')
            ->get();
    
        // Récupérer la liste des clients avec le nombre de projets
        $clients = Client::withCount('projets')->get();
    
        // Préparer les données pour le graphique
        $labels = [];
        $datasets = [];
    
        // Générer les labels (mois/année)
        $projetsMensuels->each(function ($projet) use (&$labels) {
            $moisAnnee = str_pad($projet->mois, 2, '0', STR_PAD_LEFT) . '/' . $projet->annee;
            if (!in_array($moisAnnee, $labels)) {
                $labels[] = $moisAnnee;
            }
        });
    
        // Préparer les données par client
        foreach ($clients as $client) {
            $data = array_fill(0, count($labels), 0); // Initialiser un tableau de zéros
    
            $projetsMensuels->where('clients_id', $client->id)->each(function ($projet) use (&$data, $labels) {
                $moisAnnee = str_pad($projet->mois, 2, '0', STR_PAD_LEFT) . '/' . $projet->annee;
                $index = array_search($moisAnnee, $labels);
                $data[$index] = $projet->total_projets;
            });
    
            $datasets[] = [
                'label' => $client->nom,
                'data' => $data,
                'backgroundColor' => 'rgba(' . rand(0, 255) . ', ' . rand(0, 255) . ', 0.2)',
                'borderColor' => 'rgba(' . rand(0, 255) . ', ' . rand(0, 255) . ', ' . rand(0, 255) . ', 1)',
                'borderWidth' => 1
            ];
        }
    
        // Récupérer tous les projets pour affichage avec pagination
        $projets = Projet::with(['taches', 'chefProjet'])->paginate(10);
    
        // Récupérer les statuts distincts des projets
        $statuts = Projet::select('statut_projet')->distinct()->pluck('statut_projet');
    




        
        return view('statistiques.evolution-projet', compact('labels', 'datasets', 'annee', 'mois', 'projets', 'clients', 'statuts'));
    }

    
}
