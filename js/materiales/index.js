
$(document).ready(function(){
    listProductos();
});

function listProductos(){

    let container = $("#panel-data");
    let table = $("#tbmateriales");
    let q = filtros(table);
    container.desactivar();
    $.post('/materiales/listProductos', {
        _token: $('meta[name=csrf-token]').attr('content'),
        q:q
    })
        .done(function (data) {
            container.html(data[0]).activar();
            $("#tbmateriales").mydatatable();
        })
        .fail(function(xhr)
        {
            container.html(xhr.responseText).activar();
        });
}
function getHistory(obj){
    var datos = $(obj).parents("tr").data("datos");
    $("#historytitle").text(datos.clave);
    $.post("/materiales/getHistory", {
        _token: $('meta[name=csrf-token]').attr('content'),
        id:datos.id,
        clave: datos.clave
    })
        .done(function (data) {
            var result = '';
            if(data.length>0) {
                $.each(data, function (key, value) {
                    result += '<tr><td>' + value.created_at + '</td>' +
                        '<td>' + value.descripcion + '</td><td>' + value.usuario + '</td></tr>';
                });
            }
            else{
                result = '<tr><td class="text-center" colspan="3"><i>No se encontraron cambios registrados en el producto</i></td></tr>';
            }
            $("#tbHistory tbody").html(result);
            $("#modalHistory").modal("show");
        })
        .fail(function(xhr)
        {
            console.log(xhr.responseText);
        });

}