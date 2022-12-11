@extends('layouts.auth')
@section('htmlheader_title','Iniciar sesion')

@section('content')
    <div id="fondo"></div>
    <body class="hold-transition login-page">
    <div class="outer">
        <div class="middle">
            <div class="login-box">
                <div class="login-box-body" style="border-radius: 5px; background-color: white; padding: 15px">
                    <div style="font-family: Raleway; font-weight: bold; margin-bottom: 10px" class="login-logo text-center">
                        <img style="width: 100%" src="{{asset('/img/titulo.png')}}" alt=""/>
                    </div>

                    <form action="{{ url('/login') }}" method="post" onsubmit="$('#btnSubmit').start('Ingresando...')">
                        <p class="text-left"><b>Iniciar Sesión</b></p>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group has-feedback">
                            <input type="text" class="form-control" placeholder="Email" name="email"/>
                        </div>
                        <div class="form-group has-feedback">
                            <input type="password" class="form-control" placeholder="{{ trans('adminlte_lang::message.password') }}" name="password"/>
                        </div>
                        @if(!isset($workspace))
                            <div class="form-group has-feedback">
                                <input type="text" placeholder="Espacio de trabajo" class="form-control" value="" name="workspace"/>
                            </div>
                        @else
                            <input type="hidden" placeholder="Espacio de trabajo" class="form-control" value="{!! $workspace !!}" name="workspace"/>
                        @endif
                        <div class="">
                                <button id="btnSubmit" type="submit" class="btn btn-success btn-block">Iniciar sesión</button>

                        </div>
                        @if(isset($workspace))
                            <div class="row">
                                <div class="col-xs-12 text-right">
                                    <br>
                                    <a href="{!! url('/login') !!}"><small>Ingresar a otro espacio de trabajo</small></a>
                                </div>
                            </div>
                        @endif
                    </form>

                </div>
                @if (count($errors) > 0)
                    <div class="alert alert-danger" style="color: #ffffff">
                        <strong>Whoops!</strong> {{ trans('adminlte_lang::message.someproblems') }}<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

            </div>
        </div>
    </div>
    <div id="footer" class="footer default" role="contentinfo">
        <div style="font-size: 12px; padding: 10px">
            <div id="footerLinks" class="footerNode text-secondary">
                <span id="ftrCopy">R&V Consultores ©2021 - {!! date('Y') !!}
                </span>
                <a id="ftrTerms" href="">Términos de uso</a>
                <a id="ftrPrivacy" href="">Privacidad y cookies</a>
            </div>
        </div>
    </div>
    @include('layouts.partials.scripts_auth')
    <style>
        body{
            min-height: 715px;
            position: relative;
            background: transparent;
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

    </body>
@endsection
