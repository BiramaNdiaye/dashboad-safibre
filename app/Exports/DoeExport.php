<?php

namespace App\Exports;

use App\Models\Projet;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Carbon\Carbon;
class DoeExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected $filters;
 protected $request;
    public function __construct(Request $request)
    {
        // On récupère tous les filtres
        $this->filters = $request->all();

         $this->request = $request;
    }

   public function collection()
    {
        $query = Projet::query()->whereHas('taches', fn($q) =>
            $q->whereHas('typeTache', fn($t) => $t->where('nom', 'DOE OPTIQUE'))
        );

        // Filtre support
        if ($this->request->filled('support')) {
            $query->whereHas('taches', fn($q) =>
                $q->whereHas('typeTache', fn($t) => $t->where('nom', 'DOE OPTIQUE'))
                  ->whereRaw('json_unquote(json_extract(informations, "$.\"support\"")) = ?', [$this->request->support])
            );
        }

        // Filtre statut DOE
        if ($this->request->filled('statut_doe')) {
            $query->whereHas('taches', fn($q) =>
                $q->whereHas('typeTache', fn($t) => $t->where('nom', 'DOE OPTIQUE'))
                  ->whereRaw('json_unquote(json_extract(informations, "$.\"statut_doe\"")) = ?', [$this->request->statut_doe])
            );
        }

        // Filtre date intégration (JSON)
        if ($this->request->filled('date_integration_debut') || $this->request->filled('date_integration_fin')) {
            $query->whereHas('taches', function ($q) {
                $q->whereHas('typeTache', fn($t) => $t->where('nom', 'DOE OPTIQUE'));

                if ($this->request->filled('date_integration_debut')) {
                    $q->whereRaw(
                        'date(json_unquote(json_extract(informations, "$.\"date_integration\""))) >= ?',
                        [$this->request->date_integration_debut]
                    );
                }

                if ($this->request->filled('date_integration_fin')) {
                    $q->whereRaw(
                        'date(json_unquote(json_extract(informations, "$.\"date_integration\""))) <= ?',
                        [$this->request->date_integration_fin]
                    );
                }
            });
        }

        // Charger les relations
        $query->with(['client', 'taches.typeTache']);

        return $query->get();
    }
    public function headings(): array
    {
        return [
            'Référence',
            'Client',
            'Date demande',
            'Support',
            'Date intégration',
            'Statut DOE',
            'Rectification',
            'BPE',
            'Lien',
        ];
    }
  public function map($projet): array
{
    $rows = [];

    $tachesDoe = $projet->taches->filter(fn($t) => $t->typeTache->nom === 'DOE OPTIQUE');

    foreach ($tachesDoe as $doeTask) {
        $doeData = is_array($doeTask->informations) ? $doeTask->informations : json_decode($doeTask->informations, true);

        // Formater les dates
        $date_demande = isset($doeData['date_demande_doe']) ? Carbon::parse($doeData['date_demande_doe'])->format('Y-m-d') : 'N/A';
        $date_integration = isset($doeData['date_integration']) ? Carbon::parse($doeData['date_integration'])->format('Y-m-d') : 'N/A';
        $rectification = isset($doeData['rectification']) ? Carbon::parse($doeData['rectification'])->format('Y-m-d') : 'N/A';
        $bpe = isset($doeData['doe_bpe']) ? Carbon::parse($doeData['doe_bpe'])->format('Y-m-d') : 'N/A';

        $rows[] = [
            $projet->reference,
            $projet->nom_site,
            $projet->client->nom ?? '',
            $doeData['support'] ?? 'N/A',
            $date_integration,
            $doeData['statut_doe'] ?? 'N/A',
            $date_demande,
            $bpe,
            $doeData['doe_lien'] ?? 'N/A',
        ];
    }

    return $rows;
}

}
