<?php
$user = General::user();
$empresa = General::empresa();
$licencia = General::getLicencia();
//dd($licencia);
?>
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel (optional) -->
        @if (! Auth::guest())
                <div class="user-panel">
                    <div class="pull-left image">
                        @if($empresa->logo=="")
                            <img src="{{asset('/img/user.png')}}" class="img-circle" />
                        @else
                            <img src="{{asset('/img/logos/')."/".$empresa->logo}}" class="img-circle" />
                        @endif
                    </div>
                    <div class="pull-left info">
                        <p><a href="{!! route("usuarios.edit",$user->id) !!}">{{ ucfirst($user->nombre) }} </a></p>
                        <!-- Status -->
                        <a href="#"><i class="fa fa-circle text-success"></i> {{ trans('adminlte_lang::message.online') }}</a>
                    </div>
                </div>
        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header">MENU</li>
            @if(General::checarPermiso(1))
            <li {{ (Request::is('home') ? 'class=active' : '') }}><a href="{{ url('home') }}"><i class='fa fa-home'></i> <span>Inicio</span></a></li>
            @endif
            @if(General::checarPermiso(4))
                <li {{ (Request::is('productos')||Request::is('promos')||Request::is('proveedores')||Request::is('marcas')||Request::is('categorias')||Request::is('unidades')||Request::is('clientes'))? 'class=active' : '' }} class="treeview">
                    <a href="javascript:void(0)"><i class="fas fa-book"></i> <span>Catálogos</span> <i class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                        <li {{ (Request::is('materiales') ? 'class=active' : '') }}><a href="{!! url('materiales') !!}"><i class="fas fa-folder"></i> <span>Materia Prima</span></a></li>
                        <li {{ (Request::is('productos') ? 'class=active' : '') }}><a href="{!! url('productos') !!}"><i class="fas fa-folder"></i> <span>Productos</span></a></li>
                        <li {{ (Request::is('proveedores') ? 'class=active' : '') }}><a href="{!! url('proveedores') !!}"><i class="fas fa-folder"></i> Proveedores</a></li>
                        <li {{ (Request::is('marcas') ? 'class=active' : '') }}><a href="{!! url('marcas') !!}"><i class="fas fa-folder"></i> Marcas</a></li>
                        <li {{ (Request::is('categorias') ? 'class=active' : '') }} ><a href="{!! url('categorias') !!}"><i class="fas fa-folder"></i> Categorias</a></li>
                        <li {{ (Request::is('unidades') ? 'class=active' : '') }}><a href="{!! url('unidades') !!}"><i class="fas fa-folder"></i> Unidades</a></li>
                        <li {{ (Request::is('localizaciones') ? 'class=active' : '') }}><a href="{!! url('localizaciones') !!}"><i class="fas fa-folder"></i> Localizaciones</a></li>
                        <li {{ (Request::is('clientes') ? 'class=active' : '') }}><a href="{!! url('clientes') !!}"><i class="fas fa-folder"></i> Clientes</a></li>
                        @if(General::user()->admin=="1")
                        <li {{ (Request::is('etapas') ? 'class=active' : '') }}><a href="{!! url('etapas') !!}"><i class="fas fa-folder"></i> Etapas producción</a></li>
                        @endif
                    </ul>
                </li>
            @endif
            @if(General::checarPermiso(5))
                <li {{ (Request::is('entradas') ? 'class=active' : '') }}><a href="{!! url('entradas') !!}"><i class="fas fa-truck-loading"></i> <span>Entradas</span></a></li>
                <li {{ (Request::is('inventarios') ? 'class=active' : '') }}><a href="{!! url('inventarios') !!}"><i class="fas fa-boxes"></i> <span>Almacen</span></a></li>

            @endif
            @if(General::checarPermiso(6))
                <li {{ (Request::is('traspasos')? 'class=active' : '') }} class="treeview">
                    <a href="javascript:void(0)">
                        <i class="fas fa-cogs"></i> <span>Operación </span> {!! General::countTraspasos(0) !!} <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        @foreach(General::getEtapas() as $etapa)
                        <li>
                            <a href="{!! url('operaciones') !!}/{!! $etapa->id !!}/ordenes"><i class="fas fa-folder"></i> <span>{!! $etapa->etapa !!} </span></a>
                        </li>
                        @endforeach
                    </ul>
                </li>
            @endif
            @if(General::checarPermiso(10))
                <li {{ (Request::is('salidas') ? 'class=active' : '') }}><a href="{!! url('salidas') !!}"><i class="fas fa-truck"></i> <span>Salidas</span></a></li>
                <li {{ (Request::is('reportes') ? 'class=active' : '') }}><a href="{!! url('reportes') !!}"><i class="fas fa-chart-line"></i> <span>Reportes</span></a></li>
            @endif
            @if(General::checarPermiso(11))
                <li {{ (Request::is('bitacora') ? 'class=active' : '') }}><a href="{!! url('bitacora') !!}"><i class="fas fa-address-book"></i> <span>Bitacora</span></a></li>
                <li {{ (Request::is('trazabilidad') ? 'class=active' : '') }}><a href="{!! url('trazabilidad') !!}"><i class="fas fa-search-location"></i> <span>Trazabilidad</span></a></li>
                <!--<li {{ (Request::is('respaldo') ? 'class=active' : '') }}><a onclick="respaldar()" href="javascript:void(0)"><i class="fas fa-database"></i> <span>Respaldo</span></a></li>-->
            @endif
            @if(General::checarPermiso(9) || $user->admin==1)
                <li {{ (Request::is('usuarios') ? 'class=active' : '') }}><a href="{!! url('usuarios') !!}"><i class="fas fa-users"></i> <span>Usuarios</span></a></li>
            @endif

            @if(isset($licencia->online) && $licencia->online==1)
                <li {{ (Request::is('internet/pedidos')||Request::is('internet/preguntas')||Request::is('internet/mensajes')||Request::is('internet/tienda'))? 'class=active' : '' }} class="treeview">
                    <a href="javascript:void(0)"><i class="fas fa-globe"></i> <span>Pedidos Internet</span> <i class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                        <li {{ (Request::is('internet/pedidos') ? 'class=active' : '') }}><a href="{!! url('internet/pedidos') !!}"><i class="fas fa-folder"></i> <span>Pedidos</span></a></li>
                        <li {{ (Request::is('internet/preguntas') ? 'class=active' : '') }}><a href="{!! url('internet/preguntas') !!}"><i class="fas fa-folder"></i> <span>Preguntas</span></a></li>
                        <!--<li {{ (Request::is('internet/mensajes') ? 'class=active' : '') }}><a href="{!! url('internet/mensajes') !!}"><i class="fas fa-folder"></i> <span>Mensajes</span></a></li>-->
                        <li {{ (Request::is('internet/tienda') ? 'class=active' : '') }}><a href="{!! url('internet/tienda') !!}"><i class="fas fa-folder"></i> <span>Tienda online</span></a></li>
                    </ul>
                </li>
            @endif
        </ul><!-- /.sidebar-menu -->
        @endif
        <script>
            function respaldar(){
                $.post("{{url('/respaldo')}}", {
                    _token: $('meta[name=csrf-token]').attr('content'),
                })
                .done(function (data) {
                    console.log(data[1]);
                    //window.location.assign("{!! url('storage') !!}/bdd_"+ data[0]);
                })
                 .fail(function(xhr, textStatus, errorThrown)
                   {
                       console.log(xhr.responseText);
                   });
            }
        </script>
    </section>
    <!-- /.sidebar -->
</aside>