<!doctype html>
<html lang="es">
<head>
    <meta charSet="utf-8"/>
    <meta name="description" content="@yield('htmldescription','En SAVI encuentra las mejores tiendas.')"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>@yield('htmltitle','SAVI | Las mejores tiendas te esperan')</title>
    <meta name="csrf-token" content="{!! \Illuminate\Support\Facades\Session::token() !!}">
    <link rel="stylesheet" href="https://ryvconsultores.mx/css/AdminLTE.css">
    <link rel="stylesheet" href="{{ asset('/css/bootstrap.min.css') }}">
    <link href="{{ asset('/img/icosavishop.png') }}" rel="icon" type="image/x-icon"  />

    <link href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" rel="stylesheet" type="text/css"
          integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans:700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">
    <script src="{{ asset('/js/jquery-3.3.1.min.js') }}"></script>
    <script src="https://adminlte.io/themes/AdminLTE/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <meta property="og:type"  content="@yield('typeFb','website')" />
    <meta property="og:image" content="@yield('imgFb',asset('/img/cajaregistradora.png'))" />
    <meta property="og:url" content="@yield('urlShare','savi.ryvconsultores.mx')" />
    <link href = "{{ asset('/js/lollipop/lollipopG.min.css') }}" rel = "stylesheet">
    <script src = "{{ asset('/js/lollipop/lollipopG.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <script src="https://ryvconsultores.mx:3000/socket.io/socket.io.js" ></script>
    <script src="https://ryvconsultores.mx/js/socketSAVI.js?v=1" ></script>
</head>
<body>
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v6.0"></script>
<script>
    @if(Session::has("user"))
        function getChat(tienda){
            $("#chatContent").html("");
            $.post("{{url('/shop/getChat')}}", {
                _token: $('meta[name=csrf-token]').attr('content'),
                tienda:tienda
            })
            .done(function (data) {
                $("#chatContent").append(data);
            })
            .fail(function(xhr, textStatus, errorThrown)
            {
                console.log(xhr.responseText);
            });
        }
    @endif
</script>
<style>
    .dropdown-menu,
    .navbar-default .navbar-nav > .open > a,
    .navbar-default .navbar-nav > .open > a:focus,
    .navbar-default .navbar-nav > .open > a:hover{
        background-color: #151b4f !important;
    }
    .navbar-default {
        background-color: #151b4f;
        border-color: #151b4f !important;
        margin-bottom: 0 !important;
    }
    .btn-action{
        padding: 12px 16px;
        font-size: 15px !important;
    }
    .navbar{
        margin-bottom: 10px;
    }
    body{
        font-family: 'Open Sans', sans-serif;
        font-size: 16px;
    }
    .header ul{
        margin: 0;
        padding: 0;
        list-style-type: none;
    }
    .header li{
        float: left;
        margin: 0 10px;
        font-size: 16px;
        line-height: 22px;
        padding: 15px 0;
    }
    .header li a{
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        width: 100%;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        font-weight: 600;
        white-space: nowrap;
        padding-right: 20px;
        padding-left: 20px;
        cursor: pointer;
        color: #ffffff !important;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: .5px;
        font-family: 'Lato', sans-serif;
    }
    .header li:hover a{
        background: #151b4f;
    }
    .logo{
        padding-left: 12px;
        padding-right: 12px;
    }
    #btnregistro{
        background: #6bd18e;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        justify-content: center;
        color: #fff;
        border-radius: 5px;
        -webkit-transition: background .05s ease-in-out;
        -o-transition: background .05s ease-in-out;
        transition: background .05s ease-in-out;
        line-height: normal;
    }
    .intro, body{
        background: #eeeeee !important;
    }
    .navbar-header{
        width: 17%;
    }
    #fotoppal{
        height: 540px;
        background-size: cover;
        background-position: center;
        background-image: url("https://savi.ryvconsultores.mx/img/shutterstock_526745899.jpg");
    }
    #intro{
        padding-top: 65px;
        padding-bottom: 50px;
        margin-top: -100px;
        z-index: 102;
        background: #fff;
        position: relative;
        text-align: center;
    }
    .h1container{
        width: 66.66667%;
        float: left;
        padding-left: 12px;
        padding-right: 12px;
        margin-left: 16.66667%;
        margin-right: 16.66667%;
        font-weight: 600;
        text-transform: none;
        margin-bottom: 24px;
        margin-top: 0;
        word-wrap: break-word;
    }
    .h1{
        font-size: 32px;
        line-height: 40px;
        font-weight: 600;
        text-transform: none;
        word-wrap: break-word;
        text-rendering: optimizeLegibility;
        font-family: 'Lato', sans-serif;
        display: block;
    }
    .h2container{
        width: 50%;
        padding-left: 12px;
        padding-right: 12px;
        margin-left: 25%;
        margin-right: 25%;

    }
    .h2{
        font-size: 20px;
        line-height: 26px;
        font-family: 'Open Sans', sans-serif;
        font-weight: 400;
        display: block;
    }
    .circle{
        border-radius: 60px;
        border: 3px solid #04adbf;
        width: 70px;
        height: 70px;
        font-size: 39px;
        text-align: center;
        margin: 10px auto;
        color: #04adbf;
    }
    .circle i{
        vertical-align: middle;
    }
    p.h3{
        font-family: 'Josefin Sans', sans-serif;
        font-size: 18px;
        text-transform: uppercase;
    }
    .caja{
        background: #f2f2f2;
        font-weight: bold;
        color:#023859;
        border-radius: 6px;
        margin-bottom: 40px;
        padding: 20px;
        text-align: center;
    }
    .caja i{
        font-size: 90px;
    }
    .caja .title{
        margin-bottom: 15px;
    }
    .stripe{
        padding-top: 80px;
        padding-bottom: 40px;
    }
    .caracteristicas{
        width: 90%;
        margin: 0 auto;
        margin-bottom: 80px
    }
    .caracteristicas .h1{
        font-size: 28px;
    }
    .big-circle{
        width: 235px;
        height: 235px;
        background: white;
        border-radius: 150px;
        font-size: 140px;
        text-align:center
    }
    .big-circle i{
        vertical-align: middle;
    }
    .btn-modulos{
        padding: 11px 24px;
        margin: 22px 0;
        background-color: transparent;
        border: 2px solid #023859;
        font-weight: bold;
    }
    .btn-modulos:hover{
        background: #023859;
        color: white;
    }
    .btn-faq{
        padding: 11px 24px;
        margin: 37px 0;
        background-color: transparent;
        border: 2px solid white;
        font-weight: bold;
    }
    .btn-faq:hover{
        background: white;
        color: #023859;
    }
    .panel-modulos{
        background-color: #fff;
        border-radius: 6px;
        padding: 50px;
        margin-bottom: 40px;
        -webkit-column-count: 2;
        column-count: 2;
        -webkit-column-gap: 24px;
        column-gap: 24px;
        max-width: 996px;
        margin: 0 auto;
    }
    .h4{
        margin-bottom: 24px;
        padding-bottom: 20px;
        border-bottom: 1px solid #023859;
        letter-spacing: 1px;
        font-size: 16px;
        color: #04adbf;
        text-transform: uppercase;
        font-weight: bold;
    }
    .nav i{
        color: #00d37b;
    }
    .widget-shop{
        text-align: center;
        border: 1px solid lightgray;
        border-radius: 5px;
        cursor: pointer;
    }
    .widget-shop a{
        color: grey;
        text-decoration: none;
        font-weight: bold;
    }
    .widget-shop:hover {
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    }
    .widget-shop:hover a{
        color: #1259c3;
    }
    .footershop{
        margin-top:64px;
        text-align: left;
        padding: 16px 10px;
        background: #ffffff;
        border-top: 1px solid #eee;
        border-top-color: rgb(238, 238, 238);
        line-height: 1;
        font-size: 13px;
        font-weight: 400;
    }
    .widget-user .widget-user-username{
        font-family: 'Lato',Sans-Serif;
    }
    .official-stores-slide-item {
        border: 1px solid #eee;
        border-radius: 8px;
        display: inline-block;
        height: 70px;
        margin: 3px;
        overflow: hidden;
        width: 70px;
    }
    .navbar-brand img{
        height: 51px; margin-top: 15px
    }
    @media (max-width: 576px) {
        .navbar-brand img{
            height: 51px; margin-top: 0px
        }
        .navbar-header{
            width: 100%;
        }
    }
    @media (max-width: 768px) {

    }
    @media (max-width: 992px) {

    }
    @media (max-width: 1200px) {

    }
</style>
<nav class="navbar navbar-default navbar-static-top header" style="background: #151b4f !important;">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" style="margin: 0; padding: 0" href="https://savi.ryvconsultores.mx"><img src="https://savi.ryvconsultores.mx/img/logo2.png" alt=""></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="/{!! isset($tienda->clave)? $tienda->clave:'shop' !!}"><i class="fas fa-store"></i>&nbsp; Volver a la tienda</a></li>
                @if(Session::has('user'))
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="far fa-user"></i>&nbsp; {!! Session::get("user")->nombre !!} &nbsp;<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="/shop/compras"><i class="fas fa-shopping-bag"></i>&nbsp; Compras</a></li>
                            <li><a href="/shop/favoritos"><i class="fas fa-heart"></i>&nbsp; Favoritos</a></li>
                            <li><a href="/shop/preguntas"><i class="far fa-question-circle"></i>&nbsp; Preguntas</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="/shop/misdatos"><i class="fas fa-id-card"></i>&nbsp; Mis datos</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="https://savi.ryvconsultores.mx/shop/logout"><i class="fas fa-sign-out-alt"></i>&nbsp; Salir</a></li>
                        </ul>
                    </li>
                    <li><a href="https://savi.ryvconsultores.mx/shop/cart"><i class="fas fa-bell"></i>&nbsp; 0</a></li>
                    <li><a href="https://savi.ryvconsultores.mx/shop/cart"><i class="fas fa-shopping-cart"></i>&nbsp; {!! General::getCartCount() !!}</a></li>
                @else
                    <li><a href="https://savi.ryvconsultores.mx/shop/login"><i class="far fa-user"></i>&nbsp; Inicia Sesión</a></li>
                    <li><a href="https://savi.ryvconsultores.mx/shop/register" id="btnregistro" class="btn btn-success">Regístrate</a></li>
                @endif
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>
@yield('main-content')
<div class="footershop" style="">
    <div class="container">
        <p>Vende con nosotros &nbsp; Términos y condiciones &nbsp; Políticas de privacidad &nbsp; Ayuda</p>
        <p style="color: #999;">Copyright © 2019 R&V Consultores</p>
    </div>
</div>
<div id="chatContent"></div>
<audio id="beep">
    <source src="/audio/pop.mp3" type="audio/mpeg">
    Your browser does not support the audio element.
</audio>
</body>
</html>