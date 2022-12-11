@foreach($registro->cortes as $corte)
    <tr>

        <th class="text-center">
            <a data-toggle="collapse" data-target=".collapse2_{!! $corte->id !!}"><i class="fas fa-angle-right"></i></a>
        </th>
        <td>
        @if(file_exists("cuentas/".$corte->id."/pdf"))
                <a target="_blank" href="{!! "cuentas/".$corte->id."/pdf" !!}">{!! $corte->fechaCorte !!}</a>
        @else
                {!! $corte->fechaCorte !!}
        @endif
        </td>
        <td>{!! $corte->fechaLimite !!}</td>
        <td class="number">{!! $corte->minimo !!}</td>
        <td class="number">{!! $corte->nointeres !!}</td>
        <td class="number">{!! $corte->cat !!}%</td>
    </tr>
    <tr class="collapse subtable collapse2_{!! $corte->id !!}">
        <td colspan="13">
            <table class="table table-bordered" id="tbPagos" style="margin: 15px">
                <thead>
                <tr>

                    <th style="width: 50px"></th>
                    <th style="width: 200px">Fecha</th>
                    <th class="number">Cantidad</th>
                </tr>
                </thead>
                <tbody>
                @php($total=0)
                @foreach($corte->pagos as $pago)
                    <tr>
                        <th style="width: 50px"></th>
                        <td style="width: 200px">{!! $pago->fechaPago !!}</td>
                        <td class="number">{!! $pago->cantidad !!}</td>
                    </tr>
                    @php($total+=$pago->cantidad)
                @endforeach
                <tr data-id="{!! $corte->id !!}">
                    <th style="width: 50px"></th>
                    <td style="width: 200px"><b>Total</b></td>
                    <td class="number"><b>{!! $total !!}</b></td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
@endforeach