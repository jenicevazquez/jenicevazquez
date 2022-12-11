<div class="tb tb-bordered">
    <div class="thead">
        <div class="tr">
            <div class="th col-sm-3">Serie</div>
            <div class="th col-sm-3">Folio</div>
            <div class="th col-sm-4">Tipo Comprobante</div>
            <div class="th col-sm-2">Acciones</div>
        </div>
    </div>
    <div class="tbody">
        @foreach(\App\GenericClass::getSeries() as $serie)
            <div class="tr" data-id="{!! $serie->id !!}" data-datos='{!! json_encode($serie) !!}'>
                <div class="td col-sm-3">{!! $serie->serie !!}</div>
                <div class="td col-sm-3">{!! $serie->folio !!}</div>
                <div class="td col-sm-4">{!! $serie->tipoComprobante !!} - {!! $serie->tipo_comprobante_str or '<i>Sin definir</i>' !!}</div>
                <div class="td col-sm-2 text-center">
                    <a onclick="borrarSerie(this)" class="link" title="Borrar"><i class="fas fa-times"></i></a>
                    <a onclick="editarSerie(this)" class="link" title="Editar"><i class="fas fa-edit"></i></a>
                </div>
            </div>
        @endforeach
    </div>
</div>