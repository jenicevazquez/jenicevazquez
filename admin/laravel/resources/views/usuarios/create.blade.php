@extends('layouts.app')
@section('htmlheader_title')
    Nuevo Usuario
@endsection
@section('main-content')

    <section class="content-header">
        <h1>
            Nuevo Usuario
        </h1>
    </section>
    <section class="content">
    {!! Form::open(['route' => 'usuarios.store']) !!}

        <div class="box">
            <div class="box-heading">
                <div class="row">
                    <div class="col-xs-12">
                    <div class="pull-left">
                        <ol class="breadcrumb">
                          <li><a href="{!! url('/') !!}"><i class="fa fa-home"></i> Inicio</a></li>
                            <li><a href="{!! url('/usuarios') !!}">Usuarios</a></li>
                          <li class="active">Nuevo usuario</li>
                      </ol></div>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                @include('usuarios.fields')
                <!--- Submit Field --->
                <div class="form-group col-sm-12">
                    <button type="submit" class="btn btn-success">Guardar</button>
                    <a class = "btn btn-danger" href = "{!! route('usuarios.index') !!}">
                        Cancelar
                    </a>
                </div>
            </div>
        </div>

        {!! Form::close() !!}
    </section>




@endsection
