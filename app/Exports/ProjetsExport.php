<?php

namespace App\Exports;

use App\Models\Projet;
use App\Models\Taches;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProjetsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $query;

    public function __construct($query = null)
    {
        $this->query = $query ?? Projet::query();
    }

    public function collection()
    {
        $projets = $this->query->with(['taches.typeTache', 'chefProjet', 'client'])->get();
        
        $data = new Collection();
        
        foreach ($projets as $projet) {
            $rops = $projet->taches->where('typeTache.nom', 'ROP');
            
            // Si pas de ROP, on crée une ligne avec le projet seul
            if ($rops->isEmpty()) {
                $data->push(['projet' => $projet]);
            } else {
                // Sinon une ligne par version ROP
                foreach ($rops as $rop) {
                    $data->push([
                        'projet' => $projet,
                        'rop' => $rop
                    ]);
                }
            }
        }
        
        return $data;
    }

    public function headings(): array
    {
        return [
            'REFERENCE',
            'NOM DU SITE',
            'CLIENT',
            'DATE DE COMMANDE',
            'CHEF DE PROJET',
            'STATUT DU PROJET',
            'ROP - Version',
            'ROP - Type',
            'ROP - Nombre de BPE',
            'ROP - Statut',
            'ROP - Date de livraison',
            'ROP - Lien résilié',
            'BLO - Type',
            'BLO - Date de livraison',
            'DOE - Date d\'intégration',
            'DOE - Nombre de BPE',
        ];
    }

    public function map($item): array
    {
        $projet = $item['projet'];
        $rop = $item['rop'] ?? null;
        
        $ropData = $rop ? $this->extractTacheData($rop) : [];
        $bloTache = $projet->taches->firstWhere('typeTache.nom', 'BLO');
        $doeTache = $projet->taches->firstWhere('typeTache.nom', 'DOE');
        
        $bloData = $this->extractTacheData($bloTache);
        $doeData = $this->extractTacheData($doeTache);

        return [
            $projet->reference,
            $projet->nom_site,
            $projet->client->nom ?? 'Non spécifié',
            $projet->date_commande,
            $projet->chefProjet->name ?? 'Non assigné',
            $projet->statut,
            $ropData['version_rop'] ?? '',
            $ropData['type'] ?? '',
            $ropData['nbre_bpe'] ?? '',
            $ropData['statut_projet'] ?? '',
            $ropData['date_livraison'] ?? '',
            $ropData['lien_resilie'] ?? '',
            $bloData['type'] ?? '',
            $bloData['date_livraison'] ?? '',
            $doeData['date_integration'] ?? '',
            $doeData['nbre_bpe'] ?? '', 
        ];
    }

    protected function extractTacheData($tache)
    {
        if (!$tache || !$tache->typeTache) {
            return [];
        }

        $type = strtolower($tache->typeTache->nom);

        $data = [
            'version_rop' => $tache->informations['version_rop'] ?? '',
            'type' => $tache->informations["type_{$type}"] ?? '',
            'nbre_bpe' => $tache->informations['nbre_bpe'] ?? '',
            'statut' => $tache->informations["statut_{$type}"] ?? '',
            'date_livraison' => $tache->informations["date_livraison_{$type}"] ?? '',
            'lien_resilie' => $tache->informations['lien_resilie'] ?? '',
            'num_fci' => $tache->informations['num_fci'] ?? '',
        ];

        // Champs spécifiques DOE
        if ($type === 'doe') {
            $data['date_integration'] = $tache->informations['date_integration'] ?? '';
            // Si vous avez un champ spécifique pour DOE BPE, utilisez-le ici
            $data['nbre_bpe'] = $tache->informations['nbre_bpe_doe'] ?? $tache->informations['nbre_bpe'] ?? '';
        }

        return $data;
    }
}