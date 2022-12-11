<div class="row">
    <div class="col-12 col-sm-12">
        <div class="tab-content" id="vert-tabs-tabContent">
            <div class="tab-pane text-left fade show active" id="vert-tabs-home" role="tabpanel" aria-labelledby="vert-tabs-home-tab">
                <div class="card card-default">
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-sm-9">
                                {!! Form::label('Producto_CodigoMercanciaProducto', 'Número de identificación (SKU):') !!}
                                {!! Form::text('Producto_CodigoMercanciaProducto', null, ['class' => 'form-control','maxlength'=>255]) !!}
                            </div>
                            <div class="form-group col-sm-3">
                                <input type="hidden" name="Producto_id" id="Producto_id">
                                {!! Form::label('Producto_Unidad', 'Unidad:') !!}
                                {!! Form::text('Producto_Unidad', null, ['class' => 'form-control','maxlength'=>255]) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-7">
                                <div class="form-group" title="Captura el nombre o la clave completa del producto o servicio a facturar.">
                                    {!! Form::label('ClaveProdServConf', 'Clave de producto o servicio:') !!}
                                    <div class="input-group" id="input-group-ClaveProdServConf">
                                        {!! Form::select('ClaveProdServConf',array(),null, [
                                              'class' => 'form-control text-box single-line',
                                              'title' => 'Este campo es obligatorio.',
                                              'error' => 'Longitud y/o formato de datos inválidos.',
                                              'regex' => '[^|]{0,}',
                                              'id' => 'ClaveProdServConf'
                                              ]) !!}
                                        <div class="input-group-append">
                                            <button style="padding: 0 6px" tabindex="-1" title="Seleccionar de catálogo" class="btn btn-outline-secondary" type="button"><i class="fas fa-book"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <div class="form-group" title="Captura el nombre (litros, piezas, metros, etc.)  o la clave completa de la unidad de medida, puedes escribir las tres primeras letras y el sistema mostrará una relación de unidades encontradas.">
                                    {!! Form::label('ClaveUnidad', 'Clave de unidad:') !!}
                                    <div class="input-group">
                                        {!! Form::select('ClaveUnidad',array(), null, [
                                              'class' => 'form-control autocomplete noespacio text-box single-line ui-autocomplete-input',
                                              'title' => 'Este campo es obligatorio.',
                                              'error' => 'Longitud y/o formato de datos inválidos.',
                                              'regex' => '[^|]{0,}',
                                              'id' => 'ClaveUnidad'
                                              ]) !!}
                                        <div class="input-group-append">
                                            <button style="padding: 0 6px" tabindex="-1" title="Seleccionar de catálogo" class="btn btn-outline-secondary" type="button"><i class="fas fa-book"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-8">
                                {!! Form::label('Producto_DescripcionMercancia', 'Descripcion:') !!}
                                {!! Form::text('Producto_DescripcionMercancia', null, ['class' => 'form-control','maxlength'=>255]) !!}
                            </div>
                            <div class="form-group col-sm-4">
                                {!! Form::label('Producto_PrecioUnitario', 'Precio Unitario:') !!}
                                {!! Form::text('Producto_PrecioUnitario', null, ['class' => 'form-control','maxlength'=>255]) !!}
                            </div>
                            @if(GenericClass::empresa()->ce==1)
                            <div class="form-group col-sm-4">
                                {!! Form::label('Producto_Fraccion', 'Fraccion:') !!}
                                {!! Form::text('Producto_Fraccion', null, ['class' => 'form-control','maxlength'=>255]) !!}
                            </div>
                            <div class="form-group col-sm-4">
                                {!! Form::label('Producto_SubdivisionFraccion', 'Subdivision de Fraccion:') !!}
                                {!! Form::text('Producto_SubdivisionFraccion', null, ['class' => 'form-control','maxlength'=>255]) !!}
                            </div>

                            <div class="form-group col-sm-4">
                                {!! Form::label('Producto_UnidadMedidaComercial', 'Unidad Medida Comercial:') !!}
                                {!! Form::text('Producto_UnidadMedidaComercial', null, ['class' => 'form-control','maxlength'=>255]) !!}
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="resultadoProducto"></div>
    </div>
</div>
