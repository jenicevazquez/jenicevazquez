@extends('sitio2.app')
@section('main-css')
    <style>
        .oculto{
            display: none;
        }
        .btnredes{
            border-top: solid 1px #dddd;
            border-bottom: solid 1px #dddd;
            text-align: center;
        }
        .myfield{
            border-radius: 10px;
            height: 32px;
        }
        .field-circle{
            height: 32px;
            border-radius: 60px;
            width: 32px;
        }
    </style>
@endsection
@section('main-content')
    @php($meses = ["","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"])
    @php($admin = $_SERVER['REMOTE_ADDR']=="189.202.50.218")
    @if($admin||!Auth::guest())
        <nav class="navbar navbar-expand-lg navbar-light bg-light" style="border-radius: 0; margin: 0">
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    @if($admin)
                    <li class="nav-item">
                        <a data-toggle="collapse" data-target="#nuevaNota" title="Nuevo" class="nav-link" href="#"><i class="fas fa-plus"></i></a>
                    </li>
                    @endif
                </ul>
                <ul class="navbar-nav ml-auto">
                    @if(!Auth::guest())
                    <li class="nav-item">
                        <a title="Salir de sesion" class="nav-link" href="/logout"><i class="fas fa-sign-out-alt"></i></a>
                    </li>
                    @endif
                </ul>
            </div>
        </nav>
    @endif
    @if($admin)
        <div id="nuevaNota" class="collapse" style="padding: 15px">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <form action="/v2/storenotas" method="post" style="width:100%">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group col-md-8">
                                <div class="form-group col-md-12">
                                    {!! Form::label('titulo', 'Titulo:') !!}
                                    {!! Form::text('titulo', null, ['class' => 'form-control','maxlength'=>255]) !!}
                                </div>
                                <div class="form-group col-md-12">
                                  {!! Form::label('texto', 'Nota:') !!}
                                  {!! Form::textarea('texto', null, ['class' => 'form-control','maxlength'=>5000]) !!}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group col-md-12">
                                {!! Form::label('categoria', 'Categoria:') !!}
                                {!! Form::text('categoria', null, ['class' => 'form-control','maxlength'=>255]) !!}
                                </div>
                                <div class="form-group col-md-12">
                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <section class="colorlib-blog" data-section="blog">
    <div class="colorlib-narrow-content">
        <div class="row">
            <div class="col-md-12 animate-box" data-animate-effect="fadeInLeft">
                <span class="heading-meta">Mis notas</span>
                <h2 class="colorlib-heading">Mis notas de programación y otras cosas</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 animate-box" data-animate-effect="fadeInLeft">
                @foreach($notas as $nota)
                    <div class="card" style="margin-bottom: 3em">
                      <div class="card-body">
                          <div class="blog-entry" style="margin: 0">
                              <div class="desc">
                                  <span><small>{!! $meses[$nota->created_at->format('n')] !!} {!! $nota->created_at->format('d') !!}, {!! $nota->created_at->format('Y') !!} </small> | <small> {!! $nota->categoria !!} </small> </span>
                                  <h3><a href="/v2/notas/{!! $nota->id !!}">{!! $nota->titulo !!}</a></h3>
                                  <p>{!! $nota->texto !!}</p>
                              </div>
                              <div class="row" style="padding: 5px 0">
                                  <div class="col-md-12">
                                      <span class="badge badge-primary"><i class="fas fa-thumbs-up"></i> {!! count($nota->likes) !!}</span>
                                      <span class="badge badge-primary"><i class="far fa-comment"></i> {!! count($nota->comentarios) !!}</span>
                                  </div>
                              </div>
                              @if(!Auth::guest())
                                  <div class="row">
                                      <div class="col-md-12">
                                          <div class="col-md-6 btnredes"><a {!! $nota->megusta? 'disabled':'' !!} data-id="{!! $nota->id !!}" onclick="btnMegusta(this)" class="btn btn-default"><i class="fas fa-thumbs-up"></i> Me gusta</a></div>
                                          <div class="col-md-6 btnredes"><a onclick="btnComentar({!! $nota->id !!})" class="btn btn-default"><i class="far fa-comment"></i> Comentar</a></div>
                                      </div>
                                  </div>
                                  <div class="row" style="padding: 15px 0">
                                      <div style="padding: 0"  class="col-md-1"><div class="field-circle" style="float: right; background-image:url(/img/sitio/about.PNG);"></div></div>
                                      <div class="col-md-11"><input data-id="{!! $nota->id !!}" type="text" name="comment" id="comment{!! $nota->id !!}" class="form-control myfield comentar" placeholder="Escribe un comentario..."></div>
                                  </div>
                              @else
                                  <div class="row">
                                      <div class="col-md-12">
                                          <div class="col-md-6 btnredes"><a onclick="login(this)" class="btn btn-default"><i class="fas fa-thumbs-up"></i> Me gusta</a></div>
                                          <div class="col-md-6 btnredes"><a onclick="login(this)" class="btn btn-default"><i class="far fa-comment"></i> Comentar</a></div>
                                      </div>
                                  </div>
                              @endif
                              <div id="comentarios{!! $nota->id !!}">
                              @foreach($nota->comentarios as $comentario)
                              <div class="row" style="padding: 15px 0">
                                  <div style="padding: 0"  class="col-md-1"><div class="field-circle" style="float: right; background-image:url(/img/sitio/about.PNG);"></div></div>
                                  <div class="col-md-10"><div class="form-control myfield" style="height: auto">
                                          <b>{!! $comentario->autor->name !!}</b>
                                          <p>{!! $comentario->comentario !!}</p>
                                      </div></div>
                                  @if($comentario->user_id==Auth::user()->id)
                                  <div style="padding: 0"  class="col-md-1">
                                      <a title="Borrar" onclick="borrarComentario({!! $comentario->id !!})"><div class="field-circle" style="float: left;"><i style="padding: 10px 0" class="fas fa-times"></i></div></a>
                                  </div>
                                   @endif
                              </div>
                              @endforeach
                              </div>
                          </div>
                      </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endsection
@section('main-modales')
    <div id="modalLogin" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-login">
                                <div class="card-header">
                                    <h3 class="card-title">Iniciar sesión</h3>
                                </div>
                                <div class="card-body">
                                    <form action="{{ url('/v2/dologin') }}" method="post">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <div class="form-group has-feedback">
                                            <input type="text" class="form-control" placeholder="Email" name="email"/>
                                        </div>
                                        <div class="form-group has-feedback">
                                            <input type="password" class="form-control" placeholder="{{ trans('adminlte_lang::message.password') }}" name="password"/>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-block btn-flat">Iniciar sesión</button>
                                            <a onclick="showRegister()" class="btn btn-primary btn-block btn-flat">Registrarme</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="card card-registrar oculto">
                                <div class="card-header">
                                    <h3 class="card-title">Registrarse</h3>
                                </div>
                                <div class="card-body">
                                    <form action="{{ url('/register') }}" method="post">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <div class="form-group has-feedback">
                                            <input id="txtNombre" type="text" class="form-control" placeholder="Nombre completo" name="name" value="{{ old('name') }}"/>
                                            <span class="glyphicon glyphicon-user form-control-feedback"></span>
                                        </div>
                                        <div class="form-group has-feedback">
                                            <input id="txtEmail" type="email" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}"/>
                                            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                        </div>
                                        <div class="form-group has-feedback">
                                            <input id="txtPass" type="password" class="form-control" placeholder="Contraseña" name="password"/>
                                            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                                        </div>
                                        <div class="form-group has-feedback">
                                            <input id="txtPass2" type="password" class="form-control" placeholder="Repita contraseña" name="password_confirmation"/>
                                            <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 text-center">
                                                <button onclick="registrar(this)" type="button" class="btn btn-primary btn-block btn-flat">REGISTRAR</button>
                                                <a onclick="showLogin()" class="btn btn-primary btn-block btn-flat">Iniciar sesión</a>
                                            </div><!-- /.col -->
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('main-js')
    <script>
        $(document).ready(function(){
            $(".comentar").on('keypress',function(e) {
                if(e.which == 13) {
                    comentar(this);
                }
            });
        })
        function borrarComentario(id){
            $.post("/v2/borrarComentarios", {
                _token: $('meta[name=csrf-token]').attr('content'),
                id:id
            })
                .done(function (data) {
                    getComentarios(id);
                })
                .fail(function(xhr)
                {
                    console.log(xhr.responseText);
                });
        }
        function comentar(obj){
            var id = $(obj).data("id");
            $.post("/v2/comentar", {
                _token: $('meta[name=csrf-token]').attr('content'),
                comentario: $(obj).val(),
                id:id
            })
                .done(function (data) {
                    $(obj).val("");
                    getComentarios(id);
                })
                .fail(function(xhr)
                {
                    console.log(xhr.responseText);
                });
        }
        function getComentarios(id){
            $.post("/v2/getComentarios", {
                _token: $('meta[name=csrf-token]').attr('content'),
                id:id
            })
                .done(function (data) {
                    $("#comentarios"+id).html(data);
                })
                .fail(function(xhr)
                {
                    console.log(xhr.responseText);
                });
        }
        function registrar(){
            $.post("/v2/register", {
                _token: $('meta[name=csrf-token]').attr('content'),
                name: $("#txtNombre").val(),
                email: $("#txtEmail").val(),
                password: $("#txtPass").val(),
            })
                .done(function (data) {
                    window.location.reload(true);
                })
                .fail(function(xhr)
                {
                    console.log(xhr.responseText);
                });
        }
        function showRegister(){
            $(".card-registrar").removeClass("oculto");
            $(".card-login").addClass("oculto");
        }
        function showLogin(){
            $(".card-registrar").addClass("oculto");
            $(".card-login").removeClass("oculto");
        }
        function login(obj){
            $("#modalLogin").modal("show");
        }
        function btnMegusta(obj){
            var id = $(obj).data("id");
            $.post("/v2/megusta", {
                _token: $('meta[name=csrf-token]').attr('content'),
                id:id
            })
                .done(function (data) {
                    $(obj).attr("disabled",data[0]);
                })
                .fail(function(xhr)
                {
                    console.log(xhr.responseText);
                });
        }
        function btnComentar(id){
            $("#comment"+id).focus();
        }
        function btnCompartir(id){

        }
    </script>
@endsection