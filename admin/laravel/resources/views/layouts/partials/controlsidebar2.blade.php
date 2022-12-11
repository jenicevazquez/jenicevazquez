@php($user = General::user())
@php($empresa = General::empresa())
@if(General::checarPermiso(16))
<?php
$valor = General::getConfiguracion("Comercializacion");
$valor2 = General::getConfiguracion("Alternativa");
$valor3 = General::getConfiguracion("Palabra");
$valor4 = General::getConfiguracion("Sugerencias");
$valor5 = General::getConfiguracion("Ancho");
$valor6 = General::getConfiguracion("Leyenda");
$valor7 = General::getConfiguracion("Color1");
$valor8 = General::getConfiguracion("Color2");
$valor9 = General::getConfiguracion("FontLogo");
$valor10 = General::getConfiguracion("Ticket");
$valor11 = General::getConfiguracion("PrintTicket");
$valor12 = General::getConfiguracion("Alertas");
$valor13 = General::getConfiguracion("PrintTicketShop");
$valor14 = General::getConfiguracion("MargenIzquierdo");
?>
<aside class="control-sidebar control-sidebar-dark">
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
        <li class="active"><a href="#control-sidebar-alerts-tab" data-toggle="tab"><i class="fas fa-bell"></i></a></li>
        <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-cogs"></i></a></li>
        <!--<li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fas fa-receipt"></i></a></li>-->
    </ul>
    <div class="tab-content">
        <div class="tab-pane" id="control-sidebar-home-tab">
            <h3 class="control-sidebar-heading">Configuración</h3>
            <ul class='control-sidebar-menu'>
                <li>
                    <a tabindex="-1" onclick="setDatosConfiguracion(this)" data-parametro="Comercializacion" data-value="{!! $valor !!}" href='javascript:void(0);'>
                        <i id="toggleParam1" style="font-size:25px; color: {!! $valor=="0"? "#d2d6de":"#28a745" !!}" class="menu-icon fas
                        fa-toggle-on {!! $valor=="0"? "fa-flip-horizontal":"" !!}"></i>
                        <div class="menu-info">
                            <h4 class="control-sidebar-subheading">Datos de comercialización</h4>
                            <p>Capturar unidad de compra, unidad de venta, factor y precio compra de productos</p>
                        </div>
                    </a>
                </li>
                <li>
                    <a tabindex="-1" onclick="setDatosConfiguracion(this)" data-parametro="Alternativa" data-value="{!! $valor2 !!}" href='javascript:void(0);'>
                        <i id="toggleParam2" style="font-size:25px; color: {!! $valor2=="0"? "#d2d6de":"#28a745" !!}" class="menu-icon fas
                        fa-toggle-on {!! $valor2=="0"? "fa-flip-horizontal":"" !!}"></i>
                        <div class="menu-info">
                            <h4 class="control-sidebar-subheading">Numero de parte</h4>
                            <p>Los productos y materia prima requieren numero de parte</p>
                        </div>
                    </a>
                </li>
            </ul>
            <h3 class="control-sidebar-heading">Caja</h3>
            <ul class='control-sidebar-menu'>
                <li>
                    <a tabindex="-1" onclick="setDatosConfiguracion(this)" data-parametro="Palabra" data-value="{!! $valor3 !!}" href='javascript:void(0);'>
                        <i id="toggleParam1" style="font-size:25px; color: {!! $valor3=="0"? "#d2d6de":"#28a745" !!}" class="menu-icon fas
                        fa-toggle-on {!! $valor3=="0"? "fa-flip-horizontal":"" !!}"></i>
                        <div class="menu-info">
                            <h4 class="control-sidebar-subheading">Buscar por palabra</h4>
                            <p>Se buscarán los productos por su descripcion, si se encuentra apagada esta opción,
                                la busqueda será por clave.</p>
                        </div>
                    </a>
                </li>
                <li>
                    <a tabindex="-1" onclick="setDatosConfiguracion(this)" data-parametro="Sugerencias" data-value="{!! $valor4 !!}" href='javascript:void(0);'>
                        <i id="toggleParam2" style="font-size:25px; color: {!! $valor4=="0"? "#d2d6de":"#28a745" !!}" class="menu-icon fas
                        fa-toggle-on {!! $valor4=="0"? "fa-flip-horizontal":"" !!}"></i>
                        <div class="menu-info">
                            <h4 class="control-sidebar-subheading">Sugerencia de producto</h4>
                            <p>Aparecerán al escribir la sugerencia de productos, esta opcion podría alentar el sistema
                                dependiendo del numero de productos agregados.</p>
                        </div>
                    </a>
                </li>
            </ul>
            <div class="form-group">
                <h3 class="control-sidebar-heading">Colores</h3>
                Color principal: <br>
                <div class="input-group input-group-sm">
                    <input value="{!! $valor7 !!}" type="text" class="form-control" name="Color1" id="Color1">
                    <a tabindex="-1" class="input-group-addon btn btn-success" onclick="setDatosConfiguracion(this)" data-parametro="Color1" data-id="Color1" href="javascript:void(0)">Guardar</a>
                </div>
                <br>Color secundario: <br>
                <div class="input-group input-group-sm">
                    <input value="{!! $valor8 !!}" type="text" class="form-control" name="Color2" id="Color2">
                    <a tabindex="-1" class="input-group-addon btn btn-success" onclick="setDatosConfiguracion(this)" data-parametro="Color2" data-id="Color2" href="javascript:void(0)">Guardar</a>
                </div>
                <br>Tamaño fuente: <br>
                <div class="input-group input-group-sm">
                    <input value="{!! $valor9 !!}" type="text" class="form-control" name="FontLogo" id="FontLogo">
                    <a tabindex="-1" class="input-group-addon btn btn-success" onclick="setDatosConfiguracion(this)" data-parametro="FontLogo" data-id="FontLogo" href="javascript:void(0)">Guardar</a>
                </div>
                <br>
                <a href="javascript:document.location.reload()">Recargar la pagina para ver cambios</a>
            </div>
        </div>
        <div class="tab-pane" id="control-sidebar-settings-tab">
            <ul class='control-sidebar-menu'>
                <li>
                    <a tabindex="-1" onclick="setDatosConfiguracion(this)" data-parametro="Ticket" data-value="{!! $valor10 !!}" href='javascript:void(0);'>
                        <i id="toggleParam1" style="font-size:25px; color: {!! $valor10=="0"? "#d2d6de":"#28a745" !!}" class="menu-icon fas
                        fa-toggle-on {!! $valor10=="0"? "fa-flip-horizontal":"" !!}"></i>
                        <div class="menu-info">
                            <h4 class="control-sidebar-subheading">Emitir ticket</h4>
                            <p>El sistema generará e imprimirá el ticket en cada venta</p>
                        </div>
                    </a>
                </li>
            </ul>
            <h3 class="control-sidebar-heading optTicket {!! $valor10=="0"? "oculto":"" !!}">Parametros de ticket</h3>
            <div class="form-group optTicket {!! $valor10=="0"? "oculto":"" !!}">
                <label class="control-sidebar-subheading">
                    Tamaño de papel de ticket
                </label>
                Ancho: <br>
                <div class="input-group input-group-sm">
                    <input value="{!! $valor5 !!}" type="text" class="form-control" name="anchoTicket" id="anchoTicket">
                    <span class="input-group-addon">milimetros</span>
                </div>
                <div class="form-group">
                    <a tabindex="-1" onclick="setDatosConfiguracion(this)" data-parametro="Ancho" data-id="anchoTicket" href="javascript:void(0)" style="width: 100%; margin-top: 10px" class="btn btn-success">Guardar</a>
                </div>
                Margen izquierdo : <br>
                <div class="input-group input-group-sm">
                    <input value="{!! $valor14 !!}" type="text" class="form-control" name="margenIzquierdo" id="margenIzquierdo">
                    <span class="input-group-addon">cm</span>
                </div>
                <div class="form-group">
                    <a tabindex="-1" onclick="setDatosConfiguracion(this)" data-parametro="MargenIzquierdo" data-id="margenIzquierdo" href="javascript:void(0)" style="width: 100%; margin-top: 10px" class="btn btn-success">Guardar</a>
                </div>
            </div>
            <div class="form-group optTicket {!! $valor10=="0"? "oculto":"" !!}">
                <label class="control-sidebar-subheading">
                    Observaciones
                </label>
                <p>
                    Observaciones o leyendas imprimir al final del ticket.
                </p>
                <textarea maxlength='255' style="font-size: 12px" class="form-control" name="observacionesTicket" id="observacionesTicket">{!! $valor6 !!}</textarea>
                <a tabindex="-1" onclick="setDatosConfiguracion(this)" data-parametro="Leyenda" data-id="observacionesTicket" href="javascript:void(0)" style="width: 100%; margin-top: 10px" class="btn btn-success">Guardar</a>
            </div>
            <ul class='control-sidebar-menu optTicket {!! $valor10=="0"? "oculto":"" !!}'>
                <li>
                    <a tabindex="-1" onclick="setDatosConfiguracion(this)" data-parametro="PrintTicket" data-value="{!! $valor11 !!}" href='javascript:void(0);'>
                        <i id="toggleParam1" style="font-size:25px; color: {!! $valor11=="0"? "#d2d6de":"#28a745" !!}" class="menu-icon fas
                        fa-toggle-on {!! $valor11=="0"? "fa-flip-horizontal":"" !!}"></i>
                        <div class="menu-info">
                            <h4 class="control-sidebar-subheading">Imprimir ticket</h4>
                            <p>Imprimir ticket automaticamente al generarse la venta como comprobante para el cliente.</p>
                        </div>
                    </a>
                </li>
                <li>
                    <a tabindex="-1" onclick="setDatosConfiguracion(this)" data-parametro="PrintTicketShop" data-value="{!! $valor13 !!}" href='javascript:void(0);'>
                        <i id="toggleParam1" style="font-size:25px; color: {!! $valor13=="0"? "#d2d6de":"#28a745" !!}" class="menu-icon fas
                        fa-toggle-on {!! $valor13=="0"? "fa-flip-horizontal":"" !!}"></i>
                        <div class="menu-info">
                            <h4 class="control-sidebar-subheading">Imprimir doble ticket</h4>
                            <p>Imprimir ticket automaticamente al generarse la venta como comprobante para la tienda.</p>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
        <!--<div class="tab-pane active" id="control-sidebar-alerts-tab">
            <h3 class="control-sidebar-heading">Alertas de minimos y maximos</h3>
            <ul class='control-sidebar-menu'>
                <li>
                    <a tabindex="-1" onclick="setDatosConfiguracion(this)" data-parametro="Alertas" data-value="{!! $valor12 !!}" href='javascript:void(0);'>
                        <i id="toggleParam1" style="font-size:25px; color: {!! $valor12=="0"? "#d2d6de":"#28a745" !!}" class="menu-icon fas
                        fa-toggle-on {!! $valor12=="0"? "fa-flip-horizontal":"" !!}"></i>
                        <div class="menu-info">
                            <h4 class="control-sidebar-subheading">Ver alertas</h4>
                            <p>El sistema mostrará el icono con las alertas de falta de stock</p>
                        </div>
                    </a>
                </li>
            </ul>
            @if($empresa->giro==3)
                <h3 class="control-sidebar-heading">Alertas de caducidad</h3>
                @php($valor13 = General::getConfiguracion("Vigencias"))
                @php($valor14 = General::getConfiguracion("AlertasVigencias"))
                <ul class='control-sidebar-menu'>
                    <li>
                        <a tabindex="-1" onclick="setDatosConfiguracion(this)" data-parametro="AlertasVigencias" data-value="{!! $valor12 !!}" href='javascript:void(0);'>
                            <i id="toggleParam1" style="font-size:25px; color: {!! $valor14=="0"? "#d2d6de":"#28a745" !!}" class="menu-icon fas
                        fa-toggle-on {!! $valor14=="0"? "fa-flip-horizontal":"" !!}"></i>
                            <div class="menu-info">
                                <h4 class="control-sidebar-subheading">Ver alertas de caducidad</h4>
                                <p>El sistema mostrará el icono con las alertas de productos a punto de vencer y vencidos</p>
                            </div>
                        </a>
                    </li>
                </ul>
            <div class="form-group optVigencias {!! $valor14=="0"? "oculto":"" !!}">
                <label class="control-sidebar-subheading">
                    Caducidad de los productos
                </label>
                Dias previos para la notificacion de productos a vencer: <br>
                <div class="input-group input-group-sm">
                    <input value="{!! $valor13 !!}" type="text" class="form-control" name="diasVigencia" id="diasVigencia">
                    <span class="input-group-addon">dias</span>
                </div>
                <div class="form-group">
                    <a tabindex="-1" onclick="setDatosConfiguracion(this)" data-parametro="Vigencias"
                       data-id="diasVigencia" href="javascript:void(0)" style="width: 100%; margin-top: 10px" class="btn btn-success">Guardar</a>
                </div>
            </div>
            @endif
        </div>-->
    </div>
</aside>
{{--<i class="menu-icon fa fa-birthday-cake bg-red"></i>--}}
<script>
    function setDatosConfiguracion(obj){
        var parametro = $(obj).attr("data-parametro");
        var id = $(obj).attr("data-id");
        var valor = '';

        if (typeof id !== typeof undefined && id !== false) {
            valor = $("#"+id).val();
        }else {
            valor = $(obj).attr("data-value");
            valor = valor == "1" ? 0 : 1;
        }
        console.log(parametro);
        $.post("{{url('/home/setDatosComercializacion')}}", {
            _token: $('meta[name=csrf-token]').attr('content'),
            valor:valor,
            parametro:parametro
        })
        .done(function (data) {
            console.log(data);
            var toggle = $(obj).find(".fa-toggle-on");
            if(data==1)
                $(toggle).removeClass("fa-flip-horizontal").css( "color", "#28a745" );
            else
                $(toggle).addClass("fa-flip-horizontal").css( "color", "#d2d6de" );
            $(obj).attr("data-value",valor);
            if(parametro=="Ticket"){
                if(valor==1)
                    $(".optTicket").removeClass("oculto");
                else
                    $(".optTicket").addClass("oculto");
            }
            if(parametro=="AlertasVigencias"){
                if(valor==1)
                    $(".optVigencias").removeClass("oculto");
                else
                    $(".optVigencias").addClass("oculto");
            }
        })
        .fail(function(xhr, textStatus, errorThrown)
        {
            console.log(xhr.responseText);
        });
    }
</script>
<!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
<div class='control-sidebar-bg'></div>
@endif