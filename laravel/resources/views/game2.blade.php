@extends('layouts.app')
@section('main-content')
  <div class="row">
    <div class="col-12">
      <div class="title pull-left">

      </div>
    </div>
    <div class="col-12">
      <div class="panel panel-dark panel-default">
        <!--<div class="panel-heading row">
          <div class="">
          <div class="pull-left title2"><i style="margin-right: 5px" class="fas fa-dice"></i> SpeedRoulette</div>
          <div class="pull-right title3" id="croupName">-</div>
          </div>
        </div>-->
        <div class="panel-body">
          <div class="row">
            <div class="col-12">
              <div class="col-9">
                <div class="col-12" style="padding: 15px">
                  <div class="col-12 text-center" style="padding: 15px">
                    <input type="text" name="numero" id="numero">
                  </div>
                  <div id="resp"></div>

                </div>
              </div>
              <div class="col-3">
                <div class="col-12">
                  <h3 class="pull-left">Juegos</h3>
                  <div class="pull-right">
                    <a id="btnplay" onclick="cargarDemo(this)" class="btn btn-primary"><i class="fas fa-play"></i></a>
                    <a data-toggle="modal" data-target="#modalNuevo" class="btn btn-danger"><i class="fas fa-plus"></i></a>
                  </div>
                  <div id="tbJuegos" class="col-12 text-center" style="padding: 15px; overflow: auto">
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12">
              <div class="col-6">
                <div id="apuesta" class="apuesta bordercard" style="text-align: left">
                  <div>Color: <span class="morado prediccioncolor prediccion0"></span> | <span class="rojo2 apuestacolor apuesta0"></span> | <span class="cantidad0"></span></div>
                  <div>Mitad: <span class="morado prediccionmitad prediccion1"></span> | <span class="rojo2 apuestamitad apuesta1"></span> | <span class="cantidad1"></span></div>
                  <div>Tipo: <span class="morado predicciontipo prediccion2"></span> | <span class="rojo2 apuestatipo apuesta2"></span> | <span class="cantidad2"></span></div>
                </div>
              </div>
              <div class="col-6">
                <div class="apuesta bordercard">
                  <div id="saldoJuego">Bets</div>
                  <div class="form-group col-sm-4">
                    {!! Form::select('scolor',array(""=>"","rojo"=>"rojo","negro"=>"negro"), null, ['class' => 'form-control','id'=>'scolor']) !!}
                  </div>
                  <div class="form-group col-sm-4">
                    {!! Form::select('smitad',array(""=>"","chico"=>"chico","grande"=>"grande"), null, ['class' => 'form-control','id'=>'smitad']) !!}
                  </div>
                  <div class="form-group col-sm-4">
                    {!! Form::select('stipo',array(""=>"","par"=>"par","impar"=>"impar"), null, ['class' => 'form-control','id'=>'stipo']) !!}
                  </div>
                  <a id="btnenviar" class="btn btn-default" onclick="hacerApuesta(this)">Hacer apuesta</a>
                </div>
              </div>
            </div>
            <div class="col-12">
              <div class="col-4">
                <div class="grafica">
                  <h3>Color</h3>
                  <canvas id="myChartcolor"></canvas>
                </div>
              </div>
              <div class="col-4">
                <div class="grafica">
                  <h3>Mitad</h3>
                  <canvas id="myChartmitad"></canvas>
                </div>
              </div>
              <div class="col-4">
                <div class="grafica">
                  <h3>Tipo</h3>
                  <canvas id="myCharttipo"></canvas>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal dark" tabindex="-1" id="modalNuevo" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h5 class="modal-title">Nuevo juego</h5>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="form-group col-12">
              {!! Form::label('croupier', 'Croupier:') !!}
              {!! Form::text('croupier', null, ['class' => 'form-control','maxlength'=>255]) !!}
            </div>
            <div class="form-group col-12 no-margin">
              {!! Form::label('inicial', 'Apuesta inicial:') !!}
              {!! Form::text('inicial', null, ['class' => 'form-control','maxlength'=>255]) !!}
            </div>
            <div class="form-group col-12 no-margin">
              {!! Form::label('saldo', 'Saldo:') !!}
              {!! Form::text('saldo', null, ['class' => 'form-control','maxlength'=>255]) !!}
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button id="btnNuevoJuego" type="button" onclick="crearNuevoJuego()" class="btn btn-primary">Crear</button>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="/js/game.js" type="text/javascript"></script>
<link href="/css/game.css?v=1" rel="stylesheet" type="text/css" />
@endsection
