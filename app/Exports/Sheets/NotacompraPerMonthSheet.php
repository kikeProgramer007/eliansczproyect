<?php

namespace App\Exports\Sheets;

use App\Models\Notacompra;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class NotacompraPerMonthSheet implements FromQuery, WithHeadings, WithTitle 
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
            'Impuesto',
            'Monto Total',
            'Proveedor',
            'Usuario',
            'Condición',
            'Fecha y Hora',
        ];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function query()
    {
        return Notacompra::query()
            ->join('users', 'notacompra.idusuario', 'users.id')
            ->join('personal', 'users.idpersonal', 'personal.id')
            ->join('proveedor', 'notacompra.idproveedor', 'proveedor.id')
            ->select('notacompra.id', 'notacompra.impuesto', 'notacompra.monto_total', 'proveedor.nombre', 'personal.nombre as personalnombre', 'notacompra.condicion', DB::raw('DATE_FORMAT(notacompra.created_at, "%Y-%m-%d %H:%i:%S")'))
            ->where('notacompra.condicion', 1)
            ->whereYear('notacompra.created_at', $this->year)
            ->whereMonth('notacompra.created_at', $this->month);
    }

    public function title(): string
    {
        return Carbon::parse("{$this->year}-{$this->month}-01")->translatedFormat('F-Y');
    }
}
