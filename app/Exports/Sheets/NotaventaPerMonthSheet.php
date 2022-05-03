<?php

namespace App\Exports\Sheets;

use App\Models\Notaventa;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
class NotaventaPerMonthSheet implements FromQuery, WithHeadings, WithTitle 
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
            'Monto de Pago',
            'Descuento',
            'Monto Total',
            'Cliente',
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
        return Notaventa::query()
            ->join('users', 'notaventa.idusuario', 'users.id')
            ->join('personal', 'users.idpersonal', 'personal.id')
            ->join('cliente', 'notaventa.idcliente', 'cliente.id')
            ->select('notaventa.id', 'notaventa.monto_pago', 'notaventa.descuento', 'notaventa.monto_total', 'cliente.nombre', 'personal.nombre as personalnombre', 'notaventa.condicion', DB::raw('DATE_FORMAT(notaventa.created_at, "%Y-%m-%d %H:%i:%S")'))
            ->where('notaventa.condicion', 1)
            ->whereYear('notaventa.created_at', $this->year)
            ->whereMonth('notaventa.created_at', $this->month);
    }

    public function title(): string
    {
        return Carbon::parse("{$this->year}-{$this->month}-01")->translatedFormat('F-Y');
    }
}
