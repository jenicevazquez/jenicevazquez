$(document).ready(function(){
    console.log("CONTROLSIDEBAR");
    var socket = io.connect("http://ryvconsultores.com.mx:3000");
    socket.on('new message',function(data){
        if(data!="") {
            notifyMe(data);
        }
        refrescarEstatus();
    });
    $("#logout").on("click",function(e){
        var user = '{!! Auth::user()->nombre !!}';
        socket.emit('send message',' '+user+' acaba de cerrar sesion');
    });
    $(window).blur(function(){
        Estatus(3);
    });
    $(window).focus(function(){
        Estatus(1);
    });
    window.onbeforeunload = confirmExit;
    function confirmExit()
    {
        //alert("You have attempted to leave this page.  If you have made any changes to the fields without clicking the Save button, your changes will be lost.  Are you sure you want to exit this page?");
        Estatus(0);
    }
    refrescarEstatus();
});
function refrescarEstatus(){

    $.post( "{!! url('/colaboradores/estatus') !!}",{
        _token: $('meta[name=csrf-token]').attr('content'),
    })
        .done(function(data) {

            $("#socialmedia").html(data);

        })
        .fail(function(xhr,textStatus,errorThrown){
            console.log(xhr.responseText);
        })
}
function Estatus(estatus, custom){
    console.log(custom);
    if(estatus!=4) {
        $.post("{!! url('/usuarios/estatus') !!}", {
            _token: $('meta[name=csrf-token]').attr('content'),
            estatus: estatus,
            customEstatus: custom
        })
            .done(function (data) {
                var e = ["", "online", "busy", "away"];
                var estado = ["", "Disponible", "Ocupado", "Ausente"];
                $(".mydot").removeClass("online");
                $(".mydot").removeClass("busy");
                $(".mydot").removeClass("away");
                $(".mydot").addClass(e[estatus]).parent().prop("title",estado[estatus]);
                var user = '{!! Auth::user()->nombre !!}';
                socket.emit('send message', '');

            })
            .fail(function (xhr, textStatus, errorThrown) {
                console.log(xhr.responseText);
            })
    }
    else{
        $("#custom").modal("show");
    }
}
function notifyMe(mensaje) {

    // Let's check if the browser supports notifications
    if (!("Notification" in window)) {
        alert("This browser does not support desktop notification");
    }

    // Let's check whether notification permissions have already been granted
    else if (Notification.permission === "granted") {
        // If it's okay let's create a notification
        var title = "R&V Consultores";
        var extra = {
            icon: "{{ asset('/img/icon.png') }}",
            body: mensaje

        };
        var notification = new Notification( title, extra);
    }

    // Otherwise, we need to ask the user for permission
    else if (Notification.permission !== 'denied') {
        Notification.requestPermission(function (permission) {
            // If the user accepts, let's create a notification
            if (permission === "granted") {
                var title = "R&V Consultores";
                var extra = {
                    icon: "{{ asset('/img/icon.png') }}",
                    body: mensaje

                };
                var notification = new Notification( title, extra);
            }
        });
    }

    // At last, if the user has denied notifications, and you
    // want to be respectful there is no need to bother them any more.
}