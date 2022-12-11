<table class="table table-bordered">
    <thead>
        <tr>
            <!--<th>Fecha</th>-->
            <th>Valor</th>
            <th>Tipo</th>
            <!--<th>Exito</th>-->
        </tr>
    </thead>
    <tbody>
    @foreach($registros as $registro)
        <tr>
            <!--<td>{!! $registro->created_at !!}</td>-->
            <td>{!! $registro->tipo !!}: {!! $registro->valor !!}</td>
            <td>{!! $registro->prediccion !!}</td>
            <!--<td>{!! $registro->exitoso !!}</td>-->
        </tr>
    @endforeach

    </tbody>
</table>