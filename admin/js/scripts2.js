$(document).on("load",function () {
    ajustarPantalla();
});
$(document).on("resize",function () {
    ajustarPantalla();
});
function flyToElement(flyer, flyingTo) {
    var $func = $(this);
    var divider = 3;
    var flyerClone = $(flyer).clone();
    $(flyerClone).css({position: 'absolute', top: $(flyer).offset().top + "px", left: $(flyer).offset().left + "px", opacity: 1, 'z-index': 1000});
    $('body').append($(flyerClone));
    var gotoX = $(flyingTo).offset().left + ($(flyingTo).width() / 2) - ($(flyer).width()/divider)/2;
    var gotoY = $(flyingTo).offset().top + ($(flyingTo).height() / 2) - ($(flyer).height()/divider)/2;

    $(flyerClone).animate({
            opacity: 0.4,
            left: gotoX,
            top: gotoY,
            width: $(flyer).width()/divider,
            height: $(flyer).height()/divider
        }, 700,
        function () {
            $(flyingTo).fadeOut('fast', function () {
                $(flyingTo).fadeIn('fast', function () {
                    $(flyerClone).fadeOut('fast', function () {
                        $(flyerClone).remove();
                    });
                });
            });
        });
}
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

function cancelarElemento(valor) {
    var url = $(valor).attr('data-destino');
    swal.fire({
        title             : "Cancelar",
        text              : "Esta seguro en cancelar este registro?",
        type              : "warning",
        showCancelButton  : true,
        closeOnConfirm    : false,
        confirmButtonText : "Cancelar",
        confirmButtonColor: "#ec6c62"
    }).then(function () {
        $.ajax({
            url : url
        })
            .done(function (data) {
                window.location.reload();
            })
            .error(function (data) {
                swal("Oops", "Algo salio mal, intente de nuevo", "error");
            });
    });
}

function ajustarPantalla(){
    var height = $("body").height()-401;
    $(".table-responsive").each(function(){
        $(this).css("height",height);
    })
}
function pantalla() {
    var altura = $(window).height();

    $("#fondo2").css("height",altura);
}
$(document).ready(function(){
    pantalla();
});
$(window).resize(function(){
    pantalla();
});