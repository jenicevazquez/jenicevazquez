
        <div class="card">
          <div class="card-body">
              <div id="tabComprobante" class="tabContenidoComprobante">
                  <!-- INICIA SECCIÓN DE COMPROBANTE -->
                  <div class="card card-default no-border" id="card-comprobante">
                      <div class="card-collapse collapse show">
                          <div class="card-body">
                              <div class="row">
                                  <div class="form-group col-sm-3">
                                      {!! Form::label('Comprobante_TipoComprobante', 'Tipo de comprobante:',['class'=>'required']) !!}
                                      {!! Form::select('Comprobante_TipoComprobante',GenericClass::selectTiposComprobantes(), null, [
                                            'class' => 'form-control',
                                            'id' => 'Comprobante_TipoComprobante',
                                            'onchange' => 'checkTipoComprobante()',
                                            'autocomplete' => 'off',
                                            'required',
                                            ]) !!}
                                  </div>
                              </div>
                              <div class="row">
                                  <div class="col-sm-1 form-group">
                                      {!! Form::label('Comprobante_Version', 'Version:',['class'=>'required']) !!}
                                      {!! Form::text('Comprobante_Version','4.0', [
                                            'class' => 'form-control rfc text-box single-line',
                                            'title' => 'Atributo requerido con valor prefijado a 4.0 que indica la versión del estándar bajo el que se encuentra expresado el comprobante.',
                                            'id' => 'Comprobante_Version',
                                            'required','readonly',
                                            'autocomplete' => 'off',
                                            ]) !!}
                                  </div>
                                  <div class="col-sm-4 form-group" title="Número de serie de la factura que usas para control interno, generalmente se usan letras">
                                      {!! Form::label('Comprobante_Serie', 'Serie:') !!}
                                      <select class="form-control" id="Comprobante_Serie" onclick="getFolio()" autocomplete="off" name="Comprobante_Serie">
                                          <option value="null">-</option>
                                          @foreach(GenericClass::getSeries() as $serie)
                                          <option data-folio="{!! $serie->folio !!}" data-tipo="{!! $serie->tipoComprobante !!}" value="{!! $serie->serie !!}">{!! $serie->serie !!}</option>
                                          @endforeach
                                      </select>
                                  </div>
                                  <div class="col-sm-4 form-group" title="Número de folio de la factura que usas para control interno, generalmente se usan números.">
                                      <label class="control-label" for="Comprobante_Folio">Folio:</label>
                                      <input autocomplete="off" class="form-control limpiaParaNomina text-box single-line" data-val="true" data-val-regex="Longitud y/o formato de datos inválidos." data-val-regex-pattern="[^|]{1,40}" id="Comprobante_Folio" name="Comprobante_Folio" type="text" value="" maxlength="40">
                                      <small><span class="field-validation-valid form-text form-text-error" data-valmsg-for="Folio" autocomplete="off" data-valmsg-replace="true"></span></small>

                                  </div>
                                  <div class="col-sm-3 form-group" title="Captura la fecha y hora  en que se realizó la operación, verifica que corresponda con tu horario local.">
                                          <label class="control-label required" for="Comprobante_Fecha">Fecha y hora de expedición:</label>
                                          <input class="form-control fechaHora text-box single-line" data-val="true" data-val-date="El valor del campo debe ser una fecha válida" data-val-required="Este campo es obligatorio." id="Comprobante_Fecha" name="Comprobante_Fecha" type="text" value="{!! date('Y-m-d\TH:i:s') !!}" placeholder="YYYY-MM-DDTHH:MM:SS" maxlength="19" autocomplete="off">
                                          <small><span class="field-validation-valid form-text form-text-error" data-valmsg-for="Fecha" data-valmsg-replace="true"></span></small>
                                  </div>
                                  <div class="form-group col-sm-4" title="Selecciona la forma en la que el cliente te paga la factura, si la pagará después usa '99  Por definir'">
                                      {!! Form::label('Comprobante_FormaPago', 'Forma de pago:') !!}
                                      {!! Form::select('Comprobante_FormaPago', GenericClass::selectFormasPago(), null, [
                                        'class' => 'form-control quitarParaNomina quitarParaPagos quitarParaTraslado quitarParaPagosIE',
                                        'maxlength'=>255,
                                        'id'=>'Comprobante_FormaPago',
                                        'required']) !!}
                                  </div>
                                  <div class="form-group col-sm-4" title="Selecciona si se paga en una exhibición, es decir, al momento; a plazos se refiere a varios pagos o diferido que sea un pago en una fecha futura determinada.">
                                      {!! Form::label('Comprobante_MetodoPago', 'Método de pago:') !!}
                                      {!! Form::select('Comprobante_MetodoPago', GenericClass::selectMetodosPago(), null, [
                                        'class' => 'form-control quitarParaNomina quitarParaPagos quitarParaTraslado quitarParaPagosIE',
                                        'id'=>'Comprobante_MetodoPago',
                                        'maxlength'=>255,
                                        'required']) !!}
                                  </div>
                                  <div class="form-group col-sm-4" title="Atributo requerido para incorporar el código postal del lugar de expedición del comprobante (domicilio de la matriz o de la sucursal).">
                                      {!! Form::label('Comprobante_LugarExpedicion', 'Lugar Expedición:',['class'=>'required']) !!}
                                      @if(GenericClass::empresa()->chkCp==0)
                                          {!! Form::select('Comprobante_LugarExpedicion', array(), null, [
                                            'class' => 'form-control',
                                            'id'=>'Comprobante_LugarExpedicion','multiple'=>"multiple",
                                            'required']) !!}
                                      @else
                                          {!! Form::select('Comprobante_LugarExpedicion', GenericClass::selectCodigoPostal(GenericClass::empresa()->cp), GenericClass::empresa()->cp, [
                                        'class' => 'form-control',
                                        'id'=>'Comprobante_LugarExpedicion',
                                        'required']) !!}
                                      @endif
                                  </div>
                              </div>
                              <div class="row">
                                  <div class="form-group col-sm-4" title="Selecciona el tipo de moneda con la cual te pagan la factura.">
                                      {!! Form::label('Comprobante_Moneda', 'Moneda:',['class'=>'required']) !!}
                                      {!! Form::select('Comprobante_Moneda', GenericClass::selectMonedas(), "MXN", [
                                            'class' => 'form-control quitarParaNomina quitarParaPagos quitarParaPagosIE',
                                            'maxlength'=>255,
                                            'required',
                                            'id'=>'Comprobante_Moneda',
                                            'onchange'=>'checkMoneda()',
                                            'autocomplete'=>'off'
                                            ]) !!}
                                  </div>
                                  <div class="form-group col-sm-4 " title="Cuando hayas seleccionado una moneda distinta de Peso Mexicano 'MXN', debes capturar la cantidad en pesos que equivale a una unidad de la moneda extranjera.">
                                          <label class="control-label" for="Comprobante_TipoCambio">Tipo de cambio:</label>
                                          <input class="form-control quitarParaNomina quitarParaPagos text-box single-line" data-val="true" data-val-number="El valor del campo debe ser numérico" data-val-regex="El campo debe contener máximo 18 enteros y 6 decimales." data-val-regex-pattern="[0-9]{1,18}(.[0-9]{1,6})?" id="Comprobante_TipoCambio" name="Comprobante_TipoCambio" type="text" value="0">
                                          <small><span class="field-validation-valid form-text form-text-error" data-valmsg-for="TipoCambio" data-valmsg-replace="true"></span></small>
                                  </div>
                                  <div class="form-group col-sm-4" title="Atributo requerido para expresar si el comprobante ampara una operación de exportación.">
                                      {!! Form::label('Comprobante_Exportacion', 'Exportación:',['class'=>'required']) !!}
                                      {!! Form::select('Comprobante_Exportacion', GenericClass::selectExportacion(), null, [
                                        'class' => 'form-control',
                                        'id'=>'Comprobante_Exportacion',
                                        'required']) !!}
                                  </div>
                              </div>
                              <div class="row esMisCuentas">
                                  <div class="col-md-12 form-group" title="Registra las condiciones comerciales aplicables para el pago de la factura, por ejemplo plazos o políticas de crédito.">
                                          <label class="control-label" for="Comprobante_CondicionesDePago">Condiciones de pago:</label>
                                          <input class="form-control quitarParaNomina quitarParaPagos quitarParaTraslado text-box single-line" data-val="true" data-val-regex="Longitud y/o formato de datos inválidos." data-val-regex-pattern="[^|]{1,1000}" id="Comprobante_CondicionesDePago" name="Comprobante_CondicionesDePago" type="text" value="" maxlength="1000">
                                          <small><span class="field-validation-valid form-text form-text-error" data-valmsg-for="CondicionesDePago" data-valmsg-replace="true"></span></small>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
                  <!-- INICIA SECCIÓN DE EMISOR -->
                  <div class="card card-default" id="card-emisor">
                      <div class="card-header">
                          <h4 class="card-title">
                              Datos del emisor
                          </h4>
                      </div>
                      <div class="card-collapse collapse show">
                          <div class="card-body">
                              <div class="row">
                                  <div class="col-md-3">
                                      <div class="form-group">
                                          <div class="form-group col-xs-12">

                                              <input type="hidden" id="uuid" name="uuid" autocomplete="off">
                                              {!! Form::label('Emisor_Rfc', 'RFC:',['class'=>'required']) !!}
                                              {!! Form::text('Emisor_Rfc',GenericClass::empresa()->Rfc, [
                                                    'class' => 'form-control rfc text-box single-line',
                                                    'title' => 'El valor debe contener máximo 13 y mínimo 12 caracteres.',
                                                    'minlength' => 12,
                                                    'maxlength' => 13,
                                                    'error' => 'RFC inválido. Capture solo 12 o 13 caracteres en mayúsculas.',
                                                    'regex' => '[A-Z&amp;amp;amp;Ñ]{3,4}[0-9]{2}(0[1-9]|1[012])(0[1-9]|[12][0-9]|3[01])[A-Z0-9]{2}[0-9A]',
                                                    'id' => 'Emisor_Rfc',
                                                    'required','readonly',
                                                    'autocomplete' => 'off',
                                                    ]) !!}
                                          </div>
                                      </div>
                                  </div>
                                  <div class="form-group col-sm-9">
                                      {!! Form::label('Emisor_Nombre', 'Nombre o razón social:',['class'=>'required']) !!}
                                      {!! Form::text('Emisor_Nombre', GenericClass::empresa()->Nombre, [
                                            'class' => 'form-control text-box single-line',
                                            'title'=> 'El valor debe contener máximo 254 y mínimo 1 caracteres.',
                                            'minlength'=> 1,
                                            'maxlength'=>254,
                                            'error'=>'Longitud y/o formato de datos inválidos.',
                                            'regex'=>'[^|]{1,254}',
                                            'id'=>'Emisor_Nombre',
                                            'required','readonly',
                                            'autocomplete' => 'off',
                                            ]) !!}
                                  </div>
                              </div>
                              <div class="row">

                              </div>
                              <div class="row">
                                  <div class="form-group col-md-12">
                                      {!! Form::label('Emisor_RegimenFiscal', 'Régimen fiscal:',['class'=>'required']) !!}
                                      {!! Form::select('Emisor_RegimenFiscal',GenericClass::selectRegimenesFiscales(), GenericClass::empresa()->RegimenFiscal, [
                                            'class' => 'form-control',
                                            'id' => 'Emisor_RegimenFiscal',
                                            'required','disabled',
                                            'autocomplete' => 'off',
                                            ]) !!}
                                  </div>

                              </div>
                          </div>
                      </div>
                  </div>
                  <!-- INICIA SECCIÓN DE RECEPTOR -->
                  <div class="card card-default" id="card-receptor">
                      <div class="card-header">
                          <h4 class="card-title">
                              Datos del receptor
                          </h4>
                      </div>
                      <div class="card-collapse collapse show">
                          <div class="card-body">
                              <div class="row">
                                  <div class="col-md-8">
                                      <div class="form-group">
                                          {!! Form::label('Receptor_Rfc', 'Cliente:',['class'=>'required']) !!}
                                          <div class="input-group">
                                              {!! Form::select('Receptor_Rfc',array(), null, [
                                                    'class' => 'form-control rfc text-box single-line',
                                                    'id' => 'Receptor_Rfc',
                                                    'required'
                                                    ]) !!}
                                              <div class="input-group-append">
                                                  <button tabindex="-1" title="Seleccionar de catálogo" class="btn btn-outline-secondary" type="button"><i class="fas fa-book"></i></button>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="col-md-4">
                                      <div class="form-group">
                                          {!! Form::label('Receptor_UsoCFDI', 'Uso de la factura:',['class'=>'required']) !!}
                                          {!! Form::select('Receptor_UsoCFDI',GenericClass::selectUsoCFDI(), null, [
                                                'class' => 'form-control quitarParaPagos',
                                                'title' => 'Selecciona el uso que tu cliente le dará a la factura.',
                                                'error' => 'Este campo es obligatorio.',
                                                'id' => 'Receptor_UsoCFDI',
                                                'required',
                                                ]) !!}
                                      </div>
                                  </div>
                              </div>

                          </div>
                      </div>
                  </div>
                  <!-- INICIA SECCIÓN DE CONCEPTOS -->
                  <div class="card card-default">
                      <div class="card-header">
                          <h4 class="card-title">
                              Conceptos
                          </h4>
                      </div>

                      <div class="card-body" id="contenidoConceptos">
                          <div id="formContainer_Conceptos" class="container-forms" style="text-align:left; margin-bottom:10px">
                              <div class="row">
                                  <div class="col-sm-12" style="margin-bottom: 1rem">
                                  @if(GenericClass::empresa()->ce==1)
                                      <form id="uploadProductos" style="display: inline">
                                          <a title="Subir conceptos desde archivo M" id="btnuploadProductos" class="btn btn-warning">
                                              <i class="fas fa-file-upload" aria-hidden="true"></i> Agregar de archivo M
                                          </a>
                                          <input type="file" name="archivoProducto" id="archivoProducto" style="display: none">
                                      </form>
                                      <form id="uploadProductos2" style="display: inline">
                                          <a title="Subir conceptos desde aviso de traslado" id="btnuploadProductos2" class="btn btn-warning">
                                              <i class="fas fa-file-upload" aria-hidden="true"></i> Agregar desde aviso de traslado
                                          </a>
                                          <input type="file" name="archivoProducto2" id="archivoProducto2" style="display: none">
                                      </form>
                                  @endif
                                    <button type="button" class="btn btn-primary" data-toggle="collapse" data-target="#divConceptos">
                                        <i class="fas fa-keyboard"></i> Capturar Conceptos
                                  </button>
                                  </div>
                              </div>
                              <div id="divConceptos" class="collapse">
                                  <ul id="tabsConcepto" class="nav nav-tabs">
                                      <li class="nav-item active"><a class="nav-link active" data-toggle="tab" id="tabConceptosPrincipal" href="#tabConceptos">Concepto</a></li>
                                  </ul>
                                  <div class="tab-content" style="padding: 15px;border: 1px solid rgba(0,0,0,.125);border-top: 0; background: white">
                                      <div id="tabConceptos" class="tab-pane fade show active">
                                          <div class="row esMisCuentas">

                                              <div class="col-sm-9">
                                                  <div class="form-group" title="Registra opcionalmente el código de barras, número de parte, SKU o clave equivalente, propio de tu operación.">
                                                      {!! Form::label('NoIdentificacion', 'Número de identificación:',['class'=>'']) !!}
                                                      {!! Form::select('NoIdentificacion',array(), null, [
                                                            'class' => 'form-control noespacio text-box single-line',
                                                            'title' => 'El valor debe contener máximo 100 y mínimo 1 caracteres.',
                                                            'error' => 'Longitud y/o formato de datos inválidos.',
                                                            'regex' => '^[^\|.]{1,100}$',
                                                            'id' => 'NoIdentificacion',
                                                            ]) !!}
                                                  </div>
                                              </div>
                                              <div class="col-sm-3">
                                                  <div class="form-group" title="Captura el nombre (litros, piezas, metros, etc.) o la clave completa de la unidad de medida.">
                                                      {!! Form::label('Unidad', 'Unidad:',['class'=>'']) !!}
                                                      {!! Form::text('Unidad', null, [
                                                            'class' => 'form-control noespacio text-box single-line',
                                                            'title' => 'El valor debe contener máximo 20 y mínimo 1 caracteres.',
                                                            'error' => 'Longitud y/o formato de datos inválidos.',
                                                            'regex' => '^[^\|.]{1,20}$',
                                                            'id' => 'Unidad',
                                                            'maxlength'=>20,
                                                            'minlength'=>1
                                                            ]) !!}
                                                  </div>
                                              </div>
                                          </div>
                                          <div class="row">
                                              <div class="col-sm-7">
                                                  <div class="form-group" title="Captura el nombre o la clave completa del producto o servicio a facturar.">
                                                      {!! Form::label('ClaveProdServConf', 'Clave de producto o servicio:',['class'=>'required']) !!}
                                                      <div class="input-group" id="input-group-ClaveProdServConf">
                                                          {!! Form::select('ClaveProdServConf',array(),null, [
                                                                'class' => 'form-control text-box single-line',
                                                                'title' => 'Este campo es obligatorio.',
                                                                'error' => 'Longitud y/o formato de datos inválidos.',
                                                                'regex' => '[^|]{0,}',
                                                                'id' => 'ClaveProdServConf',
                                                                'required',
                                                                ]) !!}
                                                          <div class="input-group-append">
                                                              <button tabindex="-1" title="Seleccionar de catálogo" class="btn btn-outline-secondary" type="button"><i class="fas fa-book"></i></button>
                                                          </div>
                                                      </div>
                                                  </div>
                                              </div>
                                              <div class="col-sm-5">
                                                  <div class="form-group" title="Captura el nombre (litros, piezas, metros, etc.)  o la clave completa de la unidad de medida, puedes escribir las tres primeras letras y el sistema mostrará una relación de unidades encontradas.">
                                                      {!! Form::label('ClaveUnidad', 'Clave de unidad:',['class'=>'required']) !!}
                                                      <div class="input-group">
                                                          {!! Form::select('ClaveUnidad',array(), null, [
                                                                'class' => 'form-control autocomplete noespacio text-box single-line ui-autocomplete-input',
                                                                'title' => 'Este campo es obligatorio.',
                                                                'error' => 'Longitud y/o formato de datos inválidos.',
                                                                'regex' => '[^|]{0,}',
                                                                'id' => 'ClaveUnidad',
                                                                'required',
                                                                ]) !!}
                                                          <div class="input-group-append">
                                                              <button tabindex="-1" title="Seleccionar de catálogo" class="btn btn-outline-secondary" type="button"><i class="fas fa-book"></i></button>
                                                          </div>
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>

                                          <div class="row">
                                              <div class="col-sm-2">
                                                  <div class="form-group" title="Captura la cantidad de bienes o servicios que correspondan a este concepto.">
                                                      {!! Form::label('Cantidad', 'Cantidad:',['class'=>'required']) !!}
                                                      {!! Form::text('Cantidad', null, [
                                                            'class' => 'form-control autocomplete noespacio text-box single-line ui-autocomplete-input',
                                                            'title' => 'Este campo es obligatorio.',
                                                            'error' => 'El valor del campo debe ser numérico.',
                                                            'regex' => '[0-9]{1,18}(.[0-9]{1,6})?',
                                                            'id' => 'Cantidad',
                                                            'maxlength'=>'25',
                                                            'onpaste'=>"this.onblur()",
                                                            'required'
                                                            ]) !!}
                                                  </div>
                                              </div>
                                              <div class="col-sm-10">
                                                  <div class="form-group alinea" title="Captura una descripción detallada del producto que vendes o del servicio que prestas.">
                                                      {!! Form::label('Descripcion', 'Descripción:',['class'=>'required']) !!}
                                                      {!! Form::text('Descripcion', null, [
                                                            'class' => 'form-control autocomplete noespacio text-box single-line ui-autocomplete-input',
                                                            'title' => 'Este campo es obligatorio.',
                                                            'error' => 'Longitud y/o formato de datos inválidos.',
                                                            'regex' => '[^|]{1,1000}',
                                                            'id' => 'Descripcion',
                                                            'maxlength'=>'1000',
                                                            'minlength'=>'1',
                                                            'required'
                                                            ]) !!}
                                                  </div>
                                              </div>
                                          </div>
                                          <div class="row">
                                              <div class="col-md-4">
                                                  <div class="form-group" title="Captura el valor o precio por unidad del producto o servicio.">
                                                      {!! Form::label('ValorUnitario', 'Valor unitario:',['class'=>'required']) !!}
                                                      <div class="input-group">
                                                          <div class="input-group-prepend">
                                                              <span class="input-group-text">$</span>
                                                          </div>
                                                          {!! Form::text('ValorUnitario', null, [
                                                                'class' => 'form-control importeFMoneda text-box single-line money',
                                                                'title' => 'El valor del campo debe ser numérico',
                                                                'error' => 'El campo debe contener máximo 18 enteros y 6 decimales.',
                                                                'regex' => '[0-9]{1,18}(.[0-9]{1,6})?',
                                                                'id' => 'ValorUnitario',
                                                                'maxlength'=>'21',
                                                                'onpaste' =>'this.onblur();',
                                                                'autocomplete'=>'off',
                                                                'required'
                                                                ]) !!}
                                                      </div>
                                                  </div>
                                              </div>
                                              <div class="col-md-4">
                                                  <div class="form-group" title="Es el resultado de multiplicar la cantidad por el valor unitario.">
                                                      {!! Form::label('Importe', 'Importe:',['class'=>'required']) !!}
                                                      <div class="input-group">
                                                          <div class="input-group-prepend">
                                                              <span class="input-group-text">$</span>
                                                          </div>
                                                          {!! Form::text('Importe', 0, [
                                                                'class' => 'form-control text-box single-line',
                                                                'title' => 'El valor del campo debe ser numérico',
                                                                'error' => 'El campo debe contener máximo 18 enteros y 6 decimales.',
                                                                'regex' => '[0-9]{1,18}(.[0-9]{1,6})?',
                                                                'id' => 'Importe',
                                                                'readonly'=>'readonly',
                                                                'autocomplete'=>'off',
                                                                'required'
                                                                ]) !!}
                                                      </div>
                                                  </div>
                                              </div>
                                              <div class="col-md-4">
                                                  <div class="form-group" title="Captura el importe de los descuentos que aplican sobre este producto o servicio.">
                                                      {!! Form::label('Descuento', 'Descuento:',['class'=>'required']) !!}
                                                      <div class="input-group">
                                                          <div class="input-group-prepend">
                                                              <span class="input-group-text">$</span>
                                                          </div>
                                                          {!! Form::text('Descuento', null, [
                                                                'class' => 'form-control importeFMoneda text-box single-line money',
                                                                'title' => 'El valor del campo debe ser numérico',
                                                                'error' => 'El campo debe contener máximo 18 enteros y 6 decimales.',
                                                                'regex' => '[0-9]{1,18}(.[0-9]{1,6})?',
                                                                'id' => 'Descuento',
                                                                'maxlength'=>'21',
                                                                'onpaste'=>'this.onblur();',
                                                                'autocomplete'=>'off',
                                                                'required'
                                                                ]) !!}
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>
                                          <div class="row">
                                              <div class="col-md-4">
                                                  <div class="form-group" title="A definir por el usuario (Objeto de impuesto)">
                                                      {!! Form::label('ObjetoImp', 'Objeto de impuesto:',['class'=>'required']) !!}
                                                      {!! Form::select('ObjetoImp',\App\GenericClass::selectObjetoImp(),null, [
                                                            'class' => 'form-control',
                                                            'title' => 'Este campo es obligatorio.',
                                                            'id' => 'ObjetoImp',
                                                            'onchange'=> 'checkObjetoImp(this.value)',
                                                            'autocomplete'=>'off',
                                                            'required',
                                                            ]) !!}
                                                  </div>
                                              </div>
                                              <div class="col-md-2">
                                                  <div class="form-group">
                                                      {!! Form::label('ObjetoBase', 'Subtotal:',['class'=>'required']) !!}
                                                      <div class="input-group">
                                                          <div class="input-group-prepend">
                                                              <span class="input-group-text">$</span>
                                                          </div>
                                                          {!! Form::text('ObjetoBase',null, [
                                                                                'class' => 'form-control',
                                                                                'id' => 'ObjetoBase',
                                                                                'readonly',
                                                                                'required',
                                                                                'autocomplete'=>'off'
                                                                                ]) !!}
                                                      </div>
                                                  </div>
                                              </div>
                                              <div class="col-md-2">
                                                  <div class="form-group">
                                                      {!! Form::label('Subtotal', 'Total:',['class'=>'required']) !!}
                                                      <div class="input-group">
                                                          <div class="input-group-prepend">
                                                              <span class="input-group-text">$</span>
                                                          </div>
                                                          {!! Form::text('Subtotal',null, [
                                                                                'class' => 'form-control',
                                                                                'id' => 'Subtotal',
                                                                                'readonly',
                                                                                'required',
                                                                                'autocomplete'=>'off'
                                                                                ]) !!}
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>
                                          <div class="row">
                                              <div class="col-sm-12">
                                                  <div class="card oculto" id="card-impuestos" style="padding-top: 15px;margin-bottom: 15px;">
                                                      <div class="card-body row">
                                                          <div class="col-sm-6" style="padding-right: 15px">
                                                              <!--TRASLADOS-->
                                                              <div class="form-group" style="border-bottom: 1px solid rgba(0,0,0,.125); padding-bottom:1rem">
                                                                  <div class="row">
                                                                      <h3 class="card-title col-sm-12">Impuestos trasladados de concepto:</h3>
                                                                  </div>
                                                              </div>
                                                              <div class="form-group">
                                                                  <div class="row">
                                                                      <div class="col-md-2"></div>
                                                                      <div class="col-md-3 text-center">Tipo Factor</div>
                                                                      <div class="col-md-3 text-center">Tasa o cuota</div>
                                                                      <div class="col-md-4 text-center">Importe</div>
                                                                  </div>
                                                                  @foreach(GenericClass::getImpuestoTraslado() as $impuesto)
                                                                      <div class="row trtraslado" data-clave="{!! $impuesto->c_impuesto !!}" style="padding: 10px 0">
                                                                          <div class="col-md-2" style="padding:7px">{!! $impuesto->descripcion !!}</div>
                                                                          <div class="col-md-3">
                                                                              <select autocomplete="off" name="trasladoTipo{!! $impuesto->c_impuesto !!}" id="trasladoTipo{!! $impuesto->c_impuesto !!}" onchange="checkTipoTasa(this)" class="form-control"><option>Tasa</option><option>Cuota</option></select>
                                                                          </div>
                                                                          <div class="col-md-3 input-group field-tasa">
                                                                              <input class="form-control txt-impuesto text-center" type="text" name="trasladoTasa{!! $impuesto->c_impuesto !!}" id="trasladoTasa{!! $impuesto->c_impuesto !!}">
                                                                              <div class="input-group-append">
                                                                                  <span class="input-group-text">%</span>
                                                                              </div>
                                                                          </div>
                                                                          <div class="col-md-3 input-group field-cuota oculto">
                                                                              <div class="input-group-prepend">
                                                                                  <span class="input-group-text">$</span>
                                                                              </div>
                                                                              <input class="form-control txt-impuesto text-center" type="text" name="trasladoCuota{!! $impuesto->c_impuesto !!}" id="trasladoCuota{!! $impuesto->c_impuesto !!}">
                                                                          </div>
                                                                          <div class="col-md-4 input-group">
                                                                              <div class="input-group-prepend">
                                                                                  <span class="input-group-text">$</span>
                                                                              </div>
                                                                              <input class="form-control txt-impuesto txt-impuestoImporte" type="text" name="trasladoImporte{!! $impuesto->c_impuesto !!}" id="trasladoImporte{!! $impuesto->c_impuesto !!}">
                                                                          </div>
                                                                      </div>
                                                                  @endforeach
                                                              </div>
                                                          </div>
                                                          <div class="col-sm-6" style="border-left: 1px solid rgba(0,0,0,.125); padding-left:15px">
                                                              <!--RETENCIONES-->
                                                              <div class="form-group" style="border-bottom: 1px solid rgba(0,0,0,.125); padding-bottom:1rem">
                                                                  <div class="row">
                                                                      <h3 class="card-title col-sm-12">Impuestos retenidos de concepto:</h3>
                                                                  </div>
                                                              </div>
                                                              <div class="form-group">
                                                                  <div class="row">
                                                                      <div class="col-md-2"></div>
                                                                      <div class="col-md-3 text-center">Tipo Factor</div>
                                                                      <div class="col-md-3 text-center">Tasa o cuota</div>
                                                                      <div class="col-md-4 text-center">Importe</div>
                                                                  </div>
                                                                  @foreach(\App\GenericClass::getImpuestoRetencion() as $impuesto)
                                                                      <div class="row trretencion" data-clave="{!! $impuesto->c_impuesto !!}" style="padding: 10px 0">
                                                                          <div class="col-md-2" style="padding:7px">{!! $impuesto->descripcion !!}</div>
                                                                          <div class="col-md-3">
                                                                              <select autocomplete="off" name="retencionTipo{!! $impuesto->c_impuesto !!}" id="retencionTipo{!! $impuesto->c_impuesto !!}" onchange="checkTipoTasa(this)" class="form-control"><option>Tasa</option><option>Cuota</option></select>
                                                                          </div>
                                                                          <div class="col-md-3 input-group field-tasa">
                                                                              <input class="form-control text-center txt-impuesto" type="text" name="retencionTasa{!! $impuesto->c_impuesto !!}" id="retencionTasa{!! $impuesto->c_impuesto !!}">
                                                                              <div class="input-group-append">
                                                                                  <span class="input-group-text">%</span>
                                                                              </div>
                                                                          </div>
                                                                          <div class="col-md-3 input-group field-cuota oculto">
                                                                              <div class="input-group-prepend">
                                                                                  <span class="input-group-text">$</span>
                                                                              </div>
                                                                              <input class="form-control txt-impuesto text-center" type="text" name="retencionCuota{!! $impuesto->c_impuesto !!}" id="retencionCuota{!! $impuesto->c_impuesto !!}">
                                                                          </div>
                                                                          <div class="col-md-4 input-group">
                                                                              <div class="input-group-prepend">
                                                                                  <span class="input-group-text">$</span>
                                                                              </div>
                                                                              <input class="form-control txt-impuesto txt-impuestoImporte" type="text" name="retencionImporte{!! $impuesto->c_impuesto !!}" id="retencionImporte{!! $impuesto->c_impuesto !!}">
                                                                          </div>
                                                                      </div>
                                                                  @endforeach
                                                              </div>
                                                          </div>
                                                      </div>
                                                      <div class="card-footer">
                                                          <div class="row">
                                                              <div class="col-md-2"></div>
                                                              <div class="col-md-3 text-center"></div>
                                                              <div class="col-md-3 text-right" style="padding: 7px">Total impuestos</div>
                                                              <div class="col-md-4 text-center">
                                                                  {!! Form::text('ObjetoTotal',null, [
                                                                          'class' => 'form-control',
                                                                          'id' => 'ObjetoTotal',
                                                                          'readonly',
                                                                          'required',
                                                                          ]) !!}
                                                              </div>
                                                          </div>
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>
                                          <div class="row">
                                              <div class="col-md-12">
                                                  <div style="text-align:right;">
                                                      <button type="button" class="btn btn-secondary" onclick="agregarConcepto(this)">
                                                          Guardar Concepto
                                                      </button>
                                                      <button type="button" class="btn btn-default" data-toggle="collapse" data-target="#divConceptos" onclick="cancelarConcepto()">Cancelar</button>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                      <div id="tabInfoAduanera" class="tab-pane fade show">
                                          <div class="formulario" id="frmInfoAduanera">
                                              <div class="row">
                                                  <div class="col-md-6">
                                                      <div class="form-group" title="Captura el número del pedimento correspondiente a la importación del bien que se vende con esta factura.">
                                                          {!! Form::label('Conceptos_InformacionAduanera_NumeroPedimento', 'Número de pedimento:',['class'=>'required']) !!}
                                                          {!! Form::text('Conceptos_InformacionAduanera_NumeroPedimento', null, [
                                                                'class' => 'form-control text-box single-line',
                                                                'title' => 'Este campo es obligatorio.',
                                                                'error' => 'Longitud y/o formato de datos inválidos.',
                                                                'regex' => '[0-9]{2}  [0-9]{2}  [0-9]{4}  [0-9]{7}',
                                                                'maxlength'=>21,
                                                                'id' => 'Conceptos_InformacionAduanera_NumeroPedimento',
                                                                'required',
                                                                ]) !!}
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>
                                          <div class="row">
                                              <div class="col-md-12">
                                                  <div class="form-group derecha">
                                                      <button id="btnAgregaConInfoAduanera" class="btn btn-primary" type="button" onclick="javascript: agregaRegistro('tabInfoAduanera', '/Comprobante/CrearConceptoInformacionAduaneraFila'); validaRegistros('infoAduaValida', 'tabInfoAduanera');">
                                                          Agregar
                                                      </button>
                                                  </div>
                                              </div>
                                          </div>
                                          <div class="contenido" style="display:none;">
                                              <h5>Información aduanera</h5>
                                              <table class="table table-bordered">
                                                  <thead>
                                                  <tr>
                                                      <th>Número de pedimento</th>
                                                      <th class="acciones">Acciones</th>
                                                  </tr>
                                                  </thead>
                                                  <tbody>
                                                  </tbody>
                                              </table>
                                          </div>
                                      </div>
                                  </div>
                              </div>

                          </div>
                          <div class="row contenedor" id="contenedorConceptos">
                              <div class="col-md-12" style="overflow-x: auto;">
                                  <div id="conceptosEncabezado" class="anchoConceptos">
                                      <table id="tbConceptos" class="table table-bordered sinMargenInferior">
                                          <thead>
                                          <tr>
                                              <th class="tam150"></th>
                                              <th class="tam150">Clave de producto o servicio</th>
                                              <th class="tam150">Clave de unidad</th>
                                              <th class="tam150">Cantidad</th>
                                              <th class="tam200">Descripción</th>
                                              <th class="tam150">Valor unitario</th>
                                              <th class="tam150">Subtotal</th>
                                              <th class="tam150">Descuento</th>
                                              <th class="tam150">Impuestos</th>
                                              <th class="tam150">Total</th>
                                              <th class="acciones">Acciones</th>
                                          </tr>
                                          </thead>
                                          <tbody></tbody>
                                          <tfoot></tfoot>
                                      </table>
                                  </div>
                                  <div class="anchoConceptos">
                                      <table id="Conceptos">
                                          <tbody>

                                          </tbody>
                                      </table>
                                  </div>
                              </div>

                          </div>
                      </div>

                  </div>
              </div>
          </div>
            <div class="card-footer">
                <div class="clearfix">
                    <div class="pull-left text-muted text-vertical-align-button">
                        * Campos obligatorios
                    </div>
                    <div class="pull-right">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#modalVistaPrevia" type="button" onclick="vistaPrevia()"><i style="margin-right: 3px" class="fas fa-file-invoice"></i> Vista previa</button>

                    </div>
                </div>
            </div>
        </div>
<style>
    .card.no-border, .card.no-border .card-header{
        border:none;
        background: none;
    }
    .card .card-header{
        font-weight: bold;
    }
</style>
@section('js-scripts')
    <script>

        $(document).ready(function(){
            habilitaFacturasRelacionadas();
            $('#Receptor_Rfc').select2({
                ajax: {
                    url: '/general/getCliente',
                    dataType: 'json',
                    data: function (params) {
                        return {
                            q: params.term, // search term
                            page: params.page || 1
                        };
                    },
                    processResults: function (data, params) {
                        params.page = params.page || 1;
                        var result = data.results;
                        console.log(result);
                        return {
                            results: result.data,
                            pagination: {
                                more: (params.page * 10) < result.total
                            }
                        };
                    }
                },
                language: "es"
            });
            $('#ClaveProdServConf').select2({
                ajax: {
                    url: '/general/getProdServ',
                    dataType: 'json',
                    data: function (params) {
                        return {
                            q: params.term, // search term
                            page: params.page || 1
                        };
                    },
                    processResults: function (data, params) {
                        params.page = params.page || 1;
                        var result = data.results;
                        console.log(result);
                        return {
                            results: result.data,
                            pagination: {
                                more: (params.page * 1000) < result.total
                            }
                        };
                    }
                },
                language: "es"
            });
            $('#ClaveUnidad').select2({
                ajax: {
                    url: '/general/getClaveUnidad',
                    dataType: 'json',
                    data: function (params) {
                        return {
                            q: params.term, // search term
                            page: params.page || 1
                        };
                    },
                    processResults: function (data, params) {
                        params.page = params.page || 1;
                        var result = data.results;
                        console.log(result);
                        return {
                            results: result.data,
                            pagination: {
                                more: (params.page * 1000) < result.total
                            }
                        };
                    }
                },
                language: "es"
            });
            $('#Comprobante_LugarExpedicion').select2({
                ajax: {
                    url: '/general/getLugarExpedicion',
                    dataType: 'json',
                    data: function (params) {
                        return {
                            q: params.term, // search term
                            page: params.page || 1
                        };
                    },
                    processResults: function (data, params) {
                        params.page = params.page || 1;
                        var result = data.results;
                        console.log(result);
                        return {
                            results: result.data,
                            pagination: {
                                more: (params.page * 1000) < result.total
                            }
                        };
                    }
                },
                language: "es"
            });
            $('#NoIdentificacion').select2({
                ajax: {
                    url: '/general/NoIdentificacion',
                    dataType: 'json',
                    data: function (params) {
                        return {
                            q: params.term, // search term
                            page: params.page || 1
                        };
                    },
                    processResults: function (data, params) {
                        params.page = params.page || 1;
                        var result = data.results;
                        console.log(result);
                        return {
                            results: result.data,
                            pagination: {
                                more: (params.page * 1000) < result.total
                            }
                        };
                    }
                },
                language: "es"
            });
            $('#NoIdentificacion').on('select2:select', function (e) {

                $.post("/productos/getProducto", {
                    _token: $('meta[name=csrf-token]').attr('content'),
                    codigo: select2Val("NoIdentificacion")
                })
                .done(function (data) {
                    $("#Unidad").val(data.Unidad);
                    setSelect2($("#ClaveProdServConf"),data.ClaveProducto);
                    setSelect2($("#ClaveUnidad"),data.ClaveUnidad);
                    $("#Descripcion").val(data.DescripcionMercancia);
                    $("#ValorUnitario").val(data.PrecioUnitario);
                })
                .fail(function(xhr)
                {
                    console.log(xhr.responseText);
                });
            });

            $("#Cantidad").on("keyup",calcular);
            $("#ValorUnitario").on("keyup",calcular);
            $("#Descuento").on("keyup",calcular);
            $("#Unidad").on("keyup",calcular);
            $(".txt-impuesto").on("keyup",calcular);
            $(".money").on("blur",function(){
                var valor = $(this).val();
                valor = parseFloat(valor);
                valor = isNaN(valor)? "":valor.toFixed(2);
                $(this).val(valor);
            })

            $("#btnuploadProductos").on("click",function(){
                $("#archivoProducto").trigger("click");
            });
            $("#archivoProducto").on("change",function(){
                $("#uploadProductos").submit();
            })
            $("#uploadProductos").on("submit",function(e){
                e.preventDefault();
                var formData = new FormData(document.getElementById("uploadProductos"));
                formData.append("_token", $('meta[name=csrf-token]').attr('content'));

                $.ajax({
                    url: "{{url("/cfdis/subirArchivo")}}",
                    type: "post",
                    dataType: "html",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false
                }) .done(function(data){
                    data = JSON.parse(data);
                    console.log(data);
                    $.each(data,function(key,value){
                        printConcepto(value);
                    });
                }) .fail(function(xhr){
                    errorShow(xhr.responseText);
                });
            });

            $("#btnuploadProductos2").on("click",function(){
                $("#archivoProducto2").trigger("click");
            });
            $("#archivoProducto2").on("change",function(){
                $("#uploadProductos2").submit();
            })
            $("#uploadProductos2").on("submit",function(e){
                e.preventDefault();
                var formData = new FormData(document.getElementById("uploadProductos2"));
                formData.append("_token", $('meta[name=csrf-token]').attr('content'));

                $.ajax({
                    url: "{{url("/cfdis/subirArchivo2")}}",
                    type: "post",
                    dataType: "html",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false
                }) .done(function(data){
                    data = JSON.parse(data);
                    console.log(data);
                    $.each(data,function(key,value){
                        printConcepto(value);
                    });
                }) .fail(function(xhr){
                    errorShow(xhr.responseText);
                });
            });

            // on first focus (bubbles up to document), open the menu
            $(document).on('focus', '.select2-selection.select2-selection--single', function (e) {
                $(this).closest(".select2-container").siblings('select:enabled').select2('open');
            });

            // steal focus during close - only capture once and stop propogation
            $('select.select2').on('select2:closing', function (e) {
                $(e.target).data("select2").$selection.one('focus focusin', function (e) {
                    e.stopPropagation();
                });
            });

        })
        function select2Val(id){
            var text = $("#select2-"+id+"-container").text();
            var parts = text.split(" - ");
            return parts[0]
        }
        function cleanForm(form){
            $("#formulario"+form).find("input").val("");
            $("#CfdiRelacionados_CfdiRelacionado tbody .active").removeClass("active");
        }
        function showForm(form){
            $("#formulario"+form).removeClass("oculto");
            $("#formulario"+form+" input:text:visible:first").focus();
        }
        function hideForm(form){
            $("#formulario"+form).addClass("oculto");
        }
        function addEntityModal(form){
            if(form=="CfdiRelacionado"){
                var folio = $("#UUID").val();
                var tr = '<tr data-folio="'+folio+'"><td class="folio">'+folio+'</td><td class="text-center"><a title="Editar" onclick="editar(this)"><i class="far fa-edit"></i></a>&nbsp;<a title="Eliminar" onclick="eliminar(this)"><i class="fas fa-times"></i></a></td></tr>';
                $("#UUID").val("").focus();
                if($("#CfdiRelacionados_CfdiRelacionado tbody .active").length==0){
                    $("#CfdiRelacionados_CfdiRelacionado tbody").append(tr);
                }
                else{
                    $("#CfdiRelacionados_CfdiRelacionado tbody .active").replaceWith(tr).removeClass("active");
                }
            }
        }
        function editar(obj){
            var renglon = $(obj).parents("tr");
            var folio = renglon.data('folio');
            renglon.addClass("active");
            showForm("CfdiRelacionado")
            $("#UUID").val(folio);
        }
        function eliminar(obj){
            $(obj).parents("tr").remove();
        }
        function habilitaFacturasRelacionadas(){
            if($("#EditarCfdiRelacionados").is(":checked")){
                $("#CfdiRelacionados_TipoRelacionCat").prop("disabled",false);
                $("#CfdiRelacionado").removeClass("oculto");
            }
            else{
                $("#CfdiRelacionados_TipoRelacionCat").prop("disabled",true);
                $("#CfdiRelacionado").addClass("oculto");
            }
        }
        function checkObjetoImp(valor){
            if(valor!=1){
                $("#card-impuestos").removeClass("oculto");
                $("#field-base").removeClass("oculto");
            }
            else{
                $("#card-impuestos").addClass("oculto");
                $("#field-base").addClass("oculto");
            }
            calcular();
        }
        function checkTipoTasa(obj){
            var valor = $(obj).val();
            var renglon = $(obj).parent().parent();
            if(valor=="Tasa"){
                renglon.find(".field-tasa").removeClass("oculto");
                renglon.find(".field-cuota").addClass("oculto");
            }
            else{
                renglon.find(".field-tasa").addClass("oculto");
                renglon.find(".field-cuota").removeClass("oculto");
            }
            calcular();
        }
        function calcular(){

            var cantidad = $("#Cantidad").val();
            cantidad = parseFloat(cantidad);
            cantidad = isNaN(cantidad)? 0:cantidad;
            console.log("Cantidad: "+cantidad);

            var unitario = $("#ValorUnitario").val();
            unitario = parseFloat(unitario);
            unitario = isNaN(unitario)? 0:unitario;
            console.log("Unitario: "+unitario);

            var importe = cantidad*unitario;
            importe = isNaN(importe)? 0:importe.toFixed(2);
            $("#Importe").val(importe);

            var descuento = $("#Descuento").val();
            descuento = parseFloat(descuento);
            descuento = isNaN(descuento)? 0:descuento;
            console.log("Descuento: "+descuento);

            var base = importe-descuento;
            base = isNaN(base)? 0:base.toFixed(2);
            console.log("Base: "+base);
            $("#ObjetoBase").val(base);
            console.log("-----");

            //IMPUESTOS
            var totalImpuestos = 0;
            if($("#ObjetoImp").val()!="01") {
                $(".trtraslado").each(function () {
                    var impuesto = $(this).data("clave");
                    var tipo = $("#trasladoTipo" + impuesto).val();
                    var tasa = $("#trasladoTasa" + impuesto).val();
                    var cuota = $("#trasladoCuota" + impuesto).val();
                    var importe = 0;
                    if (tipo == "Tasa") {
                        importe = base * (tasa / 100);
                    } else {
                        importe = parseFloat(cuota);
                    }
                    importe = isNaN(importe) ? 0 : importe.toFixed(2);
                    $("#trasladoImporte" + impuesto).val(importe);
                    totalImpuestos += parseFloat(importe);
                })
                console.log("Impuestos: " + totalImpuestos);
                $(".trretencion").each(function () {
                    var impuesto = $(this).data("clave");
                    var tipo = $("#retencionTipo" + impuesto).val();
                    var tasa = $("#retencionTasa" + impuesto).val();
                    var cuota = $("#retencionCuota" + impuesto).val();
                    var importe = 0;
                    if (tipo == "Tasa") {
                        importe = base * (tasa / 100);
                    } else {
                        importe = parseFloat(cuota);
                    }
                    importe = isNaN(importe) ? 0 : importe.toFixed(2);
                    $("#retencionImporte" + impuesto).val(importe);
                    totalImpuestos -= parseFloat(importe);
                })
            }
            console.log("Impuestos: "+totalImpuestos);
            totalImpuestos = isNaN(totalImpuestos)? 0:totalImpuestos.toFixed(2);
            $("#ObjetoTotal").val(totalImpuestos);
            var subtotal = parseFloat(base)+parseFloat(totalImpuestos);
            console.log(base+"+"+totalImpuestos+"="+subtotal);
            subtotal = isNaN(subtotal)? 0:subtotal.toFixed(2);
            $("#Subtotal").val(subtotal);
            //CONCEPTOS
            var totalImporte = 0;
            var totalDescuento = 0;
            var totalImpuestos = 0;
            var totalSubtotal = 0;
            $(".trConcepto").each(function(){
                var datos = $(this).data("datos");
                console.log(datos);
                totalImporte += parseFloat(datos.importe);
                totalDescuento += parseFloat(datos.descuento);
                totalImpuestos += parseFloat(datos.impuestos);
                totalSubtotal += parseFloat(datos.subtotal);
            })
            totalImporte = isNaN(totalImporte)? 0.00:totalImporte.toFixed(2);
            totalDescuento = isNaN(totalDescuento)? 0.00:totalDescuento.toFixed(2);
            totalImpuestos = isNaN(totalImpuestos)? 0.00:totalImpuestos.toFixed(2);
            totalSubtotal = isNaN(totalSubtotal)? 0.00:totalSubtotal.toFixed(2);
            var totales = {
                "importe":totalImporte,
                "descuento":totalDescuento,
                "impuestos":totalImpuestos,
                "total":totalSubtotal
            }

            var renglon = "<tr class='trTotalConcepto' data-datos='"+JSON.stringify(totales)+"'>"+
                "<th colspan='6' class='tam150 text-right'>Totales</th>"+
                "<td class='text-right' id='comprobanteSubtotal'>"+totalImporte+"</td>"+
                "<td class='text-right' id='comprobanteDescuento'>"+totalDescuento+"</td>"+
                "<td class='text-right'>"+totalImpuestos+"</td>"+
                "<td class='text-right' id='comprobanteTotal'>"+totalSubtotal+"</td>"+
                "<th class='acciones text-center'>"+
                "</tr>";
            $("#tbConceptos tfoot").html(renglon);
        }
        function getFolio(){
            var datos = $("#Comprobante_Serie").find("option:selected").data();
            $("#Comprobante_Folio").val(datos.folio);
            //return;
            var serie = $("#Comprobante_Serie").val();
            $.post("/cfdis/getFolio", {
                _token: $('meta[name=csrf-token]').attr('content'),
                serie:serie
            })
            .done(function (data) {
                $("#Comprobante_Folio").val(data);
            })
            .fail(function(xhr)
            {
                $("#Comprobante_Folio").val("");
                console.log(xhr.responseText);
            });
        }
        function agregarConcepto(obj){
            $(obj).startDisable();

            var traslados = [];
            var retenciones = [];

            if($("#ObjetoImp").val()!="01") {
                $(".trtraslado").each(function () {
                    var impuesto = $(this).data("clave");
                    var importe = $("#trasladoImporte" + impuesto).val();
                    if(importe>0){
                        var tipo = $("#trasladoTipo" + impuesto).val();
                        var tasa = $("#trasladoTasa" + impuesto).val();
                        var cuota = $("#trasladoCuota" + impuesto).val();

                        var traslado = {
                            "impuesto":impuesto,
                            "tipo":tipo,
                            "tasa":tasa,
                            "cuota":cuota,
                            "importe":importe
                        };

                        traslados.push(traslado);
                    }
                });

                $(".trretencion").each(function () {
                    var impuesto = $(this).data("clave");
                    var importe = $("#retencionImporte" + impuesto).val();
                    if(importe>0) {
                        var tipo = $("#retencionTipo" + impuesto).val();
                        var tasa = $("#retencionTasa" + impuesto).val();
                        var cuota = $("#retencionCuota" + impuesto).val();

                        var retencion = {
                            "impuesto":impuesto,
                            "tipo":tipo,
                            "tasa":tasa,
                            "cuota":cuota,
                            "importe":importe
                        };

                        retenciones.push(retencion);
                    }


                });
            }

            var concepto = {
                "producto":$("#select2-ClaveProdServConf-container").text(),
                "claveunidad":$("#select2-ClaveUnidad-container").text(),
                "cantidad":$("#Cantidad").val(),
                "noIdentificacion":$("#NoIdentificacion").val(),
                "unidad":$("#Unidad").val(),
                "descripcion":$("#Descripcion").val(),
                "unitario":$("#ValorUnitario").val(),
                "importe":$("#Importe").val(),
                "descuento":$("#Descuento").val(),
                "objetoImpuesto":$("#ObjetoImp").val(),
                "impuestos":$("#ObjetoTotal").val(),
                "base":$("#ObjetoBase").val(),
                "subtotal":$("#Subtotal").val(),
                "traslados":traslados,
                "retenciones":retenciones
            };
            printConcepto(concepto);
            $(obj).stopDisable();
        }
        function printConcepto(concepto){
            if($("#Comprobante_TipoComprobante").val()=="T"){
                concepto.unitario=0;
                concepto.importe=0;
                concepto.descuento=0;
                concepto.impuestos=0;
                concepto.subtotal=0;
            }

            var cunitario = parseFloat(concepto.unitario);
            cunitario = isNaN(cunitario)? 0.00:cunitario;
            var cimporte = parseFloat(concepto.importe);
            cimporte = isNaN(cimporte)? 0.00:cimporte;
            var cdescuento = parseFloat(concepto.descuento);
            cdescuento = isNaN(cdescuento)? 0.00:cdescuento;
            var cimpuestos = parseFloat(concepto.impuestos);
            cimpuestos = isNaN(cimpuestos)? 0.00:cimpuestos;
            var csubtotal = parseFloat(concepto.subtotal);
            csubtotal = isNaN(csubtotal)? 0.00:csubtotal;

            var renglon = "<tr class='trConcepto' data-datos='"+JSON.stringify(concepto)+"'>"+
                "<th class='trnumeracion'></th>"+
                "<td class='tam150'>"+concepto.producto+"</td>"+
                "<td class='tam150'>"+concepto.claveunidad+"</td>"+
                "<td class='text-right'>"+concepto.cantidad+"</td>"+
                "<td class='tam200'>"+concepto.descripcion+"</td>"+
                "<td class='text-right'>"+cunitario.toFixed(2)+"</td>"+
                "<td class='text-right'>"+cimporte.toFixed(2)+"</td>"+
                "<td class='text-right'>"+cdescuento.toFixed(2)+"</td>"+
                "<td class='text-right'>"+cimpuestos.toFixed(2)+"</td>"+
                "<td class='text-right'>"+csubtotal.toFixed(2)+"</td>"+
                "<td class='acciones text-center'>"+
                "<a onclick='borrarConcepto(this)' class='link' title='Borrar'><i class='fas fa-times'></i></a>"+
                "<a onclick='editarConcepto(this)' class='link' title='Editar'><i class='fas fa-edit'></i></a></td>"+
                "</tr>";
            if($(".trConcepto.active").length>0){
                $(".trConcepto.active").replaceWith(renglon);
            }
            else{
                $("#tbConceptos tbody").append(renglon);
            }
            var cont =1;
            $(".trnumeracion").each(function(){
                $(this).text(cont);
                cont++;
            })
            cancelarConcepto();
        }
        function borrarConcepto(obj){
            $(obj).parents("tr").remove();
            calcular();
        }
        function setSelect2(obj,valor){
            if(valor!=null) {
                var partes = valor.split(" - ");
                var data = {
                    text: valor,
                    id: partes[1]
                }
                // create the option and append to Select2
                var option = new Option(data.text, data.id, true, true);
                obj.append(option).trigger('change');

                // manually trigger the `select2:select` event
                obj.trigger({
                    type: 'select2:select',
                    params: {
                        data: data
                    }
                });
            }
        }
        function editarConcepto(obj){
            $(".trConcepto.active").removeClass("active");
            $(obj).parents("tr").addClass("active");
            var concepto =  $(obj).parents("tr").data("datos");
            console.log(concepto);

            //$("#select2-ClaveProdServConf-container").text(concepto.producto);
            //$("#select2-ClaveUnidad-container").text(concepto.claveunidad);
            //$("#ClaveProdServConf").val(concepto.producto).trigger("change");
            //$("#ClaveUnidad").val(concepto.claveunidad).trigger("change");

            setSelect2($("#ClaveProdServConf"),concepto.producto)
            setSelect2($("#ClaveUnidad"),concepto.claveunidad)
            $("#Cantidad").val(concepto.cantidad);
            $("#NoIdentificacion").val(concepto.noIdentificacion);
            $("#Unidad").val(concepto.unidad);
            $("#Descripcion").val(concepto.descripcion);
            $("#ValorUnitario").val(concepto.unitario);
            $("#Importe").val(concepto.importe);
            $("#Descuento").val(concepto.descuento);

            $("#ObjetoImp").val(concepto.objetoImpuesto);
            checkObjetoImp(concepto.objetoImpuesto);
            var traslados = concepto.traslados;
            var retenciones = concepto.retenciones;
            $.each(traslados,function(key,value){
                var impuesto = value.impuesto;
                $("#trasladoImporte" + impuesto).val(value.importe);
                $("#trasladoTipo" + impuesto).val(value.tipo);
                $("#trasladoTasa" + impuesto).val(value.tasa);
                $("#trasladoCuota" + impuesto).val(value.cuota);
            });
            $.each(retenciones,function(key,value){
                var impuesto = value.impuesto;
                $("#retencionImporte" + impuesto).val(value.importe);
                $("#retencionTipo" + impuesto).val(value.tipo);
                $("#retencionTasa" + impuesto).val(value.tasa);
                $("#retencionCuota" + impuesto).val(value.cuota);
            });

            $("#ObjetoBase").val(concepto.base);
            $("#Subtotal").val(concepto.subtotal);
            calcular();
        }
        function cancelarConcepto(){
            $(".trConcepto.active").removeClass("active");
            $("#ClaveProdServConf").val(null).trigger('change');
            $("#ClaveUnidad").val(null).trigger('change');
            $("#Cantidad").val("");
            $("#NoIdentificacion").val("");
            $("#Unidad").val("");
            $("#Descripcion").val("");
            $("#ValorUnitario").val("");
            $("#Importe").val("");
            $("#Descuento").val("");
            $("#ObjetoImp").val("01");
            checkObjetoImp("01");
            $("#ObjetoBase").val("");
            $("#Subtotal").val("");
            $(".txt-impuesto").val("");
            calcular();
        }
        function vistaPrevia(){
            var uuid = $("#uuid").val();
            if(uuid==null || uuid=="")
            {
                var emisor = getEmisor();
                var receptor = getReceptor();
                var comprobante = getComprobante();
                var conceptos = getConceptos();
                $("#btnDescarga").addClass("oculto");
                $("#btnGuardar").removeClass("oculto");
                $("#iframeCfdi").addClass("oculto");
                $("#btnTimbrar").removeClass("oculto");

                $.post("/cfdis/vistaPreviaPdf", {
                    _token: $('meta[name=csrf-token]').attr('content'),
                    emisor: emisor,
                    receptor: receptor,
                    comprobante: comprobante,
                    conceptos: conceptos
                })
                    .done(function (data) {
                        //$("#modalVistaPrevia .modal-body").html(data);
                        $("#iframeCfdi").attr("src", "/cfdis/verPdf/" + data + ".pdf");
                        $("#iframeCfdi").removeClass("oculto");
                        $("#lodingPdf").addClass("oculto");
                    })
                    .fail(function (xhr) {
                        console.log(xhr.responseText);
                        $("#respuestaPdf").html("<h2>Error</h2>"+xhr.responseText);
                        $("#imgloader").addClass("oculto");
                    });
            }
            else{
                showCfdi(uuid);
            }

        }
        function showCfdi(uuid){
            $("#btnDescarga").removeClass("oculto");
            $("#btnGuardar").addClass("oculto");
            $("#btnTimbrar").addClass("oculto");
            $("#iframeCfdi").attr("src","/cfdis/verCfdi/"+uuid+".pdf");
            $("#btnVistaPrevia").attr("href","/cfdis/verCfdi/"+uuid+".pdf");
            $("#iframeCfdi").removeClass("oculto");
        }
        function vistaPreviaPdf(){
            var emisor = getEmisor();
            var receptor = getReceptor();
            var comprobante = getComprobante();
            var conceptos = getConceptos();

            $.post("/cfdis/vistaPreviaPdf", {
                _token: $('meta[name=csrf-token]').attr('content'),
                emisor:emisor,
                receptor:receptor,
                comprobante:comprobante,
                conceptos:conceptos
            })
                .done(function (data) {
                    window.open("/cfdis/verPdf/"+data+".pdf");
                    $("#btnVistaPrevia").attr("href","/cfdis/verPdf/"+data+".pdf");
                })
                .fail(function(xhr)
                {
                    $("#modalVistaPrevia .modal-body").html(xhr.responseText);
                    console.log(xhr.responseText);
                });

        }
        function guardarComprobante(){
            var emisor = getEmisor();
            var receptor = getReceptor();
            var comprobante = getComprobante();
            var conceptos = getConceptos();

            $.post("/cfdis/guardarComprobante", {
                _token: $('meta[name=csrf-token]').attr('content'),
                emisor:emisor,
                receptor:receptor,
                comprobante:comprobante,
                conceptos:conceptos
            })
                .done(function (data) {
                    swal.fire({
                        title:"Guardado",
                        html:data,
                        type: 'success'
                    });
                })
                .fail(function(xhr)
                {
                    swal.fire({
                        title:"Oops!",
                        html:xhr.responseText,
                        type: 'error'
                    });
                });

        }
        function timbrarComprobante(obj){
            $(obj).startDisable("Timbrando...");
            var emisor = getEmisor();
            var receptor = getReceptor();
            var comprobante = getComprobante();
            var conceptos = getConceptos();

            $.post("/cfdis/timbrarComprobante", {
                _token: $('meta[name=csrf-token]').attr('content'),
                emisor:emisor,
                receptor:receptor,
                comprobante:comprobante,
                conceptos:conceptos
            })
                .done(function (data) {
                    $(obj).stopDisable();
                    showCfdi(data);
                    $("#uuid").val(data);
                })
                .fail(function(xhr)
                {
                    swal.fire({
                        title:"Ocurrio un error, intente de nuevo",
                        html: xhr.responseText,
                        type: 'error'
                    });
                    console.log(xhr.responseText);
                    $(obj).stopDisable();
                });

        }
        function getEmisor(){
            var emisor = {};
            $("#card-emisor :input").each(function(){
                var input = $(this);
                emisor[input.attr("id")] = input.val();

            });
            console.log(emisor);
            return emisor;
        }
        function getReceptor(){
            var receptor = {};
            $("#card-receptor :input").each(function(){
                var input = $(this);
                receptor[input.attr("id")] = input.val();

            });
            receptor["Receptor_RfcCargado"] = $("#select2-Receptor_Rfc-container").text();
            console.log(receptor);
            return receptor;
        }
        function getComprobante(){
            var comprobante = {};
            $("#card-comprobante :input").each(function(){
                var input = $(this);
                comprobante[input.attr("id")] = input.val();

            });
            comprobante["Comprobante_LugarExpedicion"]=$("#select2-Comprobante_LugarExpedicion-container").text();
            comprobante["Comprobante_Total"]=$("#comprobanteTotal").text();
            comprobante["Comprobante_SubTotal"]=$("#comprobanteSubtotal").text();
            comprobante["Comprobante_Descuento"]=$("#comprobanteDescuento").text();
            console.log(comprobante);
            return comprobante;
        }
        function getConceptos(){
            var conceptos = [];
            $(".trConcepto").each(function(){
                var concepto = $(this).data("datos");
                conceptos.push(concepto);
            });
            console.log(conceptos);
            return conceptos;
        }
        function checkMoneda(){
            var valor = $("#Comprobante_Moneda").val();
            if(valor=="MXN"||valor=="XXX"){
                $("#Comprobante_TipoCambio").val("").attr("disabled",true);
            }
            else{
                $("#Comprobante_TipoCambio").attr("disabled",false);
            }
        }
        function descargarCfdi(obj){
            $(obj).startDisable("Descargando...");
            var uuid = $("#uuid").val();
            $.post("/cfdis/descargarCfdi", {
                _token: $('meta[name=csrf-token]').attr('content'),
                uuid: uuid
            })
            .done(function (data) {
                $(obj).stopDisable();
                if(data[0]=="success") {
                    window.location.assign('/cfdis/zip/' + data[1] + '/' + uuid + '.zip');
                }
                else{
                    swal.fire({
                        title:"Error",
                        html:data[1],
                        type: 'error'
                    });
                }

            })
            .fail(function(xhr)
            {
                console.log(xhr.responseText);
                $(obj).stopDisable();
            });
        }
        function checkTipoComprobante(){
            var value = $("#Comprobante_TipoComprobante").val();
            if(value=="T"){
                $("#Comprobante_Moneda").val("XXX").prop('disabled', true);
                setSelect2($("#Receptor_Rfc"),$("#Emisor_Rfc").val()+' - '+$("#Emisor_Nombre").val());
                $("#Receptor_UsoCFDI").val("S01").prop('disabled', true);
                $("#Receptor_Rfc").prop("disabled", true);
                $("#ValorUnitario").prop("disabled", true);
            }
            else{
                $("#Comprobante_Moneda").val("MXN").prop('disabled', false);
                $("#Receptor_UsoCFDI").prop('disabled', false);
                $("#Receptor_Rfc").prop("disabled", false);
                $("#ValorUnitario").prop("disabled", false);
            }

            if(value!="T"&&value!="N"&&value!="P"){
                $("#Comprobante_FormaPago").prop('disabled', false);
                $("#Comprobante_CondicionesDePago").prop('disabled', false);
                $("#ObjetoImp").prop('disabled', false);
            }
            else{
                $("#Comprobante_FormaPago").prop('disabled', true);
                $("#Comprobante_CondicionesDePago").prop('disabled', true);
                $("#ObjetoImp").val("01").prop('disabled', true);
            }
            if(value!="T"&&value!="P"){
                $("#Comprobante_MetodoPago").prop('disabled', false);
                $("#Descuento").prop('disabled', false);
            }
            else{
                $("#Comprobante_MetodoPago").prop('disabled', true);
                $("#Descuento").prop('disabled', true);
            }
            $("#Comprobante_Serie").find("option[data-tipo='"+value+"']").prop('selected', true);

            getFolio();
            checkMoneda();
        }
    </script>
@endsection
@section('main-modales')
    @parent
    <div id="modalVistaPrevia" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Vista previa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <iframe class="oculto" style="width: 100%;height: 500px;" id="iframeCfdi" src=""></iframe>
                    <div style="width: 100%; height: 500px" id="lodingPdf">
                        <div style="text-align: center;padding: 150px;">
                            <img id="imgloader" loading="eager" src="/img/loaderlogo.gif" alt="Cargando..." height="200" width="200">
                            <p id="respuestaPdf"></p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer text-right">
                    <a id="btnVistaPrevia" class="btn btn-default" type="button" href="" target="_blank"><i class="fas fa-file-pdf"></i> Abrir en otra pestaña</a>
                    <button id="btnGuardar" class="btn btn-default guardaComprobante" onclick="guardarComprobante(this)"><i class="fas fa-save"></i> Guardar comprobante</button>
                    <button id="btnTimbrar" class="btn btn-primary" onclick="timbrarComprobante(this);"><i class="fas fa-file-signature"></i> Timbrar comprobante</button>
                    <button id="btnDescarga" class="btn btn-warning oculto" onclick="descargarCfdi(this);"><i class="fas fa-download"></i> Descargar archivos</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
@endsection