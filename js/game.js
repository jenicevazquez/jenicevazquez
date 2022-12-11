var idJuego = 0;
var contador = 0;
var ganador = {numero:"",color:"",tipo:"",mitad:""};
var tipos = {negro:0,rojo:0,par:1,impar:1,chico:2,grande:2};
var parar = 0;
var chart = [];
var numeros = [];
var i = 0;
var saldos = [];

var ctx2 = document.getElementById('myChartcolor').getContext('2d');
chart[0] = new Chart(ctx2, {
    type: 'line',
    data: {
        labels: [],
        datasets: [
            {
                label: 'Prediccion',
                data: [],
                backgroundColor: [
                    'rgba(153, 102, 255, 1)'
                ],
                borderColor: [
                    'rgba(153, 102, 255, 1)'
                ],
                borderWidth: 2
            },
            {
                label: 'Apuesta',
                data: [],
                backgroundColor: [
                    'rgba(255, 99, 132, 1)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)'
                ],
                borderWidth: 1
            },
            {
                label: 'Apuesta2',
                data: [],
                backgroundColor: [
                    'rgb(255,255,0)'
                ],
                borderColor: [
                    'rgb(255,255,0)'
                ],
                borderWidth: 1
            }
        ]
    }
});
var ctx4 = document.getElementById('myChartmitad').getContext('2d');
chart[1] = new Chart(ctx4, {
    type: 'line',
    data: {
        labels: [],
        datasets: [
            {
                label: 'Prediccion',
                data: [],
                backgroundColor: [
                    'rgba(153, 102, 255, 1)'
                ],
                borderColor: [
                    'rgba(153, 102, 255, 1)'
                ],
                borderWidth: 2
            },
            {
                label: 'Apuesta',
                data: [],
                backgroundColor: [
                    'rgba(255, 99, 132, 1)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)'
                ],
                borderWidth: 1
            },{
                label: 'Apuesta2',
                data: [],
                backgroundColor: [
                    'rgb(255,255,0)'
                ],
                borderColor: [
                    'rgb(255,255,0)'
                ],
                borderWidth: 1
            }
        ]
    }
});
var ctx3 = document.getElementById('myCharttipo').getContext('2d');
chart[2] = new Chart(ctx3, {
    type: 'line',
    data: {
        labels: [],
        datasets: [
            {
                label: 'Prediccion',
                data: [],
                backgroundColor: [
                    'rgba(153, 102, 255, 1)'
                ],
                borderColor: [
                    'rgba(153, 102, 255, 1)'
                ],
                borderWidth: 2
            },
            {
                label: 'Apuesta',
                data: [],
                backgroundColor: [
                    'rgba(255, 99, 132, 1)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)'
                ],
                borderWidth: 1
            },{
                label: 'Apuesta2',
                data: [],
                backgroundColor: [
                    'rgb(255,255,0)'
                ],
                borderColor: [
                    'rgb(255,255,0)'
                ],
                borderWidth: 1
            }
        ]
    }
});



$(document).ready(function(){
    getJuegos();
    $("#scolor").val("");
    $("#stipo").val("");
    $("#smitad").val("");
    $('#modalNuevo').on('shown.bs.modal', function () {
        $('#croupier').focus();
    })
    $("#croupier").on('keypress',function(e) {
        if(e.which == 13) {
            crearNuevoJuego();
        }
    });
    $("#numero").on("keyup",function(e){
        if(e.which == 13) {
            var input = $(this);
            var numero = input.val();
            if(idJuego==0){
                return alert("No hay juego activo");
            }
            if(numero>=0&&numero<=36&&numero!=''&&idJuego>0){
                insertTirada(numero,idJuego,1);
            }

        }
    });
})

function crearNuevoJuego(){
    $("#btnNuevoJuego").start("Creando...");
    $.post("/game/nuevoJuego", {
        _token: $('meta[name=csrf-token]').attr('content'),
        croupier:$("#croupier").val(),
        inicial:$("#inicial").val(),
        saldo:$("#saldo").val()
    })
    .done(function (data) {
        $("#btnNuevoJuego").stop();
        $("#modalNuevo").modal("hide");
        $("#croupName").text(data.croupier);
        idJuego = data.id;
        getJuegos();
    })
    .fail(function(xhr)
    {
        $("#btnNuevoJuego").stop();
        console.log(xhr.responseText);
    });
}
function getJuegos(){
    $.post("/game/getJuegos", {
        _token: $('meta[name=csrf-token]').attr('content')
    })
        .done(function (data) {
            $("#tbJuegos").html(data);
        })
        .fail(function(xhr)
        {
            console.log(xhr.responseText);
        });
}
function loadJuego(obj){
    var id = $(obj).data("id");
    $(obj).start("Cargando...");
    $.post("/game/loadJuego", {
        _token: $('meta[name=csrf-token]').attr('content'),
        id:id
    })
        .done(function (data) {
            $(obj).stop();
            $("#croupName").text(data.croupier);
            idJuego = id;
            printnumeros(data);

        })
        .fail(function(xhr)
        {
            $(obj).stop();
            console.log(xhr.responseText);
        });
}
function reloadJuego(){
    $.post("/game/loadJuego", {
        _token: $('meta[name=csrf-token]').attr('content'),
        id:idJuego
    })
        .done(function (data) {
            $("#croupName").text(data.croupier+" - #"+idJuego);
            printnumeros(data);
        })
        .fail(function(xhr)
        {
            console.log(xhr.responseText);
        });
}
function cargarDemo(obj){
    if($(obj).hasClass("play")){
        stop();
        $(obj).removeClass("play");
        $(obj).html('<i class="fas fa-play"></i>');
    }
    else{
        $(obj).addClass("play");
        $(obj).html('<i class="fas fa-stop"></i>');
        if(numeros.length==0){
            $.post("/game/demoJuego", {
                _token: $('meta[name=csrf-token]').attr('content'),
                id:idJuego
            })
                .done(function (data) {
                    numeros = data;
                    i=0;
                    console.log(numeros);
                    insertTiradaDemo(numeros,idJuego,1);
                })
                .fail(function(xhr)
                {
                    console.log(xhr.responseText);
                });
        }else{
            insertTiradaDemo(numeros,idJuego,1);
        }

    }

}
function insertTiradaDemo(numeros,juego,jugada){
    if(numeros[i]==undefined||parar==1){
        return;
    }
    console.log(i);
    var numero = numeros[i];
    console.log("Insert tirada "+numeros[i]);
    $("#numero").attr("disabled",true);
    $.post("/game/insertTirada", {
        _token: $('meta[name=csrf-token]').attr('content'),
        numero:numero,
        idJuego:juego,
        jugada:jugada
    })
        .done(function (data) {
            $.post("/game/loadJuego", {
                _token: $('meta[name=csrf-token]').attr('content'),
                id:idJuego
            })
            .done(function (data) {
                $("#croupName").text(data.croupier+" - #"+idJuego);
                printnumerosDemo(data,numeros,idJuego);

            })
            .fail(function(xhr)
            {
                console.log(xhr.responseText);
            });
        })
        .fail(function(xhr)
        {
            console.log(xhr.responseText);
        });

}
function insertTirada(numero,juego,jugada){
    $("#numero").attr("disabled",true);
    $.post("/game/insertTirada", {
        _token: $('meta[name=csrf-token]').attr('content'),
        numero:numero,
        idJuego:juego,
        jugada:jugada
    })
    .done(function (data) {
        reloadJuego();

    })
    .fail(function(xhr)
    {
        console.log(xhr.responseText);
    });

}
function addLabel(chart, label) {
    chart.data.labels.push(label);
    chart.update();
}
function addData(index,chart, data) {

    chart.data.datasets[index].data.push(data);
    /*chart.data.datasets.forEach((dataset) => {
        dataset.data.push(data);
    });*/
    chart.update();
}
function stop(){
    parar = 1;
}
function printnumerosDemo(data,numeros,idJuego){
    var apuesta = data.apuestas;
    var predicciones = data.predicciones;
    var xpredicciones = data.xpredicciones;
    var xapuestas = data.xapuestas;
    var cont = i;
    $("#saldoJuego").html(data.saldo);

    $("#contResp").text(tiros.length);

    $.each(apuesta,function(key,value){
        $(".apuesta"+value.tipo).html(value.valor);
        $(".cantidad"+value.tipo).html("$"+value.cantidad);
    });
    $.each(prediccion,function(key,value){
        $(".prediccion"+value.tipo).html(value.valor);
    });

    $("#apuesta").html(resAp);
    addLabel(chart[0], cont);
    addLabel(chart[1], cont);
    addLabel(chart[2], cont);
    $.each(xpredicciones,function(key,value){
        addData(0,chart[key], xpredicciones[key].conteo);
        addData(1,chart[key], xapuestas[key].conteo);
        addData(2,chart[key], 0);
    });

    var resultados = data.tiros;

    var input = $("#numero");

    $("#resp").html("");
    $.each(resultados,function(index,value){
        $("#resp").prepend('<div data-idTirada="'+value.id+'" id="c'+index+'" class="celda"></div>');
        var cuadro = $("#c"+index);
        cuadro.html(value.numero);
        cuadro.addClass(value.color);
        cuadro.addClass(value.tipo);
        cuadro.addClass(value.mitad);
        ganador = value;
    });
    input.val("").attr("disabled",false).focus();
    $(".celda").on("dblclick",function(){
        var idTirada = $(this).attr("data-idTirada");
        $.post("/game/deleteTirada", {
            _token: $('meta[name=csrf-token]').attr('content'),
            idTirada:idTirada,
            idJuego:idJuego
        })
            .done(function (data) {

                reloadJuego();
            })
            .fail(function(xhr)
            {
                console.log(xhr.responseText);
            });
    });

    i++;
    insertTiradaDemo(numeros,i,idJuego,1);

}
function printnumeros(data){

    console.log("printnumeros");
    console.log(data);

    saldos.push(data.saldo);
    //$("#saldoJuego").html(data.saldo);
    $(".apuesta span").html("");

    var apuesta = data.apuestas;
    var prediccion = data.predicciones;
    var xpredicciones = data.xpredicciones;
    var xapuestas = data.xapuestas;
    var xapuestas2 = data.xapuestas2;
    var factores = data.factores;
    var tiros = data.tiros;

    $("#contResp").text(tiros.length);

    $.each(apuesta,function(key,value){
        $(".apuesta"+value.tipo).html(value.valor);
    });
    $.each(prediccion,function(key,value){
        $(".prediccion"+value.tipo).html(value.valor);
    });
    $.each(factores,function(key,value){
        $(".cantidad"+key).html(value);
    });

    addLabel(chart[0], saldos.length);
    addLabel(chart[1], saldos.length);
    addLabel(chart[2], saldos.length);
    $.each(xpredicciones,function(key,value){
        if(xapuestas[key].conteo<=0) {
            $(".apuesta" + key).addClass("disabled");
        }
        else{
            $(".apuesta" + key).removeClass("disabled");
        }
        if(xpredicciones[key].conteo<=0){
            $(".prediccion"+key).addClass("disabled");
        }
        else{
            $(".prediccion"+key).removeClass("disabled");
        }

        addData(0,chart[key], xpredicciones[key].conteo);
        addData(1,chart[key], xapuestas[key].conteo);
        addData(2,chart[key], xapuestas2[key].conteo);
    });

    var resultados = data.tiros;

    var input = $("#numero");

    $("#resp").html("");
    $.each(resultados,function(index,value){
        $("#resp").prepend('<div data-idTirada="'+value.id+'" id="c'+index+'" class="celda"></div>');
        var cuadro = $("#c"+index);
        cuadro.html(value.numero);
        cuadro.addClass(value.color);
        cuadro.addClass(value.tipo);
        cuadro.addClass(value.mitad);
        ganador = value;
    });

    $("#scolor").val("").attr("disabled",false);
    $("#stipo").val("").attr("disabled",false);
    $("#smitad").val("").attr("disabled",false);
    $("#btnenviar").attr("disabled",false);

    input.val("").attr("disabled",false).focus();
    $(".celda").on("dblclick",function(){
        var idTirada = $(this).attr("data-idTirada");
        $.post("/game/deleteTirada", {
            _token: $('meta[name=csrf-token]').attr('content'),
            idTirada:idTirada,
            idJuego:idJuego
        })
        .done(function (data) {
            reloadJuego();
        })
        .fail(function(xhr)
        {
            console.log(xhr.responseText);
        });
    });

}
function hacerApuesta(obj){
    var color = $("#scolor").val();
    var tipo = $("#stipo").val();
    var mitad = $("#smitad").val();
    $(obj).start();
    $.post("/game/hacerApuesta", {
        _token: $('meta[name=csrf-token]').attr('content'),
        id:idJuego,
        scolor:color,
        stipo:tipo,
        smitad:mitad
    })
    .done(function (data) {
        $("#scolor").attr("disabled",true);
        $("#stipo").attr("disabled",true);
        $("#smitad").attr("disabled",true);
        $(obj).stop();
        $(obj).attr("disabled",true);
    })
    .fail(function(xhr)
    {
        $(obj).stop();
        console.log(xhr.responseText);
    });
}
function printObject(selector,obj){
    $(selector).html("");
    for(atributo in obj){
        if(obj[atributo]!="") {
            $(selector).append(obj[atributo] + ", ");
        }
    }
}
function onlyUnique(value, index, self) {
    return self.indexOf(value) === index;
}