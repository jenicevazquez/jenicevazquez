let apuestas = [0,0,0];
let ganados = [0,0,0];
let perdidos = [0,0,0];
$(document).ready(function(){
    $("#numerosJuego").on('keypress',function(e) {
        if(e.which === 13) {
            setNumeros();
        }
    });
    $(".apostar").on("click",function(){
        $(this).toggleClass("apostado");
    })
})

function setNumeros(){
    let renglonNumeros = $("#renglonNumeros");
    let numerosJuegos = $("#numerosJuego");
    let numerosStr = numerosJuegos.val();
    let numeros = numerosStr.split(",");
    let anterior =  renglonNumeros.data("datos");
    let numerosAnterior = anterior.split(",");
    let lastValue = null;

    if(numerosStr!==anterior||numeros.length===1) {
        if(numeros[1]===numerosAnterior[0]){
            numeros = [numeros[0]];
        }
        renglonNumeros.data("datos", numerosStr);
        let new_arr = numeros.reverse();
        let tabla = $("#tbColores tbody");
        let tabla2 = $("#tbParImpar tbody");
        let tabla3 = $("#tbChicaGde tbody");
        let tabla4 = $("#tbDocena tbody");
        let tabla5 = $("#tbLinea tbody");
        if (numeros.length > 1) {
            renglonNumeros.html("");
            tabla.html("");
            tabla2.html("");
            tabla3.html("");
            tabla4.html("");
            tabla5.html("");
        }
        $.each(new_arr, function (key, value) {
            lastValue = value;
            let celda = $("[data-numero='" + value + "']:first").clone();
            celda.removeAttr("rowspan");
            $("#renglonNumeros").prepend(celda);

            let lastRow = $("#tbColores tr:last");
            let lastColor = lastRow.data("color");
            let caracteristicas = celda.data("caracteristicas");
            let c = caracteristicas.split(",");
            let clase = c[0] === "rojo" ? "bg-red" : "bg-black";
            clase = c[0] === "verde" ? "bg-green" : clase;
            if (lastColor === c[0] ) {
                let celdatd = '<td data-color="' + c[0] + '" style="width: 50px" class="' + clase + '">' + value + '</td>';
                lastRow.append(celdatd);
            } else {
                let row = '<tr data-color="' + c[0] + '"><td data-color="' + c[0] + '" style="width: 50px" class="' + clase + '">' + value + '</td></tr>';
                tabla.append(row);
            }


            let lastRow2 = $("#tbParImpar tr:last");
            let lastColor2 = lastRow2.data("color");
            let clase2 = c[1] === "par" ? "bg-red" : "bg-black";
            clase2 = c[1] === "verde" ? "bg-green" : clase2;
            if (lastColor2 === c[1]) {
                let celdatd2 = '<td data-color="' + c[1] + '" style="width: 50px" class="' + clase2 + '">' + value + '</td>';
                lastRow2.append(celdatd2);
            } else {
                let row2 = '<tr data-color="' + c[1] + '"><td data-color="' + c[1] + '" style="width: 50px" class="' + clase2 + '">' + value + '</td></tr>';
                tabla2.append(row2);
            }


            let lastRow3 = $("#tbChicaGde tr:last");
            let lastColor3 = lastRow3.data("color");
            let clase3 = c[2] === "chico" ? "bg-red" : "bg-black";
            clase3 = c[2] === "verde" ? "bg-green" : clase3;
            if (lastColor3 === c[2] ) {
                let celdatd3 = '<td data-color="' + c[2] + '" style="width: 50px" class="' + clase3 + '">' + value + '</td>';
                lastRow3.append(celdatd3);
            } else {
                let row3 = '<tr data-color="' + c[2] + '"><td data-color="' + c[2] + '" style="width: 50px" class="' + clase3 + '">' + value + '</td></tr>';
                tabla3.append(row3);
            }

            let lastRow4 = $("#tbDocena tr:last");
            let lastColor4 = lastRow4.data("color");
            let clasis = {"verde": "bg-green", "docena1": "bg-red", "docena2": "bg-black", "docena3": "bg-blue"};
            let clase4 = clasis[c[3]];
            if (lastColor4 === c[3] || c[3] === "verde") {
                let celdatd4 = '<td data-color="' + c[3] + '" style="width: 50px" class="' + clase4 + '">' + value + '</td>';
                lastRow4.append(celdatd4);
            } else {
                let row4 = '<tr data-color="' + c[3] + '"><td data-color="' + c[3] + '" style="width: 50px" class="' + clase4 + '">' + value + '</td></tr>';
                tabla4.append(row4);
            }

            let lastRow5 = $("#tbLinea tr:last");
            let lastColor5 = lastRow5.data("color");
            let clasis2 = {"verde": "bg-green", "linea1": "bg-red", "linea2": "bg-black", "linea3": "bg-blue"};
            let clase5 = clasis2[c[4]];
            if (lastColor5 === c[4] || c[4] === "verde") {
                let celdatd5 = '<td data-color="' + c[4] + '" style="width: 50px" class="' + clase5 + '">' + value + '</td>';
                lastRow5.append(celdatd5);
            } else {
                let row5 = '<tr data-color="' + c[4] + '"><td data-color="' + c[4] + '" style="width: 50px" class="' + clase5 + '">' + value + '</td></tr>';
                tabla5.append(row5);
            }

        });

        let celdalast = $("[data-numero='" + lastValue + "']:first");
        let caracteristicaslast = celdalast.data("caracteristicas");
        let clast = caracteristicaslast.split(",");
        $("#resp").text("");
        if($("."+clast[0]).hasClass('apostado')){
            $("#resp").append(","+clast[0]);
        }
        if($("."+clast[1]).hasClass('apostado')){
            $("#resp").append(","+clast[1]);
        }
        if($("."+clast[2]).hasClass('apostado')){
            $("#resp").append(","+clast[2]);
        }

        if ($(".apuestaColor").text() === clast[0]) {
            desdoblar($("#txtApuestaColor"));
            ganados[0]++;
            apuestas[0]++;
        } else if($(".apuestaColor").text()!="") {
            doblar($("#txtApuestaColor"));
            perdidos[0]++;
            apuestas[0]++;
        }
        if ($(".apuestaParImpar").text() === clast[1]) {
            desdoblar($("#txtApuestaParImpar"));
            ganados[1]++;
            apuestas[1]++;
        } else if($(".apuestaParImpar").text()!=""){
            doblar($("#txtApuestaParImpar"));
            perdidos[1]++;
            apuestas[1]++;
        }
        if ($(".apuestaChicoGde").text() === clast[2]) {
            desdoblar($("#txtApuestaChicoGde"));
            ganados[2]++;
            apuestas[2]++;
        } else if($(".apuestaChicoGde").text()!=""){
            doblar($("#txtApuestaChicoGde"));
            perdidos[2]++;
            apuestas[2]++;
        }
        $(".tdApuesta").html("");
        $(".apuesta").removeClass("apuesta");
        $(".apostado").removeClass("apostado");

        let apuestaStr = '';
        let conteos = {"rojo":0,"negro":0,"par":0,"impar":0,"chico":0,"grande":0};

        let lastRow = $("#tbColores tr:last");
        let lastColor = lastRow.data("color");
        let celdasCont = lastRow.find('td').length;
        let colorsitos = [];
        $("#tbColores tbody tr").each(function () {
            let celdita = $(this).find("td").eq(celdasCont);
            let col = celdita.data("color");
            conteos[col]++;
            console.log(col);
            if (col !== undefined && !colorsitos.includes(col)) {
                colorsitos.push(col);
            }
        });
        console.log(colorsitos);
        let apuesta = conteos["rojo"]>conteos["negro"]? "rojo":"negro";
        apuesta = conteos["rojo"]===conteos["negro"]? "":apuesta;

        if (apuesta !== "") {
            let prom = apuestas[0] > 0 ? (ganados[0] / apuestas[0]) * 100 : 0;
            if(prom>50) {
                $("." + apuesta).addClass("apuesta");
                apuestaStr += apuesta + ',';
            }
            $(".apuestaColor").html(apuesta);
        }


        let lastRow2 = $("#tbParImpar tr:last");
        let lastColor2 = lastRow2.data("color");
        let celdasCont2 = lastRow2.find('td').length;
        let colorsitos2 = [];
        $("#tbParImpar tbody tr").each(function () {

            let celdita2 = $(this).find("td").eq(celdasCont2);
            let col2 = celdita2.data("color");
            conteos[col2]++;
            if (col2 !== undefined && !colorsitos2.includes(col2)) {
                colorsitos2.push(col2);
            }
        });
        console.log(colorsitos2);
        let apuesta2 = conteos["par"]<conteos["impar"]? "par":"impar";
        apuesta2 = conteos["par"]===conteos["impar"]? "":apuesta2;
        if (apuesta2 !== "") {
            let prom = apuestas[1] > 0 ? (ganados[1] / apuestas[1]) * 100 : 0;
            if(prom>50) {
                $("." + apuesta2).addClass("apuesta");
                apuestaStr += apuesta2 + ',';
            }
            $(".apuestaParImpar").html(apuesta2);
        }


        let lastRow3 = $("#tbChicaGde tr:last");
        let lastColor3 = lastRow3.data("color");
        let celdasCont3 = lastRow3.find('td').length;
        let colorsitos3 = [];
        $("#tbChicaGde tbody tr").each(function () {

            let celdita3 = $(this).find("td").eq(celdasCont3);
            let col3 = celdita3.data("color");
            conteos[col3]++;
            if (col3 !== undefined && !colorsitos3.includes(col3)) {
                colorsitos3.push(col3);
            }
        });
        console.log(colorsitos3);
        let apuesta3 = conteos["chico"]<conteos["grande"]? "chico":"grande";
        apuesta3 = conteos["chico"]===conteos["grande"]? "":apuesta3;
        if (apuesta3 !== "") {
            let prom = apuestas[2] > 0 ? (ganados[2] / apuestas[2]) * 100 : 0;
            if(prom>50) {
                $("." + apuesta3).addClass("apuesta");
                apuestaStr += apuesta3;
            }
            $(".apuestaChicoGde").html(apuesta3);
        }


        console.log(conteos);
        $("#conteoRojos").text(conteos["rojo"]);
        $("#conteoNegros").text(conteos["negro"]);
        $("#conteoPar").text(conteos["par"]);
        $("#conteoImpar").text(conteos["impar"]);
        $("#conteoChicos").text(conteos["chico"]);
        $("#conteoGrandes").text(conteos["grande"]);


        $("#tablero [data-caracteristicas='" + apuestaStr + "']").addClass("apuesta");
    }
    numerosJuegos.val("");
}
function desdoblar(obj){
    $(obj).parents("tr").find("input").val("");
}
function doblar(obj){
    var input = $(obj).parents("tr").find("input");
    var valor = input.val();
    valor = valor*2;
    input.val(valor);
}
function hacerapuesta(){
    let prom0 = apuestas[0] > 0 ? (ganados[0] / apuestas[0]) * 100 : 0;
    let prom1 = apuestas[1] > 0 ? (ganados[1] / apuestas[1]) * 100 : 0;
    let prom2 = apuestas[2] > 0 ? (ganados[2] / apuestas[2]) * 100 : 0;
    $(".prom0").html(prom0.toFixed() + "%");
    $(".prom1").html(prom1.toFixed() + "%");
    $(".prom2").html(prom2.toFixed() + "%");
    if((prom0>50&&$(".apuestaColor").text()!="")||(prom1>50&&$(".apuestaParImpar").text()!="")||(prom2>50&&$(".apuestaChicoGde").text()!="")){
        return 1;
    }
    return 0;
}