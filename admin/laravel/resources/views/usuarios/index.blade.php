
@extends('layouts.app')
@section('htmlheader_title')
    Usuarios
@endsection
@section('main-content')
    @php($roles = General::getPerfiles())
    <div class = "row">
        <div class = "col-lg-12">
            <h1 class = "page-header col-xs-12 col-sm-4">
                Usuarios
            </h1>
            @include('layouts.busqueda')
        </div>
    </div>

    <div class="flash"></div>

    @if(isset($resultado))
        <div class="alert alert-{!! $resultado[0] !!}" role="alert">{!! $resultado[1] !!}</div>
        <br>
    @endif
    @foreach ($errors->all() as $error)

        <div class="alert alert-info alert-dismissible"  role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
            {{ $error }}</div>
        <br>
    @endforeach
    <section class="content">
        <div class="box">
            <div class="box-heading">
                <div class="row">
                    <div class="col-xs-12">
                    <div class="pull-left">
                        <ol class="breadcrumb">
                          <li><a href="{!! url('/') !!}"><i class="fa fa-home"></i> Inicio</a></li>
                          <li class="active">Usuarios</li>
                      </ol></div>
                        <div class="pull-right" style="margin-left: 5px;">
                            @php($licencia = General::getLicencia())
                            @php($users = $licencia==null? 0:$licencia->usuarios)
                            @if(General::getUsersCount()<$users)
                                <a title="Nuevo" class="btn btn-primary btn-small" href="{!! route('usuarios.create') !!}">
                                    <i class="fa fa-plus" aria-hidden="true"></i> Nuevo
                                </a>
                                @else
                                <a title="Usted ya cuenta con los {!! $users !!} usuarios de su licencia.
Puede modificar y/o borrar algunos de sus usuarios" class="btn btn-primary btn-small disabled">
                                    <i class="fa fa-plus" aria-hidden="true"></i> Nuevo
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-body">
                <!-- Nav tabs -->
                <div style="overflow-x:auto;">
                <table class="table">
                    <thead>
                    <tr>
                    <th>Nombre</th>
                    <th>Usuario</th>
                    <th>Email</th>
                    <th>Perfil</th>
                    <th width="50px">Acción</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($usuarios as $usuario)
                        <tr>
                            <td>{!! $usuario->nombre !!}</td>
                            <td>{!! $usuario->name !!}</td>
                            <td>{!! $usuario->email !!}</td>
                            <td>{!! $usuario->perfil !!}</td>
                            <td>
                                <a title="Editar" href="{!! route('usuarios.edit', [$usuario->id]) !!}" ><i class="fas fa-edit"></i></a>
                                <a class="cursor-pointer" title="Borrar" data-destino="{!! route('usuarios.delete', [$usuario->id]) !!}" onclick="borrarElemento(this)" data-mensaje="¿Estás seguro de eliminar este usuario?"><i class="fas fa-times"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </section>
@endsection
