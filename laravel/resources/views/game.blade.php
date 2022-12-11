@extends('layouts.app')
@section('main-content')
  <div class="row">
    <div class="col-12">
      <div class="panel panel-dark panel-default">
        <div class="panel-body">
          <div class="row">
            <div class="col-6">
              <div class="row">
                <div class="col-12 text-center" style="padding: 15px">
                  <input type="text" name="numerosJuego" id="numerosJuego">
                 @include("layouts.partials.tablero")
                </div>
                <div id="resp"></div>
                <table class="table table-bordered" id="tbBets">
                  <thead>
                  <tr>
                    <th colspan="4" style="text-align: center">BETS</th>
                  </tr>
                  </thead>
                    <tbody>
                    <tr>
                        <th style="width: 25%">Color</th>
                        <th style="width: 25%" class="prom0"></th>
                        <td style="width: 25%" class="tdApuesta apuestaColor"></td>
                        <td style="width: 25%">
                            <input type="text" class="form-control" name="txtApuestaColor" id="txtApuestaColor">
                        </td>
                    </tr>
                    <tr>
                      <th>Par o Impar</th>
                      <th class="prom1"></th>
                      <td class="apuestaParImpar tdApuesta"></td>
                      <td >
                          <input type="text" class="form-control" name="txtApuestaParImpar" id="txtApuestaParImpar">
                      </td>
                    </tr>
                    <tr>
                      <th>Chico o Grande</th>
                      <th class="prom2"></th>
                      <td class="apuestaChicoGde tdApuesta"></td>
                      <td>
                          <input type="text" class="form-control" name="txtApuestaChicoGde" id="txtApuestaChicoGde">
                      </td>
                    </tr>
                    </tbody>
                </table>
              </div>
            </div>
            <div class="col-6">
            <div class="row">
              <div class="col-4">
              <div class="grafica">
                <h3>Rojos: <span id="conteoRojos">0</span> | Negros: <span id="conteoNegros">0</span></h3>
                <table class="table table-condensed" id="tbColores">
                  <tbody>
                  </tbody>
                </table>
              </div>
              </div>
              <div class="col-4">
              <div class="grafica">
                <h3>Par: <span id="conteoPar">0</span> | Impar: <span id="conteoImpar">0</span></h3>
                <table class="table table-condensed" id="tbParImpar">
                  <tbody>
                  </tbody>
                </table>
              </div>
              </div>
              <div class="col-4">
              <div class="grafica">
                <h3>Chicos: <span id="conteoChicos">0</span> | Grandes: <span id="conteoGrandes">0</span></h3>
                <table class="table table-condensed" id="tbChicaGde">
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
    </div>
  </div>
  <script src="/js/game3.js?v=2" type="text/javascript"></script>
<link href="/css/game3.css?v=2" rel="stylesheet" type="text/css" />
@endsection
