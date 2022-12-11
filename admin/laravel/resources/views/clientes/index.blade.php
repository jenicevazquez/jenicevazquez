
@extends('layouts.app')
@section('main-title','<i class="far fa-folder"></i> Clientes')
@section('acciones')
    <a onclick="openCliente(this)" title="Nuevo cliente" class="btn btn-primary"><i class="fas fa-plus"></i></a>
    <a title="Importar" onclick='traerClientes(this)' class="btn btn-success"><i class="fas fa-file-import"></i></a>
    <a title="Refrescar" onclick='$("#card-clientes").refresh();' class="btn btn-default"><i class="fas fa-sync-alt"></i></a>
@endsection
@section('main-content')
    <section class="content">
        <div class="card">
          <div class="card-body" id="card-clientes" data-widget="section-refresh" data-source="/clientes/datapanel">
          </div>
        </div>
    </section>
    <div class="modal" tabindex="-1" role="dialog" id="fieldsCliente">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title"><i class="fas fa-file-alt"></i> Cliente</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              @include("clientes.create")
          </div>
            <div class="modal-footer">
                <div class="float-left text-muted text-vertical-align-button">
                    * Campos obligatorios
                </div>
                <div class="float-right">
                    <button class="btn btn-info guardaComprobante" type="submit" onclick="guardaDatosReceptor(this)">Guardar</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>

                </div>
            </div>
        </div>
      </div>
    </div>

@endsection
@section('js-scripts')
    @parent
    <script>
        $(document).ready(function(){
            $("#card-clientes").refresh();
        })
        function openCliente(obj){

            var datos = $(obj).parents(".tr").data("datos");
            console.log(datos);
            $("#fieldsCliente input").val("");
            $("#fieldsCliente select").val(null);
            if(datos!=undefined){
                $.each(datos,function(key,value){
                    $("#Receptor_"+key).val(value);
                });
            }
            $("#fieldsCliente").modal("show");

        }
        function traerClientes(obj){
            $(obj).startDisable();
            $.post("/clientes/traerClientes", {
                _token: $('meta[name=csrf-token]').attr('content'),
            })
            .done(function (data) {
                $(obj).stopDisable();
                $("#card-clientes").refresh();
            })
            .fail(function(xhr)
            {
                $(obj).stopDisable();
                console.log(xhr.responseText);
            });
        }
        function guardaDatosReceptor(obj){
            $(obj).startDisable("Guardando...");
            $.post("/clientes/guardaDatosReceptor", {
                _token: $('meta[name=csrf-token]').attr('content'),
                Rfc: $("#Receptor_Rfc").val(),
                Nombre: $("#Receptor_Nombre").val(),
                RegimenFiscal: $("#Receptor_RegimenFiscal").val(),
                DomicilioFiscal: $("#Receptor_DomicilioFiscal").val(),
                NumRegIdTrib: $("#Receptor_NumRegIdTrib").val(),
                ResidenciaFiscal: $("#Receptor_ResidenciaFiscal").val(),
                id: $("#Receptor_id").val(),
                calle: $("#Receptor_calle").val(),
                ext: $("#Receptor_ext").val(),
                colonia: $("#Receptor_colonia").val(),
                cp: $("#Receptor_cp").val(),
                ciudad: $("#Receptor_ciudad").val(),
                estado: $("#Receptor_estado").val(),
                pais: $("#Receptor_pais").val()
            })
                .done(function (data) {
                    $(obj).stopDisable();
                    $("#card-clientes").refresh();
                    $("#fieldsCliente").modal("show");
                })
                .fail(function(xhr)
                {
                    $(obj).stopDisable();
                    $("#resultadoCliente").html('<div class="alert alert-error alert-dismissible">'+xhr.responseText+'</div>');
                });
        }
        function borrarCliente(obj){
           var id = $(obj).parents(".tr").data("id");
            Swal.fire({
                title: 'Desea borrar el cliente?',
                text: "No podrá deshacer esta acción",
                type: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.value) {
                    $.post("/clientes/borrarCliente", {
                        _token: $('meta[name=csrf-token]').attr('content'),
                        id: id
                    })
                        .done(function (data) {
                            $("#card-clientes").refresh();
                        })
                        .fail(function (xhr) {
                            Swal.fire(
                                'Algo salio mal, intente de nuevo',
                                xhr.responseText,
                                'error'
                            );
                        });
                }
            });
        }
    </script>
@endsection
