@extends('principal')
@section('contenido')
    <div class="content">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row" style="padding-left: 15px; padding-right: 15px;">
                                <a href="{{url('proveedores/')}}">
                                    <button type="button" class="btn btn-secondary btn-sm btn-outline-dark btn-pill">
                                        <i class="fas fa-arrow-left"></i>Atras
                                    </button>
                                </a>
                                &nbsp;&nbsp;&nbsp;
                                <div style="display:table; text-align: center;">
                                    <h4 class="text-primary" style="display:table-cell; vertical-align:middle;">Agregando Proveedor</h4>
                                </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{url('proveedor/create')}}" method="POST">
                            @csrf
                            <div class="form-group row">
                                <div class="col-md-6 col-sm-6">
                                    <label class="text-info">Nombre: </label>
                                    <input name="nombre" class="form-control" maxlength="50" type="text" placeholder="Nombre..." required>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <label class="text-info">Teléfono: </label>
                                    <input name="telefono" class="form-control" maxlength="15" type="text" placeholder="Teléfono..." required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6 col-sm-6">
                                    <label class="text-info">Email: </label>
                                    <input name="correo" class="form-control" type="email" placeholder="Email..." required>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <label class="text-info">Dirección: </label>
                                    <input name="direccion" class="form-control" maxlength="60" type="text" placeholder="Dirección...">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12 col-sm-12">
                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
