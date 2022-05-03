<div class="table-responsive" style="overflow: auto">
    <table class="table tablesorter">
        <thead class="text-primary" class="blockquote blockquote-primary">
            <tr >
                <th class="text-info" scope="col">Opciones</th>
                <th class="text-info" scope="col">Fecha y Hora</th>
                <th class="text-info" scope="col">Pérdida Total</th>
                <th class="text-info" scope="col">Descripción</th>
                <th class="text-info" scope="col">Usuario</th>
                <th class="text-info" scope="col">Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($notassalidas as $notasalida)
                <tr>
                    <td class="text-left">
                        @if ($ver)
                            <a type="button" title="Ver detalles de la nota de salida" class="btn btn-success btn-sm" href="{{url('notasalida/ver_reporte/'.$notasalida->id)}}">
                                <i class="tim-icons icon-tap-02"></i>
                            </a>
                        @endif
                    </td>
                    <td>{{$notasalida->created_at}}</td>
                    <td>{{$notasalida->perdida_total}}</td>
                    <td>{{$notasalida->descripcion}}</td>
                    <td>{{$notasalida->user->personal->nombre}}</td>
                    <td>
                        @if ($notasalida->condicion == 1)
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
        {{$notassalidas->links()}}
    </div>
</div>