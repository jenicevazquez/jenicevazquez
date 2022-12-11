<?php
$meses = ["","Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic"];
$m = date("n");
$y = date("Y");
$total = [];
?>
<table class="table table-bordered">
    <thead>
    <tr>
        <th></th>
        <th>Folio</th><th>Producto</th>
        @for($i=0;$i<12;$i++)
            <th>{!! $m+$i<=12? $meses[$m+$i]." ".$y:$meses[$m+$i-12]." ".($y+1) !!}</th>
        @endfor
    </tr>
    </thead>
    <tbody>
    @php($mesActual = date("n"))
    @foreach($mercadolibre as $mercado)
        <tr>
            <th></th>
            <td>{!! $mercado->folio !!}</td><td>{!! $mercado->producto !!}</td>
            @php($pendientes = $mercado->pagados-$mercado->num)
            @php($cont = 0)
            @for($i=0;$i<12;$i++)
                @php($cont2=$i+$mesActual)
                @if($cont2>=$mercado->mes-1&&$cont<=$pendientes)
                    @if(isset($total[$cont2]))
                        @php($total[$cont2]=$total[$cont2]+$mercado->mensualidad)
                    @else
                        @php($total[$cont2]=$mercado->mensualidad)
                    @endif
                        <td class="text-right">{!! number_format($mercado->mensualidad,2) !!}</td>
                            @php($cont++)
                @elseif($cont2<$mercado->mes-1)
                    <td class="text-right"></td>
                @else
                    <td></td>
                @endif
            @endfor
        </tr>
    @endforeach

    </tbody>
    <tfoot>
    <tr>
        <th></th>
        <th colspan="2">Total</th>
        @for($i=0;$i<12;$i++)
            @php($cont2=$i+$mesActual)
            @if(isset($total[$cont2]))
            <th class="text-right">{!! number_format($total[$cont2],2) !!}<br>({!! number_format($total[$cont2] /4,2) !!})
            @else
                <th class="text-right">{!! number_format(0,2) !!}<br>({!! number_format(0,2) !!})
            @endif
        @endfor
    </tr>
    </tfoot>
</table>