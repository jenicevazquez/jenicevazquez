
    <div class="row">
        <div class="col-sm-12">
            <div class="tb tb-bordered tb-hover">
                <div class="thead">
                    <div class="tr">
                        <div class="th col-sm-1"></div>
                        <div class="th col-sm-1">RFC</div>
                        <div class="th col-sm-5">Razon social</div>
                        <div class="th col-sm-1">Domicilio Fiscal</div>
                        <div class="th col-sm-3">Regimen Fiscal</div>
                        <div class="th col-sm-1">Acciones</div>
                    </div>
                </div>
                <div class="tbody">
                    @php($inicio = $clientes->firstItem())
                    @foreach($clientes as $i=>$cliente)
                    <div class="tr" data-id="{!! $cliente->id !!}" data-datos='{!! json_encode($cliente) !!}'>
                        <div class="th col-sm-1">{!! $inicio+$i !!}</div>
                        <div class="td col-sm-1">{!! $cliente->Rfc !!}</div>
                        <div class="td col-sm-6">{!! $cliente->Nombre !!}</div>
                        <div class="td col-sm-1">{!! $cliente->DomicilioFiscal !!}</div>
                        <div class="td col-md-3">{!! $cliente->RegimenFiscal !!}</div>
                        <div class="td col-md-1 text-center">
                            <a onclick="borrarCliente(this)" class="link" title="Borrar"><i class="fas fa-times"></i></a>
                            <a onclick="openCliente(this)" class="link" title="Editar"><i class="fas fa-edit"></i></a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>