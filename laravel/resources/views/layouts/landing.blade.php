<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Consultoria en Tecnologia y Comercio Exterior">
    <meta name="author" content="R&V Consultores">
    <meta property="fb:app_id" content="584357242475888" />
    <meta property="og:title" content="R&V Consultores" />
    <meta property="og:type" content="website" />
    <meta property="og:description" content="Consultoria en Tecnologia y Comercio Exterior" />
    <meta property="og:url" content="https://ryvconsultores.com.mx/" />
    <meta property="og:image" content="https://ryvconsultores.com.mx/img/logoryv.png" />
    <meta property="og:sitename" content="ryvconsultores.com.mx" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="@RVConsultores1" />
    <meta name="twitter:creator" content="@RVConsultores1" />
    <meta name="csrf-token" content="{!! \Illuminate\Support\Facades\Session::token() !!}">
    <title>R&V Consultores</title>
    <link href="https://ryvconsultores.com.mx/img/logoblancoryv.png?v=1" rel="icon" type="image/x-icon" id="dark-scheme-icon"  />
    <link href="https://ryvconsultores.com.mx/img/logoryv.png?v=1" rel="icon" type="image/x-icon" id="light-scheme-icon"  />
    <!-- Bootstrap core CSS -->
    <link href="{{ asset('/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="{{ asset('/css/main.min.css?ver=202011121113') }}" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" rel="stylesheet" type="text/css"
          integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Raleway:400,300,700' rel='stylesheet' type='text/css'>
    <script src="{{ asset('/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
    <script src="{{ asset('/js/smoothscroll.js') }}"></script>
    <script type="application/ld+json">
    {
      "@context": "https://schema.org/",
      "@type": "Organization",
      "name": "R&V Consultores",
      "address": "Gregorio M. Solis 475 Col. Las Margaritas",
      "telephone": "+52 (656) 836-4785",
      "additionalType": "Software, Consultoria en Comercio Exterior",
      "url": "https://ryvconsultores.com.mx/",
      "image": "https://ryvconsultores.com.mx/img/logoryv.png"
    }
    </script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-171521652-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'UA-171521652-1');
        lightSchemeIcon = document.querySelector('link#light-scheme-icon');
        darkSchemeIcon = document.querySelector('link#dark-scheme-icon');
        matcher = window.matchMedia('(prefers-color-scheme: dark)');
        matcher.addListener(onUpdate);
        onUpdate();
        function onUpdate() {
            if (matcher.matches) {
                lightSchemeIcon.remove();
                document.head.append(darkSchemeIcon);
            } else {
                document.head.append(lightSchemeIcon);
                darkSchemeIcon.remove();
            }
        }
    </script>
</head>
<body data-spy="scroll" data-offset="0" data-target="#navigation">
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v5.0"></script>
    <!-- Fixed navbar -->
    <div id="navigation" class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header pull-left">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">
                    <img style="height: 165px" src="https://ryvconsultores.com.mx/img/logoryv.png?v=1">
                </a>
            </div>
            <div class="pull-right col-xs-12 col-sm-8" >
                <div class="row social_networks text-right" style="margin: 12px;">
                    <div class="fb-like" data-href="https://www.facebook.com/ryvconsultoresmx" data-width=""
                         data-layout="button_count" data-action="like" data-size="small" data-share="true"></div>
                </div>
                <div class="row contact_info  text-right" style="margin-top:30px">
                    <div class="col-xs-12"><a href="mailto:info@ryvconsultores.com.mx">
                            <i class="glyphicon glyphicon-envelope"></i> info@ryvconsultores.com.mx
                        </a> |
                        <a href="tel:6568364785">
                            <i class="glyphicon glyphicon-phone-alt"></i> +52 (656) 836-4785
                        </a>
                    </div>
                </div>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="{!! url("/") !!}" class="smoothScroll">Inicio</a></li>
                    @if(count($blog)>0)
                    <li><a href="#blog" class="smoothScroll">Blog</a></li>
                    @endif
                    <li><a href="#productos" class="smoothScroll">Soluciones web</a></li>
                    <li><a href="#servicios" class="smoothScroll">Nuestro servicio</a></li>
                    <li><a href="#clientes" class="smoothScroll">Nuestros clientes</a></li>
                    <li><a href="#contacto" class="smoothScroll">Contacto</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </div>
    <section id="home" name="home"></section>
    <div id="headerwrap">
        <div class="container">
            <div class="row centered">
                <div class="col-lg-12">
                    <h1><b>R&V</b> Consultores</h1>
                    <h3><a href="javascript:void(0)">R&V Consultores</a> agradece su preferencia y confianza
                        que nos dan al permitirnos compartirles nuestros servicios de integración tecnológica.</h3>
                </div>
                <div class="col-lg-2">
                    <h5>Sistema que consolida su información</h5>
                    <p>Con interfaz amigable e intuitiva.</p>
                    <img class="hidden-xs hidden-sm hidden-md" src="{{ asset('/img/arrow1.png') }}">
                </div>
                <div class="col-lg-8">
                    <div class="shadow" id="cf4a">
                        @foreach($screens as $screen)
                            <img class="img-responsive" src="{{ asset('/img/screenshots/'.$screen) }}" alt="">
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-2">
                    <br>
                    <img class="hidden-xs hidden-sm hidden-md" src="{{ asset('/img/arrow2.png') }}">
                    <h5>Acceda a sus datos desde cualquier lugar...</h5>
                    <p>... su base de datos y archivos la nube para administrarlo dentro y fuera de su empresa.</p>
                </div>
            </div>
        </div> <!--/ .container -->
    </div><!--/ #headerwrap -->
    @if(count($blog)>0)
    <section id="blog" name="blog"></section>
    <div style="padding:40px 0 10px 0" id="noticias">
        <div class="container">
            <div class="row centered">
                <div style="margin-bottom: 20px">
                    <div class="col-xs-12" style="text-align: left">
                        <h1>Artículos recientes <a href="{!! url('/blog/index') !!}"><i style="color: #b72f3c; font-size: 26px" class="fas fa-arrow-right"></i></a></h1>
                    </div>
                    @if(count($blog)>1)
                        <div class="col-xs-12 col-sm-6">
                            <article class="first" style="position: relative">
                                <a href="{!! url("/blog/".$blog[0]->id."/".str_slug($blog[0]->titulo)) !!}">
                                    @if($blog[0]->foto2!="")
                                        @php($foto = asset("/blog/".$blog[0]->foto2))
                                        <div style="height: 420px; background: url('{!! $foto !!}'); background-position: center bottom; background-size: cover"></div>
                                        {{--<img class="img-responsive" src="{!! asset("/blog/".$blog[0]->foto2) !!}" style="max-height: 420px; margin: 0 auto">--}}
                                    @else
                                        @php($foto = asset("/blog/".$blog[0]->foto2))
                                        <div style="height: 420px; background: url('{!! $foto !!}'); background-position: center bottom; background-size: cover"></div>
                                        {{--<img class="img-responsive" src="{!! asset("/blog/".$blog[0]->foto) !!}" style="max-height: 420px; margin: 0 auto">--}}
                                    @endif
                                </a>
                                <div class="slide-caption">
                                    <h3><a href="{!! url("/blog/".$blog[0]->id."/".str_slug($blog[0]->titulo)) !!}">{!! $blog[0]->titulo !!}</a>
                                        <span class="slide_by_line">Por {!! $blog[0]->creado_por !!}</span></h3>
                                </div><!-- .slide-caption -->
                            </article>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            @foreach($blog as $i=>$articulo)
                                @if($i>0)
                                    <div class="recent-posts-list-extended-item" style="margin-bottom: 25px">
                                        <div class="row">
                                            <div class="col-xs-3">
                                                <a href="{!! url("/blog/".$articulo->id."/".str_slug($articulo->titulo)) !!}">
                                                    @if($articulo->foto2!="")
                                                        <img src="{!! asset("/blog/".$articulo->foto2) !!}" style="width:100%; max-height: 150px; margin: 0 auto" >
                                                    @else
                                                        <img src="{!! asset("/blog/".$articulo->foto) !!}" style="width:100%; max-height: 150px; margin: 0 auto" >
                                                    @endif
                                                </a>
                                            </div><!-- .recent-posts-list-extended-thumb -->
                                            <div class="col-xs-9">
                                                <h3 class="recent-posts-list-extended-title">
                                                    <a href="{!! url('/blog/') !!}/{!! $articulo->id !!}/{!! str_slug($articulo->titulo) !!}">
                                                        {!! $articulo->titulo !!}</a>
                                                </h3>
                                                <div class="recent-posts-list-extended-meta entry-meta">
                                                    <span class="posted-on"><i class="far fa-calendar-alt"></i> {!! $articulo->created_at !!}</span>
                                                </div>
                                            </div><!-- .recent-posts-list-extended-text-wrap -->
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        @else
                        <div class="col-xs-12">
                            <article class="first">
                                <a href="{!! url("/blog/".$blog[0]->id."/".str_slug($blog[0]->titulo)) !!}">
                                    <img class="img-responsive" src="{!! asset("/blog/".$blog[0]->foto) !!}" style="max-height: 420px; margin: 0 auto"></a>
                                <div class="slide-caption">
                                    <h3><a href="{!! url("/blog/".$blog[0]->id."/".str_slug($blog[0]->titulo)) !!}">{!! $blog[0]->titulo !!}</a>
                                        <span class="slide_by_line">Por R&V Consultores</span></h3>
                                </div><!-- .slide-caption -->
                            </article>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif
    <!-- INTRO WRAP -->
    <section id="productos" name="productos"></section>
    <div id="intro" style="{!!  count($blog)>0? 'padding-top:60px':'' !!}">
        <div class="container sponsored_content">
            <div class="row centered">
                <h1>Soluciones Web según sus necesidades</h1>
                <div class="micarrusel">
                    <div id="contentRow" class="center">
                        @foreach($sistemas as $sistema)
                                <div class="internal">
                                    <a target="_blank" href="{!! $sistema->landing !!}">
                                        <img class="img-responsive" src="https://ryvconsultores.com.mx/img/{!! $sistema->imagen !!}">
                                        <h3>{!! $sistema->nombre !!}</h3>
                                        <div style="width: 85%; height: 36px; margin: 0 auto">
                                            <p style="white-space: pre-line">{!! $sistema->descripcion !!}</p>
                                        </div>
                                    </a>
                                </div>
                        @endforeach
                    </div>
                    <a class="flechas" id="left-button">
                        <i class="fas fa-arrow-alt-circle-left"></i>
                    </a>
                    <a class="flechas" id="right-button">
                        <i class="fas fa-arrow-alt-circle-right"></i>
                    </a>
                </div>
            </div>
        </div> <!--/ .container -->
    </div><!--/ #introwrap -->
    <!-- FEATURES WRAP -->
    <section id="servicios" name="servicios"></section>
    <div id="features">
    <div class="container">
        <div class="row">
            <div  style="margin: 20px" class="col-lg-12 centered">
            <h1 class="centered">Nuestro servicios</h1>
            </div>
            <div class="col-lg-4 centered">
                <img class="centered img-responsive" src="{{ asset('/img/servicios.png') }}" alt="">
            </div>
            <div class="col-lg-6">
                <!-- ACCORDION -->
                <div class=" ac" id="accordion2">
                    <div class="accordion-group">
                        <div class="accordion-heading">
                            <b class="accordion-toggle">
                                Recuperación del Expediente Electrónico de Comercio Exterior
                            </b>
                        </div><!-- /accordion-heading -->
                        <div id="collapseOne" class="accordion-body collapse in">
                            <div class="accordion-inner">
                                <p>Nuestro grupo de especialistas realizaran la recuperación de los expedientes
                                    relacionados a tus operaciones de comercio exterior de fechas anteriores.</p>
                            </div><!-- /accordion-inner -->
                        </div><!-- /collapse -->
                    </div><!-- /accordion-group -->
                    <div class="accordion-group">
                        <div class="accordion-heading">
                            <b class="accordion-toggle">
                                Auditoria preventiva de saldos en el Anexo 24 y 31
                            </b>
                        </div>
                        <div id="collapseFour" class="accordion-body collapse in">
                            <div class="accordion-inner">
                                <p>Utilizando nuestras herramientas tecnológicas te ofrecemos el servicio de auditoria
                                    preventiva de saldos, el cual entrega un dictamen como resultado de la revisión que
                                    nuestros especialistas realicen a su información.</p>
                            </div><!-- /accordion-inner -->
                        </div><!-- /collapse -->
                    </div><!-- /accordion-group -->
                    <div class="accordion-group">
                        <div class="accordion-heading">
                            <b class="accordion-toggle">
                                Consultoría de Comercio Exterior
                            </b>
                        </div>
                        <div id="collapseTwo" class="accordion-body collapse in">
                            <div class="accordion-inner">
                                <p>Especialistas en el área de comercio exterior, ofrecemos asistencia en el
                                    cumplimiento de sus obligaciones fiscales y legales en materia de aduanas.</p>
                            </div><!-- /accordion-inner -->
                        </div><!-- /collapse -->
                    </div><!-- /accordion-group -->
                </div><!-- Accordion -->
                <!-- ACCORDION -->
                <div class=" ac" id="accordion2">
                    <div class="accordion-group">
                        <div class="accordion-heading">
                            <b class="accordion-toggle">
                                Revisión de cumplimiento de operaciones por fracciones arancelarias
                            </b>
                        </div>
                        <div id="collapseFour" class="accordion-body collapse in">
                            <div class="accordion-inner">
                                <p>Nuestros especialistas podrán generar un reporte con sus comentarios de cumplimiento
                                    para tus operaciones de importación y exportación.</p>
                            </div><!-- /accordion-inner -->
                        </div><!-- /collapse -->
                    </div><!-- /accordion-group -->
                    <div class="accordion-group">
                        <div class="accordion-heading">
                            <b class="accordion-toggle">
                                Soporte técnico de nuestros sistemas
                            </b>
                        </div>
                        <div id="collapseThree" class="accordion-body collapse in">
                            <div class="accordion-inner">
                                <p>Con nuestros servicios de Soporte Técnico le ayudamos a solucionar de forma
                                    integral sus dudas o problemas referentes a nuestros sistemas.</p>
                            </div><!-- /accordion-inner -->
                        </div><!-- /collapse -->
                    </div><!-- /accordion-group -->
                </div><!-- Accordion -->
            </div>
        </div>
    </div><!--/ .container -->
        <!-- INTRO WRAP -->
        <section id="productos" name="productos"></section>

</div><!--/ #features -->
    <div id="actualizaciones" style="{!!  count($blog)>0? 'padding-top:100px':'' !!}; padding: 10px 15px 0 15px;
            border-top: 1px solid #bdc3c7;
            border-bottom: 1px solid #bdc3c7;
            background-color: #ecf0f1;">
        <div class="container">
            <div class="row centered">
                <div class="col-lg-8">
                    <h1>Ultimas actualizaciones en nuestros sistemas</h1>
                    <br>
                    <div style="overflow: auto; height: 425px; text-align: left">
                @foreach(General::noticias(4) as $noticia)
                    <div class="accordion-group">
                        <div class="accordion-heading">
                            <small>&bull; Actualización: {!! $noticia->created_at !!}</small><br>
                            <b class="accordion-toggle">
                                {!! $noticia->titulo !!}
                            </b>
                        </div><!-- /accordion-heading -->
                        <div id="collapseOne" class="accordion-body collapse in">
                            <div class="accordion-inner">
                                <p>{!! $noticia->texto !!}</p>
                            </div><!-- /accordion-inner -->
                        </div><!-- /collapse -->
                    </div><!-- /accordion-group -->
                @endforeach
                    </div>
                </div>
                <div class="col-lg-4 centered">
                    <img style="margin-top: 10px; margin-bottom: 10px" class="centered" src="{{ asset('/img/noticias.png') }}" alt="">
                </div>
            </div>
        </div> <!--/ .container -->
    </div><!--/ #introwrap -->
    <section id="clientes" name="clientes"></section>
    <div id="showcase"  class="mifondo">
    <div class="container">
        <div class="row">
            <h1 class="centered">Nuestros clientes</h1>
            <br>
            <div class="col-lg-8 col-lg-offset-2">
                <div id="carousel-example-generic" class="carousel slide">
                    <ol class="carousel-indicators">
                        <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                        <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                    </ol>
                    <div class="carousel-inner">
                        <div class="item active">
                            <a href="https://www.facebook.com/" target="_blank">
                                <img class="img-circle logo-circle" src="{{ asset('/img/clientes/guma2.svg') }}" alt="">
                            </a>
                            <a href="https://www.facebook.com/" target="_blank">
                                <img class="img-circle logo-circle" src="{{ asset('/img/clientes/cristal.png') }}" alt="">
                            </a>
                            <a href="https://www.facebook.com/lreytol.df/" target="_blank">
                                <img class="img-circle logo-circle" src="{{ asset('/img/clientes/reytol2.png') }}" alt="">
                            </a>
                        </div>
                        <div class="item">
                            <a href="https://www.facebook.com/Clamatos-La-Resaca-1746512622331100/" target="_blank">
                                <img class="img-circle logo-circle" src="{{ asset('/img/clientes/laresaca.jpg') }}" alt="">
                            </a>
                            <a href="https://www.facebook.com/Lola-pop-343780519317917/" target="_blank">
                                <img class="img-circle logo-circle" src="{{ asset('/img/clientes/lolapop.jpg') }}" alt="">
                            </a>
                            <a href="https://www.facebook.com/" target="_blank">
                                <img class="img-circle logo-circle" src="{{ asset('/img/clientes/eryad.svg') }}" alt="">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <br>
        <br>
    </div>
    </div>
    <section id="contacto" name="contacto"></section>
    <div id="footerwrap">
        <div class="row" style="margin: 0">
            <div class="container">
                <div class="col-lg-8">
                    <h3>Contáctenos</h3>
                    <br>
                    <form role="form" action="/" method="post">
                        <div class="form-group">
                            <label for="name1">Su nombre</label>
                            <input type="text" name="Name" class="form-control" id="name1" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="email1">Correo electronico</label>
                            <input type="email" name="Mail" class="form-control" id="email1" placeholder="">
                        </div>
                        <div class="form-group">
                            <label>Su mensaje</label>
                            <textarea class="form-control" name="Message" id="mensaje1" rows="3"></textarea>
                        </div>
                        <br>
                        <a href="javascript:void(0)" onclick="enviarMensaje(this)" class="btn btn-large btn-success">ENVIAR</a>
                    </form>
                </div>
                <div class="col-lg-4">
                    <div class="fb-page" data-href="https://www.facebook.com/ryvconsultoresmx/" data-tabs="timeline"
                         data-width="" data-height="" data-small-header="false" data-adapt-container-width="true"
                         data-hide-cover="false" data-show-facepile="true">
                        <blockquote cite="https://www.facebook.com/ryvconsultoresmx/" class="fb-xfbml-parse-ignore">
                            <a href="https://www.facebook.com/ryvconsultoresmx/">R&amp;V Consultores</a>
                        </blockquote>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="c">
        <div class="container">
            <p>
                <strong><a href="javascript:void(0)">R&V Consultores</a> es una marca registrada. © 2019 </strong>
            </p>
        </div>
    </div>
    <div class="social">
        <ul>
            <li><a title="Facebook: ryvconsultoresmx" href="https://www.facebook.com/ryvconsultoresmx" target="_blank" class="btn btn-social-icon btn-facebook"><i class="fab fa-facebook-f"></i></a></li>
            <li><a title="Twitter: @RVConsultores1" href="https://www.twitter.com/rvconsultores1" target="_blank" class="btn btn-social-icon btn-twitter"><i class="fab fa-twitter"></i></a></li>
            <li><a title="Linkedin: ryvconsultoresmx" href="https://www.linkedin.com/company/ryvconsultoresmx" target="_blank"  class="btn btn-social-icon btn-linkedin"><i class="fab fa-linkedin-in"></i></a></li>
            <li><a title="Instagram: ryvconsultoresmx" class="btn btn-social-icon btn-instagram"  href="https://www.instagram.com/ryvconsultoresmx" target="_blank"><i class="fab fa-instagram"></i></a></li>
        </ul>
    </div>
    <a class="ir-arriba"  href="javascript:void(0)" title="Volver arriba">
      <span class="fa-stack">
        <i class="fa fa-circle fa-stack-2x"></i>
        <i class="fa fa-arrow-up fa-stack-1x fa-inverse"></i>
      </span>
    </a>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="{{ asset('/js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script>
        $('.carousel').carousel({
            interval: 4000
        });
        $(document).ready(function(){ //Hacia arriba
            irArriba();
        });

        function irArriba(){
            $('.ir-arriba').click(function(){ $('body,html').animate({ scrollTop:'0px' },1000); });
            $(window).scroll(function(){
                if($(this).scrollTop() > 0){ $('.ir-arriba').slideDown(600); }else{ $('.ir-arriba').slideUp(600); }
            });
            $('.ir-abajo').click(function(){ $('body,html').animate({ scrollTop:'1000px' },1000); });
        }
        function enviarMensaje(){
            $.post("{{url('/enviarMensaje')}}", {
                _token: $('meta[name=csrf-token]').attr('content'),
                Name:$("#name1").val(),
                Mail:$("#email1").val(),
                Message:$("#mensaje1").val()
            })
            .done(function () {
                alert("Mensaje enviado con exito, pronto le contestaremos");
                $("#name1").val("");
                $("#email1").val("");
                $("#mensaje1").val("");
            })
            .fail(function(xhr)
            {
                console.log(xhr.responseText);
            });
        }
        $('#right-button').click(function(event) {
            event.preventDefault();
            $('#contentRow').animate({
                scrollLeft: "+=300px"
            }, "slow");
        });

        $('#left-button').click(function(event) {
            event.preventDefault();
            $('#contentRow').animate({
                scrollLeft: "-=300px"
            }, "slow");
        });
    </script>
    <style>
    .social {
        position: fixed; /* Hacemos que la posición en pantalla sea fija para que siempre se muestre en pantalla*/
        left: 0; /* Establecemos la barra en la izquierda */
        top: 200px; /* Bajamos la barra 200px de arriba a abajo */
        z-index: 2000; /* Utilizamos la propiedad z-index para que no se superponga algún otro elemento como sliders, galerías, etc */
    }

    .social ul {
        list-style: none;
        padding: 0;
    }
    .btn-facebook {background:#3b5998;} /* Establecemos los colores de cada red social, aprovechando su class */
    .btn-twitter {background: #00abf0;}
    .btn-instagram {background: #666666;}
    .btn-linkedin{background: #1f85c7;}
    .social ul li a {
        min-width: 60px;
        border-radius: 0;
        display: inline-block;
        color:#fff;
        font-size: 25px;
        padding: 10px 15px;
        text-decoration: none;
        -webkit-transition:all 500ms ease;
        -o-transition:all 500ms ease;
        transition:all 500ms ease; /* Establecemos una transición a todas las propiedades */
    }

    .social ul li a:hover {
        background: #0e3363; /* Cambiamos el fondo cuando el usuario pase el mouse */
        color: #fff;
        padding: 10px 30px; /* Hacemos mas grande el espacio cuando el usuario pase el mouse */
    }
    .carousel-indicators{
        bottom: -40px;
    }

    #headerwrap{
        background: url('/img/back.jpg');
        background-size: cover;
        background-position: center -125px;
        padding-top: 33px;
    }
     .mifondo{
        background: url('/img/back.jpg');
        background-size: cover;
        background-position: center -515px;
    }


    @keyframes cf4FadeInOut {
        0% {
            opacity:1;
        }
        17% {
            opacity:1;
        }
        25% {
            opacity:0;
        }
        92% {
            opacity:0;
        }
        100% {
            opacity:1;
        }
    }

    #cf4a img {
        -webkit-animation-name: cf4FadeInOut;
        -webkit-animation-timing-function: ease-in-out;
        -webkit-animation-iteration-count: infinite;
        -webkit-animation-duration: 8s;

        -moz-animation-name: cf4FadeInOut;
        -moz-animation-timing-function: ease-in-out;
        -moz-animation-iteration-count: infinite;
        -moz-animation-duration: 8s;

        -o-animation-name: cf4FadeInOut;
        -o-animation-timing-function: ease-in-out;
        -o-animation-iteration-count: infinite;
        -o-animation-duration: 8s;

        animation-name: cf4FadeInOut;
        animation-timing-function: ease-in-out;
        animation-iteration-count: infinite;
        animation-duration: 8s;
    }
    #cf4a {
        position:relative;
        height:299px;
        width:745px;
        margin:0 auto;
        overflow: hidden;
    }
    #cf4a img {
        position:absolute;
        left:0;
    }
    #cf4a img:nth-of-type(1) {
        -webkit-animation-delay: 6s;
        -moz-animation-delay: 6s;
        -o-animation-delay: 6s;
        animation-delay: 6s;
    }
    #cf4a img:nth-of-type(2) {
        -webkit-animation-delay: 4s;
        -moz-animation-delay: 4s;
        -o-animation-delay: 4s;
        animation-delay: 4s;
    }
    #cf4a img:nth-of-type(3) {
        -webkit-animation-delay: 2s;
        -moz-animation-delay: 2s;
        -o-animation-delay: 2s;
        animation-delay: 2s;
    }
    #cf4a img:nth-of-type(4) {
        -webkit-animation-delay: 0s;
        -moz-animation-delay: 0s;
        -o-animation-delay: 0s;
        animation-delay: 0s;
    }
    .logo-circle {
        height: 210px !important;
        width: 210px;
        vertical-align: text-bottom;
        border: 5px solid white;
        box-shadow: inset 0 2px 3px 0 rgba(0, 0, 0, .15), 0 3px 3px 0 rgba(0, 0, 0, .15);
        position: relative;
        background: white;
    }
    .item a{
        display: inline-block;
        margin: 15px;
    }
</style>
</body>
</html>
