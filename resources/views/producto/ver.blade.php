@extends('principal')
@section('contenido')
    <div class="content">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row" style="padding-left: 15px; padding-right: 15px;">
                                <a href="{{url('producto/ver/'.$tallaproducto->idproducto)}}">
                                    <button type="button" class="btn btn-secondary btn-sm btn-outline-dark btn-pill">
                                        <i class="fas fa-arrow-left"></i>Atras
                                    </button>
                                </a>
                                &nbsp;&nbsp;&nbsp;
                                <div style="display:table; text-align: center;">
                                    <h4 class="text-primary" style="display:table-cell; vertical-align:middle;">Agregando Stock</h4>
                                </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{url('tallaproducto/updatestock')}}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{$tallaproducto->id}}">
                            <div class="form-group row">
                                <div class="col-sm-12 col-md-12">
                                    <label class="text-info">Stock: </label>
                                    <input name="stock" class="form-control" type="smallinteger" value="{{$tallaproducto->stock}}" placeholder="Stock..." required>
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