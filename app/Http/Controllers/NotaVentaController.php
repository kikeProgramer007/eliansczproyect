<?php

namespace App\Http\Controllers;

use App\Http\Controllers\DetalleNotaVenta as ControllersDetalleNotaVenta;
use App\Models\Bitacora;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\Notaventa;
use App\Models\Detallenotaventa;
use App\Models\Tallaproducto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\NotaventaExport;
use App\Models\Rol_permiso;

class NotaVentaController extends Controller
{
    public function index(){
        $notasventas = Notaventa::with('cliente')->with('user')->paginate(4);
        // dd(json_decode(json_encode($notasventas)));
        $permisos_de_este_rol = Rol_permiso::where('idrol', Auth::user()->idrol)->whereIn('idpermiso', [31, 32, 33, 34, 35])->where('condicion', 1)->get();
        $crear = false;
        $listar = false;
        $cambiarEstado = false;
        $generar = false;
        $ver = false;
        foreach ($permisos_de_este_rol as $item) {
            if($item->idpermiso == 31){
                $crear = true;
            }
            if($item->idpermiso == 32){
                $listar = true;
            }
            if($item->idpermiso == 34){
                $cambiarEstado = true;
            }
            if($item->idpermiso == 35){
                $generar = true;
            }
            if($item->idpermiso == 33){
                $ver = true;
            }
        }
        // dd(json_decode(json_encode($permisos_de_este_rol)));
        return view('notaventa.index', ['notasventas' => $notasventas], compact('crear', 'listar', 'cambiarEstado', 'generar', 'ver'));
    }

    public function index_reporte(){
        $notasventas = Notaventa::with('cliente')->with('user')->where('condicion', 1)->paginate(4);
        // dd(json_decode(json_encode($notasventas)));
        $permisos_de_este_rol = Rol_permiso::where('idrol', Auth::user()->idrol)->whereIn('idpermiso', [43, 44, 45, 46])->where('condicion', 1)->get();
        $generar_Excel = false;
        $generar_Recibo = false;
        $listar = false;
        $ver = false;
        foreach ($permisos_de_este_rol as $item) {
            if($item->idpermiso == 43){
                $listar = true;
            }
            if($item->idpermiso == 46){
                $generar_Excel = true;
            }
            if($item->idpermiso == 45){
                $generar_Recibo = true;
            }
            if($item->idpermiso == 44){
                $ver = true;
            }
        }
        // dd(json_decode(json_encode($permisos_de_este_rol)));
        return view('reportendv.index', ['notasventas' => $notasventas], compact('listar', 'generar_Excel', 'generar_Recibo', 'ver'));
    }

    public function create(){
        $tallasproductos = Tallaproducto::where('condicion', 1)->where('stock', '>', 0)->with('producto')->with('talla')->get();
        //$tallasproductos = Tallaproducto::join('producto', 'tallaproducto.idproducto', 'producto.id')->where('tallaproducto.condicion', 1)->where('producto.condicion', 1)->with('talla')->get();
        // dd(json_decode(json_encode($tallasproductos)));
        $clientes = Cliente::get();
        return view('notaventa.create', ['clientes' => $clientes, 'tallasproductos' => $tallasproductos]);
    }

    public function busqueda(Request $request){
        try {
            if($request->input('opcion') == 'cliente'){
                $permisos_de_este_rol = Rol_permiso::where('idrol', Auth::user()->idrol)->whereIn('idpermiso', [31, 32, 33, 34, 35])->where('condicion', 1)->get();
                $crear = false;
                $listar = false;
                $cambiarEstado = false;
                $generar = false;
                $ver = false;
                foreach ($permisos_de_este_rol as $item) {
                    if($item->idpermiso == 31){
                        $crear = true;
                    }
                    if($item->idpermiso == 32){
                        $listar = true;
                    }
                    if($item->idpermiso == 34){
                        $cambiarEstado = true;
                    }
                    if($item->idpermiso == 35){
                        $generar = true;
                    }
                    if($item->idpermiso == 33){
                        $ver = true;
                    }
                }
                $notasventas = Notaventa::join('cliente', 'notaventa.idcliente', 'cliente.id')->where('cliente.nombre', 'LIKE', '%'.$request->input('texto').'%')->get();
                $ids_clientes = array();
                foreach ($notasventas as $value) {
                    array_push($ids_clientes, $value->idcliente);
                }

                $notasventas = Notaventa::whereIn('idcliente', $ids_clientes)->with('cliente')->with('user')
                ->paginate(4);

                $view = view('notaventa.datos', compact('notasventas', 'crear', 'listar', 'cambiarEstado', 'generar', 'ver'))->render();
                return response()->json(['view' => $view], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }

    public function busqueda_reporte(Request $request){
        try {
            if($request->input('opcion') == 'cliente'){
                $permisos_de_este_rol = Rol_permiso::where('idrol', Auth::user()->idrol)->whereIn('idpermiso', [43, 44, 45, 46])->where('condicion', 1)->get();
                $generar_Excel = false;
                $generar_Recibo = false;
                $listar = false;
                $ver = false;
                foreach ($permisos_de_este_rol as $item) {
                    if($item->idpermiso == 43){
                        $listar = true;
                    }
                    if($item->idpermiso == 46){
                        $generar_Excel = true;
                    }
                    if($item->idpermiso == 45){
                        $generar_Recibo = true;
                    }
                    if($item->idpermiso == 44){
                        $ver = true;
                    }
                }
                if($request->input('texto') == ''){
                    $notasventas = Notaventa::join('cliente', 'notaventa.idcliente', 'cliente.id')->where('cliente.nombre', 'LIKE', '%'.$request->input('texto').'%')->get();
                    $ids_clientes = array();
                    foreach ($notasventas as $value) {
                        array_push($ids_clientes, $value->idcliente);
                    }

                    $notasventas = Notaventa::whereIn('idcliente', $ids_clientes)->with('cliente')->with('user')->where('condicion', 1)
                    ->paginate(4);

                    $view = view('reportendv.datos', compact('notasventas', 'listar', 'generar_Excel', 'generar_Recibo', 'ver'))->render();
                    return response()->json(['view' => $view], 200);
                }else{
                    $notasventas = Notaventa::join('cliente', 'notaventa.idcliente', 'cliente.id')->where('cliente.nombre', 'LIKE', '%'.$request->input('texto').'%')->get();
                    $ids_clientes = array();
                    foreach ($notasventas as $value) {
                        array_push($ids_clientes, $value->idcliente);
                    }

                    $notasventas = Notaventa::whereIn('idcliente', $ids_clientes)->whereBetween('created_at', [$request->desde, $request->hasta])->with('cliente')->with('user')->where('condicion', 1)
                    ->paginate(4);

                    //dd(json_decode(json_encode($notasventas)));

                    $view = view('reportendv.datos', compact('notasventas', 'listar', 'generar_Excel', 'generar_Recibo', 'ver'))->render();
                    return response()->json(['view' => $view], 200);
                }
            }
        } catch (\Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request){
        try {
            DB::beginTransaction();
            $errores = Notaventa::store($request);
            if($errores != ''){
                DB::rollBack();
                return response()->json(['mensaje' => $errores], 500);
            }
            DB::commit();
            return response()->json(['mensaje' => 'Nota de venta creada exitosamente'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }

    //ver en el detalle de la nota de venta
    public function ver($idnotaventa){
        $detallesnotasventas = Detallenotaventa::where('idnotaventa', $idnotaventa)->with('tallaproducto')->get();
        // dd(json_decode(json_encode($detallesnotasventas)));
        $clientes = Cliente::get();
        $notasventas = Notaventa::find($idnotaventa);
        return view('notaventa.ver', ['clientes' => $clientes, 'detallesnotasventas' => $detallesnotasventas, 'notasventas' => $notasventas]);
    }

    public function ver_reporte($idnotaventa){
        $detallesnotasventas = Detallenotaventa::where('idnotaventa', $idnotaventa)->with('tallaproducto')->get();
        // dd(json_decode(json_encode($detallesnotasventas)));
        $clientes = Cliente::get();
        $notasventas = Notaventa::find($idnotaventa);
        return view('reportendv.ver', ['clientes' => $clientes, 'detallesnotasventas' => $detallesnotasventas, 'notasventas' => $notasventas]);
    }

    public function desactivar(Request $request){
        try {
            DB::beginTransaction();
            $notaventa = Notaventa::findOrFail($request->input('id'));
            $notaventa->condicion = 0;
            $notaventa->update();
            
            $notasventas = Notaventa::find($notaventa->id);
            $detallesnotasventas = Detallenotaventa::where('idnotaventa', $notasventas->id)->get();
            //dd(json_decode(json_encode($detallesnotasventas)));
            foreach ($detallesnotasventas as $detalle) {
                $obtener_tallaproducto_de_db = Tallaproducto::find($detalle->idtallaproducto);
                $obtener_tallaproducto_de_db->stock = $obtener_tallaproducto_de_db->stock + $detalle->cantidad;
                $obtener_tallaproducto_de_db->update();
            }
            
            $bitacora = new Bitacora();
            $bitacora->accion = 'Desactivar';
            $bitacora->tabla = 'Nota de venta';
            $bitacora->idusuario = Auth::user()->id;
            $bitacora->save();

            DB::commit();
            return  response()->json(['mensaje' => 'Producto devuelto...'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
        
    }

    public function pdf($idnotaventa){
        $notaventa = Notaventa::with('cliente')->with('user')
        ->where('notaventa.id',$idnotaventa)->first();
        // dd(json_decode(json_encode($notasventas)));
        $detallesnotasventas= Detallenotaventa::with('tallaproducto')->where('detallenotaventa.idnotaventa', $idnotaventa)->orderBy('detallenotaventa.id','desc')->get();
        //dd(json_decode(json_encode($detallesnotasventas)));
        $pdf = PDF::loadView('pdf.recibocompra',['notaventa' => $notaventa, 'detallesnotasventas' => $detallesnotasventas]);

        $bitacora = new Bitacora();
        $bitacora->accion = 'Generar Pdf';
        $bitacora->tabla = 'Nota de Venta';
        $bitacora->idusuario = Auth::user()->id;
        $bitacora->save();

        return $pdf->download('venta-'.$notaventa->id.'.pdf');
    }

    public function excel($year){
        //return Excel::download(new NotaventaExport, 'lista_notaventa.xlsx');

        $bitacora = new Bitacora();
        $bitacora->accion = 'Generar Excel';
        $bitacora->tabla = 'Reporte de Venta';
        $bitacora->idusuario = Auth::user()->id;
        $bitacora->save();


        return (new NotaventaExport)->forYear($year)->download('lista_notaventa_'.$year.'.xlsx');
    }

}
