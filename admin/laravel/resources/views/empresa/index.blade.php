@extends('layouts.modal')
@section('main-title','Datos de empresa')
@section('main-content')
    <div class="container-fluid">
        {!! Form::open(['route' => 'empresa.store','id'=>'formEmpresa']) !!}
        @include('empresa.fields')
        {!! Form::close() !!}
        <div class="oculto">
            <form id="formpicture">
                <input type="file" name="fotoperfil" id="fotoperfil">
            </form>
        </div>
    </div>
@endsection

