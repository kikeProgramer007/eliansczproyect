@extends('principal')
@section('contenido')
    <div class="content">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row" style="padding-left: 15px; padding-right: 15px;">
                                <a href="{{url('materiales/')}}">
                                    <button type="button" class="btn btn-secondary btn-sm btn-outline-dark btn-pill">
                                        <i class="fas fa-arrow-left"></i>Atras
                                    </button>
                                </a>
                                &nbsp;&nbsp;&nbsp;
                                <div style="display:table; text-align: center;">
                                    <h4 class="text-primary" style="display:table-cell; vertical-align:middle;">Editando Material</h4>
                                </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{url('material/update')}}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{$material->id}}">
                            <div class="form-group row">
                                <div class="col-sm-12 col-md-12">
                                    <label class="text-info">Nombre: </label>
                                    <input name="nombre" class="form-control" maxlength="50" type="text" value="{{$material->nombre}}" placeholder="Nombre..." required>
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
@endsection
