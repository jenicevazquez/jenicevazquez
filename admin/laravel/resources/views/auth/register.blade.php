@extends('layouts.authShop')
@section('htmlheader_title','Registrate')
@section('content')

    <body class="hold-transition register-page">
    <div class="outer">
        <div class="middle">
            <div class="register-box">

        <div class="register-box-body" style="border-radius: 5px">
            <div class="row" style="padding: 15px">
            <div class="col-xs-12 col-sm-6">
                <img style="width: 100%" src="https://savi.ryvconsultores.mx/img/illo_welcome_1.png">
            </div>
            <div class="col-xs-12 col-sm-6">
                <p class="login-box-msg"><b>Completa tus datos</b></p>
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
                            <button onclick="registrar(this)" type="button" class="btn btn-primary btn-block btn-flat">{{ trans('adminlte_lang::message.register') }}</button>
                            <BR>
                            <small style="color: grey;">Al registrarme, declaro que soy mayor de edad y acepto los Términos y condiciones y las Políticas de privacidad de SAVI.</small>
                            <br><br>
                            <a href="/shop/login">Ya tienes cuenta? Ingresa aqui</a>
                        </div><!-- /.col -->
                    </div>
                </form>
            </div>
            </div>
        </div><!-- /.form-box -->
    </div><!-- /.register-box -->
        </div>
    </div>
    <script>
        function registrar(obj){

            var pass = $("#txtPass").val();
            var pass2 = $("#txtPass2").val();
            if(pass!=pass2){
                swal.fire({
                    title:"Atencion",
                    html:"Las contraseñas no coinciden",
                    type: 'error'
                });
                return;
            }
            $(obj).start("Registrando...");
            $.post("{{url('/register')}}", {
                _token:     $('meta[name=csrf-token]').attr('content'),
                name:       $("#txtNombre").val(),
                email:      $("#txtEmail").val(),
                password:   $("#txtPass").val()
            })
            .done(function (data) {
                $(obj).stop();
                swal.fire({
                    title: "Listo",
                    html:"Se ha enviado un correo de confirmación para continuar con el proceso, verifique su bandeja de entrada y folder de correo no deseado",
                    type: 'info',
                    showCancelButton: false,
                    closeOnConfirm: false,
                    confirmButtonText: "Continuar"
                }).then(function () {
                    window.location.href = data;
                });
            })
            .fail(function(xhr, textStatus, errorThrown)
            {
                $(obj).stop();
                console.log(xhr.responseText);
            });
        }
    </script>
    @include('layouts.partials.scripts_auth')

    @include('auth.terms')

</body>
    <style>
        .login-page, .register-page{
            background: #1c7099;
        }
        .login-box, .register-box{
            width: 100%;
            max-width: 1000px;
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
