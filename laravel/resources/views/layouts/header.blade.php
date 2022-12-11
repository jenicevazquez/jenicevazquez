<meta name="csrf-token" content="{!! \Illuminate\Support\Facades\Session::token() !!}">
<nav class = "navbar navbar-default navbar-static-top" role = "navigation">
    <div class="">
        @if (!Auth::guest())
            <div class = "navbar-collapse collapse" role = "navigation" id="bs-example-navbar-collapse-1">
                <ul class = "nav navbar-nav">
                    <li>
                        <a href = "{{url('/superadmin/licencias')}}">
                            <span class="fa fa-folder" aria-hidden="true"></span>
                            Licencias
                        </a>
                    </li>
                    <li>
                        <a href = "{{url('/superadmin/noticias')}}">
                            <span class="fa fa-newspaper" aria-hidden="true"></span>
                            Noticias
                        </a>
                    </li>
                    <li>
                        <a href = "{{url('/superadmin/sistemas')}}">
                            <span class="fa fa-cubes" aria-hidden="true"></span>
                            Sistemas
                        </a>
                    </li>
                    <li>
                        <a href = "{{url('/superadmin/permisos')}}">
                            <span class="fa fa-user-lock" aria-hidden="true"></span>
                            Permisos
                        </a>
                    </li>
                    @yield("expedientesubmenu","")
                </ul>
            </div>
    @endif
    </div>
</nav>
<script>
    $(document).ready(function(){
        $('body').tooltip({
            selector: 'svg, i .glyphicon, a, span',
            my: "center bottom",
            at: "center top-10"
        });
        @if(Auth::user()->alertas == 1)
            $.post('{{ url('general/getNotificaciones') }}', {
                _token: $('meta[name=csrf-token]').attr('content')
            })
            .done(function(data){
                $('#alertas').replaceWith(data);
                $('.verMasAlertas').click(function(e){
                    e.stopPropagation();
                    var pag = $(this).attr('data-pag');
                    $.post("{{url('general/masAlertas')}}", {
                        _token: $('meta[name=csrf-token]').attr('content'),
                        pagina: pag
                    })
                        .done(function (data) {
                            var alertas = "";
                            for(var i = 0; i< data["documentos"].length; i++){
                                alertas += "<li><a href='{{url('pedimentos')}}/"+data["documentos"][i]["id"]+"'>" +
                                    "<i class='fa fa-folder text-yellow' aria-hidden='true'></i>" + data["documentos"][i]["pedimento"] +
                                    "</a></li>";
                                alertas += "<ul>";
                                for(var k in data["documentos"][i]["faltan"]){
                                    alertas += "<li><i class='fa fa-file text-aqua' aria-hidden='true'></i>"+ k +" </li>";
                                }
                                alertas += "</ul>";
                            }
                            $('.verMasAlertas').attr("data-pag", parseInt(pag)+1);
                            if(data["documentos"].length < 10){
                                $('.verMasAlertas').hide();
                            }
                            $('#thismenu').append(alertas);
                        })
                        .fail(function(xhr, textStatus, errorThrown)
                        {
                            errorShow(xhr.responseText);
                        });
                });
            })
        @endif
    });
</script>






