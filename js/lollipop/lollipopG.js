/**
 * Created by Jenice ♥ on 09/08/2016.
 **/
console.log("lollipop: Created by Jenice ♥ updated 2020/06/02");
var loaderGIF = '<img style="width: 30px; height: 30px; margin: 0 auto" src="/img/loadingBars.gif">';
$(document).ready(function(){
    getSort();
    setFilterInput();
    setDineroFormat();
    setOnlyNumberFormat();
    setMoneyFormat();
    //setRequired();
    loadSections();
    setDecimal();
    $('.modal').on('shown.bs.modal', function (e) {
        $("body.modal-open").removeAttr("style");
    });
    $("form").on("submit",function(e){
        validar(e);
    });

    if(window.mobilecheck())
    {
        //alert("Mobil");
        $('.numeroMobile').each(function(){
            $(this).attr("type","number");
        });
        return;
    }
    $(".selectAll").on("click",function(){
       var checkboxes = $(this).parents("table").find("input[type='checkbox']");
       if($(this).is(":checked")){
           checkboxes.prop('checked', true);
       }
       else{
           checkboxes.prop('checked', false);
       }

    });
    (function(a){
        a.createModal=function(b){
            var defaults={
                title:"",
                message:"Your Message Goes Here!",
                closeButton:true,
                scrollable:false};
            var b=a.extend(
                {},defaults,
                b
            );
            var c=(b.scrollable===true)?'style="max-height: 420px;overflow-y: auto;"':"";
            var html='<div class="modal fade" id="myModal">';
            html+='<div class="modal-dialog">';
            html+='<div class="modal-content">';
            html+='<div class="modal-header">';
            html+='<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>';
            if(b.title.length>0){
                html+='<h4 class="modal-title">'+b.title+"</h4>"
            }
            html+="</div>";html+='<div class="modal-body" '+c+">";
            html+=b.message;html+="</div>";
            html+='<div class="modal-footer">';
            if(b.closeButton===true){
                html+='<button type="button" id="maximize" class="btn btn-default" >Abrir en otra pestaña</button>';
                html+='<button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>'
            }
            html+="</div>";
            html+="</div>";
            html+="</div>";
            html+="</div>";
            a("body").prepend(html);
            a("#myModal").modal().on("hidden.bs.modal",function(){a(this).remove()})
        }})(jQuery);
    jQuery.expr[':'].icontains = function(a, i, m) {
        return jQuery(a).text().toUpperCase()
            .indexOf(m[3].toUpperCase()) >= 0;
    };
});
var loader = '<i class="fas fa-spinner fa-spin"></i>';
(function($){
    $.fn.extend({
        switchClass : function (removeClassName,addClassName) {
            $(this).removeClass(removeClassName).addClass(addClassName);
        }
    });
    $.fn.extend({
        refresh : function () {
            var widget = $(this).attr("data-widget");
            var obj = $(this);
            if(widget=='section-refresh') {
                var url = $(this).attr("data-source");
                $(this).html(loaderGIF);
                $.ajax({
                    url: url,
                    data: {},
                    type: 'get',
                    error: function(XMLHttpRequest, textStatus, errorThrown){
                        console.log('status:' + XMLHttpRequest.status + ', status text: ' + XMLHttpRequest.statusText);
                        $(obj).html(XMLHttpRequest.statusText);
                    },
                    success: function(data){
                        $(obj).html(data);
                    }
                });
            }
        }
    });
})(jQuery);
function find_duplicate_in_array(arra1) {
    var object = {};
    var result = [];

    arra1.forEach(function (item) {
        if(!object[item])
            object[item] = 0;
        object[item] += 1;
    })

    for (var prop in object) {
        if(object[prop] >= 2) {
            result.push(prop);
        }
    }

    return result;

}
/*Decimal*/
function setDecimal(){
    $('.decimal').each(function(){
        $(this).addClass("numero");
    })
    setOnlyNumberFormat();
}
function loadSections() {
    console.log("loadSections");
    $("[data-widget='section-refresh']").each(function () {
        var loadInContent = $(this).attr("data-loadInContent");
        if(loadInContent=="false"){
            return;
        }
        $(this).refresh();
    })
}
function setMoneyFormat(){
    var moneda = $(".moneda");
    moneda.each(function(){
        $(this).addClass("numero");

    });
    moneda.off().on("focus",function() {
        var valor = $(this).val();
        console.log(valor);
        valor = valor.replace("$","");
        console.log(valor);
        $(this).val(valor);
    });
    setOnlyNumberFormat();
}
function setOnlyNumberFormat(){
    var numero = $('input.numero');
    numero.each(function(){
        var maxlength = $(this).attr("data-maxlength");
        if($(this).hasClass("moneda") || $(this).hasClass("decimal")){
            if (typeof maxlength === typeof undefined || maxlength === false) {
                $(this).attr("data-maxlength","18,2");
            }
        }
    });
    if(window.mobilecheck())
    {
        numero.each(function(){
            $(this).attr("type","number");
        });
        return;
    }
    numero.on("keydown",function (e) {

        // Allow: backspace, delete, tab, escape and enter
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13]) !== -1 ||
                // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) ||
                // Allow: Ctrl+C
            (e.keyCode == 67 && e.ctrlKey === true) ||
                // Allow: Ctrl+V
            (e.keyCode == 86 && e.ctrlKey === true) ||
                // Allow: Ctrl+X
            (e.keyCode == 88 && e.ctrlKey === true) ||
                // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
            // let it happen, don't do anything
            return;
        }
        //si es punto
        if ($.inArray(e.keyCode, [110, 190]) !== -1 ) {
            if($(this).hasClass("moneda") || $(this).hasClass("decimal")) {
                var valor = $(this).val();
                var partes = valor.split(".");
                if (partes.length >= 2) {
                    e.preventDefault();
                }
                else
                    return;
            }
            else
                return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
        var maxlength = $(this).attr("data-maxlength");
        var nuevo = $(this).getCursorPosition();
        if (typeof maxlength !== typeof undefined && maxlength !== false) {
            var parts = maxlength.split(",");
            var valor = $(this).val();
            var partes = valor.split("$");
            valor = partes.join("");
            var partes = valor.split(".");
            var team = (nuevo<=partes[0].length)? 0:1;

            if((team==0 && partes[0].length==parts[0]) || (team==1 && partes[1].length==parts[1])){
                e.preventDefault();
            }

        }

    });
    numero.on("blur",function(){
        var valor = $(this).val();
        valor = valor.split("$").join("");
        valor = valor.split(" ").join("");
        $(this).val(valor);
        if(valor=="")
            return;
        var letras = valor.split("");
        var punto =0;
        for(var i=0;i<letras.length;i++){
            if(isNaN(letras[i]) && letras[i]!=".")
            {
                letras[i]="";
            }
            if(letras[i]==".")
            {
                if(punto==1)
                    letras[i]="";
                else
                    punto=1;
            }

        }
        valor = letras.join("");

        var maxlength = $(this).attr("data-maxlength");
        if (typeof maxlength !== typeof undefined && maxlength !== false) {
            var parts = maxlength.split(",");
            var partes = valor.split(".");
            if(partes.length==1){
                valor += ".";
                for(var i=0;i<parts[1];i++){
                    valor += "0";
                }
            }
        }
        valor = (valor==".")? "":valor;
        $(this).val(valor);
    });
    numero.on("keyup",function(){
        var valor = $(this).val();
        if(valor=="")
            valor=0;
        var maxlength = $(this).attr("data-maxlength");
        if (typeof maxlength !== typeof undefined && maxlength !== false) {
            var parts = maxlength.split(",");
            var partes = valor.split("$");
            valor = partes.join("");
            var partes = valor.split(".");
            if(partes[0].length>parts[0]){
                partes[0] = partes[0].substring(0,parts[0]);
                valor = partes[0];
            }
            if(partes.length>1 && partes[1].length>parts[1]){
                partes[1] = partes[1].substring(0,parts[1]);
                valor += "."+partes[1];
            }
            $(this).val(valor);
        }
    })
}
function setDineroFormat(){
    /****** Dinero, dinero, dinero ♪ ***************/
    $(".dinero").each(function(){
        var contenido = $(this).text();
        contenido = (contenido=="")? 0:contenido;
        contenido = parseFloat(contenido);
        if(!isNaN(contenido)) {
            contenido = contenido.toFixed(2);
            var nuevoContenido = thousands(contenido);
            $(this).html(nuevoContenido);
        }
    })
}
function thousands(numero){
    var partes = numero.toString().split(".");
    var largoEntero = partes[0].length;
    var contador = largoEntero-3;
    var nuevo = [];
    while(contador>-3){
        nuevo.push(partes[0].substring(contador,contador+3));
        contador -= 3;
    }
    nuevo.reverse();
    var result = nuevo.join(",");
    if(partes.length>1)
        result = result+"."+partes[1];
    return result;
}
function errorShow(error){

    $("body").append("<div style='display:none' class='aux'>"+error+"</div>");
    var msg = $(".aux").find(".block_exception").text();

    if(!msg){
        msg = error;
        var quitar = new Array('{','}','[',']','"');
        for(var i=0;i<quitar.length;i++){
            msg = msg.replace(quitar[i],'');
        }
        var parts = msg.split('"');
        msg = parts.join(' ');
    }
    if(msg=="Unauthorized.")
        msg = "No se encuentra en sesión. Ingrese de nuevo.";

    swal({
        title:"Error",
        html:msg,
        type: 'error'
    });

    $(".aux").remove();

}
function errorMsg(error){

    $("body").append("<div style='display:none' class='aux'>"+error+"</div>");
    var msg = $(".aux").find(".block_exception").text();

    if(!msg){
        msg = error;
        var quitar = new Array('{','}','[',']','"');
        for(var i=0;i<quitar.length;i++){
            msg = msg.replace(quitar[i],'');
        }
        var parts = msg.split('"');
        msg = parts.join(' ');
    }
    if(msg=="Unauthorized.")
        msg = "No se encuentra en sesión. Ingrese de nuevo.";

    $(".aux").remove();

    return msg;
}
function buscarEnResult(result,col,valor){
    result = $.parseJSON(result);
    var resultado = "";
    var indice = -1;
    $.each(result,function(key,value){

        if(value[col]==valor){
            resultado = value;
            indice = key;
            return;
        }
    })
    if(indice!=-1)
        return resultado;
    else
        return -1;
}
function sort(column,dir){

    var url = window.location.href;
    var partes = url.split("?");

    var domain = partes[0];
    var params = "";
    var param = [];

    if(partes.length>1){
        params = partes[1];
        param = params.split("&");
    }


    var existe = 0;
    //column = column.trim();

    $.each(param,function(i,value){
        var partes = value.split("=");
        if(partes[0]=="sort")
        {
            partes[1] = column+"_"+dir;
            existe=1;
        }
        var convertedArray = Array.prototype.slice.call(partes);
        value = convertedArray.join("=");
        param[i] = value;
        if(partes[0]=="sort" && dir==""){
            param.splice(i,1);
        }
    });

    var convertedArray = Array.prototype.slice.call(param);

    if(existe==0 && dir!=""){
        convertedArray.push("sort="+column+"_"+dir);
    }
    param = convertedArray.join("&");

    if(param!="")
        window.location.href = domain+"?"+param;
    else
        window.location.href = domain;
}
function getSort(){
    var url = window.location.href;
    var partes = url.split("?");
    var params = "";
    var param = [];

    $(".sort thead tr:first th").on("click",function(){
        var dir = "";

        if($(this).hasClass("desc"))
            dir = "asc";
        else if($(this).hasClass("asc"))
            dir = "desc";
        else
            dir = "asc";

        var column = $(this).data("col");
        sort(column,dir);
    });
    $("#txtBuscar").keypress(function(event) {
        if (event.which == 13) {
            event.preventDefault();
            $("form").submit();
        }
    });

    if(partes.length>1){
        params = partes[1];
        param = params.split("&");
    }

    $.each(param,function(i,value){
        var partes = value.split("=");
        if(partes[0]=="sort")
        {
            var p = partes[1].split("_");
            var icono = "";
            if(p[1]=="asc"){
                icono = '<i class="fa fa-sort-asc" aria-hidden="true"></i>';
            }
            else{
                icono = '<i class="fa fa-sort-down" aria-hidden="true"></i>';
            }
            $(".sort thead th").each(function( index ) {
                var text = $(this).data("col");
                if(text==p[0]){
                    $(this).prepend(icono+"&nbsp;");
                    $(this).addClass(p[1]);
                }
            });
        }
    });
}


function verPDF(pdf_link,reload,titulo){
    reload = typeof reload !== 'undefined' ? reload : false;
    // Si tu navegador no puede mostrar un pdf
    var isIE = /*@cc_on!@*/false || !!document.documentMode;

    var title = typeof titulo !== 'undefined' ? titulo : pdf_link;
    /*Pongamos el title nice*/
    var parts = title.split("/");
    title = parts[parts.length-1];

    var parts2 = title.split(".");
    var tipo = parts2[parts2.length-1];

    parts = title.split("_");
    title = parts.join(" ");
    title = titleCase(title);

    if(isIE) {
        //No tiene visor PDF asi que lo descargamos
        var iframe = "Su navegador no puede mostrar el PDF, se inicio la descarga. <br> También puede descargarlo <a target='_blank' href='" + pdf_link + "'>aqui</a><iframe src='" + pdf_link + "' width='0' height='0'></iframe>";
    }
    else{
        if(tipo=="pdf" || parts2.length==1) {
            var iframe = "<div id='wrapper' style='width: 100%; height: 100%; overflow: auto; -webkit-overflow-scrolling: touch;'><iframe id='printf' name='printf' src='" + pdf_link + "' height='450' width='100%'><a href='" + pdf_link + "'>Descargar</a></iframe></div>";
        }
        else{
            var iframe = "<img class='img-responsive' src='" + pdf_link + "'>";
        }
    }



    $.createModal({
        title:title,
        message: iframe,
        closeButton:true,
        scrollable:false
    });

    if(reload) {
        $("#myModal").modal().on("hidden.bs.modal",function(){
            location.reload();
        });
    }
    $("#maximize").on("click",function(){
        window.open(pdf_link, '_blank');
    });
    $("#printFrame").on("click",function(){
        window.frames["printf"].focus();
        window.frames["printf"].print();
    })
    return false;
}
function titleCase(str) {

    if(str==undefined)
        return;
    if(!isNaN(str))
        return str;

    var words = str.toLowerCase().split(' ');

    for(var i = 0; i < words.length; i++) {
        if(words[i]!="") {
            var letters = words[i].split('');
            letters[0] = letters[0].toUpperCase();
            words[i] = letters.join('');
        }
    }
    return words.join(' ');
}
//----------------filter input--------------//
function setFilterInput(){

    //VERSION 1 - BY JENICE


    var focus = 0;
    var fin = 0;
    $(".filterInput").each(function(){

        // Result con datos, id y nombre
        //Importante: Comillas simples: data-lista='{!! json_encode($pacientes) !!}'
        //Clase setNew
        var caja = $(this);

        //noSelected(caja);

        $(this).attr("autocomplete","off");

        var ul = "";
        var lista = $(this).data("lista");


        var aux = $(this).attr("data-col");
        var todos = $(this).attr("data-todos");
        aux = typeof aux !== 'undefined' ? aux : "";
        var col = aux.split(",");

        if(lista.length>0){
            var name = $(this).attr("name");
            $("#"+name+"Ul").remove();
            ul = "<ul class='filterUl' id='"+name+"Ul'>";
            if(todos=="true")
                ul += "<li data-value='0'>Todos</li>";
            for(var i=0;i<lista.length;i++){
                if(col.length>1) {
                    ul += "<li data-value='" + lista[i][col[0]] + "'>" + titleCase(lista[i][col[1]]) + "</li>";
                }else
                    ul += "<li data-value='"+lista[i].id+"'>"+titleCase(lista[i].nombre)+"</li>";
            }
            ul += "</ul>";
            $(this).after(ul);

            $("#" + name + "Ul").hover(function () {
                focus = 1;
            }, function () {
                focus = 0
            });

            $("#"+name+"Ul li").on("click",function(){
                console.log("click");
                var valor = $(this).data("value");
                var valorStr = $(this).text();
                $("input[name='"+name+"']").val(valorStr);
                console.log(valorStr);
                $("input[name='"+name+"']").attr("data-value",valor);
                $("#"+name+"Ul").hide();
                caja.trigger("onchange");
                caja.focus();

            })
        }
    });
    $('.filterUl').hide();

    $(".filterInput").off("keyup").on("keyup",function(e){
        var keyCode = e.keyCode || e.which;
        var lista = $(this).next();
        if (keyCode == 13 || keyCode == 9) {
            e.preventDefault();
            seleccionarPrimero(lista);
        }
        else {
            if (fin == 0 && $(this).val() != "") {
                var valor = $(this).val();
                mostrarLista(lista, valor);
            }
        }
    });

    $(".filterInput").off("blur").on("blur",function(){
        if(focus==0) {
            var setNew = $(this).hasClass("setNew");
            var lista = $(this).next();
            if (setNew || $(this).val()=="") {
                lista.hide();
            }
            else{
                var res = seleccionarPrimero(lista);
                if(res==0){
                    var caja = $(this);
                    noSelected(caja);
                }
            }
        }
    });
    $(".filterInput").off("keypress").on("keypress",function(e){
        var keyCode = e.keyCode || e.which;
        if (keyCode == 9) {
            e.preventDefault();
            fin=1;
            //var setNew = $(this).hasClass("setNew");
            //if(setNew){
                var lista = $(this).next();
                seleccionarPrimero(lista);
            //}
            //else {
                //$(this).trigger("blur");
            //}
        }
        else{
            fin=0;
        }
    });


}
function mostrarLista(lista,valor){
    valor = titleCase(valor);
    var vacio = 1;

    if(valor!="") {
        lista.show();
        lista.find("li:not(:contains('"+valor+"'))" ).hide();
        lista.find("li:contains('"+valor+"')" ).show();
        lista.find("li:visible").each(function(){
            var cadena = $(this).text();
            cadena = Highlight(cadena,valor);
            $(this).html(cadena);
            vacio=0;
        });
    }
    else{
        lista.show();
        lista.find("li" ).show();
        lista.find("li:visible").each(function(){
            var cadena = $(this).text();
            $(this).html(cadena);
            vacio=0;
        });
    }
    lista.find("li").removeClass("selected");
    lista.find("li:visible:first").addClass("selected");
    if(vacio==1){
        lista.hide();
    }
}
function seleccionarPrimero(lista){
    var valor = lista.find("li:visible:first").data("value");
    valor = (valor== null)? 0:valor;
    lista.find("li:visible:first").trigger("click").removeClass("selected");
    lista.hide();
    return valor;
}
function noSelected(caja){
    caja.val("");
    caja.attr("data-value",0);
}
function Highlight(texto,palabra){
    var n = texto.search(palabra);
    var f = palabra.length;
    var fin = f+n;
    var nuevo = "";
    for(var i=0;i<texto.length;i++){
        if(i==n){
            nuevo += "<b>";
        }
        else if(i==fin){
            nuevo += "</b>";
        }
        nuevo += texto.charAt(i);
    }
    return nuevo;
}
new function ($) {
    $.fn.getCursorPosition = function () {
        var pos = 0;
        var el = $(this).get(0);
        // IE Support
        if (document.selection) {
            el.focus();
            var Sel = document.selection.createRange();
            var SelLength = document.selection.createRange().text.length;
            Sel.moveStart('character', -el.value.length);
            pos = Sel.text.length - SelLength;
        }
        // Firefox support
        else if (el.selectionStart || el.selectionStart == '0')
            pos = el.selectionStart;
        return pos;
    }
} (jQuery);
window.mobilecheck = function() {
    var check = false;
    (function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))) check = true;})(navigator.userAgent||navigator.vendor||window.opera);
    return check;
};
function Flash(mensaje,clase,obj){
    cerrarFlash();
    console.log(mensaje);
    clase = (clase=="error")? "danger":clase;
    if($('.flash').length==0){
        $(".page-header").parents(".row").after('<div class="flash"></div>');
    }
    var alerta = '<div class="alert alert-'+clase+' alert-dismissible" role="alert">';
    alerta += '<a href="javascript:void()" onclick="cerrarFlash(\''+obj+'\')" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
    alerta +=   mensaje;
    alerta += '</div>';
    $(".flash").html(alerta);
    if(typeof obj !== 'undefined'){

        if(obj instanceof Array){

            $.each(obj,function(index,value){
                $(value).parents('.form-group').addClass('has-error');
            })

        }else{
            $(obj).parents('.form-group').addClass('has-error');

        }

    }
}
function cerrarFlash(){
    $('.flash').html("");


}
function setRequired(){
    var icono = '<i class="fa fa-asterisk" title="Campo necesario"></i>';
    $('input,select').filter('[required]').each(function(){
        $(this).parents(".form-group").find("label").before(icono);

    })
}
function validar(e){
    var error = "";
    var cajas = [];
    console.log("-> Validando");
    $('input,select').filter('[required]').each(function(){
        if($(this).is(':visible') && ($(this).val()=="" || $(this).val()==0)){
            var nombre = $(this).parents(".form-group").find("label").text();
            nombre = nombre.replace(":","");
            error += "* "+nombre+" es requerido. <br>";
            cajas.push("#"+$(this).attr("id"));
            console.log("#"+$(this).attr("id")+" es requerido");
        }

    });
    $('.has-feedback').each(function(){
        if($(this).is(':visible') && $(this).hasClass('has-error')){
            var nombre = $(this).find("label").text();
            nombre = nombre.replace(":","");
            error += "* "+nombre+" ya agregado. <br>";
        }

    });


    if(error!=""){
        Flash(error,"danger",cajas);
        if (typeof e !== typeof undefined && e !== false) {
            e.preventDefault();
        }
        return false;
    }
    else
        return true;
}
function renderView(vista,contenedor){
    contenedor = typeof contenedor !== 'undefined' ?  contenedor : "body";
    $.get( "render/"+vista, function( data ) {
        $(contenedor).append(data);
        if (typeof setKeys == 'function') {
            setKeys(vista);
        }
    });
}
function PlaySound(soundObj) {
    var sound = document.getElementById(soundObj);
    sound.play();
}