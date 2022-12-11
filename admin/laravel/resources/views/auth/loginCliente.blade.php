@extends('layouts.authShop')
@section('htmlheader_title','Registrate')
@section('content')

    <body class="hold-transition register-page">
    <div class="outer">
        <div class="middle">
            <div class="register-box">

        <div class="register-box-body" style="border-radius: 5px">
            <div class="row" style="padding: 15px">
            <div class="col-xs-12">
                <img style="width: 100%; margin-bottom: 15px" src="https://savi.ryvconsultores.mx/img/illo_welcome_1.png">
            </div>
            <div class="col-xs-12">
                <p class="login-box-msg"><b>¡Hola! Para seguir, ingresa tu correo y clave</b></p>
                <form action="{{ url('/register') }}" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group has-feedback">
                        <input id="txtEmail" type="email" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}"/>
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input id="txtPass" type="password" class="form-control" placeholder="Contraseña" name="password"/>
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <div class="row">
    
                        <div class="col-xs-12 text-center">
                            <button id="btnSubmit" onclick="ingresar(this)" type="button" class="btn btn-primary btn-block btn-flat">Iniciar Sesion</button>
                            <BR>
                            <a href="/shop/register">No tienes cuenta aún? Registrate aqui</a>

                            <small style="color: grey;"></small>
                        </div><!-- /.col -->
                    </div>
                </form>
            </div>
            </div>
        </div><!-- /.form-box -->
    </div><!-- /.register-box -->
        </div>
    </div>
    @include('auth.terms')
</body>
@include('layouts.partials.scripts_auth')
<script>
    $(document).ready(function(){
        $("#txtPass").on('keypress',function(e) {
            if(e.which == 13) {
                var obj = $("#btnSubmit");
                ingresar(obj);
            }
        });
    });
    function ingresar(obj){
        $(obj).start("Ingresando...");
        $.post("{{url('/shop/loginCliente')}}", {
            _token:     $('meta[name=csrf-token]').attr('content'),
            name:       $("#txtNombre").val(),
            email:      $("#txtEmail").val(),
            password:   $("#txtPass").val()
        })
            .done(function (data) {
                $(obj).stop();
                if(data[0]=="success"){
                    window.location.href = data[1];
                }
                else{
                    if(data[2]==2){
                        swal.fire({
                            title:"Atencion",
                            html:data[1],
                            type: 'error',
                            footer: '<a onclick="registrarMail()">Enviar de nuevo correo de activación</a>'
                        });
                    }else{
                        swal.fire({
                            title:"Atencion",
                            html:data[1],
                            type: 'error'
                        });
                    }

                }
            })
            .fail(function(xhr, textStatus, errorThrown)
            {
                $(obj).stop();
                console.log(xhr.responseText);
            });
    }
    function registrarMail(){

        $.post("{{url('/shop/registerMail')}}", {
            _token:     $('meta[name=csrf-token]').attr('content'),
            email:      $("#txtEmail").val()
        })
        .done(function (data) {
            if(data[0]=="success"){
                swal.fire({
                    title: "Listo",
                    html:"Se ha enviado un correo de confirmación para continuar con el proceso, verifique su bandeja de entrada y folder de correo no deseado",
                    type: 'info',
                    showCancelButton: false,
                    closeOnConfirm: false,
                    confirmButtonText: "Continuar"
                }).then(function () {
                    window.location.reload(true);
                });
            }
            else{
                swal.fire({
                    title:"Atencion",
                    html:data[1],
                    type: 'error'
                });
            }
        })
        .fail(function(xhr, textStatus, errorThrown)
        {
            console.log(xhr.responseText);
        });
    }
</script>
<style>
        .login-page, .register-page{
            background: #1c7099;
        }
        .middle{
            display: block;
            padding-top: 5%;
        }
        body{
            min-height: 715px;
            position: relative;
            background: transparent;
        }
        #footer {
            bottom: 0;
            width: 100%;
            overflow: visible;
            z-index: 99;
            clear: both;
            background-color: rgba(0,0,0,.6);
            filter: progid:DXImageTransform.Microsoft.gradient(GradientType=0,startColorstr='#99000000',endColorstr='#99000000');

        }
        div.footerNode {

            margin: 5px;
            float: right;
            position: relative;
            top: 38px;

        }
        .logo-circle{
            height: 170px;
            width: 170px;
            vertical-align: text-bottom;
            border: 5px solid white;
            box-shadow: inset 0 2px 3px 0 rgba(0,0,0,.15),0 3px 3px 0 rgba(0,0,0,.15);
            position: relative;
            top: -105px;
            margin-bottom: -105px;
            background: white;
        }

    </style>
@endsection
