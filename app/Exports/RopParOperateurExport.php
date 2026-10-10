<?php

namespace App\Exports;

use App\Models\Taches;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Illuminate\Support\Facades\DB;

class RopParOperateurExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths, WithTitle
{
    protected Collection $stats;
    protected Collection $grouped;

    public function __construct(protected $request) {}

    public function collection(): Collection
    {
        $query = Taches::select(
                'users.id as user_id',
                'users.name as utilisateur',
                DB::raw("DATE(JSON_UNQUOTE(JSON_EXTRACT(taches.informations, '$.date_livraison_rop'))) as jour"),
                DB::raw('COUNT(*) as total')
            )
            ->join('projets', 'taches.projet_reference', '=', 'projets.reference')
            ->join('users', 'projets.users_id', '=', 'users.id')
            ->whereHas('typeTache', fn($q) => $q->where('nom', 'ROP'))
            ->whereNotNull('informations->date_livraison_rop');

        if ($this->request->filled('user_id'))
            $query->where('users.id', $this->request->user_id);

        if ($this->request->filled('date_debut'))
            $query->whereDate(DB::raw("JSON_UNQUOTE(JSON_EXTRACT(taches.informations, '$.date_livraison_rop'))"), '>=', $this->request->date_debut);

        if ($this->request->filled('date_fin'))
            $query->whereDate(DB::raw("JSON_UNQUOTE(JSON_EXTRACT(taches.informations, '$.date_livraison_rop'))"), '<=', $this->request->date_fin);

        $this->stats   = $query->groupBy('users.id', 'users.name', 'jour')->orderBy('users.name')->orderByDesc('jour')->get();
        $this->grouped = $this->stats->groupBy('utilisateur');

        $rows = collect();

        foreach ($this->grouped as $utilisateur => $lignes) {
            $totalOperateur = $lignes->sum('total');
            $first = true;

            foreach ($lignes as $row) {
                $rows->push([
                    'operateur'       => $row->utilisateur,
                    'jour'            => $row->jour,
                    'total_jour'      => $row->total,
                    'total_operateur' => $first ? $totalOperateur : '',
                ]);
                $first = false;
            }

            // Ligne sous-total
            $rows->push([
                'operateur'       => 'TOTAL ' . strtoupper($utilisateur),
                'jour'            => '',
                'total_jour'      => '',
                'total_operateur' => $totalOperateur,
            ]);

            // Ligne vide séparateur
            $rows->push(['operateur' => '', 'jour' => '', 'total_jour' => '', 'total_operateur' => '']);
        }

        // Grand total
        $rows->push([
            'operateur'       => 'GRAND TOTAL',
            'jour'            => '',
            'total_jour'      => '',
            'total_operateur' => $this->stats->sum('total'),
        ]);

        return $rows;
    }

    public function headings(): array
    {
        return ['Opérateur', 'Date livraison ROP', 'Total / Jour', 'Total opérateur'];
    }

    public function title(): string
    {
        return 'ROP par Opérateur';
    }

    public function columnWidths(): array
    {
        return [
            'A' => 28,
            'B' => 22,
            'C' => 16,
            'D' => 18,
        ];
    }

    public function styles(Worksheet $sheet): void
    {
        $lastRow = $sheet->getHighestRow();

        // ── En-tête ──────────────────────────────────────────────
        $sheet->getStyle('A1:D1')->applyFromArray([
            'font' => [
                'bold'  => true,
                'color' => ['argb' => 'FFFFFFFF'],
                'size'  => 11,
            ],
            'fill' => [
                'fillType'   => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF044053'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color'       => ['argb' => 'FFFFFFFF'],
                ],
            ],
        ]);
        $sheet->getRowDimension(1)->setRowHeight(22);

        // ── Lignes de données ────────────────────────────────────
        $operateurColors = [];
        $colorPalette    = ['FFE8F4FD', 'FFFFF3E0', 'FFE8F5E9', 'FFFCE4EC', 'FFEDE7F6', 'FFE0F2F1'];
        $colorIndex      = 0;
        $currentOp       = null;

        for ($row = 2; $row <= $lastRow; $row++) {
            $cellA = trim((string) $sheet->getCell("A{$row}")->getValue());
            $cellD = $sheet->getCell("D{$row}")->getValue();

            // Ligne vide → skip
            if ($cellA === '' && $sheet->getCell("B{$row}")->getValue() === '') {
                continue;
            }

            // Ligne GRAND TOTAL
            if (str_starts_with($cellA, 'GRAND TOTAL')) {
                $sheet->getStyle("A{$row}:D{$row}")->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF'], 'size' => 11],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF044053']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_MEDIUM, 'color' => ['argb' => 'FF044053']]],
                ]);
                continue;
            }

            // Ligne TOTAL opérateur
            if (str_starts_with($cellA, 'TOTAL ')) {
                $sheet->getStyle("A{$row}:D{$row}")->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['argb' => 'FF044053']],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF45C4EB']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_RIGHT],
                    'borders' => [
                        'top'    => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FF044053']],
                        'bottom' => ['borderStyle' => Border::BORDER_MEDIUM, 'color' => ['argb' => 'FF044053']],
                    ],
                ]);
                continue;
            }

            // Affecter une couleur par opérateur
            if ($cellA !== '' && $cellA !== $currentOp) {
                $currentOp = $cellA;
                if (!isset($operateurColors[$cellA])) {
                    $operateurColors[$cellA] = $colorPalette[$colorIndex % count($colorPalette)];
                    $colorIndex++;
                }
            }

            $bgColor = $operateurColors[$currentOp] ?? 'FFFFFFFF';

            $sheet->getStyle("A{$row}:D{$row}")->applyFromArray([
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => $bgColor]],
                'borders' => [
                    'allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FFD1D5DB']],
                ],
            ]);

            // Colonne Total opérateur en gras si remplie
            if ($cellD !== '') {
                $sheet->getStyle("D{$row}")->getFont()->setBold(true);
            }
        }

        // Centrer colonnes C et D
        $sheet->getStyle("C2:D{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Hauteur des lignes
        for ($row = 2; $row <= $lastRow; $row++) {
            $sheet->getRowDimension($row)->setRowHeight(18);
        }
    }
}