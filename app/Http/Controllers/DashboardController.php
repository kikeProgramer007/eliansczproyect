<?php

namespace App\Http\Controllers;

use App\Models\Notacompra;
use App\Models\Notasalida;
use App\Models\Notaventa;
use App\Models\Producto;
use App\Models\Tallaproducto;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        if (Auth::check()) {
            // $notas_de_ventas_condicion_0 = Notaventa::where('notaventa.condicion', 1)
            // ->where(DB::raw("(DATE_FORMAT(created_at,'%a'))"), "Fri")->get();

            //$date = Carbon::now()->subDays(7);

            $start = Carbon::now()->startOfWeek(Carbon::SUNDAY);
            $end = Carbon::now()->endOfWeek(Carbon::FRIDAY);
            $año = Carbon::now()->startOfYear();
            //dd(json_decode(json_encode($año)));

            $monto_total_semanal_registrado = Notaventa::select(DB::raw('IFNULL(SUM(monto_total),0) as monto_registrado'))->where('created_at', '>=', $start)->where('created_at', '<=', $end)->where('notaventa.condicion', 1)->first();
            //dd(json_decode(json_encode($monto_total_semanal_devuelto)));

            $monto_total_semanal_devuelto = Notaventa::select(DB::raw('IFNULL(SUM(monto_total),0) as monto_devuelto'))->where('created_at', '>=', $start)->where('created_at', '<=', $end)->where('notaventa.condicion', 0)->first();
            //dd(json_decode(json_encode($monto_total_semanal_devuelto)));

            $monto_total_semanal_salida= Notasalida::select(DB::raw('IFNULL(SUM(perdida_total),0) as perdida_registrado'))->where('created_at', '>=', $start)->where('created_at', '<=', $end)->where('notasalida.condicion', 1)->first();
            //dd(json_decode(json_encode($monto_total_semanal_devuelto)));

            $ingresos = Notaventa::select(DB::raw('IFNULL(SUM(monto_total),0) as ingresos'))->where('created_at', '>=', $año)->where('notaventa.condicion', 1)->first();
            //dd(json_decode(json_encode($ingresos)));

            $egresos = Notacompra::select(DB::raw('IFNULL(SUM(monto_total),0) as egresos'))->where('created_at', '>=', $año)->where('notacompra.condicion', 1)->first();
            //dd(json_decode(json_encode($egresos)));

            $perdidas = Notasalida::select(DB::raw('IFNULL(SUM(perdida_total),0) as perdidas'))->where('created_at', '>=', $año)->where('notasalida.condicion', 1)->first();
            //dd(json_decode(json_encode($perdidas)));

            $notas_de_ventas_devuelto = Notaventa::select(DB::raw("(DATE_FORMAT(created_at,'%a')) dia"), DB::raw('SUM(monto_total) as contadores'))->where('created_at', '>=', $start)->where('created_at', '<=', $end)->where('notaventa.condicion', 0)
            ->groupBy(DB::raw("(DATE_FORMAT(created_at,'%a'))"))->get();
            //dd(json_decode(json_encode($notas_de_ventas_devuelto)));

            $notas_de_ventas_registrado = Notaventa::select(DB::raw("(DATE_FORMAT(created_at,'%a')) dia"), DB::raw('SUM(monto_total) as contadores'))->where('created_at', '>=', $start)->where('created_at', '<=', $end)->where('notaventa.condicion', 1)
            ->groupBy(DB::raw("(DATE_FORMAT(created_at,'%a'))"))->get();

            $notas_de_salidas_registrado = Notasalida::select(DB::raw("(DATE_FORMAT(created_at,'%a')) dia"), DB::raw('SUM(perdida_total) as contadores'))->where('created_at', '>=', $start)->where('created_at', '<=', $end)->where('notasalida.condicion', 1)
            ->groupBy(DB::raw("(DATE_FORMAT(created_at,'%a'))"))->get();

            $tallasproductos = Tallaproducto::where('condicion', 1)->where('stock', '<=', 10)->with('producto')->with('talla')->get();
            //dd(json_decode(json_encode($num_productos)));
            return view('dashboard.index_administrador', ['tallasproductos' => $tallasproductos, 'monto_total_semanal_registrado' => $monto_total_semanal_registrado, 'monto_total_semanal_devuelto' => $monto_total_semanal_devuelto, 
            'monto_total_semanal_salida' => $monto_total_semanal_salida, 'ingresos' => $ingresos, 'egresos' => $egresos, 'perdidas' => $perdidas], compact('notas_de_ventas_devuelto', 'notas_de_ventas_registrado', 'notas_de_salidas_registrado'));
        }
    }
    public function index2()
    {
        if (Auth::check()) {
            $producto = Producto::where('condicion', 1)->get();

            $productos = Producto::where('condicion', 1)->where('oferta', '>', 0.00)->get();
            //dd(json_decode(json_encode($productos)));
            return view('dashboard.index_vendedor', ['productos' => $productos], ['producto' => $producto]);
        }
    }

    public function calcular(Request $request){
        $ingresos = Notaventa::select(DB::raw('IFNULL(SUM(monto_total),0) as ingresos'))->whereBetween('created_at', [$request->desde, $request->hasta])->where('notaventa.condicion', 1)->first();
        //dd(json_decode(json_encode($ingresos)));

        $egresos = Notacompra::select(DB::raw('IFNULL(SUM(monto_total),0) as egresos'))->whereBetween('created_at', [$request->desde, $request->hasta])->where('notacompra.condicion', 1)->first();

        $perdidas = Notasalida::select(DB::raw('IFNULL(SUM(perdida_total),0) as perdidas'))->whereBetween('created_at', [$request->desde, $request->hasta])->where('notasalida.condicion', 1)->first();
        //dd(json_decode(json_encode($egresos)));
        return response()->json(['ingresos' => $ingresos, 'egresos' => $egresos, 'perdidas' => $perdidas], 200);
    }
}
