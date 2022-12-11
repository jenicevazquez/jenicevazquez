<?php
$limite=0;
$saldo=0;
$semana = date('W');
$totalMinimo = 0;
$totalMinimoSemanal = 0;
$totalMinimo2 = 0;
$totalMinimoSemanal2 = 0;
$totalCat = 0;
$totalPagado = 0;
$totalPendiente = 0;
$totalSemanal = 0;
$totalPorcentaje = 0;
$proximo_viernes=date ("Y-m-d",strtotime("next Friday"));
?>
<table class="table table-bordered" id="tbCuentas" style="margin-top: 15px">
    <thead>
    <tr>
        <th class="text-center" colspan="9">Cuenta</th>
        <th class="text-center" colspan="3">Corte</th>
        <th class="text-center" colspan="3">Pagos</th>
        <th class="text-center" colspan="2"><input id="txtAbono" type="text" class="form-control number"></th>
    </tr>
    <tr>
        <th style="width: 50px"></th>
        <th>Nombre</th>
        <th class="text-center" style="width: 100px">Numero</th>
        <th class="text-center" style="width: 100px">Digital</th>
        <th class="number">Limite</th>
        <th class="number">Saldo</th>
        <th class="number">Deuda</th>
        <th class="number">CAT</th>
        <th class="number">Porcentaje</th>
        <th class="text-center">Fecha Corte</th>
        <th class="text-center">Fecha limite</th>
        <th style="width: 150px" class="text-center">Pago Minimo</th>
        <!--<th style="width: 200px" class="text-center">Pago para no generar intereses</th>-->
        <th class="number">Pagado</th>
        <th class="number">Pendiente</th>
        <th class="number">Semanal</th>
        <th class="number">Abono</th>
        <th>Nuevo</th>
    </tr>
    </thead>
    <tbody>
        @foreach($registros as $registro)
            <?php
            $limite+=$registro->limite;
            $saldo+=$registro->saldo;
            $totalCat+=$registro->ultimo_corte->cat;
            $totalPagado+=$registro->ultimo_corte->pagado;

            $starDate = new DateTime( $registro->ultimo_corte->fechaLimite);
            $starDate2 = new DateTime( $registro->ultimo_corte->fechaCorte);
            $semanas = $starDate->format('W')-$semana;
            $semanas2 = $starDate2->format('W')-$semana;
            $semanas2 = 4+$semanas2;
            $totalMinimo += $registro->ultimo_corte->minimo;
            $totalMinimoSemanal += ($registro->ultimo_corte->minimo/4);
            $totalMinimo2 += $registro->ultimo_corte->nointeres;
            $totalMinimoSemanal2 += ($registro->ultimo_corte->nointeres/4);
            $pagado = $registro->ultimo_corte->pagado;
            $minimo = $registro->ultimo_corte->minimo;
            //$pagado = $pagado>$minimo? $minimo:$pagado;
            $pendiente = $minimo-$pagado;
            $pendiente = $pendiente<0? 0:$pendiente;
            $semanal = $semanas>0? $pendiente/$semanas:$pendiente;
            $totalSemanal+=$semanal;
            $porcentaje = $registro->porcentaje_con_cat;
            $totalPorcentaje+=$porcentaje;
            $totalPendiente+=$pendiente;
            ?>

            <tr class="trCuenta" data-saldo="{!! $registro->saldo !!}" data-porcentaje="{!! $porcentaje !!}" data-id="{!! $registro->id !!}">
                <th class="text-center">
                    <a data-toggle="collapse" data-target=".collapse_{!! $registro->id !!}"><i class="fas fa-angle-right"></i></a>
                </th>
                <td style="width: 120px">{!! $registro->nombre !!}<br>{!! $registro->red !!}</td>
                <td class="text-center">{!! $registro->numero !!}</td>
                <td class="text-center">{!! $registro->digital !!}</td>
                <td class="number">{!! number_format($registro->limite,2) !!}</td>
                <td style="width: 150px" class="number"><input class="txtSaldo form-control" style="text-align: right" type="text" value="{!! $registro->saldo !!}"></td>
                <td class="number">{!! number_format($registro->deuda,2) !!}</td>
                <td class="number">{!! $registro->ultimo_corte->cat !!}%</td>
                <td class="number">{!! $porcentaje !!}%</td>

                <td class="text-center" style="width: 150px">{!! $registro->ultimo_corte->fechaCorte !!} <br>Prox. en {!! $semanas2 !!} semanas</td>
                <td class="text-center" style="width: 150px">{!! $registro->ultimo_corte->fechaLimite !!} <br>{!! $semanas>0? "Vence en ".$semanas." semanas":"Vencido" !!}</td>
                <td class="number">{!! number_format($minimo,2) !!} <br>({!! number_format($registro->ultimo_corte->minimo/4,2) !!} semanal)</td>
                <!--<td class="number" style="width: 300px">{!! number_format($registro->ultimo_corte->nointeres,2) !!} <br>({!! number_format($registro->ultimo_corte->nointeres/4,2) !!} semanal)</td>-->
                <td class="number">{!! number_format($pagado,2) !!}</td>
                <td class="number">{!! number_format($pendiente,2) !!}</td>
                <td class="number">{!! number_format($semanal,2) !!}</td>
                <td class="cantidad number"></td>
                <td class="nuevoSaldo number"></td>
            </tr>
            <tr class="collapse subtable collapse_{!! $registro->id !!}">
                <td colspan="13" style="padding:0">
                    <table class="table table-bordered" id="tbCortes" style="margin: 15px">
                        <thead>
                        <tr>
                            <th style="width: 50px"></th>
                            <th style="width: 50px"></th>
                            <th style="width: 100px">Fecha Corte</th>
                            <th>Fecha Limite Pago</th>
                            <th class="number">Pago minimo</th>
                            <th class="number">Pago para no generar intereses</th>
                            <th class="number">CAT</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($registro->cortes as $corte)

                            <tr>
                                <th style="width: 50px"></th>
                                <th class="text-center">
                                    <a data-toggle="collapse" data-target=".collapse2_{!! $corte->id !!}"><i class="fas fa-angle-right"></i></a>
                                </th>
                                <td>{!! $corte->fechaCorte !!}</td>
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
                                            <th style="width: 50px"></th>
                                            <th style="width: 50px"></th>
                                            <th style="width: 100px">Fecha</th>
                                            <th class="number">Cantidad</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($corte->pagos as $pago)
                                            <tr>
                                                <th style="width: 50px"></th>
                                                <th style="width: 50px"></th>
                                                <th style="width: 50px"></th>
                                                <td style="width: 100px">{!! $pago->fechaPago !!}</td>
                                                <td class="number">{!! $pago->cantidad !!}</td>
                                            </tr>
                                        @endforeach
                                            <tr data-id="{!! $corte->id !!}">
                                                <th style="width: 50px"></th>
                                                <th style="width: 50px"></th>
                                                <th style="width: 50px"></th>
                                                <td style="width: 100px"><input name="txtFechaPago" type="text" class="form-control fieldPagos fecha txtFechaPago" ></td>
                                                <td class="number"><input name="txtCantidadPago" type="text" class="form-control fieldPagos fecha txtCantidadPago" ></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        @endforeach
                        <tr data-id="{!! $registro->id !!}">
                            <th style="width: 50px"></th>
                            <th style="width: 50px"></th>
                            <td style="width: 200px"><input name="txtFechaCorte" type="text" class="form-control fieldCortes fecha txtFechaCorte" ></td>
                            <td style="width: 200px"><input name="txtFechaLimite"  type="text" class="form-control fieldCortes fecha txtFechaLimite" ></td>
                            <td><input name="txtPagoMinimo" type="text" class="form-control fieldCortes txtPagoMinimo" ></td>
                            <td><input name="txtPagoNoIntereses"  type="text" class="form-control fieldCortes txtPagoNoIntereses" ></td>
                            <td><input name="txtCAT"  type="text" class="form-control fieldCortes txtCAT" ></td>
                        </tr>

                        </tbody>
                    </table>
                </td>
            </tr>
        @endforeach
        <tr>
            <th style="width: 50px"></th>
            <td colspan="3" class="bold">Total</td>
            <td class="number bold">{!! number_format($limite,2) !!}</td>
            <td class="number bold">{!! number_format($saldo ,2)!!}</td>
            <td class="number bold">{!! number_format($limite-$saldo,2) !!}</td>
            <td class="bold number">{!! $totalCat !!}%</td>
            <td class="bold number">{!! $totalPorcentaje !!}%</td>
            <td class="bold text-center" colspan="2"></td>
            <td class="bold number">{!! number_format($totalMinimo,2) !!} <br>({!! number_format($totalMinimoSemanal,2) !!} semanal)</td>
            <!--<td class="bold number">{!! number_format($totalMinimo2,2) !!} <br>({!! number_format($totalMinimoSemanal2,2) !!} semanal)</td>-->
            <td class="number bold">{!! number_format($totalPagado ,2)!!}</td>
            <td class="number bold">{!! number_format($totalPendiente ,2)!!}</td>
            <td class="number bold">{!! number_format($totalSemanal ,2)!!}</td>
            <td class="totalcantidad number bold"></td>
            <td class="totalnuevoSaldo number bold"></td>
        </tr>
        <tr>
            <th style="width: 50px"></th>
            <td><input id="txtNombre" name="txtNombre" placeholder="Nombre" type="text" class="form-control fieldCuentas" ></td>
            <td><select id="txtRed" name="txtRed" class="form-control fieldCuentas"><option>Visa</option><option>Mastercard</option></select></td>
            <td><select id="txtTipo" name="txtTipo"  class="form-control fieldCuentas"><option>Credito</option><option>Debito</option></select></td>
            <td><input id="txtNumero" name="txtNumero" placeholder="Numero"  type="text" class="form-control fieldCuentas" ></td>
            <td><input id="txtDigital" name="txtDigital" placeholder="Digital" type="text" class="form-control fieldCuentas" ></td>
            <td><input id="txtLimite" name="txtLimite" placeholder="Limite"  type="text" class="form-control fieldCuentas" ></td>
            <td><input id="txtSaldo" name="txtSaldo" placeholder="Saldo" type="text" class="form-control fieldCuentas" ></td>
            <td></td>
            <td class="text-center text-blue" colspan="2">{!! $proximo_viernes !!}</td>
            <td class="number text-blue">{!! number_format(General::getConfig("ingreso"),2) !!} ({!! number_format(General::getConfig("ingreso")-$totalMinimoSemanal,2) !!})</td>

        </tr>
    </tbody>
</table>


