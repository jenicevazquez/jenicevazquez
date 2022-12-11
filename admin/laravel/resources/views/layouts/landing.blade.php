<!doctype html>
<html lang="es">
<head>
    <meta charSet="utf-8"/>
    <meta name="description" content="La aplicación SAVI es un sistema punto de venta que te ayuda a vender mejor,
    donde sea y cuando quieras."/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>SAVI | Tu punto de venta</title>
    <link rel="stylesheet" href="{{ asset('/css/bootstrap.min.css') }}">
    <link href="{{ asset('/img/cajaregistradora.png') }}" rel="icon" type="image/x-icon"  />
    <link href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" rel="stylesheet" type="text/css"
          integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans:700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-159062939-2"></script>
    @include("layouts.partials.scripts")
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-159062939-2');
    </script>

</head>
<body>
<style>
    body{
        font-family: 'Open Sans', sans-serif;
        font-size: 16px;
    }
    .navbar{
        margin-bottom: 10px;
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
        color: #283663;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: .5px;
        font-family: 'Josefin Sans', sans-serif;
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
        font-family: 'Josefin Sans', sans-serif;
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
        border: 3px solid #229edb;
        width: 70px;
        height: 70px;
        font-size: 39px;
        text-align: center;
        margin: 10px auto;
        color: #229edb;
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
        color: #229edb;
        text-transform: uppercase;
        font-weight: bold;
    }
    .nav i{
        color: #229edb;
    }
</style>
<div id="site">
    <div class="YVXKZ">
        <div class="header">
            <div class="container">
                <nav class="navbar navbar-default navbar-static-top header" style="background:#ffffff; border: none; box-shadow: none">
                    <div class="container">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <img style="height: 70px; margin-top: 10px" src="https://savi.ryvconsultores.mx/img/logoactual.png" alt="">
                        </div>
                        <div id="navbar" class="navbar-collapse collapse">
                            <ul class="nav navbar-nav navbar-right">
                                <!--<li><a href="/shop"><i class="fas fa-store"></i>&nbsp; Ver tiendas</a></li>-->
                                    <li><a href="https://savi.ryvconsultores.mx/login"><i class="far fa-user"></i>&nbsp; Acceso clientes</a></li>
                            </ul>
                        </div><!--/.nav-collapse -->
                    </div>
                </nav>
            </div>
            <div id="fotoppal"></div>
            <div id="intro" class="container">
                <div class="h1container" style="border-bottom: 2px solid #229edb">
                    <span class="h1">SAVI, el punto de venta más completo</span>
                </div>
                <div class="h2container">
                    <span class="h2">Un sistema web que te ayudarán a vender más y crecer tu negocio.</span>
                </div>
            </div>
            <div style="background: white">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6">
                            <figure class="">
                                <div>
                                    <img src="https://savi.ryvconsultores.mx/img/responsive.jpg"
                                         alt="incrementa tus ingresos y crecer tu negocio" class="img-responsive" >
                                </div>
                            </figure>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <article class="">
                                <div class="_2O5Ed" >
                                    <h1>
                                    <span>
                                        <span class="h1">Vende desde tu computadora, tablet o celular</span>
                                    </span>
                                    </h1>
                                </div>
                                <div class="_2O5Ed" >
                                    <p>SAVI es el punto de venta te ayuda de forma sencilla a vender.
                                        Desde llevar a cabo una venta con un el modulo de caja y un catálogo de productos práctico,
                                        hasta administrar tu inventario por sucursal con entradas y salidas de mercancia. La
                                        aplicación web SAVI lo simplifica todo para que puedas dedicarte a vender, vender y vender.
                                    </p>
                                </div>
                            </article>
                        </div>
                    </div>
                    <div class="row" style="padding-top: 40px; padding-bottom: 80px; text-align: center">
                        <div class="col-xs-12 col-sm-3">
                            <div class="circle">
                                <i class="far fa-smile-wink"></i>
                            </div>
                            <p class="h3">INTERFAZ AMIGABLE</p>
                            <p>
                                Comienza y crea tu tienda en nuestra aplicación SAVI de manera
                                fácil y rápida.
                            </p>
                        </div>
                        <div class="col-xs-12 col-sm-3">
                            <div class="circle">
                                <i class="fas fa-globe"></i>
                            </div>
                            <p class="h3">ACCESIBILIDAD WEB</p>
                            <p>
                                SAVI es una plataforma que te permite accesarlo donde sea y cuando quieras
                                ya que es web y puedes usarlo desde tu computadora, celular o tablet.
                            </p>
                        </div>
                        <div class="col-xs-12 col-sm-3">
                            <div class="circle">
                                <i class="far fa-credit-card"></i>
                            </div>
                            <p class="h3">ADMINISTRACION DE CREDITOS A CLIENTES</p>
                            <p>
                                Administra apartados y notas de credito, asi como precios especiales para tus mejores clientes.
                            </p>
                        </div>
                        <div class="col-xs-12 col-sm-3">
                            <div class="circle">
                                <i class="far fa-file-alt"></i>
                            </div>
                            <p class="h3">INFORMACION INTEGRADA</p>
                            <p>Crea tu catálogo fácilmente, controla tu inventario y obtén reportes detallados de tus
                                ventas, todo desde una misma aplicación.</p>
                        </div>
                    </div>
                    <div class="row caracteristicas">
                        <div class="col-xs-12">
                            <div class="col-xs-12 col-sm-6">
                                <img src="/img/vender-online.jpg" class="img-responsive">
                            </div>
                            <div class="col-xs-12 col-sm-6">
                                <div class="h1">Crea tu catálogo de productos</div>
                                <p>
                                    El catálogo de productos es el modulo inicial para administrar tu tienda y
                                    gracias al modulo de caja resulta fácil e intuitivo registrar las ventas;
                                    además, tendrás toda tu información registrada que posteriormente te servirán
                                    para valorar cómo va tu negocio.
                                </p>

                            </div>
                        </div>
                    </div>
                    <div class="row caracteristicas">
                        <div class="col-xs-12">
                        <div class="col-xs-12 col-sm-6">
                            <div class="h1">Compatibilidad con cajón, impresora termica y escaner de preferencia</div>
                            <p>
                                Por ser una herramienta web no requiere de ninguna instalación, además la plataforma
                                funciona con cualquier cajón, impresora térmica y scanner de preferencia del usuario.
                            </p>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <img class="img-responsive" src="/img/herramientas-vender-online-blog.png">
                        </div>
                    </div>
                    </div>
                    <div class="row caracteristicas">
                        <div class="col-xs-12">
                        <div class="col-xs-12 col-sm-6">
                            <img class="img-responsive" src="/img/Mult_Sucursal.jpg.png">
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <div class="h1">Multi-sucursal</div>
                            <p>
                                La herramienta permite el control de una o varias sucursales, el
                                usuario podrá el traspaso de las mercancias entre sucursales,
                                administrar ventas, inventarios y promociones por sucursal.
                            </p>
                        </div>

                    </div>
                    </div>
                </div>
                <div class="stripe" style="background: #024873; color: white; text-align: center;">
                    <div class="container">
                        <div style="margin-bottom: 80px" class="col-xs-12">
                        <div class="h1">Lleva tu negocio al siguiente nivel <i class="fas fa-check" style="color: #b9bf04"></i></div>
                        <p>
                            Sabemos que te esfuerzas día a día en tu negocio para brindar el mejor servicio.
                            La aplicación web SAVI punto de venta te ayuda en tu negocio y
                            te mantiene al tanto de lo que sucede detrás de la caja registradora.
                        </p>
                    </div>
                    </div>
                </div>
                <div class="stripe" style="background: #023859; color: white; text-align: center">
                    <div class="container">
                        <div class="col-xs-12" style="margin-top: -160px; text-align: left">
                            <div class="col-xs-12 col-sm-3">
                                <div class="caja">
                                    <div class="title">REPORTES</div>
                                    <i class="fas fa-chart-bar"></i>
                                </div>
                                <p class="h3">Analiza tu negocio cada día</p>
                                <p>
                                    Con nuestros reportes sencillos y fáciles de entender,
                                    sabrás cómo va tu negocio día a día.
                                </p>
                            </div>
                            <div class="col-xs-12 col-sm-3">
                                <div class="caja">
                                    <div class="title">INVENTARIO</div>
                                    <i class="fas fa-boxes"></i>
                                </div>
                                <p class="h3">Administración de inventarios</p>
                                <p>
                                    Administra tus existencias desde el modulo de Inventario.
                                    La lista de productos en tu inventario te proporciona información de lo
                                    que tienes en existencias y te notifica cuando tienes menos del minimo que estableciste
                                    que debias tener para que puedas ordenar más.
                                </p>
                            </div>
                            <div class="col-xs-12 col-sm-3">
                                <div class="caja">
                                    <div class="title">TICKETS</div>
                                    <i class="fas fa-receipt"></i>
                                </div>
                                <p class="h3">Localiza todos los tickets fácilmente</p>
                                <p>
                                    Si necesitas duplicados de tickets antiguos, te resultará útil tenerlos
                                    en el modulo de ventas.
                                    Los tickets puedes buscarlos fácilmente por número de folio.
                                </p>
                            </div>
                            <div class="col-xs-12 col-sm-3">
                                <div class="caja">
                                    <div class="title">USUARIOS</div>
                                    <i class="fas fa-user-lock"></i>
                                </div>
                                <p class="h3">Usuarios y permisos</p>
                                <p>
                                    Cada uno de tus empleados puede tener su propio usuario y les podrás asignar
                                    individualmente a que tienen permiso y a que no.
                                    Así podrás controlar lo que pueden ver y hacer cada uno sin que
                                    se vean confundidos con modulos o botones que no usarán.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="stripe" style="text-align: center; background: #5bcbe3">
                    <div class="container">
                        <span class="h1">La información que necesitas al tomar decisiones para tu negocio</span>
                        <span class="h2">
                                Tu portal en savi.ryvconsultores.mx ofrece funciones completas que te ayudarán a crecer tu
                                negocio. Con la aplicacion web con interfaz amigable podrás controlar cada producto vendido,
                                y tener todos los datos necesarios para tomar las mejores decisiones y mantener
                                el crecimiento constante de tu negocio.
                            </span>
                        <img style="margin: 0 auto;margin-top: 18px;position: relative;top: 60px;" src="/img/dashboard-para-ecommerce-1.jpg" class="img-responsive" alt="">
                    </div>
                </div>
                <div class="stripe" style="background:#f2f2f2; text-align: center">
                    <div class="container">
                        <span class="h1">Controla y analiza tus ventas</span>
                        <span class="h2">
                               Los prácticos reportes te ayudan a hacer crecer tu negocio gracias a la información
                                que el sistema te dará de cada venta realizada y cada producto vendido.
                                Gracias a ellos, podrás comprobar lo que funciona y lo que no, sin que te abrumen los datos.
                        </span>
                        <div class="col-xs-12">
                            <div class="col-xs-12 col-sm-3">
                                <div class="big-circle">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                                <p class="h3">Identifica tendencias</p>
                                <p>Conocer mejor las temporadas altas y bajas o incluso las horas de más actividad,
                                    te ayuda a planificar con eficacia. Identifica esas tendencias gracias a las
                                    herramientas y los informes personalizados disponibles y utiliza esos datos para
                                    tomar decisiones sobre temas como presupuesto o inventarios.</p>
                            </div>
                            <div class="col-xs-12 col-sm-3">
                                <div class="big-circle">
                                    <i class="fas fa-calculator"></i>
                                </div>
                                <p class="h3">Lleva la contabilidad</p>
                                <p>Cuando llega la hora de hacer la contabilidad, es fácil exportar todos los datos de
                                    las ventas. Cada transacción e ingreso se registra automáticamente,
                                    por lo que sólo tienes que generar los reportes que necesites.
                                </p>
                            </div>
                            <div class="col-xs-12 col-sm-3">
                                <div class="big-circle">
                                    <i class="fas fa-user-friends"></i>
                                </div>
                                <p class="h3">Controla las ventas de tu equipo</p>
                                <p>Si creas un usuario para cada uno de tus empleados,
                                    podrás comprobar cuánto venden por separado y en conjunto.
                                </p>
                            </div>
                            <div class="col-xs-12 col-sm-3">
                                <div class="big-circle">
                                    <i class="fas fa-file-import"></i>
                                </div>
                                <p class="h3">Importa o exporta tu catalogo de productos</p>
                                <p>Cuando vayas ampliando tu negocio, añade nuevos productos al catálogo con un par de clics.
                                    Puedes incorporar varios productos a la vez mediante
                                    un archivo de Excel. De forma automática.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="stripe" style="background:#b9bf04; text-align: center; color: #023859; padding-bottom: 80px">
                    <div class="container">
                        <div style="width: 80%; margin:0 auto">
                            <span class="h1">Todas las funcionalidades que necesitas en el mismo sistema</span>
                            <span class="h2" style="margin-bottom: 60px">
                                    Familiarízate rápidamente con las completas y potentes funciones que ofrecemos de
                                en nuestra aplicación punto de venta web.
                            </span>
                            <button class="btn btn-transparent btn-modulos">Mostrar todos los módulos</button>
                        </div>
                        <div style="padding:40px">
                            <div class="panel-modulos">
                                <div class="col-xs-12 col-sm-6">
                                    CATÁLOGO DE PRODUCTOS

                                    Imágenes de los productos
                                    Productos organizados en carpetas
                                    Búsqueda rápida de productos en el catálogo, aunque sea grande
                                    Descuentos personalizados para ciertos artículos o para todo lo que haya en el carrito
                                    Variantes de productos
                                    Posibilidad de escanear códigos de barras (solo en iOS)
                                    Precio por unidad, kilo, hora o cualquier otra unidad de medida
                                    Importación/exportación de los datos de los productos desde Excel
                                    Acceso directo a descuentos
                                </div>
                                <div class="col-xs-12 col-sm-6">
                                    CATÁLOGO DE PRODUCTOS

                                    Imágenes de los productos
                                    Productos organizados en carpetas
                                    Búsqueda rápida de productos en el catálogo, aunque sea grande
                                    Descuentos personalizados para ciertos artículos o para todo lo que haya en el carrito
                                    Variantes de productos
                                    Posibilidad de escanear códigos de barras (solo en iOS)
                                    Precio por unidad, kilo, hora o cualquier otra unidad de medida
                                    Importación/exportación de los datos de los productos desde Excel
                                    Acceso directo a descuentos
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="stripe" style="background:#f2f2f2; text-align: center">
                    <div class="container">
                        <div class="col-xs-12 col-sm-8">
                            <div class="caja" style="background: white; color: #023859; text-align: left; padding: 48px">
                                <img src="/img/ecommerce2-1.png" class="img-responsive">
                                <span class="h1">¡Vende como los expertos!</span>
                                <p style="font-weight: normal">
                                Tu portal en savi.ryvconsultores.mx ofrece funciones completas que te ayudarán a crecer tu
                                negocio. Con la aplicacion web con interfaz amigable podrás controlar cada producto vendido,
                                y tener todos los datos necesarios para tomar las mejores decisiones y mantener
                                el crecimiento constante de tu negocio.
                                </p>
                                <button class="btn btn-transparent btn-modulos">Agenda tu demo personalizado</button>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4">
                            <div class="caja" style="background: #023859; color: white; text-align: left; padding: 48px">
                                <span class="h1">Estamos para ayudarte </span>
                                <p style="font-weight: normal">
                                Sabemos que emprender un negocio puede plantear muchas dudas y aun mas al sistematizarlo.
                                Por eso te ayudamos con preguntas frecuentes detalladas que explican nuestro servicio,
                                además de poner a tu disposición un departamento de atención al cliente que puede
                                contestar tus preguntas específicas por teléfono o por correo electrónico.
                                </p>
                                <button class="btn btn-transparent btn-faq">Preguntas frecuentes</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="footer stripe" style="background: #024873; color: white;">
                    <div class="container">
                        <div class="col-xs-12">
                            <div class="col-xs-12 col-sm-4">
                                <p class="h4">ACERCA DE R&V CONSULTORES</p>
                                <p>
                                    Sobre nosotros<br>
                                    Contacto<br>
                                    Seguridad<br>
                                    Prensa<br>
                                    Política de privacidad<br>
                                    Derechos<br>
                                    Información legal
                                </p>
                            </div>
                            <div class="col-xs-12 col-sm-4">
                                <p class="h4">TRABAJA EN R&V CONSULTORES</p>
                                <p>
                                    Empleos<br>
                                    Developer<br>
                                    Únete a nuestro equipo de vendedores y gana comisiones
                                </p>
                            </div>
                            <div class="col-xs-12 col-sm-4">
                                <p class="h4">EXTRAS</p>
                                <p>
                                    ¿Necesitas una emitir facturas desde SAVI? haz clic aquí.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="background: #023859; color:  #024873; text-align: left; padding-top: 40px; padding-right: 92px; padding-left: 92px; padding-bottom: 10px">
                    <div class="container">
                        Copyright © 2019 SAVI México
                    </div>
                </div></div>
            </div>
        </div>
    </div>
</div>
</body>