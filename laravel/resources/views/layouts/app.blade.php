<!DOCTYPE html>
<html lang="es">
<?php
$tiempo = microtime();
$tiempo = explode(" ",$tiempo);
$tiempo_inicial = $tiempo[0] + $tiempo[1];

?>
@include("layouts.partials.htmlheader")

<body class="hold-transition sidebar-mini layout-fixed sidebar-collapse">
<div class="wrapper">

@include("layouts.loader")
@include("layouts.partials.mainheader")

@include("layouts.partials.sidebar")

<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper section-@yield('section-name')">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">

                    <div class="col-sm-6">
                        <h1 class="m-0">@yield('main-title')</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6 text-right">

                        @yield('acciones')
                    </div><!-- /.col -->
                </div><!-- /.row -->

            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                @yield('main-content')
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>

    @include("layouts.partials.footer")


</div>
@yield('main-modales')
</body>

@include("layouts.partials.scripts")
@yield('js-scripts')
<?php
$tiempo = microtime();
$tiempo = explode(" ",$tiempo);
$tiempo_final = $tiempo[0] + $tiempo[1];
$tiempo_carga = $tiempo_final - $tiempo_inicial;
$tiempo_carga = round($tiempo_carga,3);
if($tiempo_carga>3){
    $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    //General::carga("Pagina generada en ".$tiempo_carga." segundos",$actual_link);
}
$res = "Pagina generada en ".$tiempo_carga." segundos";
?>
<script>
    $("#detallePagina").text('{!! $res !!}');
</script>
</html>
