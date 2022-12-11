<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Jenice Vazquez</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="author" content="" />

    <meta property="og:title" content="" />
    <meta property="og:image" content="" />
    <meta property="og:url" content="" />
    <meta property="og:site_name" content="" />
    <meta property="og:description" content="" />
    <meta name="twitter:title" content="" />
    <meta name="twitter:image" content="" />
    <meta name="twitter:url" content="" />
    <meta name="twitter:card" content="" />
    <meta name="csrf-token" content="{!! \Illuminate\Support\Facades\Session::token() !!}">
    <link rel="shortcut icon" href="favicon.ico">
    <link href="https://fonts.googleapis.com/css?family=Quicksand:300,400,500,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,400i,700" rel="stylesheet">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

    <link rel="stylesheet" href="/theme/styles.css?v=2" />
    <link rel="stylesheet" href="/theme/carousel.css?v=2" />
    <script src="https://code.jquery.com/jquery-2.1.4.min.js" integrity="sha256-8WqyJLuWKRBVhxXIL1jBDD7SDxU936oZkCnxQbWwJVw=" crossorigin="anonymous"></script>
    <script src="/theme/modernizr.min.js"></script>
    <!--[if lt IE 9]>
    <script src="/theme/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
    @yield('main-css')

<body style="background: black; height: 100%">
<div id="colorlib-page">
    <div class="container-wrap">
        <a href="#" class="js-colorlib-nav-toggle colorlib-nav-toggle" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar"><i></i></a>
        <aside id="colorlib-aside" style="overflow: auto !important;" role="complementary" class="border js-fullheight">
            <div class="text-center">
                <div class="author-img" style="background-image:url(/img/sitio/about.PNG)"></div>
                <h1 id="colorlib-logo"><a href="/">Jenice Vazquez</a></h1>
                <span class="position">MIS NOTAS DE PROGRAMACION Y MAS</span>
            </div>
            <nav id="colorlib-main-menu" role="navigation" class="navbar">
                <div id="navbar" class="collapse">
                    <ul>
                        <li class="active"><a class="external" href="/v2/notas">Mis notas</a></li>
                        <li><a class="external" href="/v2/services">Acerca de mi</a></li>
                        <li><a class="external" href="/v2/skills">Skills</a></li>
                        <li><a class="external" href="/v2/experience">Experiencia</a></li>
                        <li><a class="external" href="/v2/work">Productos</a></li>
                        <li><a class="external" href="/v2/contact">Contacto</a></li>
                    </ul>
                </div>
            </nav>
            <div class="colorlib-footer">
                <p><small>{!! $_SERVER['REMOTE_ADDR'] !!} | 2022</small></p>
                <ul>
                    <li><a href="#"><i class="icon-facebook2"></i></a></li>
                    <li><a href="#"><i class="icon-twitter2"></i></a></li>
                    <li><a href="#"><i class="icon-instagram"></i></a></li>
                    <li><a href="#"><i class="icon-linkedin2"></i></a></li>
                </ul>
            </div>
        </aside>
        <div id="colorlib-main" style="background: white">
            @yield('main-content')
        </div>
    </div>
</div>
@yield('main-modales')
<script src="/theme/scripts.js"></script>
<script>eval(mod_pagespeed_zxWiKzenpV);</script>
<script>eval(mod_pagespeed_3VV3SdTttZ);</script>
<script src="/theme/carousel.js"></script>
<script>eval(mod_pagespeed_o9wd50kRIS);</script>
<script>eval(mod_pagespeed_36JYMA6VkX);</script>
<script>eval(mod_pagespeed_d7RBuNVHpz);</script>
@yield('main-js')
</body>
</html>
