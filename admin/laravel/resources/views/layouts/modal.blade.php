<!DOCTYPE html>
<html lang="es">
    @include("layouts.partials.htmlheader")
<body class="hold-transition sidebar-mini layout-fixed">

    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center" style="background: white">
        <img class="" src="/img/logo.png" alt="R&V" height="60" width="60">
    </div>
    @yield('main-content')

</body>
<!-- jQuery -->
<script src="/plugins/jquery/jquery.min.js"></script>
@include("layouts.partials.scripts")
@yield('js-scripts')
</html>
