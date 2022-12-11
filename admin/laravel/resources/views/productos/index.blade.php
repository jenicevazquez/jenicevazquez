
@extends('layouts.app')
@section('section-name','productos')
@section('main-title','<i class="far fa-folder"></i> Productos')
@section('acciones')
    <a onclick="openProducto(this)" title="Nuevo producto" class="btn btn-primary"><i class="fas fa-plus"></i></a>
    <a title="Importar" onclick='traerProductos(this)' class="btn btn-success"><i class="fas fa-file-import"></i></a>
    @if(GenericClass::empresa()->ce==1)
        <form id="uploadProductos" style="display: inline">
            <a title="Subir archivo M" id="btnuploadProductos" class="btn btn-warning">
                <i class="fas fa-file-upload" aria-hidden="true"></i> Archivo M
            </a>
            <input type="file" name="archivoProducto" id="archivoProducto" style="display: none">
        </form>
        <form id="uploadProductos2" style="display: inline">
            <a title="Subir aviso de traslado" id="btnuploadProductos2" class="btn btn-warning">
                <i class="fas fa-file-upload" aria-hidden="true"></i> Aviso de Traslado
            </a>
            <input type="file" name="archivoProducto2" id="archivoProducto2" style="display: none">
        </form>
    @endif
    <a title="Refrescar" onclick='$("#card-productos").refresh();' class="btn btn-default"><i class="fas fa-sync-alt"></i></a>
@endsection
@section('main-content')
    <section class="content">
        <div class="card">
          <div class="card-body" id="card-productos" data-widget="section-refresh" data-source="/productos/datapanel">
          </div>
        </div>
    </section>
    <div class="modal" tabindex="-1" role="dialog" id="fieldsProducto">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title"><i class="fas fa-file-alt"></i> Producto</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              @include("productos.create")
          </div>
            <div class="modal-footer">
                <div class="float-left text-muted text-vertical-align-button">

                </div>
                <div class="float-right">
                    <button class="btn btn-info guardaComprobante" type="submit" onclick="guardaProducto(this)">Guardar</button>
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
            $("#card-productos").refresh();

            $("#btnuploadProductos").on("click",function(){
                $("#archivoProducto").trigger("click");
            });
            $("#archivoProducto").on("change",function(){
                $("#uploadProductos").submit();
            })
            $("#uploadProductos").on("submit",function(e){
                e.preventDefault();
                var formData = new FormData(document.getElementById("uploadProductos"));
                formData.append("_token", $('meta[name=csrf-token]').attr('content'));

                $.ajax({
                    url: "{{url("/productos/subirArchivo")}}",
                    type: "post",
                    dataType: "html",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false
                }) .done(function(data){
                    $("#card-productos").refresh();
                }) .fail(function(xhr){
                    errorShow(xhr.responseText);
                });
            });

            $("#btnuploadProductos2").on("click",function(){
                $("#archivoProducto2").trigger("click");
            });
            $("#archivoProducto2").on("change",function(){
                $("#uploadProductos2").submit();
            })
            $("#uploadProductos2").on("submit",function(e){
                e.preventDefault();
                var formData = new FormData(document.getElementById("uploadProductos2"));
                formData.append("_token", $('meta[name=csrf-token]').attr('content'));

                $.ajax({
                    url: "{{url("/productos/subirArchivo2")}}",
                    type: "post",
                    dataType: "html",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false
                }) .done(function(data){
                    $("#card-productos").refresh();
                }) .fail(function(xhr){
                    errorShow(xhr.responseText);
                });
            });

            $('#ClaveProdServConf').select2({
                ajax: {
                    url: '/general/getProdServ',
                    dataType: 'json',
                    delay: 300,
                    data: function (params) {
                        return {
                            q: params.term, // search term
                            page: params.page || 1
                        };
                    },
                    processResults: function (data, params) {
                        params.page = params.page || 1;
                        var result = data.results;
                        console.log(result);
                        return {
                            results: result.data,
                            pagination: {
                                more: (params.page * 1000) < result.total
                            }
                        };
                    }
                },
                language: "es"
            });
            $('#ClaveUnidad').select2({
                ajax: {
                    url: '/general/getClaveUnidad',
                    dataType: 'json',
                    delay: 300,
                    data: function (params) {
                        return {
                            q: params.term, // search term
                            page: params.page || 1
                        };
                    },
                    processResults: function (data, params) {
                        params.page = params.page || 1;
                        var result = data.results;
                        console.log(result);
                        return {
                            results: result.data,
                            pagination: {
                                more: (params.page * 1000) < result.total
                            }
                        };
                    }
                },
                language: "es"
            });
            // on first focus (bubbles up to document), open the menu
            $(document).on('focus', '.select2-selection.select2-selection--single', function (e) {
                $(this).closest(".select2-container").siblings('select:enabled').select2('open');
            });

            // steal focus during close - only capture once and stop propogation
            $('select.select2').on('select2:closing', function (e) {
                $(e.target).data("select2").$selection.one('focus focusin', function (e) {
                    e.stopPropagation();
                });
            });
        })
        function openProducto(obj){

            var datos = $(obj).parents(".tr").data("datos");
            console.log(datos);
            $("#fieldsProducto input").val("");
            $("#fieldsProducto select").val(null);
            if(datos!=undefined){
                $.each(datos,function(key,value){
                    $("#Producto_"+key).val(value);
                });

                setSelect2($("#ClaveProdServConf"),datos.ClaveProducto);
                setSelect2($("#ClaveUnidad"),datos.ClaveUnidad);
            }
            $("#fieldsProducto").modal("show");
            $("#fieldsProducto input:first").focus();
        }
        function traerProductos(obj){
            $(obj).startDisable();
            $.post("/productos/traerProductos", {
                _token: $('meta[name=csrf-token]').attr('content'),
            })
                .done(function (data) {
                    $(obj).stopDisable();
                    $("#card-productos").refresh();
                })
                .fail(function(xhr)
                {
                    $(obj).stopDisable();
                    console.log(xhr.responseText);
                });
        }
        function setSelect2(obj,valor){
            if(valor!=null) {
                var partes = valor.split(" - ");
                var data = {
                    text: valor,
                    id: partes[1]
                }
                // create the option and append to Select2
                var option = new Option(data.text, data.id, true, true);
                obj.append(option).trigger('change');

                // manually trigger the `select2:select` event
                obj.trigger({
                    type: 'select2:select',
                    params: {
                        data: data
                    }
                });
            }
        }
        function guardaProducto(obj){
            $(obj).startDisable("Guardando...");
            $.post("/productos/guardaProducto", {
                _token: $('meta[name=csrf-token]').attr('content'),
                Fraccion:$("#Producto_Fraccion").val()
                ,SubdivisionFraccion:$("#Producto_SubdivisionFraccion").val()
                ,DescripcionMercancia:$("#Producto_DescripcionMercancia").val()
                ,PrecioUnitario:$("#Producto_PrecioUnitario").val()
                ,UnidadMedidaComercial:$("#Producto_UnidadMedidaComercial").val()
                ,CodigoMercanciaProducto:$("#Producto_CodigoMercanciaProducto").val()
                ,Unidad:$("#Producto_Unidad").val()
                ,ClaveProducto:$("#select2-ClaveProdServConf-container").text()
                ,ClaveUnidad:$("#select2-ClaveUnidad-container").text()
                ,id:$("#Producto_id").val()
            })
                .done(function (data) {
                    $(obj).stopDisable();
                    $("#card-productos").refresh();
                    $("#fieldsProducto").modal("show");
                })
                .fail(function(xhr)
                {
                    $(obj).stopDisable();
                    $("#resultadoProducto").html('<div class="alert alert-error alert-dismissible">'+xhr.responseText+'</div>');
                });
        }
        function select2Val(id){
            var text = $("#select2-"+id+"-container").text();
            var parts = text.split(" - ");
            return parts[0]
        }
        function borrarProducto(obj){
           var id = $(obj).parents(".tr").data("id");
            Swal.fire({
                title: 'Desea borrar el producto?',
                text: "No podrá deshacer esta acción",
                type: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.value) {
                    $.post("/productos/borrarProducto", {
                        _token: $('meta[name=csrf-token]').attr('content'),
                        id: id
                    })
                        .done(function (data) {
                            $("#card-productos").refresh();
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
