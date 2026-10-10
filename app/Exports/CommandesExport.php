<?php

namespace App\Exports;

use App\Models\Commande;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CommandesExport implements
    FromCollection,
    WithHeadings,
    WithStyles,
    WithTitle,
    ShouldAutoSize,
    WithEvents
{
    private const HEADER_ROW = 1;
    private const COMMANDE_COLUMNS = ['A', 'B', 'C', 'D', 'E', 'F', 'G'];

    protected array $filters;
    protected array $mergeRanges = [];

    /**
     * Constructeur acceptant un tableau de filtres
     */
    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function collection(): Collection
    {
        $query = Commande::query()
            ->with(['client:id,nom', 'user:id,name', 'commandeElements']);

        // Filtre recherche (référence ou site)
        if (!empty($this->filters['search'])) {
            $search = $this->filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('reference', 'like', "%{$search}%")
                  ->orWhere('nom_site', 'like', "%{$search}%");
            });
        }

        // Filtre statut
        if (!empty($this->filters['statut'])) {
            $query->where('statut', $this->filters['statut']);
        }

        // Filtre client
        if (!empty($this->filters['client_id'])) {
            $query->where('client_id', $this->filters['client_id']);
        }

        // Filtre date livraison début
        if (!empty($this->filters['date_livraison_debut'])) {
            $query->whereDate('date_livraison', '>=', $this->filters['date_livraison_debut']);
        }

        // Filtre date livraison fin
        if (!empty($this->filters['date_livraison_fin'])) {
            $query->whereDate('date_livraison', '<=', $this->filters['date_livraison_fin']);
        }

        $commandes = $query->orderBy('date_livraison')->get();

        $rows = collect();
        $currentRow = self::HEADER_ROW + 1;

        foreach ($commandes as $commande) {
            $elements = $commande->commandeElements;
            $nbLignes = $elements->isEmpty() ? 1 : $elements->count();

            if ($elements->isEmpty()) {
                $rows->push($this->mapRow($commande));
            } else {
                foreach ($elements as $element) {
                    $rows->push($this->mapRow($commande, $element));
                }
            }

            if ($nbLignes > 1) {
                $this->mergeRanges[] = [
                    'start' => $currentRow,
                    'end'   => $currentRow + $nbLignes - 1,
                ];
            }

            $currentRow += $nbLignes;
        }

        return $rows;
    }

    private function mapRow(Commande $commande, $element = null): array
    {
        return [
            'reference'      => $commande->reference ?: '-',
            'site'           => $commande->nom_site ?: '-',
            'client'         => $commande->client?->nom ?: '-',
            'utilisateur'    => $commande->user?->name ?: '-',
            'date_reception' => $this->formatDate($commande->date_reception),
            'date_livraison' => $this->formatDate($commande->date_livraison),
            'statut'         => $commande->statut ?: '-',
            'type'           => $element?->type ?: '-',
            'nom'            => $element?->nom ?: '-',
            'action'         => $element?->action ?: '-',
            'origine'        => $element?->origine ?: '-',
            'destination'    => $element?->destination ?: '-',
            'capacite_fo'    => $element?->capacite_fo ?? '-',
            'commentaire'    => $element?->commentaire ?: '-',
        ];
    }

    private function formatDate($date): string
    {
        if (!$date) {
            return '-';
        }
        return Carbon::parse($date)->format('d/m/Y');
    }

    public function headings(): array
    {
        return [
            'Référence',
            'Site',
            'Client',
            'Utilisateur',
            'Date réception',
            'Date livraison',
            'Statut',
            'Type élément',
            'Nom élément',
            'Action',
            'Origine',
            'Destination',
            'Capacité FO',
            'Commentaire',
        ];
    }

    public function title(): string
    {
        return 'Commandes';
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            self::HEADER_ROW => [
                'font' => [
                    'bold'  => true,
                    'color' => ['rgb' => 'FFFFFF'],
                    'size'  => 11,
                ],
                'fill' => [
                    'fillType'   => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '2F5597'],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical'   => Alignment::VERTICAL_CENTER,
                ],
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $lastColumn = $sheet->getHighestColumn();
                $lastRow = $sheet->getHighestRow();

                $sheet->freezePane('A2');
                $sheet->setAutoFilter("A1:{$lastColumn}1");
                $sheet->getRowDimension(1)->setRowHeight(22);

                // Bordures fines sur tout le tableau
                $sheet->getStyle("A1:{$lastColumn}{$lastRow}")->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN)
                    ->setColor(new Color('D9D9D9'));

                // Alignement vertical centré sur les données
                $sheet->getStyle("A2:{$lastColumn}{$lastRow}")
                    ->getAlignment()
                    ->setVertical(Alignment::VERTICAL_CENTER);

                // Fusion des colonnes "commande" pour chaque bloc
                foreach ($this->mergeRanges as $range) {
                    foreach (self::COMMANDE_COLUMNS as $col) {
                        $sheet->mergeCells("{$col}{$range['start']}:{$col}{$range['end']}");
                        $sheet->getStyle("{$col}{$range['start']}")
                            ->getAlignment()
                            ->setVertical(Alignment::VERTICAL_CENTER)
                            ->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    }

                    // Bordure plus épaisse en bas de chaque bloc commande
                    $sheet->getStyle("A{$range['end']}:{$lastColumn}{$range['end']}")
                        ->getBorders()->getBottom()
                        ->setBorderStyle(Border::BORDER_MEDIUM)
                        ->setColor(new Color('7F7F7F'));
                }
            },
        ];
    }
}