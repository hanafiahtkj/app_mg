<?php

namespace App\Exports\Sheets;

use App\Models\Perusahaan;
use App\Models\Proses;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Carbon\Carbon;
use DB;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Concerns\WithTitle;

class PerusahaanSheet implements FromView, WithEvents, ShouldAutoSize, WithTitle
{
    public function __construct($id_perusahaan, $bulantahun)
    {
        $this->rowCount  = 6;
        $this->id_perusahaan = $id_perusahaan;
        $this->bulantahun = $bulantahun;
    }

    public function view(): View
    {
        $report = Perusahaan::with(['proses' => function ($query) {
            $query->where('bulantahun', '=', $this->bulantahun.'-01');
        }])
        ->whereHas('proses', function ($query) {
            $query->where('bulantahun', '=', $this->bulantahun.'-01');
        });

        if ($this->id_perusahaan) {
            $report = $report->where('id_perusahaan', $this->id_perusahaan);
        }

        $bulantahun = $this->bulantahun;

        $this->rowCount += $report->count();

        // dd($report->get());

        $data = [
            'report' => $report->get(),
            'bulantahun' => $bulantahun,
        ];

        // echo view('excel.perusahaan', $data); die;
        return view('excel.perusahaan', $data);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $cellRange = 'A1:AA2';
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()
                    ->setSize(12)
                    ->setBold(true);

                $cellRange = 'A4:AA6';
                $event->sheet->getDelegate()->getStyle($cellRange)->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('E0E0E0');

                $cellRange = 'A1:AA'.$this->rowCount;
                $event->sheet->getDelegate()->getStyle($cellRange)
                    ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $event->sheet->getStyle('A4:AA'.$this->rowCount)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);
            },
        ];
    }

    public function title(): string
    {
        return 'DATA PERUSAHAAN KAB';
    }
}
