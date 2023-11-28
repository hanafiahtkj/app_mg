<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Exports\Sheets\PerusahaanSheet;
use App\Exports\Sheets\PkbSheet;
use App\Exports\Sheets\PpSheet;
use App\Exports\Sheets\LksSheet;

class RekapPerusahaanExport implements WithMultipleSheets
{
    use Exportable;

    public function __construct($id_perusahaan, $bulantahun)
    {
        $this->id_perusahaan = $id_perusahaan;
        $this->bulantahun = $bulantahun;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];
        $sheets[] = new PerusahaanSheet($this->id_perusahaan, $this->bulantahun);
        $sheets[] = new PkbSheet($this->id_perusahaan, $this->bulantahun);
        $sheets[] = new PpSheet($this->id_perusahaan, $this->bulantahun);
        $sheets[] = new LksSheet($this->id_perusahaan, $this->bulantahun);

        return $sheets;
    }
}
