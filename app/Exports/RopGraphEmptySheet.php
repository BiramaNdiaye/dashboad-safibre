<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;

class RopGraphEmptySheet implements FromArray, WithTitle
{
    public function title(): string
    {
        return 'Aucune donnée';
    }

    public function array(): array
    {
        return [['Aucune donnée disponible pour les filtres sélectionnés.']];
    }
}
