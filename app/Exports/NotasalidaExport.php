<?php

namespace App\Exports;

use App\Exports\Sheets\NotasalidaPerMonthSheet;
use App\Models\Notasalida;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class NotasalidaExport implements WithMultipleSheets
{
    use Exportable;

    private $year;
    
    public function forYear($year)
    {
        $this->year = $year;

        return $this;
    }
    // public function view(): View
    // {
    //     return view('notaventa.exportar', [
    //         'notasventas' => Notaventa::with('cliente')->with('user')->get()
    //     ]);
    // }

    public function sheets(): array
    {
        $sheets = [];

        for ($month = 1; $month <= 12; $month++) {
            $sheets[] = new NotasalidaPerMonthSheet($this->year, $month);
        }

        return $sheets;
    }
}
