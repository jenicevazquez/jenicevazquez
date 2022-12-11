var socket = io.connect("https://ryvconsultores.com.mx:3001");
var oldtitle = document.title;
socket.on("serverTalk",function(data){
    if(data.mensaje!=""&&data.mensaje!=undefined) {
        console.log(data.mensaje);
    }
    $(".progress-"+data.tipo).css("width",data.porcentaje+"%").html(data.tipo+": "+data.porcentaje+"%");
});

