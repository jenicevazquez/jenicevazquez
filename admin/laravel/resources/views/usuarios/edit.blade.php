@extends('layouts.app')
@section('htmlheader_title')
    Mi usuario
@endsection
@section('main-content')

    <section class="content-header">
        <h1>
            Editar usuario
        </h1>
    </section>

    <section class="content">
    {!! Form::model($usuario, ['route' => ['usuarios.update', $usuario->id], 'method' => 'patch','id'=>'formEdit']) !!}

        <div class="box">
            @if(General::user()->perfil==1)
            <div class="box-heading">
                <div class="row">
                    <div class="col-xs-12">
                    <div class="pull-left">
                        <ol class="breadcrumb">
                          <li><a href="{!! url('/') !!}"><i class="fa fa-home"></i> Inicio</a></li>
                          <li><a href="{!! url('/usuarios') !!}"><i class="fa fa-users"></i> Usuarios</a></li>
                          <li class="active">{!! $usuario->name !!}</li>
                      </ol></div>
                    </div>
                </div>
            </div>
            @endif
            <div class="panel-body">
                @include('usuarios.fields')
                <div class="form-group col-sm-12">
                    <button type="submit" class="btn btn-success">Editar</button>
                    <a class = "btn btn-danger" href = "{!! url('home') !!}">
                        Cancelar
                    </a>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </section>
<script>
    $(document).ready(function(){
        $("#principalSuc").val('{!! $principal !!}');
        $("input[name='sucursal[]']").prop("checked", false);
        @foreach($sucursales as $sucursal)
        $("#sucursal_{!! $sucursal->sucursal_id !!}").prop("checked", true);
        @endforeach
        @foreach($categorias as $categoria)
            $(".categorias[value='{!! $categoria->categoria_id !!}']").prop("checked", true);
        @endforeach
        var permisos = [];
        @foreach($permisos as $permiso)
        var valor = '{!! $permiso->permisoPerfil_id !!}';
        permisos.push(valor);
        @endforeach
        setPermisos(permisos);
    });

</script>
@endsection
