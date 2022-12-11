
@extends('layouts.app')
@section('main-title','<i class="fas fa-file-invoice"></i> Facturas')
@section('acciones')
    <a title="Generar factura" href="/cfdis/create" class="btn btn-primary"><i class="fas fa-plus"></i></a>
    <a title="Refrescar" onclick='$("#card-facturas").refresh();' class="btn btn-default"><i class="fas fa-sync-alt"></i></a>
@endsection
@section('main-content')
    <section class="content">
        <div class="card">
            <div class="card-body" id="card-facturas" data-widget="section-refresh" data-source="/cfdis/datapanel">
            </div>
        </div>
    </section>
@endsection
@section('js-scripts')
    @parent
    <script>
        $(document).ready(function(){
            //$("#card-facturas").refresh();
        })
        function descargarCfdi(obj){
            $(obj).startDisable("");
            var uuid = $(obj).data("uuid");
            $.post("/cfdis/descargarCfdi", {
                _token: $('meta[name=csrf-token]').attr('content'),
                uuid: uuid
            })
                .done(function (data) {
                    $(obj).stopDisable();
                    if(data[0]=="success") {
                        window.location.assign('/cfdis/zip/' + data[1] + '/' + uuid + '.zip');
                    }
                    else{
                        swal.fire({
                            title:"Error",
                            html:data[1],
                            type: 'error'
                        });
                    }
                })
                .fail(function(xhr)
                {
                    console.log(xhr.responseText);
                    $(obj).stopDisable();
                });
        }
        </script>
@endsection
