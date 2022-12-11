@extends('layouts.app')
@section('contentheader_title')
    Mi Perfil
@stop
@section('main-content')
    <div class="">
        {!! Form::model($usuario, ['route' => ['usuarios.update', $usuario->id], 'method' => 'patch','files'=>true]) !!}
        <div class="panel panel-default">
            <div class="panel-body">
            @include('usuarios.fields')
            <!--- Submit Field --->
                <div class="form-group col-sm-12">
                    <button type="submit" class="btn btn-success">Editar</button>
                    <a class = "btn btn-danger" href = "{!! route('usuarios.index') !!}">
                        Cancelar
                    </a>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection