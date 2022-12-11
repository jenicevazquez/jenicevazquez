@extends('layouts.app')
@section('main-content')
<div class="container-fluid" style="padding: 15px">
    <div class="panel panel-default">
      <div class="panel-heading row">
          <div class="col-xs-12">
              <div class="pull-right">
                  <a href="{!! route("blog.create") !!}" class="btn btn-primary"><i class="fas fa-plus"></i></a>
              </div>
          </div>
      </div>
      <div class="panel-body" style="padding: 0">
          <table class="table table-bordered" style="margin: 0">
              <thead>
                  <tr>
                      <th>Titulo</th>
                      <th>Categoria</th>
                      <th>Tipo</th>
                      <th>Creacion</th>
                      <th>Visitas</th>
                  </tr>
              </thead>
              <tbody>
              @foreach($articulos as $articulo)
              <tr>
                  <td>{!! $articulo->titulo !!}</td>
                  <td>{!! $articulo->categoriaRow->categoria or '' !!}</td>
                  <td>{!! $articulo->tipo !!}</td>
                  <td>{!! $articulo->created_at !!}</td>
                  <td>{!! $articulo->visitas !!}</td>
              </tr>
              @endforeach
              </tbody>
          </table>
      </div>
    </div>
</div>
@endsection