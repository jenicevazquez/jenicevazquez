@extends('layouts.auth')
@section('htmlheader_title','Iniciar Sesion')
@section('content')
    <div id="fondo" style="z-index: -1"></div>
    <body class="hold-transition login-page">
    <div class="outer">
        <div class="middle">
            <div class="login-box">
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> {{ trans('adminlte_lang::message.someproblems') }}<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="login-box-body">
                    <div class="login-logo">
                        <a href="{{ url('/home') }}"><b>Jenice Vazquez</b></a>
                    </div><!-- /.login-logo -->
                    <p class="login-box-msg"> Iniciar sesión </p>
                    <form action="{{ url('/login') }}" method="post">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group has-feedback">
                            <input type="text" class="form-control" placeholder="Email" name="email"/>
                            <i class="far fa-envelope form-control-feedback"></i>
                        </div>
                        <div class="form-group has-feedback">
                            <input type="password" class="form-control" placeholder="Contraseña" name="password"/>
                            <i class="fas fa-lock form-control-feedback"></i>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block btn-flat">Iniciar sesión</button>
                        </div>
                    </form>

                </div><!-- /.login-box-body -->

            </div><!-- /.login-box -->
        </div>
    </div>

    @include('layouts.partials.scripts_auth')

    </body>
    <style>
        #fondo{
            /*background-color: rgba(0,0,0,0.8);*/
            background: url('https://blog.desdelinux.net/wp-content/uploads/2012/11/php-wallpaper.jpg') center;
            background-size: cover ;
            position: absolute;
            top:0;
            left: 0;
            width: 100%;
            height: 786px;
            /*filter:brightness(0.4);*/
        }
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            overflow: visible;
            z-index: 99;
            clear: both;
            background-color: rgba(0,0,0,.6);
            filter: progid:DXImageTransform.Microsoft.gradient(GradientType=0,startColorstr='#99000000',endColorstr='#99000000');

        }
        div.footerNode {
            margin: 0;
            float: right;
        }
        .text-secondary {
            color: rgba(0,0,0,.7);
            font-size: 13px;
        }
        div.footerNode a, div.footerNode span {
            color: #fff;
            font-size: 12px;
            line-height: 28px;
            white-space: nowrap;
            display: inline-block;
            margin-left: 8px;
            margin-right: 8px;
        }
    </style>
@endsection
