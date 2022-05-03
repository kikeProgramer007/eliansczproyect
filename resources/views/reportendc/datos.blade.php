<div class="table-responsive" style="overflow: auto">
    <table class="table tablesorter">
        <thead class="text-primary" class="blockquote blockquote-primary">
            <tr >
                <th class="text-info" scope="col">Opciones</th>
                <th class="text-info" scope="col">Fecha y Hora</th>
                <th class="text-info" scope="col">Impuesto</th>
                <th class="text-info" scope="col">Monto total</th>
                <th class="text-info" scope="col">Proveedor</th>
                <th class="text-info" scope="col">Usuario</th>
                <th class="text-info" scope="col">Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($notascompras as $notacompra)
                <tr>
                    <td class="text-left">
                        @if ($ver)
                            <a type="button" title="Ver detalles de la nota de compra" class="btn btn-success btn-sm" href="{{url('notacompra/ver_reporte/'.$notacompra->id)}}">
                                <i class="tim-icons icon-tap-02"></i>
                            </a>
                        @endif
                    </td>
                    <td>{{$notacompra->created_at}}</td>
                    <td>{{$notacompra->impuesto}}</td>
                    <td>{{$notacompra->monto_total}}</td>
                    <td>{{$notacompra->proveedor->nombre}}</td>
                    <td>{{$notacompra->user->personal->nombre}}</td>
                    <td>
                        @if ($notacompra->condicion == 1)
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
        {{$notascompras->links()}}
    </div>
</div>