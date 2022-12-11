@extends('layouts.app')
@section('contentheader_title')
    Usuarios
@stop
@section('submenu')

        <li><a class="" href="{!! route('usuarios.create') !!}">
            <i class="fa fa-plus" aria-hidden="true"></i>
            Nuevo
        </a></li>

@stop
@section('main-content')
<div class="panel panel-default panel-noborder">
      @if($usuarios->isEmpty())
          <div class="well text-center">No usuarios found.</div>
      @else
          <div style="overflow-x: auto">
              <table class="table table-hover sort">
                  <thead>
                  <th data-col="nombre">Nombre</th>
                  <th data-col="usuario">Usuario</th>
                  <th data-col="email">Email</th>
                  <th data-col="createdat">Registro</th>
                  <th data-col="updatedat">Actualizacion</th>
                  <th width="80px">Acción</th>
                  </thead>
                  <tbody>

                  @foreach($usuarios as $usuario)
                      <tr class="rol{!! $usuario->role_id !!}">
                          <td><img src="{!! $usuario->foto !!}" class="thumb-user-image" alt="User Image"/> {!! $usuario->name !!}</td>
                          <td>{!! $usuario->name !!}</td>
                          <td>{!! $usuario->email !!}</td>
                          <td>{!! $usuario->created_at !!}</td>
                          <td>{!! $usuario->updated_at !!}</td>
                          <td>
                              <a title="Editar" href="{!! route('usuarios.edit', [$usuario->id]) !!}" ><i class="fas fa-edit"></i></a>
                              <a title="Borrar" data-destino="{!! route('usuarios.delete', [$usuario->id]) !!}" onclick="borrarElemento(this)" data-mensaje="¿Estás seguro de eliminar este usuario?"><i class="fas fa-times"></i></a>
                          </td>
                      </tr>
                  @endforeach
                  </tbody>
              </table>
          </div>
        <div class="col-xs-12">
            {!! General::paginado($usuarios,$q) !!}

        </div>
      @endif
</div>

<script>
    $(document).on('click', '.toggleActivo', function(){
        var activo = $(this).attr('data-id');
        var id = $(this).attr('id');
        var toggle = $(this);

        $.post( "{!! url('usuarios/activo') !!}",{
            _token: $('meta[name=csrf-token]').attr('content'),
            id: id,
            activo: activo
        })
        .done(function(data) {
            if(activo == 1){
                toggle.replaceWith($("<a id='"+data+"' class='Desactivado toggleActivo' title='Activar' data-id='0'><i class='fas fa-toggle-off'></i></a>"));
            } else {
                toggle.replaceWith($("<a id='"+data+"' class='Activado toggleActivo' title='Desactivar' data-id='1'><i class='fas fa-toggle-on'></i></a>"));
            }
        })
        .fail(function(xhr,textStatus,errorThrown){
            errorShow(xhr.responseText);
        })

    });
</script>

@endsection