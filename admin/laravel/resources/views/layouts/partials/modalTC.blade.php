<table data-function="getTC()" id="tbTC" class="table table-bordered table-condensed table-centered sort">
  <thead>
  <tr>
    <td colspan="2">
      <div class="form-inline">
          {!! Form::label('fechaPub', 'Buscar fecha:') !!}
          {!! Form::text('fechaPub', $q["fechaPub"]?? null, ['class' => 'form-control fieldSearch fecha','maxlength'=>10, 'placeholder'=>'yyyy-mm-dd']) !!}
        </div>
      </div>
    </td>
  </tr>
  <tr>
    <th class="{!! checkSort($q,"fechaPub") !!}" data-col="fechaPub">Fecha Publicacion</th>
    <th class="{!! checkSort($q,"valor") !!}" data-col="valor">Tipo de Cambio</th>
  </tr>
  </thead>
  <tbody>
  @foreach($registros as $registro)
    <tr>
      <td>{!! $registro->fechaPub !!}</td><td>${!! $registro->valor !!}</td>
    </tr>
  @endforeach
  </tbody>
  <tfoot>
  <tr><td colspan="2" class="paginado">
      @include("paginado")
    </td></tr>
  </tfoot>

</table>