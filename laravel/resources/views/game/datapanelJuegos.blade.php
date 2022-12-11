<table class="table table-bordered">
    <thead>
        <tr>
            <th>Id</th>
            <th>Croupier</th>
            <th>Accion</th>
        </tr>
    </thead>
    <tbody>
    @foreach($registros as $registro)
        <tr>
            <td>{!! $registro->id !!}</td>
            <td>{!! $registro->croupier !!}</td>
            <td>

                <a class="btn btn-default" onclick="borrarElemento(this)" data-call="getJuegos" data-destino="/game/{!! $registro->id !!}/delete"><i class="fas fa-trash"></i></a>
                <a class="btn btn-default" onclick="borrarElemento(this)" data-call="getJuegos" data-destino="/game/{!! $registro->id !!}/clean"><i class="fas fa-eraser"></i></a>
                <a class="btn btn-default" id="btn{!! $registro->id !!}" data-id="{!! $registro->id !!}" onclick="loadJuego(this)"><i class="fas fa-file-upload"></i></a>
            </td>
        </tr>
    @endforeach

    </tbody>
</table>