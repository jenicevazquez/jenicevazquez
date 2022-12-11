
<table class="table table-bordered" style="margin-top: 15px">
    <thead>
    <tr>
        <th class="text-center" colspan="7">Cuenta</th>
        <th class="text-center" colspan="2">Corte</th>
        <th class="text-center" colspan="5">Pagos</th>
        <th style="width:50px; background: transparent; border-top:none; border-bottom: none"></th>
        <th class="text-center" colspan="4">Fechas</th>
    </tr>
    <tr>
        <th style="width: 50px; text-align:center"><a data-toggle="modal" data-target="#crearCuenta" ><i class="fas fa-plus"></i></a></th>
        <th>Nombre</th>
        <th class="text-center">Limite</th>
        <th class="text-center">Saldo</th>
        <th class="text-center">Deuda</th>
        <th class="text-center">CAT</th>
        <th class="text-center">Porcentaje</th>

        <th class="text-center">Fecha Corte</th>
        <th class="text-center">Fecha limite</th>

        <th class="text-center">Periodo</th>
        <th class="text-center">Minimo</th>
        <th class="text-center">Pagado</th>
        <th class="text-center">Pendiente</th>
        <th class="text-center">Semanal</th>
        <th style="width:50px; background: transparent; border-top:none; border-bottom: none" class="text-center"></th>
        @foreach($fridays as $friday)
        <th class="text-center">{!! $friday !!}</th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    @php($totalS = [0,0,0,0])
        @foreach($registros as $registro)
            <?php
                $cont = 0;
                foreach($fridays as $friday){
                    if($friday<=$registro->fechaLimite){
                        $cont++;
                    }
                }
                $semanal = $cont>0? $registro->pendiente/$cont:0;
                $totalS[0] += $cont>=1? $semanal:0;
                $totalS[1] += $cont>=2? $semanal:0;
                $totalS[2] += $cont>=3? $semanal:0;
                $totalS[3] += $cont>=4? $semanal:0;
                ?>

            <tr class="trCuenta" data-saldo="{!! $registro->saldo !!}" data-porcentaje="{!! $registro->porcentaje !!}" data-id="{!! $registro->id !!}">
                <th class="text-center">
                    <a onclick="listPagos('{!! $registro->id !!}')"><i class="fas fa-angle-right"></i></a>
                </th>
                <td style="width: 120px">{!! $registro->nombre !!}<br>{!! $registro->red !!}</td>
                <td class="number">{!! number_format($registro->limite,2) !!}</td>
                <td style="width: 150px" class="number"><input class="txtSaldo form-control" style="text-align: right" type="text" value="{!! $registro->saldo !!}"></td>
                <td class="number">{!! number_format($registro->deuda,2) !!}</td>
                <td class="number">{!! $registro->ultimoCorte !!}%</td>
                <td class="number">{!! $registro->porcentaje !!}%</td>

                <td class="text-center" style="width: 150px">
                    {!! $registro->fechaCorte !!}
                    <br>Prox. en {!! $registro->semanas2 !!} semanas

                </td>
                <td class="text-center" style="width: 150px">
                    {!! $registro->fechaLimite !!}
                    @if($registro->fechaLimite!="-")
                        @if($registro->pendiente==0)
                            <br><span class="text-success">Pagado</span>
                        @elseif($registro->semanas>0)
                            <br>Vence en {!! $registro->semanas !!} semanas
                        @else
                            <br><span class="text-danger">Vencido</span>
                        @endif
                    @endif
                </td>

                <td class="number">{!! number_format($registro->nointeres,2) !!}</td>
                <td class="number">{!! number_format($registro->minimo,2) !!}</td>
                <td class="number">{!! number_format($registro->pagado,2) !!}</td>
                <td class="number">{!! number_format($registro->pendiente,2) !!}</td>
                <td class="number">{!! number_format($registro->semanal,2) !!}</td>
                <td class="number" style="width:50px; background: transparent; border-top:none; border-bottom: none"></td>
                <td class="number">{!! $cont>=1? number_format($semanal):'' !!}</td>
                <td class="number">{!! $cont>=2? number_format($semanal):'' !!}</td>
                <td class="number">{!! $cont>=3? number_format($semanal):'' !!}</td>
                <td class="number">{!! $cont>=4? number_format($semanal):'' !!}</td>
            </tr>

        @endforeach
        <tr>
            <th style="width: 50px"></th>
            <td class="bold">Total</td>
            <td class="number bold">{!! number_format($foot->limite,2) !!}</td>
            <td class="number bold">{!! number_format($foot->saldo ,2)!!}</td>
            <td class="number bold">{!! number_format($foot->limite-$foot->saldo,2) !!}</td>
            <td class="bold number">{!! $foot->totalCat !!}%</td>
            <td class="bold number">{!! $foot->totalPorcentaje !!}%</td>

            <td class="bold text-center" colspan="2"></td>

            <td class="bold number">{!! number_format($foot->totalnointeres,2) !!}<br>{!! number_format($foot->totalnointeres/4,2) !!}</td>
            <td class="bold number">{!! number_format($foot->totalMinimo,2) !!}<br>{!! number_format($foot->totalMinimo/4,2) !!}</td>
            <td class="number bold">{!! number_format($foot->totalPagado ,2)!!}</td>
            <td class="number bold">{!! number_format($foot->totalPendiente ,2)!!}</td>
            <td class="number bold">{!! number_format($foot->totalSemanal ,2)!!}</td>
            <td class="number bold" style="width:50px; background: transparent; border-top:none; border-bottom: none"></td>

            <td class="number bold">{!! number_format($totalS[0] ,2)!!}</td>
            <td class="number bold">{!! number_format($totalS[1] ,2)!!}</td>
            <td class="number bold">{!! number_format($totalS[2] ,2)!!}</td>
            <td class="number bold">{!! number_format($totalS[3] ,2)!!}</td>
        </tr>

    </tbody>
</table>


