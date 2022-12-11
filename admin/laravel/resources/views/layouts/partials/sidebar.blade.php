<aside class="main-sidebar sidebar-dark-primary elevation-4" style="background: #041414">
    <a href="index3.html" class="brand-link">
        <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item {{ (Request::is('home') ? 'active' : '') }}"><a class="nav-link" href="{{ url('home') }}"><i class='fa fa-home'></i> <p>Inicio</p></a></li>
                    <li class="nav-item {{ (Request::is('cfdis') ? 'active' : '') }}"><a class="nav-link" href="{!! route('cfdis.create') !!}"><i class="fas fa-check-circle"></i> <p>Generar Factura</p></a></li>
                    <li class="nav-item {{ (Request::is('cfdis') ? 'active' : '') }}"><a class="nav-link" href="{!! route('cfdis.index') !!}"><i class="fas fa-file-invoice"></i> <p>Facturas</p></a></li>
                    <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class='fa fa-book'></i>
                        <p>
                            Catálogos
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="display: none;">
                        <li class="nav-item">
                            <a href="/clientes" class="nav-link">
                                <i class="far fa-folder nav-icon"></i>
                                <p>Clientes</p>
                            </a>
                            <a href="/productos" class="nav-link">
                                <i class="far fa-folder nav-icon"></i>
                                <p>Productos</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</aside>