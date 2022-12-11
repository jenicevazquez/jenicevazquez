@extends('layouts.app')
@section('contentheader_title')
    Articulos - Nuevo
@stop
@section('main-content')
<div style="padding: 15px">
    {!! Form::open(['route' => 'blog.store','files'=>true]) !!}
        <div class="panel panel-default">
            <div class="panel-body">
            @include('blog.fields')
            <div class="form-group col-sm-12">
                <button type="submit" class="btn btn-success">Guardar</button>
                <a class = "btn btn-danger" href = "{!! route('blog.index') !!}">
                    Cancelar
                </a>
            </div>
            </div>
        </div>
    {!! Form::close() !!}
</div>
@endsection
