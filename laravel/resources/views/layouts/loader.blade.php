
<div id='loading_wrap' style='background: rgba(0,0,0,.5); z-index:1000;position:fixed; height:100%; width:100%;
overflow:hidden; top:0; left:0; color: #ffffff; display: table'>
    <div style="display: table-cell; vertical-align: middle; text-align: center">
        <div class="fa-4x">
            <i class="fas fa-spinner fa-spin"></i>
        </div>
        <div id="messageLoader"></div>
    </div>

</div>
<style>
    .loader {
        border: 16px solid #f3f3f3; /* Light grey */
        border-top: 16px solid #3498db;
        border-radius: 50%;
        width: 120px;
        height: 120px;
        animation: spin 2s linear infinite;
        position: absolute;
        left: 45px;
        top: 15px;

    }
    .myloader{
        position: relative;
        width: 400px;
        height: 400px;
        margin: 0 auto;
    }
    #messageLoader{
        position: absolute;
        text-align: center;
        width: 100%;
        font-size: 18px;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
<script>

    $(window).on("load",function() {
        stopTruck();
    });
    $(document).ready(function(){


    });

    function loaderTruck(mensaje){

        if(document.referrer.indexOf("descarga") == -1){
            mensaje = typeof mensaje !== 'undefined' ? mensaje : '';
            $("#messageLoader").text(mensaje);
            $('#loading_wrap').show();
        }
        $("body").css("cursor","wait");
    }
    function stopTruck(){
        $("body").css("cursor","default");
        $('#loading_wrap').hide();
    }

</script>