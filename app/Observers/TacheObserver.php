<?php

namespace App\Observers;

use App\Models\Taches;

class TacheObserver
{

 public function created(Taches $tache)
    {
        $this->majStatutProjet($tache->projet);
    }

    public function updated(Taches $tache)
    {
        $this->majStatutProjet($tache->projet);
    }

    private function majStatutProjet($projet)
    {
        // Charger les tâches liées avec leur type
        $projet->load('taches.typeTache');

        $ropTache = $projet->taches->firstWhere('typeTache.nom', 'ROP');
        $bloTache = $projet->taches->firstWhere('typeTache.nom', 'BLO');

        // Extraction des infos JSON sécurisée
        $ropStatut = null;
        if ($ropTache) {
            $ropInfos = is_array($ropTache->informations) 
                ? $ropTache->informations 
                : json_decode($ropTache->informations ?? '{}', true);
            $ropStatut = $ropInfos['statut_rop'] ?? null;
        }

        $bloStatut = null;
        if ($bloTache) {
            $bloInfos = is_array($bloTache->informations) 
                ? $bloTache->informations 
                : json_decode($bloTache->informations ?? '{}', true);
            $bloStatut = $bloInfos['statut_blo'] ?? null;
        }

        // Détermination du nouveau statut
        $nouveauStatut = 'En cours'; // par défaut

        if ($ropTache && !$bloTache) {
            if ($ropStatut === 'Livré') {
                $nouveauStatut = 'Livré';
            }
        } elseif ($ropTache && $bloTache) {
            if (
                $ropStatut === 'Livré' &&
                $bloStatut === 'Livré : Dépôt ANNX sur WT'
            ) {
                $nouveauStatut = 'Livré';
            }
        }

        // Mise à jour uniquement si nécessaire
        if ($projet->statut_projet !== $nouveauStatut) {
            $projet->update(['statut_projet' => $nouveauStatut]);
        }
    }




}
