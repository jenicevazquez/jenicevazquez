<div id='loading_wrap' style='background:#ffffff; z-index:1100;position:fixed; height:100%; width:100%;
overflow:hidden; top:0; left:0; color: #ffffff; display: table'>
    <div style="display: table-cell; vertical-align: middle; text-align: center">
        <div class="fa-4x">
            <img loading="eager"  style="height: 100px;"  src="{!! $icohref !!}">
            <div class="initial-loading__bar">
                <div class="initial-loading__blue-bar"></div>
            </div>
        </div>
    </div>
</div>
<style>
    .initial-loading__bar {
        background-color: #CFCFCF;
        border-radius: 2px;
        height: 3px;
        margin: 20px auto;
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
        background-color: #0073B1;
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