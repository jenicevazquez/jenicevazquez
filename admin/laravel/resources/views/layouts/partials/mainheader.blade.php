<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white" style="height: 72px; background: #23c1c1; color: white">
    <!-- Left navbar links -->
    <ul class="navbar-nav ">
        <li class="nav-item">
            <a class="nav-link btncollapse" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        @if(Genericclass::user()->admin==1||Genericclass::user()->titular==1)
        <li class="nav-item dropdown">
            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link"><i class="fas fa-building"></i></a>
            <ul id="submenuTitular" aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow" style="left: 0px; right: inherit;">
                <li><a class="dropdown-item" data-toggle="modal" data-target="#modalEmpresa">Datos de la empresa</a></li>
                <li class="dropdown-divider"></li>
                <li class="nav-item {{ (Request::is('usuarios') ? 'active' : '') }}"><a  class="nav-link"  href="{!! url('usuarios') !!}"><p>Usuarios</p></a></li>
            </ul>
        </li>
        @endif
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a data-toggle="modal" data-target="#modalTC" onclick="getTC()" class="nav-link" role="button">
                Tipo de cambio Hoy: ${!! GenericClass::tipoDeCambio() !!}MXN
            </a>
        </li>

        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                <span class="badge badge-warning navbar-badge">15</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-item dropdown-header">15 Notifications</span>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-envelope mr-2"></i> 4 new messages
                    <span class="float-right text-muted text-sm">3 mins</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-users mr-2"></i> 8 friend requests
                    <span class="float-right text-muted text-sm">12 hours</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-file mr-2"></i> 3 new reports
                    <span class="float-right text-muted text-sm">2 days</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
            </div>
        </li>
        <li class="nav-item">
            <a title="Cerrar sesion" class="nav-link" href="/logout" role="button">
                <i class="fas fa-sign-out-alt"></i>
            </a>
        </li>
    </ul>
</nav>
<!-- /.navbar -->
<div id="modalTC" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tipo de Cambio</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span style="color: #979ca0" aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>
<!-- /.navbar -->
<div id="modalA22" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Anexo 22</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span style="color: #979ca0" aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>
<div class="modal" tabindex="-1" role="dialog" id="modalEmpresa">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
          <h5 class="modal-title"><i class="fas fa-building"></i> Datos de la empresa</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
      </div>
      <div class="modal-body" style="padding:0; padding-top: 1rem">
          <iframe class="fullIframe" src="{!! url('empresa') !!}"></iframe>
      </div>
    </div>
  </div>
</div>
<style>
    .fullIframe{
        border: none;
        width: 100%;
        min-height: 500px;
    }
</style>