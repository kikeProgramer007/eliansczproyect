<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromCollection;
use Carbon\Carbon;
use App\Models\Notasalida;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class NotasalidaPerMonthSheet implements FromQuery, WithHeadings, WithTitle 
{
    private $year;
    private $month;

    public function __construct($year, $month)
    {
        $this->year  = $year;
        $this->month = $month;
    }

    public function headings(): array
    {
        return [
            'Id',
            'Perdida Total',
            'Condición',
            'Fecha y Hora',
        ];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function query()
    {
        return Notasalida::query()
            ->select('notasalida.id', 'notasalida.perdida_total', 'notasalida.condicion', DB::raw('DATE_FORMAT(notasalida.created_at, "%Y-%m-%d %H:%i:%S")'))
            ->where('notasalida.condicion', 1)
            ->whereYear('notasalida.created_at', $this->year)
            ->whereMonth('notasalida.created_at', $this->month);
    }

    public function title(): string
    {
        return Carbon::parse("{$this->year}-{$this->month}-01")->translatedFormat('F-Y');
    }
}
