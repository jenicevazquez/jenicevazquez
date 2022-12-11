<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminJVS | @yield("main-title")</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <meta name="csrf-token" content="{!! \Illuminate\Support\Facades\Session::token() !!}">
    <link href="https://{!! $_SERVER['HTTP_HOST'] !!}/img/favicon.png?v=2" rel="icon" type="image/x-icon"  />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://{!! $_SERVER['HTTP_HOST'] !!}/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="https://{!! $_SERVER['HTTP_HOST'] !!}/dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="https://{!! $_SERVER['HTTP_HOST'] !!}/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <link href="https://{!! $_SERVER['HTTP_HOST'] !!}/js/jqueryuicustom/jquery-ui.css" rel="stylesheet" type="text/css" />
    <link href = "https://{!! $_SERVER['HTTP_HOST'] !!}/css/mytheme.css?v=2" rel = "stylesheet">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
</head>
