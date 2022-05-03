<?php

namespace App\Exports;

use App\Exports\Sheets\NotaventaPerMonthSheet;
use App\Models\Notaventa;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class NotaventaExport implements WithMultipleSheets
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
            $sheets[] = new NotaventaPerMonthSheet($this->year, $month);
        }

        return $sheets;
    }
}
