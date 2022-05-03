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
                                    <h4 class="text-primary" style="display:table-cell; vertical-align:middle;">Agregando Producto</h4>
                                </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{url('producto/create')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row">
                                <div class="col-md-4 col-sm-4">
                                    <label class="text-info">Nombre: </label>
                                    <input name="nombre" class="form-control" maxlength="40" type="text" placeholder="Nombre..." required>
                                </div>
                                <div class="col-md-4 col-sm-4">
                                    <label class="text-info">Precio: </label>
                                    <input name="precio" class="form-control" type="decimal" placeholder="Precio..." required>
                                </div>
                                <div class="col-md-4 col-sm-4">
                                    <label class="text-info">Costo: </label>
                                    <input name="costo" class="form-control" type="decimal" placeholder="Costo..." required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4 col-sm-4">
                                    <label class="text-info">Oferta: </label>
                                    <input name="oferta" class="form-control" min="0" type="decimal" value="0" placeholder="Oferta..." required>
                                </div>
                                <div class="col-md-4 col-sm-4">
                                    <label class="text-info">Categoria: </label>
                                    <select class="form-control" name="idcategoria">
                                        @foreach ($categorias as $categoria)
                                            <option class="text-dark" value="{{$categoria->id}}">{{$categoria->nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 col-sm-4">
                                    <label class="text-info">Material: </label>
                                    <select class="form-control" name="idmaterial">
                                        @foreach ($materiales as $material)
                                            <option class="text-dark" value="{{$material->id}}">{{$material->nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4 col-sm-4">
                                    <label class="text-info">Marca: </label>
                                    <select class="form-control" name="idmarca">
                                        @foreach ($marcas as $marca)
                                            <option class="text-dark" value="{{$marca->id}}">{{$marca->nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 col-sm-4">
                                    <label class="text-info">Descripcion: </label>
                                    <input name="descripcion" class="form-control" maxlength="50" type="text" placeholder="Descripcion...">
                                </div>
                                <div class="col-md-4 col-sm-4">
                                    <label class="text-info">Imagen: </label>
                                    <input name="imagen" class="form-control" style="position: inherit !important; height: 43% !important" type="file" accept="image/png, image/jpg, image/jpeg">
                                </div>
                            </div>
                            
                            <div class="form-group row"  style="padding-right: 15px;">
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
