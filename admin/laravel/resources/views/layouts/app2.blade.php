<!DOCTYPE html>
<html lang="en">
<?php
$tiempo = microtime();
$tiempo = explode(" ",$tiempo);
$tiempo_inicial = $tiempo[0] + $tiempo[1];
?>
    @section('htmlheader')
        @include('layouts.partials.htmlheader')
    @show
    <body class="skin-purple sidebar-mini fixed">
        @include('layouts.partials.scripts')
        @include('layouts/loader')
        <div class="wrapper">
            @include('layouts.partials.mainheader')
            @include('layouts.partials.sidebar')
            <div class="content-wrapper">
                <section class="content">
                    <div class="flash pull-right">
                        <div id="FlashAlert" class="alert alert-success" role="alert">
                            This is a success alert—check it out!
                        </div>
                    </div>
                    @yield('main-content')
                </section>
            </div>
            @include('layouts.partials.controlsidebar')
            @include('layouts.partials.footer')
        </div>
        <audio id="beep">
            <source src="/audio/pop.mp3" type="audio/mpeg">
            Your browser does not support the audio element.
        </audio>
<style>
    .sidebar-menu .fas{
        width: 20px;
    }
</style>
    </body>
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
