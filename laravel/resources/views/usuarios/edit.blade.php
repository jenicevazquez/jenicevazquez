@extends('layouts.app')
@section('contentheader_title')
    Usuarios - Editar
@stop
@section('main-content')
<div class="">
    {!! Form::model($usuario, ['route' => ['usuarios.update', $usuario->id], 'method' => 'patch','files'=>true]) !!}
        <div class="panel panel-default">
            <div class="panel-body">
            @include('usuarios.fields')
            <div class="form-group col-sm-12">
                <button type="submit" class="btn btn-success">Editar</button>
                <a class = "btn btn-danger" href = "{!! route('usuarios.index') !!}">
                    Cancelar
                </a>
            </div>
            </div>
        </div>
    {!! Form::close() !!}
    </div>
@endsection
