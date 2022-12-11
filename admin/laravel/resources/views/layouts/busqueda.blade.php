<div class="pull-right form-group col-xs-12 col-sm-3">
    {!! Form::open(['method'=>'GET']) !!}
    <div class="input-group">
        {!! Form::text('q', (isset($q["q"]))? $q["q"]:"", ['class' => 'form-control', 'placeholder' => 'Búsqueda']) !!}
        <div class="input-group-btn">
            @if(isset($q["q"]) && $q["q"]!='')
                <button onclick="clean()"  type="submit" class='btn btn-danger'><i class="fa fa-times"></i></button>
            @else
                <button type="submit" class='btn btn-default'><i class="fa fa-search"></i></button>
            @endif

        </div>
    </div>
    @if(isset($advanced) && $advanced==true)
        <a data-toggle="collapse" href="#collapseAdvanced" style="padding: 5px 0" class="pull-right">Búsqueda avanzada</a>
    @endif
    {!! Form::close() !!}
</div>
<script>
    function clean(){
        $('[name="q"]').val('');
    }
</script>