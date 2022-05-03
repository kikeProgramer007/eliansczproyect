@extends('principal')
@section('contenido')
    <div class="content">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row" style="padding-left: 15px; padding-right: 15px;">
                            @if ($user->idrol == 1)
                                <a href="{{url('dashboard/')}}">
                            @else
                                <a href="{{url('dashboard2/')}}">
                            @endif
                                <button type="button" class="btn btn-secondary btn-sm btn-outline-dark btn-pill">
                                    <i class="fas fa-arrow-left"></i>Atras
                                </button>
                            </a>
                            &nbsp;&nbsp;&nbsp;
                            <div style="display:table; text-align: center;">
                                <h4 class="text-primary" style="display:table-cell; vertical-align:middle;" >Editar Perfil</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{url('user/updateperfil')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{$user->id}}">
                            <div class="form-group row">
                                <div class="col-sm-4 col-md-4 ">
                                    <div class="col-md-12 col-sm-12" align="center">
                                        @if ($user->imagen)
                                            <img src="{{asset('storage/'.$user->imagen)}}" style="border-radius: 20px; height: 185px; width: 250px" id="imagenmuestra">
                                        @else
                                            No hay imagen
                                        @endif
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-12 col-sm-12">
                                            <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
                                            <label class="text-info">Foto: </label>
                                            <input name="imagen" id="imagen" class="form-control" style="position: inherit !important; height: 43% !important" type="file" accept="image/png, image/jpg, image/jpeg">
                                            <input type="hidden" class="form-control" name="imagenactual" id="imagenactual">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-8 col-md-8">
                                    <div class="form-group row">
                                        <div class="col-sm-4 col-md-4">
                                            <label class="text-info">CI: </label>
                                            <input name="ci" class="form-control" maxlength="10" type="text" value="{{$user->ci}}" placeholder="CI..." required>
                                        </div>
                                        <div class="col-sm-4 col-md-4">
                                            <label class="text-info">Nombre: </label>
                                            <input name="nombre" class="form-control" maxlength="50" type="text" value="{{$user->nombre}}" placeholder="Nombre..." required>
                                        </div>
                                        <div class="col-sm-4 col-md-4">
                                            <label class="text-info">Sexo: </label>
                                            <select class="form-control" name="sexo">
                                                @if ($user->sexo == 'M')
                                                    <option selected class="text-dark" value="M">Masculino</option>
                                                    <option class="text-dark" value="F">Femenino</option>
                                                @else
                                                    <option selected class="text-dark" value="F">Femenino</option>
                                                    <option class="text-dark" value="M">Masculino</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-4 col-md-4">
                                            <label class="text-info">Teléfono: </label>
                                            <input name="telefono" class="form-control" maxlength="10" type="text" value="{{$user->telefono}}"  placeholder="Teléfono..." required>
                                        </div>
                                        <div class="col-sm-4 col-md-4">
                                            <label class="text-info">Dirección: </label>
                                            <input name="direccion" class="form-control" maxlength="60" type="text" value="{{$user->direccion}}" placeholder="Dirección...">
                                        </div>
                                        <div class="col-sm-4 col-md-4">
                                            <label class="text-info">Rol: </label>
                                            <select class="form-control" name="idrol">
                                                @foreach ($roles as $rol)
                                                    @if ($user->idrol == $rol->id)
                                                        <option class="text-dark" selected value="{{$rol->id}}">{{$rol->nombre}}</option>
                                                    @else
                                                        <option class="text-dark" value="{{$rol->id}}">{{$rol->nombre}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-8 col-md-8">
                                            <label class="text-info">Email: </label>
                                            <input name="email" class="form-control" type="email" value="{{$user->email}}" placeholder="Email..." required>
                                        </div>
                                        <div class="col-md-4 col-sm-4">
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12 col-md-12">
                                    <button type="submit" class="btn btn-primary">Editar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script>
    function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
        // Asignamos el atributo src a la tag de imagen
        $('#imagenmuestra').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
    }

    // El listener va asignado al input
    $("#imagen").change(function() {
    readURL(this);
    });
</script>
@endsection