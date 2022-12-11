<div class="form-group col-sm-6 col-lg-6">
  {!! Form::label('titulo', 'Titulo:') !!}
  {!! Form::text('titulo', null, ['class' => 'form-control','maxlength'=>255,'required']) !!}
</div>
<div class="form-group col-sm-6 col-lg-3">
    {!! Form::label('categoria', 'Categoria:') !!}
    {!! Form::select('categoria',General::getCategorias(), null, ['class' => 'form-control','maxlength'=>255,'required']) !!}
</div>
<div class="form-group col-sm-6 col-lg-3">
    {!! Form::label('tipo', 'Tipo:') !!}
    {!! Form::select('tipo',array("standard"=>"Estandar","quote"=>"Cita","video"=>"Video","gallery"=>"Galeria","audio"=>"Audio","link"=>"Enlace"), null, ['class' => 'form-control','maxlength'=>255,'required']) !!}
</div>
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('texto', 'Texto:') !!}
    {!! Form::textarea('texto', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-12 col-lg-12">
    <a onclick="agregarArchivo(1)" class="btn btn-default">Agregar archivo</a>
    <a onclick="agregarArchivo(2)" class="btn btn-default">Agregar enlace</a>
    <a onclick="agregarArchivo(3)" class="btn btn-default">Agregar tag</a>
    <div id="campos" style="padding: 15px"></div>
</div>
<script>
    function agregarArchivo(valor){
        var input = '';
        if(valor==1){
            input = '<div class="form-group col-sm-4"><input type="file" name="archivos[]"></div>';
        }if(valor==2){
            input = '<div class="form-group col-sm-4"><input placeholder="Link" class="form-control" type="text" name="links[]"></div>';
        }
        else{
            input = '<div class="form-group col-sm-4"><input placeholder="Tag" class="form-control" type="text" name="tags[]"></div>';
        }
        $("#campos").append(input);
    }
</script>