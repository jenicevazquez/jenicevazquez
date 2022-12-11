function pantalla() {
    var altura = $(window).height();
    $("#fondo").css("height",altura);
    $("body").css("height",altura);
}
function printErrorMsg(msg) {
    $(".print-error-msg-login").removeClass('oculto').find("ul").html('');
    $(".print-error-msg-login").css('display', 'block');
    $.each(msg, function(key, value) {
        $(".print-error-msg-login").find("ul").append('<li>' + value + '</li>');
    });
}
$(document).ready(function(){
    $('.enviar').prop('disabled',false);
    $("body").css("cursor","default");
    $(".estado").hide();
    pantalla();
});

$(window).resize(function(){
    pantalla();
});