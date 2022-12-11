function guardarUsuarios(){
    var titular = $("#titular").is(":checked")? 1:0;
    var easySCAN = $("#easySCAN").is(":checked")? 1:0;
    $.post("/admin/licencias/scan/storeUser", {
        _token:     $('meta[name=csrf-token]').attr('content'),
        nombre:     $("#nombreUsuario").val(),
        titular:    titular,
        email:      $("#emailUsuario").val(),
        password:   $("#password").val(),
        id:         licencia_id,
        telefono:   $("#telefono").val(),
        notas:      $("#notas").val(),
        easySCAN:   easySCAN
    })
        .done(function (data) {
            window.location.href = "?modulo=inactivos";
        })
        .fail(function(xhr)
        {
            errorShow(xhr.responseText);
        });
}
$(document).ready(function(){
    listRegistros();
    $(".fecha").datepicker();
});
function setBotones(){
    $(".fieldSearch").on('keypress',function(e) {
        if(e.which == 13) {
            listRegistros();
        }
    });
    $(".txtActivacionField").on('keypress',function(e) {
        if(e.which == 13) {
            addActivacion();
        }
    });
    $(document).on('click', '.toggleActivo', function(){
        var activo = $(this).attr('data-id');
        var id = $(this).attr('id');
        var toggle = $(this);

        $.post( "/superadmin/licencia/activo",{
            _token: $('meta[name=csrf-token]').attr('content'),
            id: id,
            activo: activo
        })
            .done(function(data) {
                if(activo == 1){
                    toggle.replaceWith($("<a id='"+data+"' class='Desactivado toggleActivo' title='Activar' data-id='0'><i class='fas fa-toggle-off'></i></a>"));
                } else {
                    toggle.replaceWith($("<a id='"+data+"' class='Activado toggleActivo' title='Desactivar' data-id='1'><i class='fas fa-toggle-on'></i></a>"));
                }
            })
            .fail(function(xhr){
                errorShow(xhr.responseText);
            })
    });
}
function sacar(obj){
    var id = $(obj).attr("data-id");
    $.get( "/admin/licencia/sacarSCAN/"+id, function() {
        $(obj).remove();
    });
}
function asignarLicencia(obj){
    var datos = $(obj).parents("tr").attr("data-datos");
    console.log(datos);
    datos = JSON.parse(datos);
    $("#btnGuardar").attr("data-id",datos.id);
    $("#licenciaModal").modal("show");
}
function updateLicencia(obj){
    var id = $(obj).attr("data-id");
    var licencia = $("#licenciaUser").val();
    $(obj).start("Guardando...");
    $.post("/admin/licencia/asignarLicencia", {
        _token: $('meta[name=csrf-token]').attr('content'),
        id:id,
        licencia:licencia
    })
        .done(function () {
            window.location.reload(true);
        })
        .fail(function(xhr)
        {
            console.log(xhr.responseText);
        });
}
function setVigencia(obj){
    var fecha = $("#fechaVigencia").val();
    var id = $(obj).attr("data-id");
    var user = $(obj).attr("data-user");
    var notas = $("#notasVigencia").val();
    var fechapago = $("#fechaPago").val();
    var referencia = $("#referencia").val();
    var formapago = $("#formapago").val();
    var periodo = $("#periodo").val();
    $(obj).start("Guardando...");
    $.post("/admin/licencia/setVigencia", {
        _token: $('meta[name=csrf-token]').attr('content'),
        fecha:fecha,
        id:id,
        user:user,
        notas: notas,
        fechapago:fechapago,
        referencia:referencia,
        formapago:formapago,
        periodo:periodo
    })
        .done(function () {
            window.location.reload(true);
        })
        .fail(function(xhr)
        {
            console.log(xhr.responseText);
        });
}
function asignarVigencia(obj){
    var datos = $(obj).parents("tr").attr("data-datos");
    datos = JSON.parse(datos);
    $("#btnSetVigencia").attr("data-user",datos.id);
    $.post("/admin/licencia/scan/listVigencias", {
        _token: $('meta[name=csrf-token]').attr('content'),
        id:datos.id
    })
    .done(function (data) {
        $("#divVigencias").html(data[0]);
    })
    .fail(function(xhr)
    {
        console.log(xhr.responseText);
    });
}
function addActivacion(){
    $.post("/admin/licencia/addActivacion", {
        _token: $('meta[name=csrf-token]').attr('content'),
        inicia: $("#inicia").val(),
        vence: $("#vence").val(),
        observaciones: $("#observaciones").val(),
        id: $("#activacionId").val(),
        licencia: $("#licenciaId").val()
    })
        .done(function (data) {
            activaciones(data.licencia_id);
        })
        .fail(function(xhr)
        {
            console.log(xhr.responseText);
        });
}
function resetModal(){
    $("#inicia").val("");
    $("#vence").val("");
    $("#observaciones").val("");
    $("#activacionId").val(0);
    $("#btnCancel").addClass("oculto");
}
function activaciones(id){
    resetModal();
    $("#licenciaId").val(id);
    $.post("/admin/licencia/getActivaciones", {
        _token: $('meta[name=csrf-token]').attr('content'),
        id:id
    })
        .done(function (data) {
            var result = '';
            for(var i=0;i<data.length;i++){
                result += '<tr data-id="'+data[i].id+'" data-inicia="'+data[i].inicia+'" data-vence="'+data[i].vence+'" data-observaciones="'+data[i].observaciones+'">' +
                    '<td>'+data[i].inicia+'</td><td>'+data[i].vence+'</td><td>'+data[i].observaciones+'</td>' +
                    '<td style="text-align:center">' +
                    '<a title="Editar" href="javascript:void(0)" onclick="editar(this)"><i class="fas fa-edit"></i></a> ' +
                    '<a title="Borrar" href="javascript:void(0)" onclick="borrar(this)"><i class="fas fa-trash"></i></a></td>' +
                    '</tr>';
            }
            $("#tbactivaciones tbody").html(result);
            $("#modalActivaciones").modal("show");
        })
        .fail(function(xhr)
        {
            console.log(xhr.responseText);
        });

}
function borrar(obj) {
    var renglon = $(obj).parents("tr");
    var id = $(obj).parents("tr").attr("data-id");
    $.post("/admin/licencia/borrarActivacion", {
        _token: $('meta[name=csrf-token]').attr('content'),
        id:id
    })
        .done(function () {
            renglon.remove();
        })
        .fail(function(xhr)
        {
            console.log(xhr.responseText);
        });
}
function editar(obj) {
    var renglon = $(obj).parents("tr");
    var id = renglon.attr("data-id");
    var inicia = renglon.attr("data-inicia");
    var vence = renglon.attr("data-vence");
    var observaciones = renglon.attr("data-observaciones");

    $("#activacionId").val(id);
    $("#inicia").val(inicia);
    $("#vence").val(vence);
    $("#observaciones").val(observaciones);
    $("#btnCancel").removeClass("oculto");
}
function listRegistros(){
    var container = $(".panel-main");
    var q = {};
    q["page"] = container.find(".currentPage").text();
    q["perpage"] = container.find(".showup").val();
    $("#panel-main .fieldSearch").each(function(){
        if($(this).val()!="") {
            q[this.name] = $(this).val();
        }
    });
    var queryString = window.location.search;
    var urlParams = new URLSearchParams(queryString);
    var entries = urlParams.entries();
    for(var entry of entries) {
        q[entry[0]] = entry[1];
    }
    q["id"] = $("#id").val();
    q["email"] = $("#email").val();
    q["nombre"] = $("#nombre").val();
    q["notas"] = $("#notas").val();

    container.addClass("disabled");

    $.post("/admin/licencias/scan/listRegistrosScanUsers", {
        _token: $('meta[name=csrf-token]').attr('content'),
        q:q,
        licencia:licencia_id
    })
        .done(function (data) {
            container.find(".panel-body").html(data[0]);
            container.find("#paginadoRow").html(data[1]).paginado(listRegistros);
            container.removeClass("disabled");
            setBotones();
        })
        .fail(function(xhr)
        {
            console.log(xhr.responseText);
        });
}
function selectAll(){
    var estado = $("#selectAll").prop("checked");
    console.log(estado);
    $(".chkRegistro").prop("checked",estado);
    if(estado){
        $("#alertSelectAll").removeClass("oculto");
    }
    else{
        $("#alertSelectAll").addClass("oculto");
    }
}
function selectAllRecords(estado){
    $("#selectAllRecords").prop("checked",estado);
    if(estado){
        $("#stepOne").addClass("oculto");
        $("#stepTwo").removeClass("oculto");
    }
    else{
        $("#stepTwo").addClass("oculto");
        $("#stepOne").removeClass("oculto");
    }
}
function borrarUsuarios(obj){
    var q = {};
    $("#tbUsuarios .fieldSearch").each(function(){
        if($(this).val()!="") {
            q[this.name] = $(this).val();
        }
    });
    var ids = [];
    var todo = $("#selectAllRecords").is(":checked")? 1:0;
    if(todo==0){
        $("#tbUsuarios .chkRegistro:checked").each(function(){
            var temp = $(this).val();
            ids.push(temp);
        })
    }
    $(obj).start("Borrando...");
    $.post("/admin/licencias/removeUsers", {
        _token: $('meta[name=csrf-token]').attr('content'),
        ids:ids,
        todo: todo,
        q:q
    })
        .done(function () {
            $(obj).stop();
            listRegistros();
        })
        .fail(function(xhr)
        {
            $(obj).stop();
            errorShow(xhr.responseText);
        });
}
function setEditar(obj){
    var datos = $(obj).parents("tr").data("datos");
    console.log(datos);
    $('.nav-tabs').find('.active').removeClass('active');
    $("#btnSetVigencia").attr("data-id",datos.id);
    $("#fechaPago").val(datos.fechapago);
    $("#fechaVigencia").val(datos.vence);
    $("#referencia").val(datos.referencia);
    $("#formapago").val(datos.formapago);
    $("#periodo").val(datos.periodo);
    $("#notasVigencia").val(datos.notas);
}
function setNewVigencia(){
    $('.nav-tabs').find('.active').removeClass('active');
    $("#btnSetVigencia").attr("data-id",0);
}