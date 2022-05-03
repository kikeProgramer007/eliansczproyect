<div class="table-responsive" style="overflow: auto">
    <table class="table tablesorter">
        <thead class="text-primary" class="blockquote blockquote-primary">
            <tr >
                <th class="text-info" scope="col">Opciones</th>
                <th class="text-info" scope="col">Fecha y Hora</th>
                <th class="text-info" scope="col">Monto de pago</th>
                <th class="text-info" scope="col">Descuento</th>
                <th class="text-info" scope="col">Monto total</th>
                <th class="text-info" scope="col">Cliente</th>
                <th class="text-info" scope="col">Usuario</th>
                <th class="text-info" scope="col">Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($notasventas as $notaventa)
                <tr>
                    <td class="text-left">
                        @if ($cambiarEstado)
                            @if ($notaventa->condicion == 1)
                                <button type="button" title="Devolver o Eliminar Producto" class="btn btn-danger btn-sm" onclick="desactivar({{$notaventa->id}})">
                                    <i class="tim-icons icon-trash-simple"></i>
                                </button>
                            @endif
                        @endif
                        @if ($generar)
                            <a type="button" title="Imprimir recibo" class="btn btn-info btn-sm" href="{{url('notaventa/pdf/'.$notaventa->id)}}">
                                <i class="tim-icons icon-cloud-download-93"></i>
                            </a>
                        @endif
                        @if ($ver)
                            <a type="button" title="Ver detalles de la nota de venta" class="btn btn-success btn-sm" href="{{url('notaventa/ver/'.$notaventa->id)}}">
                                <i class="tim-icons icon-tap-02"></i>
                            </a>
                        @endif
                    </td>
                    <td>{{$notaventa->created_at}}</td>
                    <td>{{$notaventa->monto_pago}}</td>
                    <td>{{$notaventa->descuento}}</td>
                    <td>{{$notaventa->monto_total}}</td>
                    <td>{{$notaventa->cliente->nombre}}</td>
                    <td>{{$notaventa->user->personal->nombre}}</td>
                    <td>
                        @if ($notaventa->condicion == 1)
                            <span class="badge badge-info">Registrado</span>
                        @else
                            <span class="badge badge-danger">Devuelto</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div>
        {{$notasventas->links()}}
    </div>
</div>