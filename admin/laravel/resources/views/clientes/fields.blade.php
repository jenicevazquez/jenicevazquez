<div class="row">
    <div class="col-12 col-sm-12">
        <div class="tab-content" id="vert-tabs-tabContent">
            <div class="tab-pane text-left fade show active" id="vert-tabs-home" role="tabpanel" aria-labelledby="vert-tabs-home-tab">
                <div class="card card-default">
                    <div class="card-header">
                        <h4 class="card-title" style="padding: 4px 0">Datos del receptor</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-3 form-group">
                                <input type="hidden" name="Receptor_id" id="Receptor_id">
                                {!! Form::label('Receptor_Rfc', 'RFC:',['class'=>'required']) !!}
                                {!! Form::text('Receptor_Rfc', null, [
                                      'class' => 'form-control rfc text-box single-line',
                                      'title' => 'El valor debe contener máximo 13 y mínimo 12 caracteres.',
                                      'minlength' => 12,
                                      'maxlength' => 13,
                                      'error' => 'RFC inválido. Capture solo 12 o 13 caracteres en mayúsculas.',
                                      'regex' => '[A-Z&amp;amp;amp;Ñ]{3,4}[0-9]{2}(0[1-9]|1[012])(0[1-9]|[12][0-9]|3[01])[A-Z0-9]{2}[0-9A]',
                                      'id' => 'Receptor_Rfc',
                                      'autocomplete' => 'off',
                                      'required',
                                      'onkeyup'=>'this.value = this.value.toLocaleUpperCase();'
                                      ]) !!}
                            </div>
                            <div class="form-group col-sm-6">
                                {!! Form::label('Receptor_Nombre', 'Nombre o razón social:',['class'=>'required']) !!}
                                {!! Form::text('Receptor_Nombre', null, [
                                      'class' => 'form-control text-box single-line',
                                      'title'=> 'El valor debe contener máximo 254 y mínimo 1 caracteres.',
                                      'minlength'=> 1,
                                      'maxlength'=>254,
                                      'error'=>'Longitud y/o formato de datos inválidos.',
                                      'regex'=>'[^|]{1,254}',
                                      'id'=>'Receptor_Nombre',
                                      'autocomplete' => 'off',
                                      'required'
                                      ]) !!}
                            </div>
                            <div class="col-sm-3 form-group">
                                {!! Form::label('Receptor_DomicilioFiscal', 'Domicilio Fiscal:',['class'=>'required']) !!}
                                {!! Form::text('Receptor_DomicilioFiscal', null, [
                                      'class' => 'form-control rfc text-box single-line',
                                      'title' => 'Atributo requerido para registrar el código postal del domicilio fiscal del receptor del comprobante.',
                                      'minlength' => 5,
                                      'maxlength' => 5,
                                      'error' => 'Capture solo 5 caracteres numericos.',
                                      'regex' => '[0-9]{5}',
                                      'id' => 'Receptor_DomicilioFiscal',
                                      'autocomplete' => 'off',
                                      'required',
                                      'onkeyup'=>'this.value = this.value.toLocaleUpperCase();'
                                      ]) !!}
                            </div>
                            <div class="form-group col-md-12">
                                {!! Form::label('Receptor_RegimenFiscal', 'Régimen fiscal:',['class'=>'required']) !!}
                                {!! Form::select('Receptor_RegimenFiscal',GenericClass::selectRegimenesFiscales(), null, [
                                      'class' => 'form-control',
                                      'id' => 'Receptor_RegimenFiscal',
                                      'autocomplete' => 'off',
                                      'required'
                                      ]) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-7">
                                <div class="form-group">
                                    <div class="form-group col-xs-12">
                                        {!! Form::label('Receptor_NumRegIdTrib', 'Registro de identidad fiscal:') !!}
                                        {!! Form::text('Receptor_NumRegIdTrib', null, [
                                              'class' => 'form-control rfc text-box single-line',
                                              'title' => 'Atributo condicional para expresar el número de registro de identidad fiscal del receptor cuando sea residente en el extranjero. Es requerido cuando se incluya el complemento de comercio exterior.',
                                              'minlength' => 1,
                                              'maxlength' => 40,
                                              'id' => 'Receptor_NumRegIdTrib',
                                              'autocomplete' => 'off',
                                              'onkeyup'=>'this.value = this.value.toLocaleUpperCase();'
                                              ]) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-sm-5">
                                {!! Form::label('Receptor_ResidenciaFiscal', 'Residencia Fiscal:') !!}
                                {!! Form::select('Receptor_ResidenciaFiscal',GenericClass::selectPais(), null, [
                                      'class' => 'form-control text-box single-line',
                                      'title'=> 'Atributo condicional para registrar la clave del país de residencia para efectos fiscales del receptor del comprobante, cuando se trate de un extranjero, y que es conforme con la especificación ISO 3166-1 alpha-3. Es requerido cuando se incluya el complemento de comercio exterior o se registre el atributo NumRegIdTrib.',
                                      'minlength'=> 1,
                                      'maxlength'=>40,
                                      'id'=>'Receptor_Nombre',
                                      'autocomplete' => 'off'
                                      ]) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="form-group col-sm-8"><b>Domicilio fiscal</b></div>
                                    <div class="form-group col-sm-8">
                                        {!! Form::label('Receptor_calle', 'Calle:') !!}
                                        {!! Form::text('Receptor_calle', null, ['class' => 'form-control','maxlength'=>500]) !!}
                                    </div>
                                    <div class="form-group col-sm-4">
                                        {!! Form::label('Receptor_ext', 'Numero:') !!}
                                        {!! Form::text('Receptor_ext', null, ['class' => 'form-control','maxlength'=>50]) !!}
                                    </div>
                                    <div class="form-group col-sm-8">
                                        {!! Form::label('Receptor_colonia', 'Colonia:') !!}
                                        {!! Form::text('Receptor_colonia', null, ['class' => 'form-control','maxlength'=>500]) !!}
                                    </div>
                                    <div class="form-group col-sm-4">
                                        {!! Form::label('Receptor_cp', 'CP:') !!}
                                        {!! Form::text('Receptor_cp', null, ['class' => 'form-control','maxlength'=>50]) !!}
                                    </div>
                                    <div class="form-group col-sm-4">
                                        {!! Form::label('Receptor_ciudad', 'Ciudad:') !!}
                                        {!! Form::text('Receptor_ciudad', null, ['class' => 'form-control','maxlength'=>50]) !!}
                                    </div>
                                    <div class="form-group col-sm-4">
                                        {!! Form::label('Receptor_estado', 'Estado:') !!}
                                        {!! Form::text('Receptor_estado', null, ['class' => 'form-control','maxlength'=>50]) !!}
                                    </div>
                                    <div class="form-group col-sm-4">
                                        {!! Form::label('Receptor_pais', 'Pais:') !!}
                                        {!! Form::text('Receptor_pais', null, ['class' => 'form-control','maxlength'=>50]) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="resultadoCliente"></div>
    </div>
</div>
