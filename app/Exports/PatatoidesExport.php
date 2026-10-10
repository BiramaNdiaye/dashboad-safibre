<?php

namespace App\Exports;

use App\Models\Patatoide;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PatatoidesExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $patatoides;

    public function __construct($patatoides)
    {
        $this->patatoides = $patatoides;
    }

    public function collection()
    {
        return $this->patatoides;
    }

    public function headings(): array
    {
        return [
            'Type Projet',
            'Référence Projet',
            'Site',
            'Date Réception',
            'Nb BPE',
            'Nb Client',
            'Nb Câble Ext',
            'Nb Racco Client',
            'Statut Patatoïde',
            'Date Livraison Patatoïde',
            'Validation Covage',
            'Commentaires'
        ];
    }

    public function map($patatoide): array
    {
        return [
            $patatoide->type_projet,
            $patatoide->ref_projet,
            $patatoide->site,
            $patatoide->date_reception ? $patatoide->date_reception->format('d/m/Y') : '',
            $patatoide->nbre_bpe ?? '',
            $patatoide->nbre_client ?? '',
            $patatoide->nbre_cable_ext ?? '',
            $patatoide->nbre_racco_client ?? '',
            $patatoide->statut_patatoide,
            $patatoide->date_liv_patatoide ? $patatoide->date_liv_patatoide->format('d/m/Y') : '',
            $patatoide->validation_covage,
            $patatoide->commentaires,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style pour l'en-tête
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType' => 'solid',
                    'startColor' => ['rgb' => '45C4EB'],
                ],
            ],
        ];
    }
}