<div class="sidebar">
    <nav class="sidebar-wrapper">
        <ul class="nav">
            <li class="logo">
                <img class="rounded mx-auto d-block" class="avatar" src="{{asset('img/Imagen.jpeg')}}" width="150" height="70"></img>
                <div>&nbsp;</div>
            </li>
            @if ($listarEscritorio1)
            <li>
                <a href="{{url('dashboard')}}">
                    <i class="tim-icons icon-chart-pie-36"></i>
                    <p>Escritorio</p>
                </a>
            </li>
            @endif
            @if ($listarEscritorio2)
            <li>
                <a href="{{url('dashboard2')}}">
                    <i class="tim-icons icon-chart-pie-36"></i>
                    <p>Escritorio</p>
                </a>
            </li>
            @endif
            @if ($listarUsuario || $listarRol || $listarPermiso || $listarBitacora)
            <li>
                <a data-toggle="collapse" data-target="#bajar" aria-expanded="false" aria-controls="bajar">
                    <i class="tim-icons icon-double-right"></i>
                    <span class="nav-link-text" >Administración</span>
                    <b class="caret mt-1"></b>
                </a>
                <div class="collapse" id="bajar">
                    <ul class="nav pl-4">
                        @if ($listarUsuario)
                        <li >
                            <a href="{{url('users')}}">
                                <i class="tim-icons icon-badge"></i>
                                <p>Usuario</p>
                            </a>
                        </li>
                        @endif
                        @if ($listarRol)
                        <li>
                            <a href="{{url('roles')}}">
                                <i class="tim-icons icon-bullet-list-67"></i>
                                <p>Rol</p>
                            </a>
                        </li>
                        @endif
                        @if ($listarPermiso)
                        <li >
                            <a href="{{url('permisos')}}">
                                <i class="tim-icons icon-settings-gear-63"></i>
                                <p>Permiso</p>
                            </a>
                        </li>
                        @endif
                        @if ($listarBitacora)
                        <li >
                            <a href="{{url('bitacoras')}}">
                                <i class="tim-icons icon-link-72"></i>
                                <p>Bitácora</p>
                            </a>
                        </li>
                        @endif
                    </ul>
                </div>
            </li>
            @endif
            @if ($listarProducto || $listarCategoria || $listarMarca|| $listarMaterial || $listarTalla)
            <li>
                <a data-toggle="collapse" data-target="#desplegar1" aria-expanded="false" aria-controls="desplegar1">
                    <i class="tim-icons icon-components"></i>
                    <span class="nav-link-text">Inventario</span>
                    <b class="caret mt-1"></b>
                </a>
                <div class="collapse" id="desplegar1">
                    <ul class="nav pl-4">
                        @if ($listarCategoria)
                        <li >
                            <a href="{{url('categorias')}}">
                                <i class="tim-icons icon-notes"></i>
                                <p>Categoría</p>
                            </a>
                        </li>
                        @endif
                        @if ($listarMarca)
                        <li>
                            <a href="{{url('marcas')}}">
                                <i class="tim-icons icon-bold"></i>
                                <p>Marca</p>
                            </a>
                        </li>
                        @endif
                        @if ($listarMaterial)
                        <li>
                            <a href="{{url('materiales')}}">
                                <i class="tim-icons icon-puzzle-10"></i>
                                <p>Material</p>
                            </a>
                        </li>
                        @endif
                        @if ($listarTalla)
                        <li>
                            <a href="{{url('tallas')}}">
                                <i class="tim-icons icon-caps-small"></i>
                                <p>Talla</p>
                            </a>
                        </li>
                        @endif
                        @if ($listarProducto)
                        <li >
                            <a href="{{url('productos')}}">
                                <i class="tim-icons icon-basket-simple"></i>
                                <p>Producto</p>
                            </a>
                        </li>
                        @endif
                    </ul>
                </div>
            </li>
            @endif
            @if ($listarProveedor || $listarNotaCompra || $listarReporteCompra)
            <li>
                <a data-toggle="collapse" data-target="#desplegar2" aria-expanded="false" aria-controls="desplegar2">
                    <i class="tim-icons icon-delivery-fast"></i>
                    <span class="nav-link-text">Compra</span>
                    <b class="caret mt-1"></b>
                </a>
                <div class="collapse" id="desplegar2">
                    <ul class="nav pl-4">
                        @if ($listarProveedor)
                        <li >
                            <a href="{{url('proveedores')}}">
                                <i class="tim-icons icon-single-02"></i>
                                <p>Proveedor</p>
                            </a>
                        </li>
                        @endif
                        @if ($listarNotaCompra)
                        <li>
                            <a href="{{url('notascompras')}}">
                                <i class="tim-icons icon-book-bookmark"></i>
                                <p>Nota de Compra</p>
                            </a>
                        </li>
                        @endif
                        @if ($listarReporteCompra)
                        <li>
                            <a href="{{url('reportescompras')}}">
                                <i class="tim-icons icon-pin"></i>
                                <p>Reporte de compras</p>
                            </a>
                        </li>
                        @endif
                    </ul>
                </div>
            </li>
            @endif
            @if ($listarCliente || $listarNotaVenta || $listarReporteVenta)
            <li>
                <a data-toggle="collapse" data-target="#desplegar5" aria-expanded="false" aria-controls="desplegar5">
                    <i class="tim-icons icon-bag-16"></i>
                    <span class="nav-link-text">Venta</span>
                    <b class="caret mt-1"></b>
                </a>
                <div class="collapse" id="desplegar5">
                    <ul class="nav pl-4">
                        @if ($listarCliente)
                        <li >
                            <a href="{{url('clientes')}}">
                                <i class="tim-icons icon-single-02"></i>
                                <p>Cliente</p>
                            </a>
                        </li>
                        @endif
                        @if ($listarNotaVenta)
                        <li>
                            <a href="{{url('notasventas')}}">
                                <i class="tim-icons icon-paper"></i>
                                <p>Nota de Venta</p>
                            </a>
                        </li>
                        @endif
                        @if ($listarReporteVenta)
                        <li>
                            <a href="{{url('reportesventas')}}">
                                <i class="tim-icons icon-single-copy-04"></i>
                                <p>Reporte de ventas</p>
                            </a>
                        </li>
                        @endif
                    </ul>
                </div>
            </li>
            @endif
            @if ($listarNotaSalida || $listarReporteSalida)
            <li>
                <a data-toggle="collapse" data-target="#desplegar3" aria-expanded="false" aria-controls="desplegar3">
                    <i class="tim-icons icon-cart"></i>
                    <span class="nav-link-text">Salida</span>
                    <b class="caret mt-1"></b>
                </a>
                <div class="collapse" id="desplegar3">
                    <ul class="nav pl-4">
                        @if ($listarNotaSalida)
                        <li>
                            <a href="{{url('notassalidas')}}">
                                <i class="tim-icons icon-paper"></i>
                                <p>Nota de Salida</p>
                            </a>
                        </li>
                        @endif
                        @if ($listarReporteSalida)
                        <li>
                            <a href="{{url('reportessalidas')}}">
                                <i class="tim-icons icon-alert-circle-exc"></i>
                                <p>Reporte de salidas</p>
                            </a>
                        </li>
                        @endif
                    </ul>
                </div>
            </li>
            @endif
            <li>&nbsp;</li>
            <li>&nbsp;</li>
            <li>&nbsp;</li>
            <li>&nbsp;</li>
        </ul>
    </nav>
</div>