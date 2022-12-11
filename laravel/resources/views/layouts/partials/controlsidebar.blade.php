<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
        <li class="active"><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fas fa-user-friends"></i></a></li>
        <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fas fa-cogs"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
        <!-- Home tab content -->
        <div class="tab-pane active" id="control-sidebar-home-tab">
            <h3 class="control-sidebar-heading">Contactos</h3>
            <ul class='control-sidebar-menu'>
                @foreach(General::getUsuariosRows() as $usuario)
                    <li>
                        <a href='javascript:void(0);'>
                            <img src="{!! $usuario->foto !!}" class="thumb-user-image menu-icon" alt="User Image"/>
                            <div class="menu-info">
                                <h4 class="control-sidebar-subheading">{!! $usuario->name !!}</h4>
                                <p><i class="fa fa-circle text-success"></i> En linea</p>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul><!-- /.control-sidebar-menu -->

            {{--<h3 class="control-sidebar-heading">{{ trans('adminlte_lang::message.progress') }}</h3>
            <ul class='control-sidebar-menu'>
                <li>
                    <a href='javascript:void(0);'>
                        <h4 class="control-sidebar-subheading">
                            {{ trans('adminlte_lang::message.customtemplate') }}
                            <span class="label label-danger pull-right">70%</span>
                        </h4>
                        <div class="progress progress-xxs">
                            <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
                        </div>
                    </a>
                </li>
            </ul>--}}

        </div><!-- /.tab-pane -->
        <!-- Stats tab content -->
        <div class="tab-pane" id="control-sidebar-stats-tab">{{ trans('adminlte_lang::message.statstab') }}</div><!-- /.tab-pane -->
        <!-- Settings tab content -->
        <div class="tab-pane" id="control-sidebar-settings-tab">
            <form method="post">
                <h3 class="control-sidebar-heading">Mi configuración</h3>
                <div class="form-group">
                    <label class="control-sidebar-subheading">
                        Panel de informes de uso
                        <input type="checkbox" class="pull-right" />
                    </label>
                    <p>
                        Alguna información sobre esta opción de configuración general
                    </p>
                </div>
                @if(Auth::user()->admin==1)
                    <h3 class="control-sidebar-heading">Configuración de licencia</h3>
                    <div class="form-group">
                        <label class="control-sidebar-subheading">
                            Panel de informes de uso
                            <input type="checkbox" class="pull-right" />
                        </label>
                        <p>
                            Alguna información sobre esta opción de configuración general
                        </p>
                    </div>
                @endif
            </form>
        </div>
    </div>
</aside>
<div class='control-sidebar-bg'></div>