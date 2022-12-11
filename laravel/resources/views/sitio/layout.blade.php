<!DOCTYPE html>
<html class="no-js" lang="en">
<head>

    <meta charset="utf-8">
    <title>@yield('web-title','Desarrollo web | Jenice Vazquez')</title>
    <meta name="description" content="">
    <meta name="author" content="">

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <link rel="stylesheet" href="/css/sitio/base.css?v={!! General::getFilem('/css/sitio/base.css') !!}" />

    <script src="/js/sitio/modernizr.js"></script><script>eval(mod_pagespeed_F_5s4xpU58);</script>
    <script>eval(mod_pagespeed_6uAVvYLEkz);</script>

    <link href="/images/favicon.png" rel="shortcut icon" type="image/png"  />
    <link rel="icon" type="image/png" href="/images/favicon.png">
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-3BJ89KXVW6');
    </script>
</head>
<body id="top">

<section class="s-pageheader s-pageheader--home">

    <header class="header">
        <div class="header__content row">

            <div class="header__logo">
                <a class="logo" href="/">
                    <img src="/img/sitio/jenice.png" alt="Jenice Vazquez">
                </a>
            </div>
            <ul class="header__social">
                <li>
                    <a target="_blank" href="https://www.linkedin.com/in/jenice-vazquez-354892111/"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
                </li>
                <li>
                    <a target="_blank" href="https://www.facebook.com/codigojenice"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                </li>
                <li>
                    <a target="_blank" href="https://twitter.com/GoJenice"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                </li>
                <li>
                    <a target="_blank" href="https://www.instagram.com/vjenice/"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                </li>
                <li>
                    <a target="_blank" href="https://www.youtube.com/channel/UCiN249Ek1Q0qzsrlATror3Q"><i class="fa fa-youtube" aria-hidden="true"></i></a>
                </li>
                <li>
                    <a target="_blank" href="https://www.twitch.tv/gojenice"><i class="fa fa-twitch" aria-hidden="true"></i></a>
                </li>
            </ul>
            <a class="header__search-trigger" href="javascript:void(0)"></a>
            <div class="header__search">
                <form role="search" class="header__search-form" action="/">
                    <label>
                        <span class="hide-content">Buscar:</span>
                        <input type="search" class="search-field" placeholder="Escribe tus palabras" value="" name="s" title="Buscar por:" autocomplete="off">
                    </label>
                    <input type="submit" class="search-submit" value="Search">
                </form>
                <a href="javascript:void(0)" title="Close Search" class="header__overlay-close">Cerrar</a>
            </div>
            <a class="header__toggle-menu" href="javascript:void(0)" title="Menu"><span>Menu</span></a>
            <nav class="header__nav-wrap">
                <h2 class="header__nav-heading h6">Navegacion del sitio</h2>
                <ul class="header__nav">
                    <li class="current"><a href="/" title="">Inicio</a></li>
                    <li class="has-children">
                        <a href="javascript:void(0)" title="">Categorias</a>
                        <ul class="sub-menu">
                            <li><a href="/blog/cat/programacion">Programacion</a></li>
                            <li><a href="/blog/cat/emprendimiento">Emprendimiento</a></li>
                            <li><a href="/blog/cat/tecnologia">Tecnologia</a></li>
                            <li><a href="/blog/cat/videojuegos">Videojuegos</a></li>
                            <li><a href="/blog/cat/lifestyle">Lifestyle</a></li>

                        </ul>
                    </li>
                    <li class="has-children">
                        <a href="javascript:void(0)" title="">Blog</a>
                        <ul class="sub-menu">
                            <li><a href="/blog/tipo/video">Video Posts</a></li>
                            <li><a href="/blog/tipo/audio">Audio Posts</a></li>
                            <li><a href="/blog/tipo/gallery">Galeria Posts</a></li>
                            <li><a href="/blog/tipo/standard">Standard Posts</a></li>
                        </ul>
                    </li>
                    <li class="has-children">
                        <a href="/cursos" title="">Desarrollo web</a>
                        <ul class="sub-menu">
                            <li><a href="/html">HTML y CSS con Bootstrap</a></li>
                            <li><a href="/javascript">Javascript con Jquery</a></li>
                            <li><a href="/php">PHP con Laravel</a></li>
                        </ul>
                    </li>
                    <li><a href="/projects" title="">Proyectos</a></li>
                    <li><a href="/about" title="">Acerca de</a></li>
                    <li><a href="/contact" title="">Contacto</a></li>
                </ul>
                <a href="#0" title="Close Menu" class="header__overlay-close close-mobile-menu">Close</a>
            </nav>
        </div>
        <div style="margin-top: 10px;background: yellow;" class="alert alert-warning" role="alert">
            <b>Aún en construccion - </b> Bienvenidos, sitio aun en construcción, disculpe la molestia. Buen día!
        </div>
    </header>
    @yield('header-content')
</section>


    @yield('main-content')


<section class="s-extra">
    <div class="row top">
        <div class="col-eight md-six tab-full popular">
            <h3>Articulos populares</h3>
            <div class="block-1-2 block-m-full popular__posts">
                @foreach(General::getPopulares() as $popular)
                <article class="col-block popular__post">
                    <a href="/blog/{!! $popular->id !!}/{!! $popular->slug !!}" class="popular__thumb">
                        <img src="{!! $popular->imagen !!}" alt="" data-pagespeed-url-hash="1559777111" onload="pagespeed.CriticalImages.checkImageForCriticality(this);">
                    </a>
                    <h5><a href="/blog/{!! $popular->id !!}/{!! $popular->slug !!}">{!! $popular->titulo !!}</a></h5>
                    <section class="popular__meta">
                        <span class="popular__author"><span>Por</span> <a href="#0"> {!! $popular->autorRow->name !!}</a></span>
                        <span class="popular__date"><span>el</span> <time datetime="{!! $popular->created_at !!}">{!! $popular->fecha_str !!}</time></span>
                    </section>
                </article>
                @endforeach
            </div>
        </div>
        <div class="col-four md-six tab-full about">
            <h3>Acerca de mi</h3>
            <p>
                Ing. en Sistemas Computacionales, Desarrolladora Web con {!! date('Y')-2011 !!} años de experiencia,
                actualmente lider de tecnología en R&V Consultores.
            </p>
            <ul class="about__social">
                <li>
                    <script type="text/javascript" src="https://cdnjs.buymeacoffee.com/1.0.0/button.prod.min.js" data-name="bmc-button" data-slug="nFiKE2J" data-color="#FFDD00" data-emoji=""  data-font="Cookie" data-text="Cómprame un café" data-outline-color="#000000" data-font-color="#000000" data-coffee-color="#ffffff" ></script>
                </li>
            </ul>
        </div>
    </div>
    <div class="row bottom tags-wrap">
        <div class="col-full tags">
            <h3>Etiquetas</h3>
            <div class="tagcloud">
                @foreach(General::getEtiquetas() as $etiqueta)
                <a href="#0">{!! $etiqueta->etiqueta !!}</a>
                @endforeach
            </div>
        </div>
    </div>
</section>

<footer class="s-footer">
    <div class="s-footer__main">
        <div class="row">
            <div class="col-two md-four mob-full s-footer__sitelinks">
                <h4>Links rapidos</h4>
                <ul class="s-footer__linklist">
                    <li><a href="/">Inicio</a></li>
                    <li><a href="/cursos">Desarrollo web</a></li>
                    <li><a href="/projects">Proyectos</a></li>
                    <li><a href="/about">Acerca de</a></li>
                    <li><a href="/contact">Contacto</a></li>
                    <li><a href="#0">Politicas de privacidad</a></li>
                </ul>
            </div>
            <div class="col-two md-four mob-full s-footer__archives">
                <h4>Archivos</h4>
                <ul class="s-footer__linklist">
                    <li><a href="#0">Enero 2018</a></li>
                    <li><a href="#0">Diciembre 2017</a></li>
                    <li><a href="#0">Noviembre 2017</a></li>
                    <li><a href="#0">Octubre 2017</a></li>
                    <li><a href="#0">Septiembre 2017</a></li>
                    <li><a href="#0">Agosto 2017</a></li>
                </ul>
            </div>
            <div class="col-two md-four mob-full s-footer__social">
                <h4>Social</h4>
                <ul class="s-footer__linklist">
                    <li><a target="_blank" href="https://www.facebook.com/codigojenice">Facebook</a></li>
                    <li><a target="_blank" href="https://www.youtube.com/channel/UCiN249Ek1Q0qzsrlATror3Q">Youtube</a></li>
                    <li><a target="_blank" href="https://www.instagram.com/vjenice/">Instagram</a></li>
                    <li><a target="_blank" href="https://twitter.com/GoJenice">Twitter</a></li>
                    <li><a target="_blank" href="https://www.twitch.tv/gojenice">Twitch</a></li>
                    <li><a target="_blank" href="https://www.linkedin.com/in/jenice-vazquez-354892111/">LinkedIn</a></li>
                </ul>
            </div>
            <div class="col-five md-full end s-footer__subscribe">
                <h4>Comunidad</h4>
                <p>Suscríbete y recibe las actualizaciones y novedades de mi página directamente a tu email.</p>
                <div class="subscribe-form">
                    <form id="mc-form" class="group" novalidate>
                        <input type="email" value="" name="EMAIL" class="email" id="mc-email" placeholder="Direccion de Email" required>
                        <input type="submit" name="subscribe" value="Enviar">
                        <label for="mc-email" class="subscribe-message"></label>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="s-footer__bottom">
        <div class="row">
            <div class="col-full">
                <div class="go-top">
                    <a class="smoothscroll" title="Back to Top" href="#top"></a>
                </div>
            </div>
        </div>
    </div>
</footer>

<div id="preloader">
    <div id="loader">
        <div class="line-scale">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
</div>

<script src="/js/sitio/jquery-3.2.1.min.js"></script>
<script src="/js/sitio/plugins.js"></script>
<script src="/js/sitio/main.js"></script>

</body>
</html>
