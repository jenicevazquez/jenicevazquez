@include('usuarios.script')
<div class="row">
    <!--- Nombre Field --->
    <div class="form-group col-sm-6 col-lg-3">
        {!! Form::label('nombre', 'Nombre:') !!}
        {!! Form::text('nombre', null, ['class' => 'form-control','maxlength'=>255,'required']) !!}
    </div>
    <!--- Email Field --->
    <div class="form-group col-sm-6 col-lg-3">
        {!! Form::label('email', 'E-Mail:') !!}
        {!! Form::text('email', null, ['class' => 'form-control','maxlength'=>255,'required']) !!}
    </div>
    <!--- Name Field --->
    <div class="form-group col-sm-6 col-lg-3">
        {!! Form::label('name', 'Usuario:') !!}<i class=" info fa fa-info-circle" title="Debe de ser unico."></i>
        {!! Form::text('name', null, ['class' => 'form-control','maxlength'=>255,'required']) !!}
    </div>
    <!--- Password Field --->
    <div class="form-group col-sm-6 col-lg-3">
        {!! Form::label('password', 'Contraseña: ') !!} <i class=" info fa fa-info-circle" title="Guarda la contraseña en un lugar seguro, no serás capaz de recuperarla, soló podrás cambiarla."></i>
        <input name="password" value="" type="password" class="form-control" id="password">
    </div>
</div>
<div class="row">
    <div class="form-group col-xs-12 col-sm-8">
        <div class="panel panel-default">
          <div class="panel-heading">
              <div class="row">
                  <div class="col-xs-12">
                      <div class="pull-left">Perfil</div>
                      <div class="pull-right">
                          <div class="col-xs-12 pull-right text-right">
                              Cargar perfil:
                          {!! Form::select('perfil_id',General::getPerfiles(), null, ['class' => '', 'id'=>'perfil_id','onchange'=>'loadPerfil(this.value)']) !!}
                              <a id="btnGuardarPerfil" title="Guardar perfil" class="btn btn-xs btn-default" style="margin-top: -2px;"><i class="fas fa-save"></i></a>
                              <a id="btnBorrarPerfil" title="Borrar perfil" class="btn btn-xs btn-default" style="margin-top: -2px;"><i class="fas fa-trash"></i></a>
                          </div>
                          <div id="nuevoNombre" class="col-xs-12 pull-right text-right">
                              Nombre: <input type="text" name="nombrePerfil" id="txtnombrePerfil"><a onclick="guardarPerfil(this)" title="Guardar" class="btn btn-xs"><i class="fas fa-check"></i></a>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
          <div class="panel-body">
              <div class="row">
                  <div class="col-xs-12 col-sm-6">
                      <table class="table">
                          <tr><th style="width: 30px"><input type="checkbox" class="selectAll smodulos"></th><th>Modulos</th></tr>
                          <tr><td><input type="checkbox" class="modulos" name="modulos[]" value="1"></td><td>Inicio y estadísticas</td></tr>
                          <tr><td><input type="checkbox" class="modulos" name="modulos[]" value="2"></td><td>Caja</td></tr>
                          <tr><td><input type="checkbox" class="modulos" name="modulos[]" value="3"></td><td>Apartados</td></tr>
                          <tr><td><input type="checkbox" class="modulos" name="modulos[]" value="4"></td><td>Catálogos</td></tr>
                          <tr><td><input type="checkbox" class="modulos" name="modulos[]" value="5"></td><td>Inventario</td></tr>
                          <tr><td><input type="checkbox" class="modulos" name="modulos[]" value="6"></td><td>Traspasos</td></tr>
                          <tr><td><input type="checkbox" class="modulos" name="modulos[]" value="7"></td><td>Ventas</td></tr>
                          <tr><td><input type="checkbox" class="modulos" name="modulos[]" value="8"></td><td>Cortes de caja</td></tr>
                          <tr><td><input type="checkbox" class="modulos" name="modulos[]" value="10"></td><td>Reportes</td></tr>
                          <tr><td><input type="checkbox" class="modulos" name="modulos[]" value="11"></td><td>Bitácora</td></tr>
                          <tr><td><input type="checkbox" class="modulos" name="modulos[]" value="9"></td><td>Usuarios</td></tr>
                      </table>
                  </div>
                  <div class="col-xs-12 col-sm-6">
                      <table class="table">
                          <tr><th style="width: 30px"><input type="checkbox" class="selectAll smodulos"></th><th>Permisos</th></tr>
                          <tr><td><input type="checkbox" class="modulos" name="modulos[]" value="12"></td><td>Borrar productos</td></tr>
                          <tr><td><input type="checkbox" class="modulos" name="modulos[]" value="13"></td><td>Alta de productos desde caja</td></tr>
                          <tr><td><input type="checkbox" class="modulos" name="modulos[]" value="14"></td><td>Cancelación de ventas</td></tr>
                          <tr><td><input type="checkbox" class="modulos" name="modulos[]" value="15"></td><td>Edición del inventario</td></tr>
                          <tr><td><input type="checkbox" class="modulos" name="modulos[]" value="16"></td><td>Configuracion del sistema</td></tr>
                      </table>
                  </div>
              </div>
          </div>
        </div>
    </div>
    <div class="form-group col-xs-12 col-sm-4">
        <div class="panel panel-default">
            <div class="panel-heading">Asignación a sucursales:</div>
            <div class="panel-body">
                @if(count(General::sucursales2())>0)
                    <input type="hidden" name="principalSuc" id="principalSuc">
                    <table class="table">
                        <tr><th style="width: 30px"><input type="checkbox" class="selectAll"></th><th colspan="2">Sucursal</th></tr>
                    @foreach(General::sucursales2() as $sucursal)
                            <tr><td><input type="checkbox" name="sucursal[]" id="sucursal_{!! $sucursal->id !!}" value="{!! $sucursal->id !!}"></td>
                                <td style="vertical-align: middle">{!! $sucursal->sucursal !!}</td>
                                <td style="width: 30px">
                                    @if(isset($principal) && $sucursal->id==$principal)
                                        <i title="Marcar como principal" class="fas fa-star estrella hand" data-value="{!! $sucursal->id !!}"></i>
                                    @else
                                        <i title="Marcar como principal" class="far fa-star estrella hand" data-value="{!! $sucursal->id !!}"></i>
                                    @endif
                                </td>
                            </tr>
                    @endforeach
                    </table>
                @else
                    <i>No se encuentran sucursales registrados</i>
                @endif
            </div>
        </div>
        @if(General::empresa()->giro=="2")
        <div class="panel panel-default">
          <div class="panel-heading">Módulo de ordenes</div>
          <div class="panel-body">
              <table class="table">
                  <tr><th style="width: 30px"><input type="checkbox" class="selectAll"></th><th colspan="2">Categoria</th></tr>
                  @foreach(General::categorias() as $categoria)
                      <tr><td><input type="checkbox" class="categorias" name="categorias[]" value="{!! $categoria->id !!}"></td><td>{!! $categoria->categoria !!}</td></tr>
                  @endforeach
              </table>
          </div>
        </div>
        @endif
    </div>
</div>
<script>
    var perfil = 0;
    var custom = [];
$(document).ready(function(){
    $("#nuevoNombre").hide();
    $("#perfil_id").val(0);
    $("#btnGuardarPerfil").on("click",function(){
        $("#nuevoNombre").toggle();
        if($("#txtnombrePerfil").is(":visible"))
            $("#txtnombrePerfil").focus();
    });
    $("#btnBorrarPerfil").on("click",function(){
        var obj = $(this);
        $(obj).start("");
        var id = $("#perfil_id").val();
        $.post("{{url('/usuarios/borrarPerfil')}}", {
            _token: $('meta[name=csrf-token]').attr('content'),
            id:id
        })
        .done(function (data) {
            if(data=="exito"){
                $("#perfil_id option[value='"+id+"']").remove();
            }
            $(obj).stop();
        })
        .fail(function(xhr, textStatus, errorThrown)
        {
            $(obj).stop();
            console.log(xhr.responseText);
        });

    });
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
    $(".modulos").on("click",function(){
        $("#perfil_id").val(0);
    });
    $(".smodulos").on("click",function(){
        $("#perfil_id").val(0);
    });
    $(".estrella").on("click",function(){
        var obj = $(this);
        var suc = $(this).attr("data-value");
        $("#principalSuc").val(suc);
        $(".estrella.fas").toggleClass("fas").toggleClass("far");
        obj.toggleClass("fas").toggleClass("far" );
    });
});
    function loadPerfil(id){
        $("#perfil_id").attr("disabled",true);
        if(perfil==0){
            custom = getPermisosChecked();
        }
        if(id!=0) {
            $.post("{{url('/usuarios/getPermisosPerfil')}}", {
                _token: $('meta[name=csrf-token]').attr('content'),
                id: id
            })
                .done(function (data) {
                    $("#perfil_id").attr("disabled", false);
                    setPermisos(data);
                    perfil=id;
                })
                .fail(function (xhr, textStatus, errorThrown) {
                    console.log(xhr.responseText);
                });
        }
        else{
            $("#perfil_id").attr("disabled", false);
            setPermisos(custom);
        }
    }
    function setPermisos(permisos){
        $(".modulos").prop('checked', false);
        $.each( permisos, function( key, value ) {
            $(".modulos[value='"+value+"']").prop('checked', true);
        });
    }
    function guardarPerfil(obj){
        $(obj).start("");
        var nombre = $("#txtnombrePerfil").val();
        if(nombre==""){
            $(obj).stop();
            return alert("No ingreso el nombre del perfil");
        }
        var permisos = getPermisosChecked();

        if(permisos.length==0){
            $(obj).stop();
            return alert("No tiene permisos asignados para el perfil");
        }
        console.log(permisos);

        $.post("{{url('/usuarios/nuevoPerfil')}}", {
            _token: $('meta[name=csrf-token]').attr('content'),
            nombre:nombre,
            permisos:permisos
        })
        .done(function (data) {
            $("#txtnombrePerfil").val("");
            $("#nuevoNombre").hide();
            if(!$("#perfil_id option[value='"+data.id+"']").length){
                $("#perfil_id").append('<option value="'+data.id+'">'+data.perfil+'</option>');
            }
            $("#perfil_id").val(data.id);
            $(obj).stop();
        })
        .fail(function(xhr, textStatus, errorThrown)
        {
            $(obj).stop();
            console.log(xhr.responseText);
        });


    }
    function getPermisosChecked(){
        var permisos = [];
        $(".modulos:checked").each(function(){
            var id = $(this).val();
            permisos.push(id);
        });
        return permisos;
    }
</script>
<style>
    #nuevoNombre{
        padding: 5px;
        position: absolute;
        top: 148%;
        background:#f5f5f5;
        color:#333;
        border: 1px solid #ddd;
        z-index: 10;
        right: 0;
        width: 220px;
    }
</style>
