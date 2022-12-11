@extends('layouts.app')
@section('main-content')
<?php
$sucursales = General::usersucursal(General::user()->id);
?>
    <section class="content-header">
        <h1>
            Mi usuario
        </h1>
    </section>

    <section class="content">
       <div class="box">
            @if(General::user()->perfil==1)
                <div class="box-heading">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="pull-left">
                                <ol class="breadcrumb">
                                    <li><a href="{!! url('/') !!}"><i class="fa fa-home"></i> Inicio</a></li>
                                    <li class="active">Mi usuario</li>
                                </ol></div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="panel-body">
            @include('usuarios.script')
            <form id="formActualizar">
            <!--- Nombre Field --->
                <div class="form-group col-sm-6 col-lg-4">
                    {!! Form::label('nombre', 'Nombre:') !!}
                    {!! Form::text('nombre', General::user()->nombre, ['class' => 'form-control','maxlength'=>255,'required']) !!}
                </div>
                <!--- Email Field --->
                <div class="form-group col-sm-6 col-lg-4">
                    {!! Form::label('email', 'E-Mail:') !!}
                    {!! Form::text('email', General::user()->email, ['class' => 'form-control','maxlength'=>255,'required']) !!}
                </div>

                <!--- Password Field --->
                <div class="form-group col-sm-6 col-lg-4">
                    {!! Form::label('password', 'Contraseña: ') !!} <i class=" info fa fa-info-circle" title="Guarda la contraseña en un lugar seguro, no serás capaz de recuperarla, soló podrás cambiarla."></i>
                    <input name="password" value="" type="password" class="form-control" id="password">
                </div>
                <div class="form-group col-xs-12 col-sm-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Sucursales</h3>
                        </div>
                        <div class="panel-body">
                            @if(count($sucursales)>0)
                                @foreach($sucursales as $sucursal)
                                    <div class="col-xs-12 col-sm-4">
                                        @if($sucursal->principal==1)
                                            <i title="Marcar como principal" class="fas fa-star estrella hand" data-value="{!! $sucursal->sucursal_id !!}"></i> {!! $sucursal->sucursal->sucursal !!}<br>
                                        @else
                                            <i title="Marcar como principal" class="far fa-star estrella hand" data-value="{!! $sucursal->sucursal_id !!}"></i> {!! $sucursal->sucursal->sucursal !!}<br>
                                        @endif
                                    </div>
                                @endforeach
                            @else
                                <i>No se encuentran sucursales relacionados a su usuario.</i>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="form-group col-sm-12">
                    <button onclick="actualizarMiUsuario(this)" class="btn btn-success">Editar</button>
                    <a class = "btn btn-danger" href = "{!! url('home') !!}">
                        Cancelar
                    </a>
                </div>
            </form>
            </div>
        </div>
    </section>
    <script>
        function actualizarMiUsuario(obj){
            $(obj).start();
            var principal = $(".estrella.fas").data("value");
            var formData = new FormData(document.getElementById("formActualizar"));
            formData.append("_token", $('meta[name=csrf-token]').attr('content'));
            formData.append("principal", principal);
            $.ajax({
                url: "{{url("/usuarios/actualizarMiUsuario")}}",
                type: "post",
                dataType: "html",
                data: formData,
                cache: false,
                contentType: false,
                processData: false
            }) .done(function(data){
                window.location.reload(true);
            }) .fail(function(xhr){
                errorShow(xhr.responseText);
            });
        }
        $(document).ready(function(){
            $("#name,#password").on("keydown",function(e){
                // Allow: backspace, delete, tab, escape and enter
                if ($.inArray(e.keyCode, [46, 8, 9, 27, 13]) !== -1 ||
                    // Allow: home, end, left, right
                    (e.keyCode >= 35 && e.keyCode <= 39)) {
                    // let it happen, don't do anything
                    return;
                }
                if (e.which > 90 || e.which < 48 || e.which==59)
                {
                    (e).preventDefault();

                }
            });
            $(".estrella").on("click",function(){
                var obj = $(this);
                obj.start("");
                var suc = $(this).attr("data-value");
                $.post("{{url('/usuarios/setppalsuc')}}", {
                    _token: $('meta[name=csrf-token]').attr('content'),
                    user: '{!! General::user()->id !!}',
                    sucursal: suc
                })
                .done(function (data) {
                    obj.stop();
                    $(".estrella.fas").toggleClass("fas").toggleClass("far");
                    obj.toggleClass("fas").toggleClass("far" );
                })
                .fail(function(xhr, textStatus, errorThrown)
                {
                    console.log(xhr.responseText);
                });

            });
        })
    </script>
@endsection
