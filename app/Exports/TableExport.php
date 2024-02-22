<?php

namespace App\Exports;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TableExport implements FromView, ShouldAutoSize,
    WithStyles, WithColumnWidths, ShouldQueue
{

    protected $view;
    protected $datas;

    function __construct($view,$datas) {
        $this->view = $view;
        $this->datas = $datas;
    }

    public function view(): View
    {
        return view('export.'.$this->view, ['datas' => $this->datas]);
    }

    public function columnWidths(): array
    {
        return [
            'C' => 35,
            'D' => 35,
            'H' => 35,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // TODO: Implement styles() method.
    }
}
