var idJuego = 0;
var contador = 0;
var ganador = {numero:"",color:"",tipo:"",mitad:""};

var ctx = document.getElementById('myChart').getContext('2d');
var chart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: [],
        datasets: [
            {
            label: 'Juego',
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
                label: 'Perdida',
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
                label: 'Ganada',
                data: [],
                backgroundColor: [
                    'rgba(54, 162, 235, 1)'
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)'
                ],
                borderWidth: 1
            }
        ]
    }
});

$(document).ready(function(){
    getJuegos();
    $('#modalNuevo').on('shown.bs.modal', function () {
        $('#croupier').focus();
    })
    $("#croupier").on('keypress',function(e) {
        if(e.which == 13) {
            crearNuevoJuego();
        }
    });
})
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
function crearDemoJuego(){
    $("#btnDemoJuego").start("Cargando...");
    $.post("/game/demoJuego", {
        _token: $('meta[name=csrf-token]').attr('content'),
        croupier:$("#croupier").val(),
        inicial:$("#inicial").val()
    })
        .done(function (data) {
            $("#btnDemoJuego").stop();
            $("#modalNuevo").modal("hide");
            $("#croupName").text(data.croupier);
            idJuego = data.id;
            getJuegos();
            loadJuego(idJuego);
        })
        .fail(function(xhr)
        {
            $("#btnDemoJuego").stop();
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
function getPredicciones(){
    $.post("/game/getPredicciones", {
        _token: $('meta[name=csrf-token]').attr('content')
    })
        .done(function (data) {
            $("#tbPredicciones").html(data);
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

function cargarDemo(){
    $.post("/game/demoJuego", {
        _token: $('meta[name=csrf-token]').attr('content'),
    })
    .done(function (data) {
        var numeros = data;
        var i = 0;
        insertTiradaDemo(numeros,i,idJuego,1)
    })
    .fail(function(xhr)
    {
        console.log(xhr.responseText);
    });
}
function insertTiradaDemo(numeros,i,juego,jugada){
    if(numeros[i]==undefined){
        return;
    }
    var numero = numeros[i];
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
                printnumeros(data);
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
var saldos = [];
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


function printnumeros(data){

    console.log(data);
    saldos.push(data.saldo);
    var totalGanador = parseFloat(data.saldo);
    var totalPerdedor = parseFloat(data.saldo);

    var apuesta = data.apuestas;


    var resAp = data.saldo+"<br>";
    if(data.salida=="si"){
        resAp += "Puedes terminar<br>";
    }


    $.each(apuesta,function(key,value){
        var cant = value.cantidad;
        resAp += value.valor+" "+cant+"<br>";
        totalGanador += parseFloat(cant);
        totalPerdedor -= parseFloat(cant);
        console.log("->"+totalGanador);
        console.log("<-"+totalPerdedor);
    });

    $("#apuesta").html(resAp);

    addData(0,chart, data.saldo);
    if(saldos.length==1){
        addLabel(chart, saldos.length);
        addData(1,chart, data.saldo);
        addData(2,chart, data.saldo);
    }
    addLabel(chart, saldos.length+1);
    addData(1,chart, totalPerdedor);
    addData(2,chart, totalGanador);

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