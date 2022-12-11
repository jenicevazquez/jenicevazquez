<div class="modal" tabindex="-1" role="dialog" id="modalActivacion">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-pink">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title">Activación de licencia</h5>
      </div>
      <div class="modal-body row">
          <div class="col-xs-12">
            <p style="line-height: 15px">
              <b>Licencia para {{ ucfirst(General::empresa()->nombre) }}</b><br>
              <small>Suscripción activa hasta {!! General::ingreso(General::getLicenceExp()) !!}</small>
            </p>
          </div>

        <hr>
        <div class="col-xs-12">
        <p>Activar nueva licencia:</p>
        <p><input class="tipoActivacion" name="tipoActivacion" value="1" type="radio"> Activar automaticamente usando internet (recomendado) <br>
        <input class="tipoActivacion" name="tipoActivacion" value="2" type="radio"> Activar manualmente sin internet </p>
        <div class="codigoActivacion">
          <div class="form-group col-xs-12 col-sm-6 claveField">
            {!! Form::label('codeActivation', 'Ingrese codigo de activacion:') !!}
            {!! Form::text('codeActivation', null, ['class' => 'form-control','maxlength'=>45])!!}
          </div>
          <div class="form-group col-xs-12 col-sm-6">
          <p><br>Si no cuenta con ningún código de activación, contacte a su administrador de sistema.</p>
          </div>
        </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" onclick="activar()" class="btn btn-primary"><i class="fa fa-check"></i> Activar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<script>
  $(document).ready(function(){
     checar();
     $(".tipoActivacion").on("click",function(){
         checar();
     })
  });
  function checar(){
      var tipo = $('input[name=tipoActivacion]:checked').val();
      if(tipo==2){
          $(".codigoActivacion").show();
      }
      else{
          $(".codigoActivacion").hide();
      }
  }
  function activar() {
      var tipo = $('input[name=tipoActivacion]:checked').val();
      if(tipo==2){
          $.post("{{url('general/activacion')}}", {
              _token: $('meta[name=csrf-token]').attr('content'),
              vence: $("#codeActivation").val()
          })
          .done(function (data) {
              if(data=="exito") {
                  swal.fire({
                      title: "Activado",
                      html: "Se ha realizado la activacion exitosamente",
                      type: 'success',
                      showCancelButton: false,
                      closeOnConfirm: false,
                      confirmButtonText: "Ok"
                  }).then(function () {
                      window.location.reload(true);
                  });
              }else{
                  swal.fire({
                      title: "Error",
                      html: "El codigo ingresado no es válido",
                      type: 'error',
                      showCancelButton: false,
                      closeOnConfirm: false,
                      confirmButtonText: "Ok"
                  })
              }
          })
           .fail(function(xhr, textStatus, errorThrown)
             {
                 console.log(xhr.responseText);
             });
      }else{
          $.post("{{url('general/activacionOnline')}}", {
              _token: $('meta[name=csrf-token]').attr('content')
          })
              .done(function (data) {
                  if(data[0]=="exito") {
                      swal.fire({
                          title: "Activado",
                          html: "Se ha realizado la activacion exitosamente",
                          type: 'success',
                          showCancelButton: false,
                          closeOnConfirm: false,
                          confirmButtonText: "Ok"
                      }).then(function () {
                          window.location.reload(true);
                      });
                  }else{
                      swal.fire({
                          title: "Error",
                          html: "Hubo un error con su activacion, contacte a su administrador de sistema",
                          type: 'error',
                          showCancelButton: false,
                          closeOnConfirm: false,
                          confirmButtonText: "Ok"
                      });
                      console.log(data[1]);
                  }
              })
              .fail(function(xhr, textStatus, errorThrown)
              {
                  console.log(xhr.responseText);
              });
      }
  }
</script>