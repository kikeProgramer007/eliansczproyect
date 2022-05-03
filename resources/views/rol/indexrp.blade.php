@extends('principal')
@section('contenido')
    <div class="content">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row" style="padding-left: 15px; padding-right: 15px;">
                            <div class="col-8 col-sm-8 col-md-8 col-lg-8 col-xl-8">
                                <div class="row">
                                    <a href="{{url('roles/')}}">
                                        <button type="button" class="btn btn-secondary btn-sm btn-outline-dark btn-pill">
                                            <i class="fas fa-arrow-left"></i>Atras
                                        </button>
                                    </a>
                                    &nbsp;
                                    <div style="align-items: center; display: flex;">
                                        <h4 style="margin: 0" class="text-primary">{{$rol->nombre}}</h4>
                                    </div>
                                    
                                </div>
                            </div>
                            
                            <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4 text-right" style="padding-right: 0">
                                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#exampleModalLong">
                                    Agregar
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card-body">
                            <div id="tabla">
                                @include('rol.datosrp')
                            </div>
                        </div>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="exampleModalLongTitle" aria-hidden="true" >
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Agregando permiso al rol {{$rol->nombre}}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="{{url('rol_permiso/update')}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="idrol" value="{{$rol->id}}">
                                    <div class="modal-body" style="height: 40vh; overflow-y: auto;">
                                        <div class="row">
                                            <div class="col-md-12">
                                                @foreach ($permisos as $permiso)
                                                    @php
                                                        $bandera = false;
                                                    @endphp
                                                    @foreach ($roles_permisos as $rol_permiso)
                                                        @if ($rol_permiso->idpermiso == $permiso->id)
                                                            <div style="padding-left: 25px">
                                                                <input type="checkbox" name="permisos[]" value="{{$permiso->id}}" checked>
                                                                <label class="form-check-label text-dark">{{$permiso->nombre}}</label>
                                                            </div>
                                                            @php
                                                                $bandera = true;
                                                            @endphp
                                                            @break
                                                        @endif
                                                    @endforeach
                                                    @if (!$bandera)
                                                        <div style="padding-left: 25px">
                                                            <input type="checkbox" name="permisos[]" value="{{$permiso->id}}">
                                                            <label class="form-check-label text-dark">{{$permiso->nombre}}</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Guardar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        jQuery(document).ready(function () {
            
        });
    </script>
@endpush