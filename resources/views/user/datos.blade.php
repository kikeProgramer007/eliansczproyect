<div class="table-responsive" style="overflow: auto">
    <table class="table tablesorter">
        <thead class="text-primary" class="blockquote blockquote-primary">
            <tr >
                <th class="text-info" scope="col">Opciones</th>
                <th class="text-info" scope="col">Email</th>
                <th class="text-info" scope="col">CI</th>
                <th class="text-info" scope="col">Nombre</th>
                <th class="text-info" scope="col">Sexo</th>
                <th class="text-info" scope="col">Teléfono</th>
                <th class="text-info" scope="col">Dirección</th>
                <th class="text-info" scope="col">Rol</th>
                <th class="text-info" scope="col">Imagen</th>
                <th class="text-info" scope="col">Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td class="text-left">
                        @if ($cambiarEstado)
                            @if ($user->condicion == 1)
                                <button type="button" title="Deshabilitar Usuario" class="btn btn-danger btn-sm" onclick="desactivar({{$user->id}})">
                                    <i class="tim-icons icon-trash-simple"></i>
                                </button>
                            @else
                                <button type="button" title="Habilitar Usuario" class="btn btn-info btn-sm" onclick="activar({{$user->id}})">
                                    <i class="tim-icons icon-check-2"></i>
                                </button>
                            @endif
                        @endif
                        @if ($editar)
                            <a type="button" title="Editar información del Usuario" class="btn btn-primary btn-sm" href="{{url('user/edit/'.$user->id)}}">
                                <i class="tim-icons icon-pencil"></i>
                            </a>
                        @endif
                    </td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->ci}}</td>
                    <td>{{$user->nombre}}</td>
                    <td>{{$user->sexo}}</td>
                    <td>{{$user->telefono}}</td>
                    <td>{{$user->direccion}}</td>
                    <td>{{$user->rol_nombre}}</td>
                    <td>
                        @if ($user->imagen)
                            <img src="{{asset('storage/'.$user->imagen)}}" style="border-radius: 40px; height: 80px; width: 80px">
                        @else
                            No hay imagen
                        @endif
                    </td>
                    <td>
                        @if ($user->condicion == 1)
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
        {{$users->links()}}
    </div>
</div>