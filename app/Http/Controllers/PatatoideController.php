<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patatoide;
use League\Csv\Reader;
use League\Csv\Statement;
use App\Exports\PatatoidesExport;

use Maatwebsite\Excel\Facades\Excel;
class PatatoideController extends Controller
{
public function index(Request $request)
{
    $query = Patatoide::query();

    // Si l'utilisateur n'est pas admin ni manager, il ne voit que ses patatoides
    if (!auth()->user()->hasAnyRole(['admin', 'Manager'])) {
        $query->where('users_id', auth()->id());
    }

    // Filtre par référence projet
    if ($request->filled('ref_projet')) {
        $query->where('ref_projet', 'like', '%' . $request->ref_projet . '%');
    }

    // Filtre par statut patatoïde
    if ($request->filled('statut_patatoide')) {
        $statut = $request->statut_patatoide;
        if ($statut === 'LIVRE') {
            $query->where(function($q) {
                $q->where('statut_patatoide', 'LIVRE')
                  ->orWhere('statut_patatoide', 'LIVRÉ');
            });
        } elseif ($statut === 'ANNULE') {
            $query->where(function($q) {
                $q->where('statut_patatoide', 'ANNULE')
                  ->orWhere('statut_patatoide', 'ANNULÉ');
            });
        } else {
            $query->where('statut_patatoide', $statut);
        }
    }

    // Filtre par validation covage
    if ($request->filled('validation_covage')) {
        $query->where('validation_covage', $request->validation_covage);
    }

    // Filtre par date réception (intervalle)
    if ($request->filled('date_reception_from')) {
        $query->where('date_reception', '>=', $request->date_reception_from);
    }
    if ($request->filled('date_reception_to')) {
        $query->where('date_reception', '<=', $request->date_reception_to);
    }

    // Filtre par date livraison patatoïde (intervalle)
    if ($request->filled('date_liv_from')) {
        $query->where('date_liv_patatoide', '>=', $request->date_liv_from);
    }
    if ($request->filled('date_liv_to')) {
        $query->where('date_liv_patatoide', '<=', $request->date_liv_to);
    }

    // Tri par date de réception descendante et pagination
    $patatoides = $query->orderBy('date_reception', 'desc')->paginate(30)->withQueryString();

    // Statistiques pour les cartes
    $totalPatatoides = Patatoide::when(!auth()->user()->hasAnyRole(['admin', 'Manager']), function ($q) {
        $q->where('users_id', auth()->id());
    })->count();

    $livresCount = Patatoide::when(!auth()->user()->hasAnyRole(['admin', 'Manager']), function ($q) {
        $q->where('users_id', auth()->id());
    })->where(function($q) {
        $q->where('statut_patatoide', 'LIVRE')
          ->orWhere('statut_patatoide', 'LIVRÉ');
    })->count();

    $enCoursCount = Patatoide::when(!auth()->user()->hasAnyRole(['admin', 'Manager']), function ($q) {
        $q->where('users_id', auth()->id());
    })->where('statut_patatoide', 'EN COURS')->count();

    $attenteCount = Patatoide::when(!auth()->user()->hasAnyRole(['admin', 'Manager']), function ($q) {
        $q->where('users_id', auth()->id());
    })->where('statut_patatoide', 'ATTENTE INFO SUPP')->count();

    return view('patatoides.index', compact('patatoides', 'totalPatatoides', 'livresCount', 'enCoursCount', 'attenteCount'));
}




    public function create()
    {
        return view('patatoides.create');
    }

 public function store(Request $request)
{
    $messages = [
        'type_projet.required' => 'Le champ Type Projet est obligatoire.',
        'ref_projet.required' => 'Le champ Référence Projet est obligatoire.',
        'site.required' => 'Le champ Site est obligatoire.',
        'date_reception.required' => 'La Date de Réception est obligatoire.',
        'date_reception.date' => 'La Date de Réception doit être une date valide.',
        'nbre_bpe.integer' => 'Le nombre de BPE doit être un entier.',
        'nbre_bpe.min' => 'Le nombre de BPE doit être au moins 0.',
        'nbre_client.integer' => 'Le nombre de Clients doit être un entier.',
        'nbre_client.min' => 'Le nombre de Clients doit être au moins 0.',
        'nbre_cable_ext.integer' => 'Le nombre de Câbles Ext doit être un entier.',
        'nbre_cable_ext.min' => 'Le nombre de Câbles Ext doit être au moins 0.',
        'nbre_racco_client.integer' => 'Le nombre de Racco Client doit être un entier.',
        'nbre_racco_client.min' => 'Le nombre de Racco Client doit être au moins 0.',
        'statut_patatoide.required' => 'Le statut Patatoïde est obligatoire.',
        'validation_covage.required' => 'La Validation Covage est obligatoire.',
    ];

    $validatedData = $request->validate([
        'type_projet' => 'required|string|max:255',
        'ref_projet' => 'required|string|max:255',
        'site' => 'required|string|max:255',
        'date_reception' => 'required|date',
        'nbre_bpe' => 'nullable|integer|min:0',
        'nbre_client' => 'nullable|integer|min:0',
        'nbre_cable_ext' => 'nullable|integer|min:0',
        'nbre_racco_client' => 'nullable|integer|min:0',
        'statut_patatoide' => 'required|string',
        'date_liv_patatoide' => 'nullable|date',
        'validation_covage' => 'required|string',
        'commentaires' => 'nullable|string',
    ], $messages);

    // Ajouter l'utilisateur connecté
    $validatedData['users_id'] = auth()->id();

    Patatoide::create($validatedData);

    return redirect()->route('patatoides.index')
                     ->with('success', 'Patatoïde créé avec succès.');
}




    public function edit(Patatoide $patatoide)
    {
        return view('patatoides.edit', compact('patatoide'));
    }

    public function update(Request $request, Patatoide $patatoide)
{
    // Validation identique
    $request->validate([
        'type_projet' => 'required|string|max:255',
        'ref_projet' => 'required|string|max:255',
        'site' => 'required|string|max:255',
        'date_reception' => 'nullable|date',
        'nbre_bpe' => 'nullable|integer|min:0',
        'nbre_client' => 'nullable|integer|min:0',
        'nbre_cable_ext' => 'nullable|integer|min:0',
        'nbre_racco_client' => 'nullable|integer|min:0',
        'statut_patatoide' => 'required|string',
        'date_liv_patatoide' => 'nullable|date',
        'validation_covage' => 'required|string',
        'commentaires' => 'nullable|string',
    ]);

    $patatoide->update($request->only([
        'type_projet',
        'ref_projet',
        'site',
        'date_reception',
        'nbre_bpe',
        'nbre_client',
        'nbre_cable_ext',
        'nbre_racco_client',
        'statut_patatoide',
        'date_liv_patatoide',
        'validation_covage',
        'commentaires',
    ]));

    return redirect()->route('patatoides.index')
                     ->with('success', 'Patatoïde mis à jour avec succès.');
}

    public function destroy(Patatoide $patatoide)
    {
        $patatoide->delete();

        return redirect()->route('patatoides.index')
            ->with('success', 'Patatoïde supprimé avec succès.');
    }

    public function show(Patatoide $patatoide)
{
    return view('patatoides.show', compact('patatoide'));
}

public function importCsv(Request $request)
{
    $request->validate([
        'csv_file' => 'required|file|mimes:csv,txt',
    ]);

    $filePath = $request->file('csv_file')->getRealPath();
    $rawLines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    if (!$rawLines) {
        return redirect()->back()->with('warning', 'Le fichier CSV est vide.');
    }

    // Détecter l'encodage automatiquement
    $encoding = mb_detect_encoding(implode("\n", $rawLines), ['UTF-8','Windows-1252','ISO-8859-1'], true) ?: 'Windows-1252';

    // Convertir en UTF-8 et nettoyer tous les guillemets doubles
    $lines = array_map(function($line) use ($encoding) {
        $line = mb_convert_encoding($line, 'UTF-8', $encoding);
        $line = str_replace('""', '"', $line); // doubles guillemets Excel
        return trim($line, '"'); // guillemets externes
    }, $rawLines);

    // En-tête
    $header = str_getcsv(array_shift($lines), ';', '"');
    $header = array_map(fn($h) => str_replace('-', '_', trim($h, '"')), $header);

    $count = 0;
    $errors = [];

    foreach ($lines as $index => $line) {
        $row = str_getcsv(trim($line), ';', '"');

        // Compléter les colonnes manquantes avec des valeurs vides
        while (count($row) < count($header)) {
            $row[] = '';
        }

        $data = array_combine($header, $row);

        try {
            $cleanData = [
                'type_projet'        => trim($data['type_projet'] ?? ''),
                'ref_projet'         => trim($data['ref_projet'] ?? ''),
                'site'               => trim($data['site'] ?? ''),
                'date_reception'     => !empty(trim($data['date_reception'] ?? '')) ? $this->parseDate(trim($data['date_reception'])) : null,
                'nbre_bpe'           => is_numeric(trim($data['nbre_bpe'] ?? '')) ? (int)trim($data['nbre_bpe']) : 0,
                'nbre_client'        => is_numeric(trim($data['nbre_client'] ?? '')) ? (int)trim($data['nbre_client']) : 0,
                'nbre_cable_ext'     => is_numeric(trim($data['nbre_cable_ext'] ?? '')) ? (int)trim($data['nbre_cable_ext']) : 0,
                'nbre_racco_client'  => is_numeric(trim($data['nbre_racco_client'] ?? '')) ? (int)trim($data['nbre_racco_client']) : 0,
                'statut_patatoide'   => trim($data['statut_patatoide'] ?? ''),
                'date_liv_patatoide' => !empty(trim($data['date_liv_patatoide'] ?? '')) ? $this->parseDate(trim($data['date_liv_patatoide'])) : null,
                'validation_covage'  => trim($data['validation_covage'] ?? ''),
                'commentaires'       => trim($data['commentaires'] ?? ''),
                'users_id'           => auth()->id(),
            ];

            Patatoide::create($cleanData);
            $count++;

        } catch (\Exception $e) {
            // Ne bloque pas l'import
            $errors[] = "Ligne " . ($index + 2) . ": " . $e->getMessage();
        }
    }

    $message = "$count lignes importées avec succès !";
    if (!empty($errors)) {
        $message .= " Certaines lignes ont eu des erreurs: " . implode(', ', array_slice($errors, 0, 5));
        if (count($errors) > 5) {
            $message .= "... et " . (count($errors) - 5) . " autres erreurs";
        }
    }

    return redirect()->route('patatoides.index')
                     ->with($errors ? 'warning' : 'success', $message);
}

// Méthode helper pour parser les dates
private function parseDate($dateString)
{
    if (empty($dateString)) return null;

    // dd/mm/yyyy
    if (preg_match('/^(\d{1,2})\/(\d{1,2})\/(\d{4})$/', $dateString, $matches)) {
        return $matches[3] . '-' . str_pad($matches[2], 2, '0', STR_PAD_LEFT) . '-' . str_pad($matches[1], 2, '0', STR_PAD_LEFT);
    }

    // yyyy-mm-dd
    if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $dateString)) {
        return $dateString;
    }

    $timestamp = strtotime($dateString);
    return $timestamp !== false ? date('Y-m-d', $timestamp) : null;
}



public function export(Request $request)
{
    try {
        $query = Patatoide::query();

        // Filtres utilisateur
        if (!auth()->user()->hasAnyRole(['admin', 'Manager'])) {
            $query->where('users_id', auth()->id());
        }

        // Filtre par référence projet
        if ($request->filled('ref_projet')) {
            $query->where('ref_projet', 'like', '%' . $request->ref_projet . '%');
        }

        // Filtre par statut
        if ($request->filled('statut_patatoide')) {
            $statut = $request->statut_patatoide;
            if ($statut === 'LIVRE') {
                $query->where(function($q) {
                    $q->where('statut_patatoide', 'LIVRE')
                      ->orWhere('statut_patatoide', 'LIVRÉ');
                });
            } elseif ($statut === 'ANNULE') {
                $query->where(function($q) {
                    $q->where('statut_patatoide', 'ANNULE')
                      ->orWhere('statut_patatoide', 'ANNULÉ');
                });
            } else {
                $query->where('statut_patatoide', $statut);
            }
        }

        // Filtre par validation covage
        if ($request->filled('validation_covage')) {
            $query->where('validation_covage', $request->validation_covage);
        }

        // Filtres dates
        if ($request->filled('date_reception_from')) {
            $query->where('date_reception', '>=', $request->date_reception_from);
        }
        if ($request->filled('date_reception_to')) {
            $query->where('date_reception', '<=', $request->date_reception_to);
        }
        if ($request->filled('date_liv_from')) {
            $query->where('date_liv_patatoide', '>=', $request->date_liv_from);
        }
        if ($request->filled('date_liv_to')) {
            $query->where('date_liv_patatoide', '<=', $request->date_liv_to);
        }

        // Récupérer toutes les données
        $patatoides = $query->orderBy('date_reception', 'desc')->get();

        if ($patatoides->isEmpty()) {
            return redirect()->back()->with('warning', 'Aucune donnée à exporter avec les filtres actuels.');
        }

        $fileName = 'patatoides_export_' . now()->format('Y-m-d_His') . '.xlsx';

        return Excel::download(new PatatoidesExport($patatoides), $fileName);

    } catch (\Exception $e) {
        \Log::error('Erreur export Excel: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Erreur lors de l\'export: ' . $e->getMessage());
    }
}

private function buildExportQuery(Request $request)
{
    $query = Patatoide::query();

    // Filtres utilisateur
    if (!auth()->user()->hasAnyRole(['admin', 'Manager'])) {
        $query->where('users_id', auth()->id());
    }

    // Filtre par référence projet
    if ($request->filled('ref_projet')) {
        $query->where('ref_projet', 'like', '%' . $request->ref_projet . '%');
    }

    // Filtre par statut
    if ($request->filled('statut_patatoide')) {
        $statut = $request->statut_patatoide;
        if ($statut === 'LIVRE') {
            $query->where(function($q) {
                $q->where('statut_patatoide', 'LIVRE')
                  ->orWhere('statut_patatoide', 'LIVRÉ');
            });
        } elseif ($statut === 'ANNULE') {
            $query->where(function($q) {
                $q->where('statut_patatoide', 'ANNULE')
                  ->orWhere('statut_patatoide', 'ANNULÉ');
            });
        } else {
            $query->where('statut_patatoide', $statut);
        }
    }

    // Filtres dates
    if ($request->filled('date_reception_from')) {
        $query->where('date_reception', '>=', $request->date_reception_from);
    }
    if ($request->filled('date_reception_to')) {
        $query->where('date_reception', '<=', $request->date_reception_to);
    }
    if ($request->filled('date_liv_from')) {
        $query->where('date_liv_patatoide', '>=', $request->date_liv_from);
    }
    if ($request->filled('date_liv_to')) {
        $query->where('date_liv_patatoide', '<=', $request->date_liv_to);
    }

    return $query->orderBy('date_reception', 'desc');
}


}
