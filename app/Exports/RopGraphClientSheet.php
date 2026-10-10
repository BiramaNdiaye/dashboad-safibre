<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Chart\Chart;
use PhpOffice\PhpSpreadsheet\Chart\DataSeries;
use PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues;
use PhpOffice\PhpSpreadsheet\Chart\Legend;
use PhpOffice\PhpSpreadsheet\Chart\PlotArea;
use PhpOffice\PhpSpreadsheet\Chart\Title;

class RopGraphClientSheet implements FromArray, WithHeadings, WithTitle, WithEvents, ShouldAutoSize
{
    protected $tableData;
    protected $clientId;
    protected $clientNom;

    protected $colorRop = 'FF06B6D4'; // cyan
    protected $colorCap = 'FFFB923C'; // orange
    protected $colorBpe = 'FFA855F7'; // violet

    public function __construct($tableData, $clientId, $clientNom)
    {
        $this->tableData = $tableData;
        $this->clientId  = $clientId;
        $this->clientNom = $clientNom;
    }

    /**
     * Le nom de la feuille = nom du client (tronqué à 31 caractères, limite Excel,
     * et nettoyé des caractères interdits dans un nom de feuille Excel).
     */
    public function title(): string
    {
        $title = $this->clientNom ?: ('Client ' . $this->clientId);
        $title = preg_replace('/[\\\\\/\?\*\[\]:]/', '-', $title);
        return mb_substr($title, 0, 31);
    }

    public function headings(): array
    {
        return ['Date', 'ROP', 'Capacité', 'BPE'];
    }

    public function array(): array
    {
        $rows = [];
        foreach ($this->tableData as $row) {
            $rows[] = [
                $row['date'],
                $row[$this->clientId] ?? 0,
                round($row['capacite_' . $this->clientId] ?? 0, 2),
                round($row['nbre_bpe_' . $this->clientId] ?? 0, 2),
            ];
        }

        // Ligne de total pour ce client (exclue du graphique, voir registerEvents)
        if (count($this->tableData) > 0) {
            $rows[] = [
                'TOTAL',
                array_sum(array_column($this->tableData, $this->clientId)),
                round(array_sum(array_column($this->tableData, 'capacite_' . $this->clientId)), 2),
                round(array_sum(array_column($this->tableData, 'nbre_bpe_' . $this->clientId)), 2),
            ];
        }

        return $rows;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $sheetTitle = $this->title();
                $nbDataRows = count($this->tableData);

                if ($nbDataRows === 0) {
                    return; // pas de données, pas de style ni de graphique à générer
                }

                $lastDataRow      = $nbDataRows + 1; // +1 pour la ligne d'en-tête (ligne 1)
                $lastRowWithTotal = $lastDataRow + 1; // +1 pour la ligne TOTAL

                // ---- Style en-tête (ligne 1), couleur par mesure ----
                $sheet->getStyle('A1:D1')->applyFromArray([
                    'font'      => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                ]);
                $sheet->getStyle('A1')->applyFromArray([
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF6B7280']],
                ]);
                $sheet->getStyle('B1')->applyFromArray([
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => $this->colorRop]],
                ]);
                $sheet->getStyle('C1')->applyFromArray([
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => $this->colorCap]],
                ]);
                $sheet->getStyle('D1')->applyFromArray([
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => $this->colorBpe]],
                ]);
                $sheet->getRowDimension(1)->setRowHeight(20);

                // ---- Bordures sur tout le tableau (en-tête + données + total) ----
                $sheet->getStyle('A1:D' . $lastRowWithTotal)->applyFromArray([
                    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FFD1D5DB']]],
                ]);

                // ---- Ligne TOTAL en gras + fond clair ----
                $sheet->getStyle('A' . $lastRowWithTotal . ':D' . $lastRowWithTotal)->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFE0F7FA']],
                ]);

                // ---- Alignement centré pour les valeurs numériques ----
                $sheet->getStyle('B2:D' . $lastRowWithTotal)
                    ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $sheet->freezePane('A2');

                // =========================================================
                // GRAPHIQUE : barres groupées ROP / Capacité / BPE
                // Un seul axe Y (approche simple et fiable, sans risque
                // d'affichage cassé selon la version d'Excel/LibreOffice)
                // La ligne TOTAL est exclue des plages du graphique.
                // =========================================================

                $categories = [
                    new DataSeriesValues(
                        DataSeriesValues::DATASERIES_TYPE_STRING,
                        "'{$sheetTitle}'!\$A\$2:\$A\${$lastDataRow}",
                        null,
                        $nbDataRows
                    ),
                ];

                $values = [
                    new DataSeriesValues(
                        DataSeriesValues::DATASERIES_TYPE_NUMBER,
                        "'{$sheetTitle}'!\$B\$2:\$B\${$lastDataRow}",
                        null,
                        $nbDataRows
                    ),
                    new DataSeriesValues(
                        DataSeriesValues::DATASERIES_TYPE_NUMBER,
                        "'{$sheetTitle}'!\$C\$2:\$C\${$lastDataRow}",
                        null,
                        $nbDataRows
                    ),
                    new DataSeriesValues(
                        DataSeriesValues::DATASERIES_TYPE_NUMBER,
                        "'{$sheetTitle}'!\$D\$2:\$D\${$lastDataRow}",
                        null,
                        $nbDataRows
                    ),
                ];

                $seriesLabels = [
                    new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, "'{$sheetTitle}'!\$B\$1", null, 1),
                    new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, "'{$sheetTitle}'!\$C\$1", null, 1),
                    new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, "'{$sheetTitle}'!\$D\$1", null, 1),
                ];

                $series = new DataSeries(
                    DataSeries::TYPE_BARCHART,
                    DataSeries::GROUPING_CLUSTERED,
                    range(0, count($values) - 1),
                    $seriesLabels,
                    $categories,
                    $values
                );
                $series->setPlotDirection(DataSeries::DIRECTION_COL);

                $plotArea = new PlotArea(null, [$series]);
                $legend   = new Legend(Legend::POSITION_TOP, null, false);
                $title    = new Title('ROP, Capacité et BPE — ' . $this->clientNom);

                $chart = new Chart(
                    'chart_' . $this->clientId,
                    $title,
                    $legend,
                    $plotArea
                );
                $chart->setTopLeftPosition('F2');
                $chart->setBottomRightPosition('P22');

                $sheet->addChart($chart);
            },
        ];
    }
}
