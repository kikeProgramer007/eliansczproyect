@extends('principal')
@section('contenido')
    <div class="content">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row" style="padding-left: 15px; padding-right: 15px;">
                                <a href="{{url('productos/')}}">
                                    <button type="button" class="btn btn-secondary btn-sm btn-outline-dark btn-pill">
                                        <i class="fas fa-arrow-left"></i>Atras
                                    </button>
                                </a>
                                &nbsp;&nbsp;&nbsp;
                                <div style="display:table; text-align: center;">
                                    <h4 class="text-primary" style="display:table-cell; vertical-align:middle;" >Editando Producto</h4>
                                </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{url('producto/update')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{$producto->id}}">
                            <div class="form-group row">
                                <div class="col-sm-4 col-md-4">
                                    <label class="text-info">Nombre: </label>
                                    <input name="nombre" class="form-control" maxlength="40" type="text" value="{{$producto->nombre}}" placeholder="Nombre..." required>
                                </div>
                                <div class="col-md-4 col-sm-4">
                                    <label class="text-info">Precio: </label>
                                    <input name="precio" class="form-control" type="decimal" value="{{$producto->precio}}" placeholder="Precio..." required>
                                </div>
                                <div class="col-md-4 col-sm-4">
                                    <label class="text-info">Costo: </label>
                                    <input name="costo" class="form-control" type="decimal" value="{{$producto->costo}}" placeholder="Costo..." required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4 col-sm-4">
                                    <label class="text-info">Oferta: </label>
                                    <input name="oferta" class="form-control" type="decimal" value="{{$producto->oferta}}" placeholder="Oferta...">
                                </div>
                                <div class="col-sm-4 col-md-4">
                                    <label class="text-info">Categoria: </label>
                                    <select class="form-control" name="idcategoria">
                                        @foreach ($categorias as $categoria)
                                            @if ($producto->idcategoria == $categoria->id)
                                                <option class="text-dark" selected value="{{$categoria->id}}">{{$categoria->nombre}}</option>
                                            @else
                                                <option class="text-dark" value="{{$categoria->id}}">{{$categoria->nombre}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-4 col-md-4">
                                    <label class="text-info">Material: </label>
                                    <select class="form-control" name="idmaterial">
                                        @foreach ($materiales as $material)
                                            @if ($producto->idmaterial == $material->id)
                                                <option class="text-dark" selected value="{{$material->id}}">{{$material->nombre}}</option>
                                            @else
                                                <option class="text-dark" value="{{$material->id}}">{{$material->nombre}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-4 col-md-4">
                                    <label class="text-info">Marca: </label>
                                    <select class="form-control" name="idmarca">
                                        @foreach ($marcas as $marca)
                                            @if ($producto->idmarca == $marca->id)
                                                <option class="text-dark" selected value="{{$marca->id}}">{{$marca->nombre}}</option>
                                            @else
                                                <option class="text-dark" value="{{$marca->id}}">{{$marca->nombre}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-4 col-md-4">
                                    <label class="text-info">Descripcion: </label>
                                    <input name="descripcion" class="form-control" maxlength="50" type="text" value="{{$producto->descripcion}}" placeholder="Descripcion...">
                                </div>
                                <div class="col-md-4 col-sm-4">
                                    <label class="text-info">Imagen: </label>
                                    <input name="imagen" class="form-control" style="position: inherit !important; height: 43% !important" type="file" accept="image/png, image/jpg, image/jpeg">
                                </div>
                                <div class="col-sm-4 col-md-4">
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
