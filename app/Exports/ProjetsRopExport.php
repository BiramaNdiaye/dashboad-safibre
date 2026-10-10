<?php

namespace App\Exports;

use App\Models\Projet;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class ProjetsRopExport implements FromCollection, WithHeadings, WithMapping, WithColumnWidths, WithEvents
{
    protected $query;
    protected $request;

    // Colonnes par bloc, pour garder une seule source de vérité sur la mise en forme
    // Bloc Projet + ROP : Référence, Nom du site, Client, Chef de projet, Code_site,
    //                      Version ROP, Type ROP, Statut ROP, Statut Rop Netgo,
    //                      Date livraison ROP, Nombre BPE, Longueur extension, Lien résilié
    private const COL_PROJET_ROP_START = 'A';
    private const COL_PROJET_ROP_END   = 'M';

    // Bloc BLO : Date Livraison BLO, Type BLO, Statut BLO, FCI BLO
    private const COL_BLO_START        = 'N';
    private const COL_BLO_END          = 'Q';

    // Bloc DOE : Support DOE, Date intégration DOE, Statut DOE
    private const COL_DOE_START        = 'R';
    private const COL_DOE_END          = 'T';

    // Colonnes contenant un statut (mise en forme conditionnelle)
    // H = Statut ROP, P = Statut BLO, T = Statut DOE
    private const STATUS_COLUMNS = ['H', 'P', 'T'];

    public function __construct($query = null, $request = null)
    {
        $this->query = $query ?? Projet::query();
        $this->request = $request;
    }

    public function collection()
    {
        return $this->query->get();
    }

    public function headings(): array
    {
        return [
            'Référence',
            'Nom du site',
            'Client',
            'Chef de projet',
            'Code_site',
            'Version ROP',
            'Type ROP',
            'Statut ROP',
            'Statut Rop Netgo',
            'Date livraison ROP',
            'Nombre BPE',
            'Longueur extension',
            'Lien résilié',
            'Date Livraison BLO',
            'Type BLO',
            'Statut BLO',
            'FCI BLO',
            'Support DOE',
            'Date intégration DOE',
            'Statut DOE',
        ];
    }

    public function map($projet): array
    {
        $rows = [];

        // Tâches ROP déjà filtrées dans le contrôleur
        $tachesRop = $projet->taches;

        // Récupérer la tâche DOE OPTIQUE du projet (indépendante de ROP)
        $tacheDoe = $projet->taches()
            ->whereHas('typeTache', fn($q) => $q->where('nom', 'DOE OPTIQUE'))
            ->first();

        $doeData = $tacheDoe
            ? (is_array($tacheDoe->informations) ? $tacheDoe->informations : json_decode($tacheDoe->informations, true))
            : [
                'support' => 'N/A',
                'date_integration' => 'N/A',
                'statut_doe' => 'N/A',
            ];

        // BLO (si nécessaire)
        $tachesBlo = $projet->taches()
            ->whereHas('typeTache', fn($t) => $t->where('nom', 'BLO'))
            ->get();

        // Regroupement par version
        $blosByVersion = [];
        foreach ($tachesBlo as $tacheBlo) {
            $data = is_array($tacheBlo->informations) ? $tacheBlo->informations : json_decode($tacheBlo->informations, true);
            $version = $data['version_rop'] ?? 'N/A';
            $blosByVersion[$version] = $data;
        }

        // Générer une ligne par ROP
        foreach ($tachesRop as $tacheRop) {

            $ropData = is_array($tacheRop->informations)
                ? $tacheRop->informations
                : json_decode($tacheRop->informations, true);

            $version = $ropData['version_rop'] ?? 'N/A';

            $bloData = $blosByVersion[$version] ?? [
                'date_livraison_blo' => 'N/A',
                'type_blo' => 'N/A',
                'statut_blo' => 'N/A',
                'num_fci' => 'N/A',
            ];

            $rows[] = [
                // Projet
                $projet->reference,
                $projet->nom_site,
                $projet->client->nom ?? '',
                $projet->chefProjet->name,
                $projet->code_site ?? '',

                // Tâche ROP
                $version,
                $ropData['type_rop'] ?? '',
                $ropData['statut_rop'] ?? '',
                $ropData['statut_rop_netgeo'] ?? '',
                $ropData['date_livraison_rop'] ?? '',
                $ropData['nbre_bpe'] ?? '0',
                $ropData['capacite'] ?? '0',
                $ropData['lien_resilie'] ?? '',

                // BLO
                $bloData['date_livraison_blo'] ?? '',
                $bloData['type_blo'] ?? '',
                $bloData['statut_blo'] ?? '',
                $bloData['num_fci'] ?? '',

                // DOE OPTIQUE indépendant
                $doeData['support'] ?? 'N/A',
                $doeData['date_integration'] ?? 'N/A',
                $doeData['statut_doe'] ?? 'N/A',
            ];
        }

        return $rows;
    }

    public function columnWidths(): array
    {
        return [
            'A' => 16, // Référence
            'B' => 22, // Nom du site
            'C' => 18, // Client
            'D' => 18, // Chef de projet
            'E' => 14, // Code_site
            'F' => 12, // Version ROP
            'G' => 14, // Type ROP
            'H' => 16, // Statut ROP
            'I' => 18, // Statut Rop Netgo
            'J' => 16, // Date livraison ROP
            'K' => 12, // Nombre BPE
            'L' => 16, // Longueur extension
            'M' => 12, // Lien résilié
            'N' => 16, // Date Livraison BLO
            'O' => 12, // Type BLO
            'P' => 16, // Statut BLO
            'Q' => 12, // FCI BLO
            'R' => 14, // Support DOE
            'S' => 18, // Date intégration DOE
            'T' => 14, // Statut DOE
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $highestRow = $sheet->getHighestRow();
                $highestColumn = $sheet->getHighestColumn(); // 'T'

                // --- Mise en forme générale du corps du tableau ---
                if ($highestRow >= 1) {
                    $sheet->getStyle("A1:{$highestColumn}{$highestRow}")->applyFromArray([
                        'font' => ['name' => 'Calibri', 'size' => 10],
                        'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT, 'vertical' => Alignment::VERTICAL_CENTER],
                        'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'E2E5E9']]],
                    ]);
                }

                // --- En-tête : fonds colorés par bloc ---
                $sheet->getStyle(self::COL_PROJET_ROP_START . '1:' . self::COL_PROJET_ROP_END . '1')
                    ->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('2E5C8A');
                $sheet->getStyle(self::COL_BLO_START . '1:' . self::COL_BLO_END . '1')
                    ->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('3E8254');
                $sheet->getStyle(self::COL_DOE_START . '1:' . self::COL_DOE_END . '1')
                    ->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('B8860B');

                $sheet->getStyle("A1:{$highestColumn}1")->applyFromArray([
                    'font' => ['bold' => true, 'size' => 11, 'color' => ['rgb' => 'FFFFFF'], 'name' => 'Calibri'],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true],
                    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'FFFFFF']]],
                ]);
                $sheet->getRowDimension(1)->setRowHeight(34);

                // --- Corps : zébrage, statuts colorés, alignement des nombres ---
                if ($highestRow >= 2) {
                    for ($row = 2; $row <= $highestRow; $row++) {
                        if ($row % 2 === 0) {
                            $sheet->getStyle("A{$row}:{$highestColumn}{$row}")
                                ->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('F4F6F8');
                        }

                        foreach (self::STATUS_COLUMNS as $col) {
                            $cellCoord = "{$col}{$row}";
                            $value = mb_strtolower(trim((string) $sheet->getCell($cellCoord)->getValue()));
                            $colors = $this->statusColors($value);

                            if ($colors !== null) {
                                $sheet->getStyle($cellCoord)->applyFromArray([
                                    'font' => ['bold' => true, 'color' => ['rgb' => $colors['font']]],
                                    'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => $colors['fill']]],
                                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                                ]);
                            }
                        }
                    }

                    // Colonnes numériques centrées : K = Nombre BPE, L = Longueur extension
                    $sheet->getStyle("K2:L{$highestRow}")
                        ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                    // Colonnes "dates" centrées : J = Date livraison ROP,
                    // N = Date Livraison BLO, S = Date intégration DOE
                    foreach (['J', 'N', 'S'] as $dateCol) {
                        $sheet->getStyle("{$dateCol}2:{$dateCol}{$highestRow}")
                            ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    }
                }

                // --- Bordure extérieure plus marquée autour du tableau ---
                $sheet->getStyle("A1:{$highestColumn}{$highestRow}")->applyFromArray([
                    'borders' => [
                        'outline' => ['borderStyle' => Border::BORDER_MEDIUM, 'color' => ['rgb' => '8C8C8C']],
                    ],
                ]);

                // --- Confort de lecture ---
                $sheet->freezePane('A2');
                $sheet->setAutoFilter("A1:{$highestColumn}1");
                $sheet->getDefaultRowDimension()->setRowHeight(20);
            },
        ];
    }

    /**
     * Détermine la couleur (fond / police) à appliquer selon le libellé d'un statut.
     * Retourne null si aucune correspondance (cellule laissée neutre).
     */
    private function statusColors(string $value): ?array
    {
        if ($value === '' || $value === 'n/a') {
            return ['fill' => 'ECECEC', 'font' => '6B7280'];
        }

        $rules = [
            // vert : terminé / livré / validé
            ['needles' => ['livr', 'valid', 'termin', 'cloture', 'clôtur'], 'fill' => 'D9F2DD', 'font' => '1E7B34'],
            // orange : en cours / en attente
            ['needles' => ['en cours', 'attente', 'planifi'], 'fill' => 'FCEBC4', 'font' => '8A6500'],
            // rouge : annulé / refusé / en retard
            ['needles' => ['annul', 'refus', 'retard', 'bloqu'], 'fill' => 'FBD8D6', 'font' => 'A6231F'],
        ];

        foreach ($rules as $rule) {
            foreach ($rule['needles'] as $needle) {
                if (str_contains($value, $needle)) {
                    return ['fill' => $rule['fill'], 'font' => $rule['font']];
                }
            }
        }

        return null;
    }
}