@include('usuarios.script')
@if ($errors->any())
@endif

      <div class="form-group col-sm-6 col-lg-4">
          {!! Form::label('name', 'Nombre:') !!}
          {!! Form::text('name', null, ['class' => 'form-control','maxlength'=>255,'required']) !!}
      </div>

      <!--- Email Field --->
      <div class="form-group col-sm-6 col-lg-4">
          {!! Form::label('email', 'E-Mail:') !!}
          {!! Form::text('email', null, ['class' => 'form-control','maxlength'=>255,'required']) !!}
      </div>
      <div class="form-group col-sm-6 col-lg-4">
          <input type="checkbox" name="habilitarPass" id="habilitarPass"> {!! Form::label('password', 'Contraseña: ') !!} <i class=" info fa fa-info-circle" title="Guarda la contraseña en un lugar seguro, no serás capaz de recuperarla, soló podrás cambiarla."></i>
          <input name="password" value="" type="password" class="form-control" id="password">
      </div>
        <div class="form-group col-sm-6 col-lg-4 col-xs-12">
            {!! Form::label('imagen', 'Imagen:') !!}
            <input type="file" name="imagen" id="imagen" accept="image/*" />
        </div>
<script>
    $("#password").prop("disabled",true);
    $("#habilitarPass").on("click",function(){
        if($(this).is(":checked")) {
            $("#password").prop("disabled",false);
        }
        else{
            $("#password").prop("disabled",true);
        }
    })
</script>
<script>
$(document).ready(function(){
    //crear
    @if(!isset($usuario))
        $("#role_id").val(0);
    @else
        //editar
        checkAgente('{!! $usuario->role_id !!}');
    @endif
    $("#name,#password").on("keydown",function(e){
        // Allow: backspace, delete, tab, escape and enter
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13]) !== -1 ||
                // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
            // let it happen, don't do anything
            return;
        }
        if (e.which > 90 || e.which < 48 || e.which==59)
       {
          (e).preventDefault();

       }
    });
    var usuario = 0;
    @if(isset($usuarios))
        usuario = {!! $usuarios !!};
    $(function(){
        $('#password').val("");
    });
    @endif
    $(function(){
        $('#password').prop('disabled', false);
    });

});
    function checkAgente(valor) {
        console.log(valor);
        $(".rol").hide();
        var i = valor-1;
        $(".rol"+i).show();
    }
</script>
