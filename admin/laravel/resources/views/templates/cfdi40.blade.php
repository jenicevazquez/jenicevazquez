
@php($factura = $input["comprobante"])
@php($receptor = $input["receptor"])
@php($cliente = $input["cliente"])
@php($conceptos = $input["conceptos"]?? array())
@php($traslados = $input["traslados"] ?? array())
@php($retenciones = $input["retenciones"] ?? array())
@php($timbre = $input["timbre"] ?? array())
@php($empresa = GenericClass::empresa())
<div id="facturita">
<table class="table table-condensed">
    <tr>
        <td style="width: 13%">
            <img style="height: 105px;" src="https://{!! $_SERVER['HTTP_HOST'] !!}/img/logos/{!! $empresa->imagen !!}">
        </td>
        <td style="width: 51%">
            <div class="" style="padding: 0 20px">
                <div style="text-align: center; font-weight: bold; margin-bottom: 14px">
                    {!! $empresa->Nombre !!}<br>
                    {!! $empresa->Rfc !!}
                </div>
                <div class="direccion">
                    {!! $empresa->calle !!} Num {!! $empresa->ext !!} Col. {!! $empresa->colonia !!}<br>
                    CP.{!! $empresa->cp !!} - {!! $empresa->ciudad !!}, {!! $empresa->estado !!}, {!! $empresa->pais !!}
                </div>
                <div class="regimen"><b>Régimen fiscal</b></div>
                <div class="regimenData">{!! $empresa->RegimenFiscal !!} - {!! GenericClass::regimenesC($empresa->RegimenFiscal) !!}</div>
            </div>
        </td>
        <td class="detailsFactura">
            <table class="table table-bordered table-bg-gray"  style="margin: 0">
                <thead>
                    <tr>
                        <th colspan="2" class="text-center">Factura</th>
                    </tr>
                </thead>
                <tbody>
                <tr>
                    <td><b>No. Comprobante:</b></td>
                    <td style="text-align: right">{!! $factura["Comprobante_Folio"] !!}</td>
                </tr>
                <tr>
                    <td><b>Lugar de expedición:</b></td>
                    <td style="text-align: right">{!! $factura["Comprobante_LugarExpedicion"] !!}</td>
                </tr>
                <tr>
                    <td><b>Fecha comprobante:</b></td>
                    <td style="text-align: right">{!! $factura["Comprobante_Fecha"] !!}</td>
                </tr>
                <tr>
                    <td><b>Tipo de comprobante:</b></td>
                    <td style="text-align: right">{!! $factura["Comprobante_TipoComprobante"] !!} - {!! GenericClass::tipoComprobante($factura["Comprobante_TipoComprobante"]) !!}</td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            @if($cliente)
            <table class="table table-condensed table-bordered table-bg-gray" style="margin: 0">
                <tbody>
                <tr>
                    <td style="width: 130px"><b>Nombre:</b></td>
                    <td colspan="3">{!! $cliente->Nombre !!}</td>
                </tr>
                <tr>
                    <td><b>RFC:</b></td>
                    <td colspan="3">{!! $cliente->Rfc !!}</td>
                </tr>
                <tr>
                    <td><b>Domicilio:</b></td>
                    <td colspan="3">{!! $cliente->calle or '' !!} Num {!! $cliente->ext or '' !!} Col. {!! $cliente->colonia or '' !!} CP.{!! $cliente->cp or '' !!}, {!! $cliente->ciudad or '' !!}, {!! $cliente->estado or '' !!}, {!! $cliente->pais or '' !!}</td>
                </tr>
                <tr>
                    <td><b>Uso de CFDI:</b></td>
                    <td colspan="3">{!! $receptor["Receptor_UsoCFDI"] !!} - {!! GenericClass::getUsoCFDI($receptor["Receptor_UsoCFDI"])->descripcion !!}</td>
                </tr>
                <tr>
                    @if($factura["Comprobante_TipoComprobante"]!="T"&&$factura["Comprobante_TipoComprobante"]!="P")
                    <td><b>Método de pago:</b></td>
                    <td>{!! $factura["Comprobante_MetodoPago"] !!} - {!! $factura["Comprobante_MetodoPago"]=="PPD"? "Pago en Parcialidades o Diferido":"Pago en una sola exhibición" !!}</td>
                    @else
                        <td></td>
                        <td></td>
                    @endif
                    @if($factura["Comprobante_TipoComprobante"]!="T"&&$factura["Comprobante_TipoComprobante"]!="N"&&$factura["Comprobante_TipoComprobante"]!="P")
                    <td><b>Forma de pago:</b></td>
                    <td>{!! $factura["Comprobante_FormaPago"] !!} - {!! GenericClass::formasPago($factura["Comprobante_FormaPago"]) !!}</td>
                    @else
                        <td></td>
                        <td></td>
                    @endif
                </tr>
                <tr>
                    <td><b>Moneda:</b></td>
                    <td>{!! $factura["Comprobante_Moneda"] !!}</td>
                    <td style="width: 100px"><b>Tipo de cambio:</b></td>
                    <td  style="width:250px">{!! $factura["Comprobante_TipoCambio"] !!}</td>
                </tr>

                </tbody>
            </table>
            @endif
        </td>
    </tr>
    <tr>
        <td colspan="3">
        <table class="table table-condensed table-bordered" style="margin: 0" id="tablaconceptos">
            <thead>
            <tr>
                <th>Clave SAT</th>
                <th>Cantidad</th>
                <th>Unidad SAT</th>
                <th>Descripción</th>
                <th>Precio unitario</th>
                <th>Importe</th>
            </tr>
            </thead>
            <tbody>
            @if(isset($conceptos))
                @foreach($conceptos as $concepto)
                    <tr>
                        <td>{!! $concepto["producto"] !!}</td>
                        <td>{!! $concepto["cantidad"] !!}</td>
                        <td>{!! $concepto["claveunidad"] !!}</td>
                        <td>{!! $concepto["descripcion"] !!}</td>
                        <td style="text-align: right">{!! number_format((float)$concepto["unitario"],2) !!}</td>
                        <td style="text-align: right">{!! number_format((float)$concepto["importe"],2) !!}</td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
        </td>
    </tr>
</table>
<table class="table table-condensed">
    <tr>
        <td style="width: 66%">
            <div>
                <div style="padding: 15px">
                    @if(isset($timbre["UUID"]))
                        <div class="row">
                            <div class="col-xs-12">"Este documento es una representación impresa de un CFDI"</div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6 fieldname small">Fecha de certificación del CFDI:</div>
                            <div class="col-xs-6 small">{!! $timbre["FechaTimbrado"] !!}</div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6 fieldname small">Folio fiscal:</div>
                            <div class="col-xs-6 small">{!! $timbre["UUID"] !!}</div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6 fieldname small">Número de serie del certificado de sello digital:</div>
                            <div class="col-xs-6 small">{!! $factura["NoCertificado"] !!}</div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6 fieldname small">Número de serie del certificado de sello digital del SAT:</div>
                            <div class="col-xs-6 small">{!! $timbre["NoCertificadoSAT"] !!}</div>
                        </div>
                    @else
                    <div class="row">
                        <div class="col-xs-12">"Este documento es una representación impresa de un CFDI sin validez fiscal"</div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6 fieldname small"></div>
                        <div class="col-xs-6 small"></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6 fieldname small"></div>
                        <div class="col-xs-6 small"></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6 fieldname small"></div>
                        <div class="col-xs-6 small"></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6 fieldname small"></div>
                        <div class="col-xs-6 small"></div>
                    </div>
                    @endif
                </div>
            </div>
        </td>
        <td class="detailsFactura">
            <table class="table table-bordered table-bg-gray"  style="margin: 0">
                <tbody>
                <tr>
                    <td>Subtotal</td>
                    <td style="text-align: right">{!!  number_format((float)$factura["Comprobante_SubTotal"],2) !!}</td>
                </tr>
                <tr>
                    <td>Descuento</td>
                    <td style="text-align: right">{!!  number_format((float)$factura["Comprobante_Descuento"],2) !!}</td>
                </tr>
                @if($traslados)
                    @foreach($traslados as $i=>$traslado)
                        @php($partes = explode("_",$i))
                        @php($porcentaje = (float)$partes[2])
                        <tr>
                            <td>{!! GenericClass::getImpuesto($partes[0])->descripcion !!} ({!! $porcentaje !!}%)</td>
                            <td style="text-align: right">{!! number_format((float)$traslado,2) !!}</td>
                        </tr>
                    @endforeach
                @endif
                @if($retenciones)
                    @foreach($retenciones as $i=>$retencion)
                        @php($partes = explode("_",$i))
                        <tr>
                            <td>{!! GenericClass::getImpuesto($partes[0])->descripcion !!} Retenido</td>
                            <td style="text-align: right">{!! number_format((float)$retencion,2) !!}</td>
                        </tr>
                    @endforeach
                @endif
                <tr>
                    <td><b>Total</b></td>
                    <td style="text-align: right">{!! number_format((float)$factura["Comprobante_Total"],2) !!}</td>
                </tr>
                </tbody>
            </table>

        </td>
    </tr>
    <tr>
        <td colspan="2">
            <div id="totalLetra" class="col-xs-12" style="text-align: right">{!! GenericClass::convertir($factura["Comprobante_Total"]) !!}</div>
        </td>
    </tr>
</table>
    @if(isset($timbre["UUID"]))
        @php($tt = number_format($factura["Comprobante_Total"]*1,6,'.',''))
        @php($fe = substr($timbre["SelloCFD"],-8))
        @php($url = urlencode('https://verificacfdi.facturaelectronica.sat.gob.mx/default.aspx?&id='.$timbre["UUID"].'&re='.$empresa->Rfc.'&rr='.$cliente->Rfc.'&tt='.$tt.'&fe='.$fe))
        <table>
            <tr>
                <td class="cadenas" style="width: 80%">
                    <div class="titleSmall">Cadena original del complemento de certificación digital del SAT</div>
                    <div class="cadenaOriginal small wrapword">||{!! $timbre["Version"] !!}|{!! $timbre["UUID"] !!}|{!! $timbre["FechaTimbrado"] !!}|{!! $timbre["RfcProvCertif"] !!}|{!! $factura["Sello"] !!}|{!! $timbre["NoCertificadoSAT"] !!}||</div>
                    <div class="titleSmall">Sello digital del emisor</div>
                    <div class="sellodigitalEmisor small wrapword">{!! $factura["Sello"] !!}</div>
                    <div class="titleSmall">Sello digital del SAT</div>
                    <div class="sellodigitalSAT  small wrapword">{!! $timbre["SelloSAT"] !!}</div>
                </td>
                <td style="width: 20%">
                    <img class="img-responsive" style="margin: 0 auto;" src="https://chart.googleapis.com/chart?chs=300x300&amp;cht=qr&amp;chl={!! $url !!}&amp;choe=UTF-8">
                </td>
            </tr>
        </table>
    @endif
</div>
<style>
    #facturita{
        font-size: 12px;
    }
    #facturita .table{
        margin: 0;
    }
    #facturita .table td{
        border: none;
        font-size: 12px;
    }
    #facturita .table th{
        background: #dee2e6 !important;
        text-align: center;
    }
    #facturita .table.table-bg-gray td{
        background: #f8f9fa;
        border:none !important;
        padding: 3px 5px !important;
    }
    #facturita .table.table-bordered td{
        border: 1px solid #dee2e6;
        font-size: 12px;
    }
    .cadenas > div{
        margin: 5px;
        word-wrap: break-word !important;
    }
    .wrapword {
        white-space: -moz-pre-wrap !important;  /* Mozilla, since 1999 */
        white-space: -o-pre-wrap;    /* Opera 7 */
        white-space: pre-wrap;       /* css-3 */
        word-wrap: break-word;       /* Internet Explorer 5.5+ */
        word-break: break-all;
        white-space: normal;
    }
</style>