var loader = '<i class="fa fa-spinner fa-spin fa-fw"></i>';
navigator.mediaDevices.addEventListener('devicechange', () => {
    // Do whatever you need to with the devices
    // Maybe use enumerateDevices() to see what connected
    navigator.mediaDevices.enumerateDevices()
        .then(devices => {
            // Check the connected devices
            console.log(devices);
        });
});
(function($){
    $.fn.extend({
        startDisable : function (msg) {
            if(typeof $(this).html() === 'undefined')
            {
                return;
            }
            var html = $(this).html();
            html = html.replace(loader,"");
            if(typeof msg === 'undefined' && $(this).hasClass("btn")) {
                if($(this).text=="")
                    msg = '';
                else
                    msg = "Guardando...";
            }
            else if(typeof msg === 'undefined')
                msg = "Cargando...";

            $(this).attr("data-label",html);
            $(this).html(loader+" "+msg);
            $(this).attr("disabled",true);
        }
    });
    $.fn.extend({
        stopDisable : function (msg) {
            var html = $(this).attr("data-label");
            if(typeof msg === 'undefined')
                msg = html;
            $(this).removeAttr("data-label");
            $(this).html(msg);
            $(this).attr("disabled",false);
        }
    });
    $.fn.extend({
        desactivar : function () {
            var html = $(this).text();
            if(html.trim()=="")
                $(this).html(loader+" Cargando...");
            $(this).addClass("disabled");
        }
    });
    $.fn.extend({
        activar : function () {
            $(this).removeClass("disabled");
        }
    });
    $.fn.extend({
        progreso : function (porcentaje,msg,status) {

            porcentaje = porcentaje>100? 100:porcentaje;

            $(this).find(".progress-bar").css("width",porcentaje+"%");
            if(typeof msg === 'undefined') {
                porcentaje = Math.round(porcentaje);
                $(this).find(".statusProgress").text(porcentaje + "%");
            }
            else
                $(this).find(".statusProgress").text(msg);
            if(typeof status !== 'undefined'){
                /*$(this).find(".progress-bar").removeClass('progress-bar-success');
                $(this).find(".progress-bar").removeClass('progress-bar-info');
                $(this).find(".progress-bar").removeClass('progress-bar-warning');
                $(this).find(".progress-bar").removeClass('progress-bar-danger');*/
                $(this).find(".progress-bar").removeClass('progress-bar-striped active');
                $(this).find(".progress-bar").addClass('progress-bar-'+status);
            }
            else{
                $(this).find(".progress-bar").addClass('progress-bar-striped active');
            }

        }
    });
    $.fn.extend({
        mydatatable : function () {
            var obj = $(this);
            var callback = obj.attr("data-function");
            var total = obj.find(".totalPages").text();
            obj.find(".fecha").datepicker({
                dateFormat: 'yy-mm-dd',
                changeYear: true,
                changeMonth: true,
                beforeShow: function(el, dp) {
                    $(el).parent().append($('#ui-datepicker-div'));
                    $('#ui-datepicker-div').addClass('datepicker-modal');
                    $('#ui-datepicker-div').hide();
                },
                onSelect: function (dateText, inst) {
                    eval(callback);
                }

            });
            obj.find(".page-link[data-go]").on("click",function(){
                var page = $(this).attr("data-go");
                page = parseInt(page);
                total = parseInt(total);
                if(page>0 && page<=total) {
                    obj.find(".currentPage").text(page);
                    eval(callback);
                }
            });
            obj.find(".jumpto").on('keypress',function(e) {
                if(e.which == 13) {
                    var page = $(this).val();
                    page = parseInt(page);
                    total = parseInt(total);
                    if(page>0 && page<=total) {
                        obj.find(".currentPage").text(page);
                        eval(callback);
                    }
                }
            });
            obj.find(".showup").on('keypress',function(e) {
                if(e.which == 13) {
                    eval(callback);
                }
            });
            obj.find("th[data-col]").on("click",function(){
                if($(this).hasClass("asc")){
                    $(this).toggleClass("asc").toggleClass("desc");
                }
                else if($(this).hasClass("desc")){
                    $(this).toggleClass("asc").toggleClass("desc");
                }
                else{
                    $(this).toggleClass("desc");
                }
                eval(callback);
            });
            obj.find("input.fieldSearch:text").on('keypress',function(e) {
                if(e.which == 13) {
                    eval(callback);
                }
            });
            obj.find("select.fieldSearch").on('change',function(e) {
                eval(callback);
            });
            obj.find("input.fieldQuery:text").on('keypress',function(e) {
                if(e.which == 13) {
                    eval(callback);
                }
            });
        }
    });
    $('<audio id="uploadSound">' +
        '<source src="/sounds/ogg/03 Primary System Sounds/state-change_confirm-up.ogg" type="audio/ogg">' +
        '<source src="/sounds/ogg/03 Primary System Sounds/state-change_confirm-up.mp3" type="audio/mpeg">' +
        '<source src="/sounds/ogg/03 Primary System Sounds/state-change_confirm-up.wav" type="audio/wav"></audio>').appendTo('body');
})(jQuery);
function borrarElemento(valor) {
    var url = $(valor).attr('data-destino');
    var mensaje = $(valor).attr("data-mensaje");
    if(!mensaje) {
        mensaje = "¿Está seguro de eliminar este registro?";
    }
    Swal.fire({
        title: mensaje,
        text: "No podrá deshacer esta acción",
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url : url
            })
                .done(function (data) {
                    if(data[0]=="error"){
                        Swal.fire(
                            'Opps!',
                            data[1],
                            'error'
                        );
                    }else {
                        window.location.reload();
                    }
                })
                .fail(function (data) {
                    Swal.fire(
                        'Opps!',
                        'Algo salio mal, intente de nuevo',
                        'error'
                    );
                });
        }
    });

}
function filtros(table){
    let q = {};
    q["page"] = table.find(".currentPage").text();
    q["perpage"] = table.find(".showup").val();
    table.find(".fieldSearch").each(function(){
        if($(this).val()!="") {
            q[this.name] = $(this).val();
        }
    });
    table.find(".fieldQuery").each(function(){
        if($(this).val()!="") {
            q["query"] = $(this).val();
        }
    });
    table.find(".asc").each(function(){
        if($(this).data("col")!="") {
            q["sort"] = $(this).data("col")+"_asc";
        }
    });
    table.find(".desc").each(function(){
        if($(this).data("col")!="") {
            q["sort"] = $(this).data("col")+"_desc";
        }
    });
    let queryString = window.location.search;
    let urlParams = new URLSearchParams(queryString);
    let entries = urlParams.entries();
    for(let entry of entries) {
        q[entry[0]] = entry[1];
    }
    return q;
}
function getTC(){
    let container = $("#modalTC .modal-body");
    let table = $("#tbTC");
    let q = filtros(table);
    container.desactivar();
    $.post("/general/getTC", {
        _token: $('meta[name=csrf-token]').attr('content'),
        q:q
    })
        .done(function (data) {
            container.html(data[0]).activar();
            $("#tbTC").mydatatable();
        })
        .fail(function(xhr)
        {
            container.html(xhr.responseText).activar();
        });
}
function getA22(num){
    let container = $("#modalA22 .modal-body");
    let table = $("#tbA22");
    let q = filtros(table);
    container.desactivar();
    $.post("/general/getA22", {
        _token: $('meta[name=csrf-token]').attr('content'),
        q:q,
        num:num
    })
        .done(function (data) {
            container.html(data[0]).activar();
            $("#tbA22").mydatatable();
            $("#modalA22 .modal-title").text(data[1]);
            $("#modalA22").modal("show");
        })
        .fail(function(xhr)
        {
            container.html(xhr.responseText).activar();
        });
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

    Swal.fire({
        title:"Error",
        html:msg,
        type: 'error'
    });

    $(".aux").remove();

}
function partialReload(selector,valores){
    if($(selector).length>0) {
        var src = $(selector).data("source");
        $.post("/general/partialReload", {
            _token: $('meta[name=csrf-token]').attr('content'),
            src: src,
            valores: valores
        })
            .done(function (data) {
                $(selector).replaceWith(data);
            })
            .fail(function (xhr) {
                console.log(xhr.responseText);
            });
    }
}
function makeAlert(mensaje,clase){
    var alerta = '';
    switch (clase){
        case "success":
            alerta = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-check"></i> ' +
                mensaje +
                '</div>';
            break;
        case "info":
            alerta = '<div class="alert alert-info alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-info"></i> ' +
                mensaje +
                '</div>';
            break;
        case "warning":
            alerta = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> ' +
                mensaje +
                '</div>';
            break;
        case "error":
            alerta = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> ' +
                mensaje +
                '</div>';
            break;
    }
    return alerta;
}