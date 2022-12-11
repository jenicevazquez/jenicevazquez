<!-- Preloader -->
<div class="preloader flex-column justify-content-center align-items-center" style="background: white">
    <img loading="eager" src="/img/loaderlogo.gif" alt="Cargando..." height="200" width="200">
    <!--<div class="initial-loading__bar">
        <div class="initial-loading__blue-bar"></div>
    </div>-->
</div>
<style>
    .initial-loading__bar {
        background-color: #CFCFCF;
        border-radius: 2px;
        height: 3px;
        margin: 0px auto;
        overflow: hidden;
        position: relative;
        transform: rotateY(0);
        transition: transform .3s ease-in;
        width: 130px;
        z-index: 1;
    }
    .initial-loading__blue-bar {
        -webkit-animation: initial-loading 1.5s infinite ease;
        animation: initial-loading 1.5s infinite ease;
        background-color: #23c1c1;
        border-radius: 2px;
        height: 100%;
        position: absolute;
        transform: translate(-34px, 0);
        width: 68px;
    }
    @keyframes initial-loading {
        0% {
            -webkit-transform: translate(-34px, 0);
            transform: translate(-34px, 0);
        }
        50%{
            -webkit-transform: translate(96px, 0);
            transform: translate(96px, 0);
        }
        100%{
            -webkit-transform: translate(-34px, 0);
            transform: translate(-34px, 0);
        }
    }

</style>