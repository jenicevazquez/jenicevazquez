@extends('layouts.app')
@section('main-title','Inicio')
@section('main-content')

<div class="container-fluid" style="padding: 20px">
    <div class="row" id="cuadroCuentas"></div>
    <div class="row">
        <div class="modal" id="modalCuenta" tabindex="-1" role="dialog">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="modalTitle">Modal title</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
              </div>
              <div class="modal-body">
                  <div class="row">
                      <div class="form-group col-12">
                          {!! Form::select('modoEdicion', array("1"=>"Pago","2"=>"Gasto","0"=>"Edicion"), null, ['class' => 'form-control','maxlength'=>255,'required','id'=>'modoEdicion']) !!}
                          <input type="checkbox" checked id="agregarSaldo"> Sumar a saldo
                      </div>
                      <div class="form-group col-12">
                          {!! Form::hidden('idMov', null, ['class' => 'form-control','id'=>'idMov']) !!}
                          {!! Form::label('cantidadMov', 'Cantidad:') !!}
                          <input type="number" id="cantidadMov" name="cantidadMov" class="form-control" autocomplete="off">
                      </div>
                  </div>
              </div>
              <div class="modal-footer text-right">
                <button onclick="guardarMovimiento(this)" type="button" class="btn btn-primary">Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
              </div>
            </div>
          </div>
        </div>
        <div class="modal" id="crearCuenta" tabindex="-1" role="dialog">

          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title">Crear cuenta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>

              </div>
              <div class="modal-body">
                  <div class="row">
                      <div class="col-xs-12">
                        <table>
                            <tr>
                                <th style="width: 50px"></th>
                                <td><input id="txtNombre" name="txtNombre" placeholder="Nombre" type="text" class="form-control fieldCuentas" ></td>
                                <td><select id="txtRed" name="txtRed" class="form-control fieldCuentas"><option>Visa</option><option>Mastercard</option></select></td>
                                <td><select id="txtTipo" name="txtTipo"  class="form-control fieldCuentas"><option>Credito</option><option>Debito</option></select></td>
                                <td><input id="txtNumero" name="txtNumero" placeholder="Numero"  type="text" class="form-control fieldCuentas" ></td>
                                <td><input id="txtDigital" name="txtDigital" placeholder="Digital" type="text" class="form-control fieldCuentas" ></td>
                                <td><input id="txtLimite" name="txtLimite" placeholder="Limite"  type="text" class="form-control fieldCuentas" ></td>
                                <td><input id="txtSaldo" name="txtSaldo" placeholder="Saldo" type="text" class="form-control fieldCuentas" ></td>
                                <td></td>
                            </tr>
                        </table>
                      </div>
                  </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary">Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
              </div>
            </div>
          </div>
        </div>
        <div class="modal" id="modalDetalles" tabindex="-1" role="dialog">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title">Cuenta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                  <div class="row">
                      <div class="col-xs-12">
                          <table class="table table-bordered" id="tbCortes">
                              <thead>
                              <tr>
                                  <th style="width: 50px; text-align: center"></th>
                                  <th style="width: 125px; text-align: center">Fecha Corte</th>
                                  <th style="width: 125px; text-align: center">Fecha Limite Pago</th>
                                  <th style="width: 125px; text-align: center" class="number">Pago minimo</th>
                                  <th class="number" style="text-align: center">Pago para no generar intereses</th>
                                  <th style="width: 100px; text-align: center" class="number">CAT</th>
                              </tr>
                              <tr id="altaCorte">
                                  <th style="width: 50px"></th>
                                  <td style="width: 125px"><input type="hidden" class="txtCuentaId"><input name="txtFechaCorte" type="text" class="form-control fieldCortes txtFechaCorte" ></td>
                                  <td style="width: 125px"><input name="txtFechaLimite"  type="text" class="form-control fieldCortes txtFechaLimite" ></td>
                                  <td style="width: 125px"><input name="txtPagoMinimo" type="text" class="form-control fieldCortes txtPagoMinimo" ></td>
                                  <td><input name="txtPagoNoIntereses"  type="text" class="form-control fieldCortes txtPagoNoIntereses" ></td>
                                  <td style="width: 100px"><input name="txtCAT"  type="text" class="form-control fieldCortes txtCAT" ></td>
                              </tr>
                              </thead>
                              <tbody>
                              </tbody>
                          </table>
                      </div>
                  </div>
              </div>
              <div class="modal-footer">
                <button onclick="storeCorte()" type="button" class="btn btn-primary">Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
              </div>
            </div>
          </div>
        </div>
        Hoy es {!! date("Y-m-d") !!}; Semana {!! date("W") !!};
    </div>
    <div class="row">
        <div class="col-xs-12" id="tbCuentas" style="overflow: auto">

        </div>
    </div>
    <div class="row">
        <div class="col-xs-12" id="tbMercadoLibre" style="overflow: auto"></div>

    </div>
</div>
    <style>
        .number{
            text-align: right;
        }
        .info-box-content{
            margin: 0 !important;
        }
        .info-box-icon{
            background: none;
        }
        tr.subtable > td{
            padding: 0 !important;
        }
        tr.subtable > td > table{
            margin: 0 !important;
        }
        .bold{
            font-weight: bold;
        }
    </style>
    <script>
        function procesar(){
            $.ajax({
                url: $("iframe#sat").attr("src"),
                type: 'GET',
                dataType: 'html'
            }).done(function(html) {
                console.log("PART 2:: ");
                console.log(html);
            });

        }
        function storeCuenta(){
            $.post("/cuentas/storeCuentas", {
                _token: $('meta[name=csrf-token]').attr('content'),
                red: $("#txtRed").val(),
                nombre: $("#txtNombre").val(),
                tipo: $("#txtTipo").val(),
                numero: $("#txtNumero").val(),
                digital: $("#txtDigital").val(),
                saldo: $("#txtSaldo").val(),
                limite: $("#txtLimite").val(),
            })
            .done(function (data) {
                listCuentas();
            })
            .fail(function(xhr)
            {
                console.log(xhr.responseText);
            });
        }
        function storeCorte(){
            var renglon = $("#altaCorte");
            var id = renglon.find(".txtCuentaId").val();
            $.post("/cuentas/storeCorte", {
                _token: $('meta[name=csrf-token]').attr('content'),
                fechaCorte: renglon.find(".txtFechaCorte").val(),
                fechaLimite: renglon.find(".txtFechaLimite").val(),
                minimo: renglon.find(".txtPagoMinimo").val(),
                nointeres: renglon.find(".txtPagoNoIntereses").val(),
                cuenta_id: renglon.find(".txtCuentaId").val(),
                cat: renglon.find(".txtCAT").val()
            })
                .done(function (data) {
                    listPagos(id);
                })
                .fail(function(xhr)
                {
                    console.log(xhr.responseText);
                });
        }
        function storePago(obj){
            var renglon = $(obj).parents("tr");
            var id = renglon.data("id");
            $.post("/cuentas/storePagos", {
                _token: $('meta[name=csrf-token]').attr('content'),
                fechaPago: renglon.find(".txtFechaPago").val(),
                cantidad: renglon.find(".txtCantidadPago").val(),
                corte_id: id,
            })
                .done(function (data) {
                    listCuentas();
                })
                .fail(function(xhr)
                {
                    console.log(xhr.responseText);
                });
        }
        function saveSaldo(saldo,id,operacion,agregar){
            $.post("/cuentas/storeSaldo", {
                _token: $('meta[name=csrf-token]').attr('content'),
                saldo: saldo,
                id: id,
                operacion:operacion,
                agregar:agregar
            })
                .done(function (data) {
                    listCuentas();
                    $("#modalCuenta").modal("hide");
                })
                .fail(function(xhr)
                {
                    console.log(xhr.responseText);
                });
        }
        function storeSaldo(obj){
            var renglon = $(obj).parents("tr");
            var id = renglon.data("id");
            var saldo = renglon.find(".txtSaldo").val();
            saveSaldo(saldo,id,0);
        }
        function calculateAbono(obj){
            var abono = $(obj).val();
            if(abono>0) {
                var totalcantidad = 0;
                var totalnuevosaldo = 0;
                $(".trCuenta").each(function () {
                    var renglon = $(this);
                    var porcentaje = renglon.data("porcentaje");
                    var saldo = renglon.data("saldo");
                    var cantidad = abono * (porcentaje / 100);
                    var nuevoSaldo = cantidad + parseFloat(saldo);
                    renglon.find(".cantidad").text(cantidad.toFixed(2));
                    renglon.find(".nuevoSaldo").text(nuevoSaldo.toFixed(2));
                    totalcantidad += cantidad;
                    totalnuevosaldo += nuevoSaldo;
                })
                $(".totalcantidad").text(totalcantidad.toFixed(2));
                $(".totalnuevoSaldo").text(nuevoSaldo.toFixed(2));
            }
            else{
                $(".trCuenta").each(function () {
                    var renglon = $(this);
                    renglon.find(".cantidad").text("");
                    renglon.find(".nuevoSaldo").text("");
                })
                $(".totalcantidad").text("");
                $(".totalnuevoSaldo").text("");
            }

        }
        function listCuentas(){
            $.post("/cuentas/listCuentas", {
                _token: $('meta[name=csrf-token]').attr('content'),
                abono: $(".txtAbono").val()
            })
            .done(function (data) {
                $("#tbCuentas").html(data[0]);
                $("#cuadroCuentas").html(data[1]);
                calculateAbono($("#txtAbono"));
                $(".fieldCuentas").on('keypress',function(e) {
                    if(e.which == 13) {
                        storeCuenta();
                    }
                });
                $(".fieldCortes").on('keypress',function(e) {
                    if(e.which == 13) {
                        storeCorte();
                    }
                });
                $(".fieldPagos").on('keypress',function(e) {
                    if(e.which == 13) {
                        storePago($(this));
                    }
                });
                $(".txtSaldo").on('keypress',function(e) {
                    if(e.which == 13) {
                        storeSaldo($(this));
                    }
                });
                $("#txtAbono").on('keypress',function(e) {
                    if(e.which == 13) {
                        calculateAbono($(this));
                    }
                })
                $(".fecha").datepicker({
                    format: 'yyyy-mm-dd'
                });
            })
            .fail(function(xhr)
            {
                console.log(xhr.responseText);
            });
        }
        function listMercadoLibre(){
            $.post("/cuentas/listMercadoLibre", {
                _token: $('meta[name=csrf-token]').attr('content')
            })
                .done(function (data) {
                    $("#tbMercadoLibre").html(data[0]);
                })
                .fail(function(xhr)
                {
                    console.log(xhr.responseText);
                });
        }
        function listPagos(id){
            $.post("/cuentas/listPagos", {
                _token: $('meta[name=csrf-token]').attr('content'),
                id:id
            })
                .done(function (data) {
                    $(".txtCuentaId").val(id);
                    $("#tbCortes tbody").html(data[0]);
                    $(".fieldPagos").on('keypress',function(e) {
                        if(e.which == 13) {
                            storePago($(this));
                        }
                    });
                    $("#modalDetalles .fecha").datepicker({
                        format: 'yyyy-mm-dd'
                    });
                    $("#modalDetalles").modal("show");
                })
                .fail(function(xhr)
                {
                    console.log(xhr.responseText);
                });
        }
        function openCuenta(obj){
            var id = $(obj).data("id");
            $("#idMov").val(id);
            var nombre = $(obj).data("nombre");
            $("#modalTitle").text(nombre);
            $("#modalCuenta").modal("show");
        }
        function guardarMovimiento(obj){
            var id = $("#idMov").val();
            var saldo = $("#cantidadMov").val();
            var operacion = $("#modoEdicion").val();
            var agregar = $("#agregarSaldo").is(":checked")? 1:0;
            saveSaldo(saldo,id,operacion,agregar);
        }
        listCuentas();
        listMercadoLibre();
    </script>
@endsection
