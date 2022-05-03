<div class="table-responsive" style="overflow: auto">
    <table class="table tablesorter">
        <thead class="text-primary">
            <tr>
                <th class="text-info" scope="col">Usuario</th>
                <th class="text-info" scope="col">Tabla</th>
                <th class="text-info" scope="col">Acción</th>
                <th class="text-info" scope="col">Nombre implicado</th>
                <th class="text-info" scope="col">Fecha y Hora</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($bitacoras as $bitacora)
                <tr>
                    <td>{{$bitacora->user->personal->nombre}}</td>
                    <td>{{$bitacora->tabla}}</td>
                    <td>{{$bitacora->accion}}</td>
                    <td>{{$bitacora->nombre_implicado}}</td>
                    <td>{{$bitacora->created_at}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div>
        {{$bitacoras->links()}}
    </div>
</div>