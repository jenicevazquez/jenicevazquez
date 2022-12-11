<div class="row">
    <div class="col-sm-3">
        <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
            <a class="nav-link active" id="vert-tabs-home-tab" data-toggle="pill" href="#vert-tabs-home" role="tab" aria-controls="vert-tabs-home" aria-selected="true">Razón social y logo</a>
            <a class="nav-link " id="vert-tabs-settings-tab" data-toggle="pill" href="#vert-tabs-settings" role="tab" aria-controls="vert-tabs-settings" aria-selected="false">Domicilio fiscal</a>

            <a class="nav-link" id="vert-tabs-profile-tab" data-toggle="pill" href="#vert-tabs-profile" role="tab" aria-controls="vert-tabs-profile" aria-selected="false">Series</a>
            <a class="nav-link" id="vert-tabs-messages-tab" data-toggle="pill" href="#vert-tabs-messages" role="tab" aria-controls="vert-tabs-messages" aria-selected="false">CFDI</a>
        </div>
    </div>
    <div class="col-sm-9">
        <div class="tab-content" id="vert-tabs-tabContent">
            <div class="tab-pane fade show active" id="vert-tabs-home" role="tabpanel" aria-labelledby="vert-tabs-home-tab">
                <div class="card card-default">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-4 form-group">
                                <input class="form-control" maxlength="255" id="imagen" name="imagen" type="hidden" value="{!! GenericClass::empresa()->imagen !!}">
                                <div class="img-user form-control" style="height: 140px; text-align: center">
                                    <img id="imgPerfil" src="/img/logos/{!! GenericClass::empresa()->imagen !!}" style="height: 125px;">
                                </div>
                            </div>
                            <div class="col-sm-8 form-group">
                                <p>El logotipo se mostrará en la versión impresa de sus facturas como se encuentra en el recuadro.</p>
                                <a id="btnfotoperfil" style="display: block; margin-top: 10px; margin-bottom: 10px" class="btn btn-default">Sube una imagen</a>
                                <a onclick="eliminarFoto()" style="display: block; color: darkblue; text-align: center">Eliminar foto</a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="form-group col-xs-12">
                                        {!! Form::label('Emisor_Rfc', 'RFC:',['class'=>'required']) !!}
                                        {!! Form::text('Emisor_Rfc', GenericClass::empresa()->Rfc, [
                                              'class' => 'form-control rfc text-box single-line',
                                              'title' => 'El valor debe contener máximo 13 y mínimo 12 caracteres.',
                                              'minlength' => 12,
                                              'maxlength' => 13,
                                              'error' => 'RFC inválido. Capture solo 12 o 13 caracteres en mayúsculas.',
                                              'regex' => '[A-Z&amp;amp;amp;Ñ]{3,4}[0-9]{2}(0[1-9]|1[012])(0[1-9]|[12][0-9]|3[01])[A-Z0-9]{2}[0-9A]',
                                              'id' => 'Emisor_Rfc',
                                              'autocomplete' => 'off',
                                              'required',
                                              'onkeyup'=>'this.value = this.value.toLocaleUpperCase();'
                                              ]) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-sm-8">
                                {!! Form::label('Emisor_Nombre', 'Nombre o razón social:',['class'=>'required']) !!}
                                {!! Form::text('Emisor_Nombre', GenericClass::empresa()->Nombre, [
                                      'class' => 'form-control text-box single-line',
                                      'title'=> 'El valor debe contener máximo 254 y mínimo 1 caracteres.',
                                      'minlength'=> 1,
                                      'maxlength'=>254,
                                      'error'=>'Longitud y/o formato de datos inválidos.',
                                      'regex'=>'[^|]{1,254}',
                                      'id'=>'Emisor_Nombre',
                                      'autocomplete' => 'off',
                                      'required'
                                      ]) !!}
                            </div>
                            <div class="form-group col-md-12">
                                {!! Form::label('Emisor_RegimenFiscal', 'Régimen fiscal:',['class'=>'required']) !!}
                                {!! Form::select('Emisor_RegimenFiscal',GenericClass::selectRegimenesFiscales(), GenericClass::empresa()->RegimenFiscal, [
                                      'class' => 'form-control',
                                      'id' => 'Emisor_RegimenFiscal',
                                      'autocomplete' => 'off',
                                      'required'
                                      ]) !!}
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <div class="clearfix">
                                <div class="pull-left text-muted text-vertical-align-button">
                                    * Campos obligatorios
                                </div>
                                <div class="pull-right">
                                    <button class="btn btn-info guardaComprobante" type="submit" onclick="guardaDatosEmisor(this)">Guardar</button>
                                    <a onclick="javascript:document.location.reload(true)" class="btn btn-default">Cancelar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="vert-tabs-profile" role="tabpanel" aria-labelledby="vert-tabs-profile-tab">
                <div class="card card-default">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    {!! Form::label('Serie_TipoComprobante', 'Tipo de comprobante:') !!}
                                    {!! Form::select('Serie_TipoComprobante',GenericClass::selectTiposComprobantes(), null, [
                                          'class' => 'form-control',
                                          'id' => 'Serie_TipoComprobante',
                                          'required',
                                          ]) !!}
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <input type="hidden" name="Serie_id" id="Serie_id" value="">
                                <div class="form-group" title="Número de serie de la factura que usas para control interno, generalmente se usan letras">
                                    <label class="control-label" for="Serie_serie">Serie:</label>
                                    <input class="form-control text-box single-line" data-val="true" data-val-regex="Longitud y/o formato de datos inválidos." data-val-regex-pattern="[^|]{1,25}" id="Serie_serie" name="Serie_serie" type="text" value="" maxlength="25">

                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group" title="Número de folio de la factura que usas para control interno, generalmente se usan números.">
                                    <label class="control-label" for="Serie_folio">Folio:</label>
                                    <input class="form-control text-box single-line" data-val-regex="Longitud y/o formato de datos inválidos." data-val-regex-pattern="[^|]{1,40}" id="Serie_folio" name="Serie_folio" type="text" value="" maxlength="40" autocomplete="nope">
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-sm-12" id="tbSeries" data-widget="section-refresh" data-source="/empresa/listSeries">

                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="vert-tabs-messages" role="tabpanel" aria-labelledby="vert-tabs-messages-tab">
                <!-- INICIA SECCIÓN DE CSD -->
                <div class="card card-default">
                    <div id="card-fiel">
                        <div class="card-body">
                            <div class="row esMisCuentas">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        {!! Form::label('cer', 'Certificado (.cer):') !!}
                                        <div class="custom-file">
                                            <input autocomplete="off" type="file" class="custom-file-input" id="CSD_cer" name="CSD_cer" accept=".cer">
                                            <label class="custom-file-label" for="exampleInputFile">Seleccionar archivo .cer</label>
                                        </div>
                                        <small>{!! GenericClass::certificado()->archivocer !!}</small>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        {!! Form::label('key', 'Llave privada (.key):') !!}
                                        <div class="custom-file">
                                            <input autocomplete="off" type="file" class="custom-file-input" id="CSD_key" name="CSD_key" accept=".key">
                                            <label class="custom-file-label" for="exampleInputFile">Seleccionar archivo .key</label>
                                        </div>
                                        <small>{!! GenericClass::certificado()->archivokey !!}</small>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        {!! Form::label('CSD_pass', 'Contraseña:') !!}
                                        {!! Form::password('CSD_pass', ['class' => 'form-control','maxlength'=>255,'required','autocomplete'=>'off']) !!}
                                        <input type="hidden" value="{!! GenericClass::certificado()->certificado !!}" name="CSD_certificado" id="CSD_certificado">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 text-right">
                                    <a class="btn btn-info" onclick="guardarCSD(this)">Guardar</a>
                                    <a class="btn btn-default">Cancelar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="vert-tabs-settings" role="tabpanel" aria-labelledby="vert-tabs-settings-tab">
                <div class="card card-default">
                  <div class="card-body">
                      <div class="row">
                          <div class="col-sm-12">
                              <div class="row">
                                  <div class="form-group col-sm-8">
                                      {!! Form::label('Emisor_calle', 'Calle:') !!}
                                      {!! Form::text('Emisor_calle', GenericClass::empresa()->calle, ['class' => 'form-control','maxlength'=>500]) !!}
                                  </div>
                                  <div class="form-group col-sm-4">
                                      {!! Form::label('Emisor_ext', 'Numero:') !!}
                                      {!! Form::text('Emisor_ext', GenericClass::empresa()->ext, ['class' => 'form-control','maxlength'=>50]) !!}
                                  </div>
                                  <div class="form-group col-sm-8">
                                      {!! Form::label('Emisor_colonia', 'Colonia:') !!}
                                      {!! Form::text('Emisor_colonia', GenericClass::empresa()->colonia, ['class' => 'form-control','maxlength'=>500]) !!}
                                  </div>
                                  <div class="form-group col-sm-4">
                                      {!! Form::label('Emisor_cp', 'CP:') !!}
                                      {!! Form::text('Emisor_cp', GenericClass::empresa()->cp, ['class' => 'form-control','maxlength'=>50]) !!}
                                  </div>
                                  <div class="form-group col-sm-4">
                                      {!! Form::label('Emisor_ciudad', 'Ciudad:') !!}
                                      {!! Form::text('Emisor_ciudad', GenericClass::empresa()->ciudad, ['class' => 'form-control','maxlength'=>50]) !!}
                                  </div>
                                  <div class="form-group col-sm-4">
                                      {!! Form::label('Emisor_estado', 'Estado:') !!}
                                      {!! Form::text('Emisor_estado', GenericClass::empresa()->estado, ['class' => 'form-control','maxlength'=>50]) !!}
                                  </div>
                                  <div class="form-group col-sm-4">
                                      {!! Form::label('Emisor_pais', 'Pais:') !!}
                                      {!! Form::text('Emisor_pais', GenericClass::empresa()->pais, ['class' => 'form-control','maxlength'=>50]) !!}
                                  </div>
                                  <div class="form-group col-sm-12" style="margin-top: 1rem">
                                      <p><input type="checkbox" name="chk_LugarExpedicion" id="chk_LugarExpedicion"> Usar el código postal como lugar de expedición de facturas.</p>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <div class="row">
                          <div class="col-sm-12" style="text-align: right">
                              <div class="clearfix">
                                      <button class="btn btn-info guardaComprobante" type="submit" onclick="guardaDatosEmisor(this)">Guardar</button>
                                      <a onclick="javascript:document.location.reload(true)" class="btn btn-default">Cancelar</a>
                                  </div>
                              </div>
                          </div>
                      </div>

                  </div>
                </div>
            </div>
        </div>
        <div id="resultadoEmpresa"></div>
    </div>
</div>


@section('js-scripts')
    @parent
<script>
     $(document).ready(function(){
        $("#tbSeries").refresh();
         $("#Serie_folio,#Serie_serie").on('keypress',function(e) {
             if(e.which == 13) {
                 e.preventDefault();
                 $.post("/empresa/setFolio", {
                     _token: $('meta[name=csrf-token]').attr('content'),
                     folio: $("#Serie_folio").val(),
                     serie: $("#Serie_serie").val(),
                     tipoComprobante: $("#Serie_TipoComprobante").val(),
                     id: $("#Serie_id").val()
                 })
                 .done(function (data) {
                    $("#tbSeries").refresh();
                     $("#Serie_folio").val("");
                     $("#Serie_serie").val("");
                     $("#Serie_id").val("");
                     $("#Serie_TipoComprobante").val(null);
                     $("#resultadoEmpresa").html(makeAlert(data,"success"));
                 })
                 .fail(function(xhr)
                 {
                     $("#resultadoEmpresa").html(makeAlert(xhr.responseText,"error"));
                 });
             }
         });
    })
    function guardaDatosEmisor(obj){
        $(obj).startDisable("Guardando...");
        var chkCp = $("#chk_LugarExpedicion").is(":checked")? 1:0;
        $.post("/empresa/guardarDatosEmisor", {
            _token: $('meta[name=csrf-token]').attr('content'),
            Rfc: $("#Emisor_Rfc").val(),
            Nombre: $("#Emisor_Nombre").val(),
            RegimenFiscal: $("#Emisor_RegimenFiscal").val(),
            calle: $("#Emisor_calle").val(),
            ext: $("#Emisor_ext").val(),
            colonia: $("#Emisor_colonia").val(),
            cp: $("#Emisor_cp").val(),
            ciudad: $("#Emisor_ciudad").val(),
            estado: $("#Emisor_estado").val(),
            pais: $("#Emisor_pais").val(),
            imagen: $("#imagen").val(),
            chkCp: chkCp
        })
        .done(function (data) {
            $(obj).stopDisable();
            $("#resultadoEmpresa").html(makeAlert(data,"success"));
        })
        .fail(function(xhr)
        {
            $(obj).stopDisable();
            $("#resultadoEmpresa").html(makeAlert(xhr.responseText,"error"));
        });
    }
    function borrarSerie(obj){
        var id = $(obj).parents(".tr").data("id");
        Swal.fire({
            title: 'Desea borrar la serie?',
            text: "No podrá deshacer esta acción",
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.value) {
                $.post("/empresa/borrarSerie", {
                    _token: $('meta[name=csrf-token]').attr('content'),
                    id: id
                })
                    .done(function (data) {
                        $("#tbSeries").refresh();
                        $("#resultadoEmpresa").html(makeAlert(data,"success"));
                    })
                    .fail(function (xhr) {
                        $("#resultadoEmpresa").html(makeAlert(xhr.responseText,"error"));
                    });
            }
        });
    }
    function editarSerie(obj){
        var datos = $(obj).parents(".tr").data("datos");
        console.log(datos);
        if(datos!=undefined){
            $.each(datos,function(key,value){
                $("#Serie_"+key).val(value);
            });
        }
    }
    function subirFoto(obj){
        $(obj).startDisable("Cargando...");
        var formData = new FormData(document.getElementById("formpicture"));
        formData.append("_token", $('meta[name=csrf-token]').attr('content'));
        $.ajax({
            url: "/empresa/uploadPhotoPerfil",
            type: "post",
            dataType: "html",
            data: formData,
            cache: false,
            contentType: false,
            processData: false
        }) .done(function(data){
            $("#resultadoEmpresa").html(makeAlert("Su imagen se cargó correctamente","success"));
            $(obj).stopDisable();
            $("#imgPerfil").attr("src",'/empresa/img/'+data);
            $("#imagen").val(data);
        }) .fail(function(xhr){
            $("#resultadoEmpresa").html(makeAlert(xhr.responseText,"error"));
        });
    }
    function eliminarFoto(){
        $.post("/empresa/deletePhotoPerfil", {
            _token: $('meta[name=csrf-token]').attr('content')
        })
            .done(function (data) {
                $("#imgPerfil").attr("src","/img/user2-160x160.jpg");
                $("#imagen").val("");
                $("#resultadoEmpresa").html(makeAlert("Su imagen se borró correctamente","success"));
            })
            .fail(function(xhr)
            {
                $("#resultadoEmpresa").html(makeAlert(xhr.responseText,"error"));
            });
    }
    function guardarCSD(obj){
         var formData = new FormData(document.getElementById("formEmpresa"));
         formData.append("_token", $('meta[name=csrf-token]').attr('content'));
         $(obj).startDisable("Guardando...");
         $.ajax({
             url: "{{url("/empresa/guardarCSD")}}",
             type: "post",
             dataType: "html",
             data: formData,
             cache: false,
             contentType: false,
             processData: false
         }) .done(function(data){
             $(obj).stopDisable();
         }) .fail(function(xhr){
             $(obj).stopDisable();
             errorShow(xhr.responseText);
         });
    }
    $(document).ready(function(){
        $("#btnfotoperfil").on("click",function(){
            $("#fotoperfil").click();
        })
        $("#fotoperfil").change(function (e) {
            subirFoto($("#btnfotoperfil"));
        });
    })
</script>
@endsection