
    <div class="row">
        <div class="col-sm-12">
            <div class="tb tb-bordered tb-hover">
                <div class="thead">
                    <div class="tr">
                        <div class="th"></div>
                        <div class="th col-sm-1">Num. Iden.</div>
                        <div class="th col-sm-1">Clave de prod o serv</div>
                        <div class="th col-sm-6">Descripcion</div>
                        <div class="th col-sm-1">Unidad</div>
                        <div class="th col-sm-1">Clave unidad</div>
                        <div class="th col-sm-2">Precio Unitario</div>
                        <div class="th col-sm-1">Acciones</div>
                    </div>
                </div>
                <div class="tbody">
                    @php($inicio = $registros->firstItem())
                    @foreach($registros as $i=>$registro)
                    <div class="tr" data-id="{!! $registro->id !!}" data-datos='{!! json_encode($registro) !!}'>
                        <div class="th">{!! $inicio+$i !!}</div>
                        <div class="td col-sm-1">{!! $registro->CodigoMercanciaProducto !!}</div>
                        <div class="td col-sm-1">{!! GenericClass::select2Val($registro->ClaveProducto) !!}</div>
                        <div class="td col-sm-6">{!! $registro->DescripcionMercancia !!}</div>
                        <div class="td col-sm-1">{!! $registro->Unidad !!}</div>
                        <div class="td col-sm-1">{!! GenericClass::select2Val($registro->ClaveUnidad) !!}</div>
                        <div class="td col-md-2 text-right" style="padding-right: 2%">{!! number_format($registro->PrecioUnitario,2) !!}</div>
                        <div class="td col-md-1 text-center">
                            <a onclick="borrarProducto(this)" class="link" title="Borrar"><i class="fas fa-times"></i></a>
                            <a onclick="openProducto(this)" class="link" title="Editar"><i class="fas fa-edit"></i></a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>



