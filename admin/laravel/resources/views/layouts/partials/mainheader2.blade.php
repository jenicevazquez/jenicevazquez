<?php

    $user = General::user();
    $empresa = General::empresa();
    $sucursal = General::sucursal();
    $sucursales = General::usersucursal($user->id);
    $color1 = General::getConfiguracion("Color1");
    $color2 = General::getConfiguracion("Color2");
    $color3 = General::getConfiguracion("FontLogo");

    //dd(Session::get("licencia_id"));
?>
@php($valor14 = General::getConfiguracion("AlertasVigencias"))
<header class="main-header">
    <a href="{{ url('/home') }}" class="logo" id="logo" data-id="{!! General::user()->licencia_id !!}">
        <span class="logo-mini">{!! $empresa->nombre !!}</span>
        <span class="logo-lg">{!! $empresa->nombre !!}</span>
    </a>
    <nav class="navbar navbar-static-top" role="navigation">
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <i class="fas fa-align-justify"></i>
        </a>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav ml-auto">
                @if(!Auth::guest())
                    <li class="nav-item dropdown">
                        <a href = "javascript:void(0)" class = "dropdown-toggle" data-toggle = "dropdown" role = "button"
                           aria-expanded = "false">
                        <span class="notificacion">
                            <i class = "far fa-bell campana"></i>
                            <span class="badge badge-notify alertCount"></span>
                        </span>
                        </a>
                        <ul class = "dropdown-menu dropdown-alertas" role = "menu">
                            <li class="header">Notificaciones</li>
                            <li class="body">
                                <ul class="menu" id="menuAlertas">
                                    <div class="text-center">
                                        <i class="fas fa-spinner fa-spin"></i>
                                    </div>
                                </ul>
                            </li>
                            <li class="footer"><a href="{!! url('inventarios') !!}">Ir a Inventario</a></li>
                        </ul>
                    </li>
                @endif
                @if (Auth::guest())
                    <li class="nav-item"><a href="{{ url('/login') }}">{{ trans('adminlte_lang::message.login') }}</a></li>
                @else
                    <li class="nav-item dropdown">
                        <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
                            <span id="sucursalActual" data-id="{!! $sucursal? $sucursal->id:0 !!}" class="">{!! $sucursal? $sucursal->sucursal:'' !!}</span> <i class="fas fa-caret-down"></i>
                        </a>
                        @if(count($sucursales)>0)
                        <ul class="dropdown-menu dropdown-sucursal">
                            @foreach ($sucursales as $i=>$suc)
                                @if(isset($sucursal) && $sucursal->id==$suc->sucursal->id)
                                    <li><a href="javascript:void(0)"><i class="far fa-dot-circle"></i> {!! $suc->sucursal->sucursal !!}</a></li>
                                @else
                                    <li><a onclick="setSucursal('{!! $suc->sucursal->id !!}')"  href="javascript:void(0)"><i class="far fa-circle"></i> {!! $suc->sucursal->sucursal !!}</a></li>
                                @endif
                            @endforeach
                        </ul>
                        @endif
                    </li>
                    <li class="nav-item dropdown user user-menu">
                        <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
                            @if($empresa->logo=="")
                                <img src="{{asset('/img/user.png')}}" class="user-image" />
                            @else
                                <img src="{{asset('/img/logos/')."/".$empresa->logo}}" class="user-image" />
                            @endif
                            <!-- hidden-xs hides the username on small devices so only the image appears. -->
                            <span class="hidden-xs">{{ ucfirst($user->name) }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- The user image in the menu -->
                            <li class="user-header">
                                @if($empresa->logo=="")
                                    <img src="{{asset('/img/user.png')}}" class="img-circle" />
                                @else
                                    <img src="{{asset('/img/logos/')."/".$empresa->logo}}" class="img-circle" />
                                @endif

                                    <p>
                                        {{ ucfirst($user->nombre) }}<br>
                                        <small>{{ $user->name }}</small>
                                    </p>

                            </li>
                            <!-- Menu Body -->
                            <li class="user-body">
                                <div class="col-xs-12 text-center">
                                    <a style="width: 100%" class="btn btn-default btn-flat" href="{{ route('usuarios.show',[$user->id]) }}">Mis datos</a>
                                </div>
                                <!--<div class="col-xs-4 text-center">
                                    <a href="#"></a>
                                </div>
                                <div class="col-xs-4 text-center">
                                    <a href="#"></a>
                                </div>-->
                            </li>
                        @if(General::checarPermiso(16))
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="">
                                    <a style="width:100%" href="{!! url("empresa") !!}" class="btn btn-default btn-flat">Datos de la empresa</a>
                                </div>
                            </li>
                        @endif

                        </ul>
                    </li>
                    <li class="nav-item"><a title="Cerrar Sesion" href="{{ url('/logout') }}"><i class="fas fa-sign-out-alt"></i></a></li>
                    {{--<li><a title="Cerrar aplicacion" href="{{ url('/salir') }}"><i class="fas fa-times bg-red"></i></a></li>--}}
                @endif
                @if(General::checarPermiso(16))
                <!-- Control Sidebar Toggle Button -->
                <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-cogs"></i></a>
                </li>
                @endif
            </ul>
        </div>
    </nav>
</header>
<script>
    document.title = "{!! $empresa->nombre !!} | SAVI";

    $(document).ready(function(){
        alertas();
        @if($empresa->giro=="3")
            alertas2();
        @endif
        ajustarPantalla();
        $("#FlashAlert").hide();

    });
    function alertas(){
        $.post( "{!! url('/home/alertas') !!}",{
            _token: $('meta[name=csrf-token]').attr('content')
        })
            .done(function(data) {
                var result = '';
                if(data[0]>0){
                    $(".alertCount").text(data[0]);
                }
                else{
                    $(".alertCount").text("");
                }
                var notificaciones = data[1];
                if(notificaciones.length>0){
                    $(".campana").attr('data-prefix','fas');
                    for(var i=0; i<notificaciones.length; i++){
                        var fotos = notificaciones[i].producto.fotos;
                        console.log(fotos.length);
                        var foto = (fotos.length>0)? '<img src="{!! url('storage') !!}/fotos_{!! Auth::user()->licencia_id !!}_'+fotos[0].foto+'" class="img-responsive">':'';
                        if(notificaciones[i].stock>0) {
                            result += '<li>';
                            result += '<a href="/inventarios?q='+notificaciones[i].clave+'">';
                            result += '<div class=""><div class="placeholderImg picalert">'+foto+'</div><b>' + notificaciones[i].clave + ' ' + notificaciones[i].descripcion + '</b> solo tiene <b>' + notificaciones[i].stock + ' en inventario</b><br>';
                            result += '<small><i class="fas fa-exclamation-triangle yellow" aria-hidden="true"></i> Producto a punto de agotarse</small></div>';
                            result += '</a></li>';
                        }
                        else{
                            result += '<li>';
                            result += '<a href="/inventarios?q='+notificaciones[i].clave+'"><div class=""><div class="placeholderImg picalert">'+foto+'</div><b>' + notificaciones[i].clave + ' ' + notificaciones[i].descripcion + '</b> se encuentra <b>agotado</b><br>';
                            result += '<small><i class="fas fa-exclamation-circle red" aria-hidden="true"></i> Producto agotado</small></div>';
                            result += '</a></li>';
                        }
                    }
                    $("#menuAlertas").html(result);
                }
                else{
                    $(".campana").attr('data-prefix','far');
                    $("#menuAlertas").html("<li style='text-align: center; border-bottom: none'><i>No tiene notificaciones</i></li>");
                }

            })
            .fail(function(xhr,textStatus,errorThrown){
                console.log(xhr.responseText);
            })
    }
    function alertas2(){
        $.post( "{!! url('/home/alertas2') !!}",{
            _token: $('meta[name=csrf-token]').attr('content')
        })
            .done(function(data) {
                var result = '';
                if(data[0]>0){
                    $(".alertCount2").text(data[0]);
                }
                else{
                    $(".alertCount2").text("");
                }
                var notificaciones = data[1];
                if(notificaciones.length>0){
                    //$(".campana").attr('data-prefix','fas');
                    for(var i=0; i<notificaciones.length; i++){
                        var fotos = notificaciones[i].producto.fotos;
                        console.log(fotos.length);
                        var foto = (fotos.length>0)? '<img src="{!! url('storage') !!}/fotos_'+fotos[0].foto+'" class="img-responsive">':'';
                        if(notificaciones[i].dias<0) {
                            var dias = notificaciones[i].dias*-1;
                            result += '<li>';
                            result += '<a href="/inventarios?q='+notificaciones[i].clave+'">';
                            result += '<div class=""><div class="placeholderImg picalert">'+foto+'</div><b>' + notificaciones[i].clave + ' ' + notificaciones[i].descripcion + '</b> solo tiene <b>' + dias + ' dias de vigencia</b><br>';
                            result += '<small><i class="fas fa-exclamation-triangle yellow" aria-hidden="true"></i> Producto a punto de vencer</small></div>';
                            result += '</a></li>';
                        }
                        else{
                            result += '<li>';
                            result += '<a href="/inventarios?q='+notificaciones[i].clave+'"><div class=""><div class="placeholderImg picalert">'+foto+'</div><b>' + notificaciones[i].clave + ' ' + notificaciones[i].descripcion + '</b> se encuentra <b>vencido</b><br>';
                            result += '<small><i class="fas fa-exclamation-circle red" aria-hidden="true"></i> Producto vencido</small></div>';
                            result += '</a></li>';
                        }
                    }
                    $("#menuVigencias").html(result);
                }
                else{
                    //$(".campana").attr('data-prefix','far');
                    $("#menuVigencias").html("<li style='text-align: center; border-bottom: none'><i>No tiene notificaciones</i></li>");
                }

            })
            .fail(function(xhr,textStatus,errorThrown){
                console.log(xhr.responseText);
            })
    }
    function setSucursal(id){
        $.get("{!! url('/home/sucursal/') !!}/"+id)
            .done(function(data) {
                window.location.reload(true);
            });
    }
    function marcar(obj){
        var url = $(obj).data("href");
        var notificacion =  $(obj).data("notificacion");
        $.get("{!! url('/home/notificacion/') !!}/"+notificacion)
            .done(function(data) {
                window.location.href = url;
            });
    }
    function visto(){
        $.get("{!! url('/home/visto/') !!}")
            .done(function(data) {
                alertas();
            });
    }
</script>
<style>
    .skin-purple .main-header .logo, .skin-purple .main-header .logo:hover,
    .skin-purple .main-header li.user-header, .dropdown-sucursal, .panel-primary .panel-heading, .modal-header{
        background-color: {!! $color1 !!};
        color: #ffffff;
    }
    .skin-purple .main-header .navbar, .skin-purple .main-header .navbar > a:hover{
        background: linear-gradient(45deg, {!! $color1 !!} 0%, 80%, {!! $color2 !!} 100%) !important;
    }
    .dropdown-menu > li > a:hover {
        background-color: {!! $color2 !!};
        color: #ffffff;
    }
    .logo-lg{
        font-size: {!! $color3 !!};
    }
    .box{
        border-top: 3px solid {!! $color1 !!};
    }
    .skin-purple .sidebar-menu > li:hover > a, .skin-purple .sidebar-menu > li.active > a{
        border-left-color: {!! $color1 !!};
    }
    #myModal{
        z-index: 1060;
    }
</style>
