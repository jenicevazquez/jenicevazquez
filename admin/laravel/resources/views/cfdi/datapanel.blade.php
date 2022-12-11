
<div class="row">
    <div class="col-sm-12">
        <div class="tb tb-bordered tb-hover">
            <div class="thead">
                <div class="tr">
                    <div class="th" style="width: 10px"></div>
                    <div class="th" style="width: 125px">Folio</div>
                    <div class="th">RFC Receptor</div>
                    <div class="th">Nombre Receptor</div>
                    <div class="th">Fecha Emision</div>
                    <div class="th">Total</div>
                    <div class="th">Efecto Comprobante</div>
                    <div class="th">Estatus</div>
                    <div class="th" style="width: 120px">Acciones</div>
                </div>
            </div>
            <div class="tbody">
                @php($inicio = $facturas->firstItem())
                @foreach($facturas as $i=>$registro)
                    <div class="tr" data-id="{!! $registro->id !!}" data-datos='{!! json_encode($registro) !!}'>
                        <div class="th">{!! $inicio+$i !!}</div>
                        <div class="td">
                            <a style="margin-top: 5px" class="" href="javascript:void(0)"
                               onclick="verPDF('/cfdis/proforma/{!! $registro->id !!}',false,'{!! $registro->uuid !!}')">
                                {!! $registro->Serie!=""? $registro->Serie:"" !!}{!! $registro->Folio !!}</a>

                        </div>
                        <div class="td">{!! $registro->receptorRow->Rfc or '<i>No definido</i>' !!}</div>
                        <div class="td">{!! $registro->receptorRow->Nombre or '<i>No definido</i>' !!}</div>
                        <div class="td text-center" style="line-height: 1rem">{!! $registro->Fecha !!}</div>
                        <div class="td text-right">{!! number_format($registro->Total,2) !!}</div>
                        <div class="td text-center">{!! $registro->tipo_comprobante !!}</div>

                        <div class="td text-center">
                            {!! $registro->estado !!}<br>
                            @if(isset($registro->cfdiMetadata))
                                @if($registro->cfdiMetadata->Estatus==null)
                                    <span class="label"></span>
                                @elseif($registro->cfdiMetadata->Estatus==1)
                                    <span onclick="estatusCFDI(this)" data-id="{!! $registro->id !!}" class="label text-success">VIGENTE</span>
                                @elseif($registro->cfdiMetadata->Estatus==0)
                                    <span onclick="estatusCFDI(this)" data-id="{!! $registro->id !!}" class="label text-danger">CANCELADO</span>
                                    @if($registro->cfdiMetadata->FechaCancelacion!="1900-01-01 00:00:00.000")
                                        <div  style="line-height: 1rem"><small>{!! $registro->cfdiMetadata->FechaCancelacion !!}</small></div>
                                    @endif
                                @endif
                            @endif
                        </div>
                        <div class="td">
                            <a class="btn btn-secondary btn-sm btn-action" data-toggle="dropdown" title="Acciones"><i class="fas fa-caret-down"></i></a>
                            <div class="dropdown-menu" style="">
                                <a class="dropdown-item" href="#">Enviar factura por email</a>
                                <a class="dropdown-item" href="#">Descargar archivos</a>
                                @if(isset($registro->cfdiMetadata))
                                    <a class="dropdown-item" href="#">Cancelar factura</a>
                                @else
                                    <a class="dropdown-item" href="#">Timbrar factura</a>
                                @endif
                            </div>
                            @if(isset($registro->cfdiMetadata))
                                <a class="btn btn-primary btn-sm btn-action" onclick="sendCfdi(this)" title="Enviar"><i class="fas fa-envelope"></i></a>
                                <a data-uuid="{!! $registro->uuid !!}" class="btn btn-warning btn-sm btn-action" onclick="descargarCfdi(this)" title="Descargar"><i class="fas fa-download"></i></a>
                            @else
                                <a class="btn btn-warning btn-sm btn-action" onclick="openCfdi(this)" title="Editar"><i class="fas fa-edit"></i></a>
                                <a class="btn btn-danger btn-sm btn-action" onclick="borrarCfdi(this)" title="Borrar"><i class="fas fa-times"></i></a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>