<div class="table-responsive">
    <table class="table tablesorter">
        <thead class=" text-primary">
            <tr>
                <th class="text-info" scope="col">Opciones</th>
                <th class="text-info" scope="col">Nombre</th>
                <th class="text-info" scope="col">Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($roles as $rol)
                <tr>
                    <td class="text-left">
                        @if ($cambiarEstado)
                            @if ($rol->condicion == 1)
                                <button type="button" class="btn btn-danger btn-sm" onclick="desactivar({{$rol->id}})">
                                    <i class="tim-icons icon-trash-simple"></i>
                                </button>
                            @else
                                <button type="button" class="btn btn-success btn-sm" onclick="activar({{$rol->id}})">
                                    <i class="tim-icons icon-check-2"></i>
                                </button>
                            @endif
                        @endif
                        @if ($editar)
                            <a type="button" title="Editar información del Rol" class="btn btn-primary btn-sm" href="{{url('rol/edit/'.$rol->id)}}">
                                <i class="tim-icons icon-pencil"></i>
                            </a>
                        @endif
                        @if ($verPermiso)
                        <a type="button" title="Ver Permisos del Rol" class="btn btn-success btn-sm" href="{{url('rol/ver/'.$rol->id)}}">
                            <i class="tim-icons icon-tap-02"></i>
                        </a>
                        @endif
                    </td>
                    <td>{{$rol->nombre}}</td>
                    <td>
                        @if ($rol->condicion == 1)
                            <span class="badge badge-success">Activo</span>
                        @else
                            <span class="badge badge-danger">Inactivo</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>