<div class="table-responsive" style="overflow: auto">
    <table class="table tablesorter">
        <thead class="text-primary">
            <tr>
                <th class="text-info" scope="col">Opciones</th>
                <th class="text-info" scope="col">Nombre</th>
                <th class="text-info" scope="col">Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($permisos as $permiso)
                <tr>
                    <td class="text-left">
                        @if ($editar)
                            <a type="button" title="Editar información del Permiso" class="btn btn-primary btn-sm" href="{{url('permiso/edit/'.$permiso->id)}}">
                                <i class="tim-icons icon-pencil"></i>
                            </a>
                        @endif
                    </td>
                    <td>{{$permiso->nombre}}</td>
                    <td>
                        @if ($permiso->condicion == 1)
                            <span class="badge badge-success">Activo</span>
                        @else
                            <span class="badge badge-danger">Inactivo</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div>
        {{$permisos->links()}}
    </div>
</div>