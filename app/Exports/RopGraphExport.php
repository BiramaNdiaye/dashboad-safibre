<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class RopGraphExport implements WithMultipleSheets
{
    protected $tableData;
    protected $clients; // collection [id => nom]

    public function __construct($tableData, $clients)
    {
        $this->tableData = $tableData;
        $this->clients   = $clients;
    }

    /**
     * Une feuille par client.
     */
    public function sheets(): array
    {
        $sheets = [];

        foreach ($this->clients as $clientId => $clientNom) {
            $sheets[] = new RopGraphClientSheet($this->tableData, $clientId, $clientNom);
        }

        // Si aucun client (aucune donnée), on évite un fichier Excel vide sans feuille
        if (empty($sheets)) {
            $sheets[] = new RopGraphEmptySheet();
        }

        return $sheets;
    }
}
